<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CronController; // 👈 IMPORTANTE
use App\Models\Outcome;
use App\Models\Market;

class DeclareOutcomeController extends Controller
{
    public function pendingOutcomes() {
        $pageTitle = 'Pending Outcomes';
        $markets = Market::resultUndeclared()
            ->with([
                'outcomes' => function ($bets) {
                    $bets->withCount('bets');
                },
                'game',
                'game.teamOne',
                'game.teamTwo'
            ])
            ->withCount('betItems')
            ->whereHas('betItems', function ($query) {
                $query->where('bet_items.status', Status::BET_PENDING);
            })
            ->filter(['game_id'])
            ->searchable(['title'])
            ->orderBy('id', 'desc')
            ->paginate(getPaginate());

        return view('admin.declare_outcomes.index', compact('pageTitle', 'markets'));
    }

    public function declaredOutcomes() {
        $pageTitle = 'Declared Outcomes';
        $markets = Market::resultDeclared()
            ->with([
                'outcomes' => function ($bets) {
                    $bets->withCount('bets');
                },
                'game', 'game.teamOne', 'game.teamTwo', 'winOutcome:id,market_id,name',
            ])
            ->withCount('betItems')
            ->whereHas('betItems', function ($query) {
                $query->where('bet_items.status', '!=', Status::BET_PENDING);
            })
            ->searchable(['title'])
            ->orderBy('id', 'desc')
            ->paginate(getPaginate());

        return view('admin.declare_outcomes.index', compact('pageTitle', 'markets'));
    }

    public function refund($id) {
        $market = Market::active()->resultUndeclared()
            ->with(['betItems' => function ($query) {
                $query->pending()->with('bet.user');
            }])->find($id);

        if (!$market) {
            $notify[] = ['error', 'Invalid market selected'];
            return back()->withNotify($notify);
        }

        $market->result_declared = Status::YES;
        $market->save();

        $betItems = $market->betItems;

        foreach ($betItems as $detail) {
            $detail->status = Status::BET_REFUNDED;
            $detail->save();

            $bet = $detail->bet;

            if ($bet->type == Status::SINGLE_BET) {
                $bet->status  = Status::BET_REFUNDED;
                $bet->save();
            } else {
                $this->updateMultiBetBetStatus($bet);
            }
        }

        // 👇 después de marcar como refund, pagamos de una con el cron
        app(CronController::class)->refund();

        $notify[] = ['success', 'All bets for the market: ' . $market->title . ' have been marked as refunded and settled.'];
        return back()->withNotify($notify);
    }

    public function winner($id) {
        $outcome = Outcome::with('market')->find($id);

        if (!$outcome) {
            $notify[] = ['error', 'Invalid outcome selected'];
            return back()->withNotify($notify);
        }

        $market = $outcome->market;

        if ($market && $market->result_declared == Status::YES) {
            $notify[] = ['error', 'Result already declared'];
            return back()->withNotify($notify);
        }

        // 1) declarar el mercado
        $market->result_declared = Status::YES;
        $market->win_outcome_id  = $outcome->id;
        $market->save();

        // 2) obtener todas las apuestas de ese market
        $betItems = $market->betItems()->with('bet')->get();

        $winnerBetItems = $betItems->where('outcome_id', $outcome->id);
        $loserBetItems  = $betItems->where('outcome_id', '!=', $outcome->id);

        // 3) marcar perdedoras
        foreach ($loserBetItems as $loserBetItem) {
            $loserBetItem->status = Status::BET_LOSS;
            $loserBetItem->save();

            $loseBet              = $loserBetItem->bet;
            $loseBet->status      = Status::BET_LOSS;
            $loseBet->result_time = now();
            $loseBet->save();
        }

        // 4) marcar ganadoras
        foreach ($winnerBetItems as $item) {
            $item->status = Status::BET_WIN;
            $item->save();

            $winBet = $item->bet;

            if ($winBet->type == Status::MULTI_BET ) {
                if ($winBet->status == Status::BET_PENDING) {
                    $this->updateMultiBetBetStatus($winBet);
                }
            } else {
                $winBet->status      = Status::BET_WIN;
                $winBet->result_time = now();
                $winBet->save();
            }
        }

        // 👇 5) AQUÍ está la magia: liquidamos ya mismo
        // esto hace que se sume el return_amount al usuario sin esperar al cron del server
        app(CronController::class)->win();
        // opcional: si también quieres que en el mismo golpe se notifiquen las perdidas:
        app(CronController::class)->lose();

        $notify[] = ['success', 'Outcome selected and bets settled successfully'];
        return back()->withNotify($notify);
    }

    protected function winAmount($bet, $wonBets) {
        $totalOddsRate = 1;

        foreach ($wonBets as $betData) {
            $totalOddsRate *= $betData->odds;
        }

        $winAmount = getAmount($bet->stake_amount * $totalOddsRate, 8);
        return $winAmount;
    }

    private function updateMultiBetBetStatus($bet) {
        $totalMultiBet       = $bet->bets()->count();
        $refundMultiBetCount = $bet->bets()->where('status', Status::BET_REFUNDED)->count();
        $wonBets             = $bet->bets()->where('status', Status::BET_WIN)->get();

        if ($totalMultiBet == $refundMultiBetCount + $wonBets->count()) {
            $winAmount               = $this->winAmount($bet, $wonBets);
            $bet->return_amount   = $winAmount;
            $bet->status          = Status::BET_WIN;
            $bet->result_time     = now();
            $bet->save();
        }
    }
}
