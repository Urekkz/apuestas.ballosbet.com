<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\Referral;
use App\Models\Bet;
use App\Models\BetItem;
use App\Models\Transaction;
use App\Models\Outcome; // 👈 CAMBIO: necesitamos Outcome
use Illuminate\Http\Request;

class BetController extends Controller
{
    public function placeBet(Request $request)
    {
        $status = implode(',', [Status::SINGLE_BET, Status::MULTI_BET]);

        $request->validate([
            'type'         => "required|integer|in:$status",
            'stake_amount' => 'required_if:type,2|nullable|numeric|gt:0',
        ]);

        $user    = auth()->user();
        $betType = $request->type;
        $bets    = collect(session('bets'));

        $isSuspended = $bets->contains(function ($bet) {
            return isSuspendBet($bet);
        });

        if ($isSuspended) {
            $notify[] = ['error', 'You have to remove suspended bet from bet slip'];
            return back()->withNotify($notify);
        }

        if (blank($bets)) {
            $notify[] = ['error', 'No bet item found in bet slip'];
            return back()->withNotify($notify);
        }

        if ($bets->count() < 2 && $betType == Status::MULTI_BET) {
            $notify[] = ['error', 'Multi bet requires more than one bet'];
            return back()->withNotify($notify);
        }

        $totalStakeAmount = $betType == Status::SINGLE_BET
            ? getAmount($bets->sum('stake_amount'), 8)
            : $request->stake_amount;

        $minLimit = $betType == Status::SINGLE_BET ? gs('single_bet_min_limit') : gs('multi_bet_min_limit');
        $maxLimit = $betType == Status::SINGLE_BET ? gs('single_bet_max_limit') : gs('multi_bet_max_limit');

        if ($totalStakeAmount < $minLimit) {
            $notify[] = ['error', 'Min stake limit ' . $minLimit . ' ' . gs('cur_text')];
            return back()->withNotify($notify);
        }
        if ($totalStakeAmount > $maxLimit) {
            $notify[] = ['error', 'Max stake limit ' . $maxLimit . ' ' . gs('cur_text')];
            return back()->withNotify($notify);
        }

        if ($totalStakeAmount > $user->balance) {
            $notify[] = ['error', "You don't have sufficient balance"];
            return back()->withNotify($notify);
        }

        // descontamos saldo
        $user->balance -= $totalStakeAmount;
        $user->save();

        // transacción de salida
        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $totalStakeAmount;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type     = '-';
        $transaction->details      = 'For bet placing';
        $transaction->trx          = getTrx();
        $transaction->remark       = 'bet_placed';
        $transaction->save();

        if ($betType == Status::SINGLE_BET) {
            $this->placeSingleBet();
        } else {
            $this->placeMultiBet();
        }

        if (gs('bet_commission') && gs('referral_program')) {
            Referral::levelCommission($user, $totalStakeAmount, $transaction->trx, 'bet');
        }

        session()->forget('bets');
        $notify[] = ['success', 'Bet placed successfully'];

        if ($request->ajax()) {
            try {
                $html = view('templates.basic.partials.my_bets')->render();
            } catch (\Throwable $e) {
                $html = null;
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Bet placed successfully',
                'html' => $html,
            ]);
        }

        return to_route('home', 'mybets')->withNotify($notify);
    }

    /**
     * SINGLE BET
     */
    private function placeSingleBet()
    {
        $betData = collect(session('bets'));

        // ver si la apuesta se marcó como "abierta"
        $isOpen = false;
        try {
            if (request()->has('is_open')) {
                $isOpen = (string) request()->get('is_open') === '1'
                    || request()->get('is_open') === 1
                    || request()->get('is_open') === true;
            }
        } catch (\Exception $e) {
            $isOpen = false;
        }

        foreach ($betData as $betItem) {
            // 👇 CAMBIO: ya NO usamos $betItem->odds directamente
            // 1) buscamos el outcome con el market y los otros outcomes
            $outcome = Outcome::with('market.outcomes')->find($betItem->outcome_id);

            // 2) calculamos el return según favoritismo
            $returnAmount = $this->calculateReturnAmountByFavoritismo(
                $betItem->stake_amount,
                $outcome
            );

            // 3) guardamos la apuesta (bets)
            $bet = $this->saveBetData(
                Status::SINGLE_BET,
                $betItem->stake_amount,
                $returnAmount,
                $isOpen
            );

            // 4) detalle
            $this->saveBetDetail($bet->id, $betItem);
        }
    }

    /**
     * MULTI
     * (si quieres también lo podemos adaptar al favoritismo, de momento lo dejo como estaba)
     */
    private function placeMultiBet()
    {
        $bet          = $this->saveBetData(Status::MULTI_BET, request()->stake_amount);
        $returnAmount = $bet->stake_amount;
        $betData      = collect(session('bets'));

        foreach ($betData as $betItem) {
            // aquí seguías multiplicando por odds
            $returnAmount *= $betItem->odds;
            $this->saveBetDetail($bet->id, $betItem);
        }

        $bet->return_amount = $returnAmount;
        $bet->save();
    }

    private function saveBetData($type, $stakeAmount, $returnAmount = 0, $isOpen = false)
    {
        $bet                = new Bet();
        $bet->bet_number    = getTrx(8);
        $bet->user_id       = auth()->id();
        $bet->type          = $type;
        $bet->stake_amount  = $stakeAmount;
        $bet->return_amount = $returnAmount;
        $bet->status        = Status::BET_PENDING;
        $bet->is_open       = $isOpen;
        $bet->save();

        return $bet;
    }

    private function saveBetDetail($betId, $betItem)
    {
        $outcome = Outcome::find($betItem->outcome_id);

        $betDetail             = new BetItem();
        $betDetail->bet_id     = $betId;
        $betDetail->market_id  = $outcome ? $outcome->market_id : ($betItem->market_id ?? null);
        $betDetail->outcome_id = $betItem->outcome_id;
        $betDetail->odds       = $betItem->odds;
        $betDetail->status     = Status::BET_PENDING;
        $betDetail->save();
    }

    /**
     * Tapar apuesta de otro
     */
    public function matchBet(Request $request)
    {
        $request->validate([
            'original_bet_id' => 'required|exists:bets,id',
            'outcome_id'      => 'required|exists:outcomes,id',
        ]);

        $user = auth()->user();

        $originalBet = Bet::where('id', $request->original_bet_id)
            ->where('is_open', true)
            ->where('status', Status::BET_PENDING)
            ->whereNull('matched_bet_id')
            ->with('bets')
            ->first();

        if (!$originalBet) {
            $notify[] = ['error', 'Bet is not available for matching'];
            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Bet is not available for matching',
                ], 400);
            }
            return back()->withNotify($notify);
        }

        if ($originalBet->user_id == $user->id) {
            $notify[] = ['error', 'You cannot match your own bet'];
            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'You cannot match your own bet',
                ], 400);
            }
            return back()->withNotify($notify);
        }

        $stakeAmount = $originalBet->stake_amount;

        if ($stakeAmount > $user->balance) {
            $notify[] = ['error', "You don't have sufficient balance to match this bet"];
            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => "You don't have sufficient balance. Balance: " . showAmount($user->balance),
                ], 400);
            }
            return back()->withNotify($notify);
        }

        // 👇 traemos el outcome con el market y su otro lado
        $outcome = Outcome::with('market.outcomes')->find($request->outcome_id);
        if (!$outcome) {
            $notify[] = ['error', 'Invalid outcome'];
            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Invalid outcome',
                ], 400);
            }
            return back()->withNotify($notify);
        }

        // 👇 CAMBIO: usamos la misma lógica de favoritismo
        $returnAmount = $this->calculateReturnAmountByFavoritismo($stakeAmount, $outcome);

        // descontar saldo
        $user->balance -= $stakeAmount;
        $user->save();

        // transacción
        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $stakeAmount;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type     = '-';
        $transaction->details      = 'For matching bet #' . $originalBet->bet_number;
        $transaction->trx          = getTrx();
        $transaction->remark       = 'bet_matched';
        $transaction->save();

        // crear la apuesta que tapa
        $matchingBet                 = new Bet();
        $matchingBet->bet_number     = getTrx(8);
        $matchingBet->user_id        = $user->id;
        $matchingBet->type           = Status::SINGLE_BET;
        $matchingBet->stake_amount   = $stakeAmount;
        $matchingBet->return_amount  = $returnAmount; // 👈 ahora es con favoritismo
        $matchingBet->status         = Status::BET_PENDING;
        $matchingBet->is_open        = false;
        $matchingBet->matched_bet_id = $originalBet->id;
        $matchingBet->save();

        $originalBetItem = $originalBet->bets->first();

        $betDetail             = new BetItem();
        $betDetail->bet_id     = $matchingBet->id;
        $betDetail->market_id  = $originalBetItem->market_id;
        $betDetail->outcome_id = $outcome->id;
        $betDetail->odds       = $outcome->odds;
        $betDetail->status     = Status::BET_PENDING;
        $betDetail->save();

        // marcar la original como tapada
        $originalBet->matched_bet_id     = $matchingBet->id;
        $originalBet->matched_by_user_id = $user->id;
        $originalBet->matched_at         = now();
        $originalBet->is_open            = false;
        $originalBet->save();

        if (gs('bet_commission') && gs('referral_program')) {
            Referral::levelCommission($user, $stakeAmount, $transaction->trx, 'bet');
        }

        $notify[] = ['success', 'Bet matched successfully!'];

        if ($request->ajax()) {
            try {
                $html = view('templates.basic.partials.my_bets')->render();
            } catch (\Throwable $e) {
                $html = null;
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'Bet matched successfully!',
                'html'    => $html,
            ]);
        }

        return to_route('home', 'mybets')->withNotify($notify);
    }

    /* =========================================================
     *  LÓGICA DE FAVORITISMO
     * =======================================================*/

    /**
     * Calcula cuánto debe ganar una apuesta según el favoritismo.
     *
     * Reglas:
     * - si ESTE outcome tiene favoritismo 8 → stake * 1.75
     * - si ESTE outcome tiene favoritismo 7 → stake * 1.65
     * - si el OTRO outcome del mismo market tiene 7 u 8 → stake * 1.95 (estás yendo contra el favorito)
     * - si ninguno tiene 7 u 8 → mano a mano → stake * 1.95
     */
    private function calculateReturnAmountByFavoritismo($stake, ?Outcome $outcome): float
    {
        if (!$outcome) {
            // si no hay outcome, pagamos mano a mano
            return round($stake * 1.95, 8);
        }

        $thisFav = (int) ($outcome->favoritismo ?? 0);

        // si este es el favorito
        if ($thisFav === 8) {
            return round($stake * 1.75, 8);
        }
        if ($thisFav === 7) {
            return round($stake * 1.65, 8);
        }

        // necesitamos ver el otro lado del mercado
        $market = $outcome->market;
        if ($market && $market->relationLoaded('outcomes')) {
            $other = $market->outcomes->firstWhere('id', '!=', $outcome->id);
        } else {
            // si no vino cargado, lo cargamos simple
            $market = $outcome->market()->with('outcomes')->first();
            $other  = $market ? $market->outcomes->firstWhere('id', '!=', $outcome->id) : null;
        }

        $otherFav = $other ? (int) ($other->favoritismo ?? 0) : 0;

        // si el otro sí es favorito (7 u 8) y tú no → tú estás apostando CONTRA el favorito
        if (in_array($otherFav, [7, 8], true)) {
            return round($stake * 1.95, 8);
        }

        // mano a mano
        return round($stake * 1.95, 8);
    }
}
