<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Market;
use App\Models\Outcome;
use Illuminate\Http\Request;

class MarketController extends Controller {

    public function index($id) {
        $marketInfo         = getMarkets()->pluck('key')->toArray();
        $quotedMarketInfo   = array_map(fn($item) => "'$item'", $marketInfo);
        $implodedMarketInfo = implode(', ', $quotedMarketInfo);
        $pageTitle          = "All Markets";

        $game               = Game::findOrFail($id);

        $markets = $game->markets()
            ->with('game')
            ->orderByRaw("FIELD(`market_type`, $implodedMarketInfo , 'exact_score') ASC")
            ->with(['outcomes' => function ($q) {
                $q->withCount('bets');
            }])
            ->get();

        return view('admin.game.market', compact('pageTitle', 'game', 'markets'));
    }

    public function store(Request $request)
    {
        $marketInfo = getMarkets();
        $marketKeys = $marketInfo->pluck('key')->toArray();

        $request->validate([
            'game_id'                        => 'required|exists:games,id',
            'market'                         => 'required|array|min:1',
            'market.*.key'                   => 'required|string|in:' . implode(",", $marketKeys),
            'market.*.status'                => 'nullable|in:1',
            'market.*.locked'                => 'nullable|in:1',
            'market.*.outcome_type'          => 'required|integer|gte:0|lt:5',
            'title'                          => 'required_if:market_type,outrights,others|max:255',
            'market.*.outcomes'              => 'required|array',
            'market.*.outcomes.*.odds'       => 'required|numeric|gte:0',
            'market.*.outcomes.*.name'       => 'required|string',
            'market.*.outcomes.*.status'     => 'nullable|in:1',
            'market.*.outcomes.*.locked'     => 'nullable|in:1',
            'market.*.outcomes.*.point'      => 'sometimes|required|numeric',
            'market.*.outcomes.*.point_type' => 'sometimes|required|in:+,-',
            'market.*.outcomes.*.favoritismo' => 'nullable|string|max:255', // ✅ Validar nuevo campo
        ]);

        $game = Game::findOrFail($request->game_id);

        foreach ($request->market as $requestMarket) {
            $marketData  = collect($marketInfo)->where('key', $requestMarket['key'])->first();
            $marketTitle = $marketData ? $marketData->name : null;

            $market = Market::where('game_id', $game->id)
                ->where('id', $requestMarket['id'] ?? null)
                ->firstOrNew();

            $market->market_type        = @$requestMarket['market_type'] ?? $requestMarket['key'];
            $market->outcome_type       = $requestMarket['outcome_type'];
            $market->title              = @$requestMarket['title'] ?? @$marketTitle;
            $market->player_props       = @$requestMarket['player_props'];
            $market->game_period_market = @$requestMarket['game_period_market'];
            $market->game_id            = $request->game_id;
            $market->status             = @$requestMarket['status'] ? 1 : 0;
            $market->locked             = @$requestMarket['locked'] ? 0 : 1;

            // ✅ Ya no guardamos favoritismos aquí
            $market->save();

            // 🔹 Guardar los outcomes (ahora con favoritismo)
            $this->saveOutcomes($requestMarket['outcomes'], $market->id);
        }

        $notify[] = ['success', 'Market data updated successfully'];
        return back()->withNotify($notify);
    }

    private function saveOutcomes($outcomes, $marketId)
    {
        foreach ($outcomes as $outcome) {
            $point = @$outcome['point'];

            if (isset($outcome['point']) && isset($outcome['point_type'])) {
                $point = $outcome['point_type'] == '+' ? $outcome['point'] : $outcome['point'] * (-1);
            }

            $newOutcome = Outcome::where('market_id', $marketId)
                ->where('id', $outcome['outcome_id'] ?? null)
                ->firstOrNew();

            $newOutcome->market_id = $marketId;
            $newOutcome->name      = $outcome['name'] ?? null;
            $newOutcome->odds      = $outcome['odds'] ?? null;
            $newOutcome->status    = isset($outcome['status']) ? (@$outcome['status'] ? 1 : 0) : 1; // ✅ Por defecto activo
            $newOutcome->locked    = isset($outcome['locked']) ? (@$outcome['locked'] ? 1 : 0) : 0; // ✅ Por defecto desbloqueado (0)
            $newOutcome->point     = $point;

            // ✅ Guardamos el favoritismo en cada outcome
            $newOutcome->favoritismo = $outcome['favoritismo'] ?? null;

            $newOutcome->save();
        }
    }

    public function update(Request $request, $id) {
        $request->validate(['title' => 'required|max:255']);

        $market = Market::findOrFail($id);

        if (!in_array($market->market_type, ['others', 'outrights'])) {
            $notify[] = ['error', 'This market is not editable'];
            return back()->withNotify($notify);
        }

        $market->title = $request->title;
        $market->save();

        $notify[] = ['success', 'Market updated successfully'];
        return back()->withNotify($notify);
    }

    public function status($id) {
        $market = Market::findOrFail($id);
        $market->status = !$market->status;
        $market->save();

        if (!request()->ajax()) {
            $notify[] = ['success', 'Market status updated successfully'];
            return back()->withNotify($notify);
        }

        return response()->json(['success' => 'Market status updated successfully']);
    }

    public function locked($id) {
        $market = Market::findOrFail($id);
        $market->locked = !$market->locked;
        $market->save();

        $message = $market->locked ? 'Market locked successfully' : 'Market unlocked successfully';

        if (!request()->ajax()) {
            $notify[] = ['success', $message];
            return back()->withNotify($notify);
        }

        return response()->json(['success' => $message]);
    }
}
