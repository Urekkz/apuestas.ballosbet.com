<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Market extends Model {
    use GlobalStatus;

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'game_id',
        'market_type',
        'outcome_type',
        'player_props',
        'game_period_market',
        'title',
        'status',
        'locked',
        'result_declared',
        'win_outcome_id',
        'market_updated_at',
        'favoritismo_izquierda',
        'favoritismo_derecha',
    ];

    // Casts útiles
    protected $casts = [
        'game_id' => 'integer',
        'outcome_type' => 'integer',
        'player_props' => 'integer',
        'game_period_market' => 'integer',
        'status' => 'integer',
        'locked' => 'integer',
        'result_declared' => 'integer',
        'win_outcome_id' => 'integer',
        'market_updated_at' => 'datetime',
    ];

    protected $appends = ['market_title'];

    // Relaciones
    public function game() {
        return $this->belongsTo(Game::class);
    }

    public function outcomes() {
        return $this->hasMany(Outcome::class);
    }

    public function winOutcome() {
        return $this->belongsTo(Outcome::class);
    }

    public function betItems() {
        return $this->hasMany(BetItem::class, 'market_id');
    }

    // Scopes (sin cambios funcionales)
    public function scopeResultDeclared($query) {
        return $query->where('result_declared', Status::YES);
    }

    public function scopeResultUndeclared($query) {
        return $query->where('result_declared', Status::NO);
    }

    public function scopeLocked($query) {
        return $query->where('locked', Status::MARKET_LOCKED);
    }

    public function scopeUnLocked($query) {
        return $query->where('locked', Status::MARKET_UNLOCKED);
    }

    public function scopeFilterByGamePeriod($query) {
        $query->where(function ($query) {
            $query->where('game_period_market', Status::NO)
                ->orWhere(function ($query) {
                    $query->where('game_period_market', Status::YES)
                        ->whereHas('game', function ($gameQuery) {
                            $gameQuery->runningGame();
                        });
                });
        });
    }

    public function scopeMarketAvailable($query) {
        $query->unLocked()->resultUndeclared()->with('outcomes.bets', 'betItems.bet')->withWhereHas('game', function ($game) {
            $game->expired()->with([
                'teamOne',
                'teamTwo',
                'league' => function ($league) {
                    $league->active()->with(['category' => function ($category) {
                        $category->active();
                    }]);
                },
            ]);
        });
    }

    public function getMarketTitleAttribute() {
        if ($this->market_type == 'h2h') {
            $title = 'Mano a Mano';
        } else if ($this->market_type == 'h2h_3way') {
            $title = 'Mano a Mano 3 vías';
        } else if ($this->market_type == 'spreads') {
            $title = 'Spreads';
        } else if ($this->market_type == 'totals') {
            $title = 'Totales';
        } else if ($this->market_type == 'outrights') {
            $title = 'Outrights';
        } else {
            $title = $this->title;
        }
        return $title;
    }
    public function getFavoritismoLabelAttribute()
{
    // Tomamos los dos outcomes m��s recientes de este market
    $outcomes = $this->outcomes()->latest('id')->take(2)->get();

    if ($outcomes->count() < 2) {
        return 'Mano a mano'; // por defecto si no hay ambos
    }

    $fav1 = $outcomes[0]->favoritismo ?? 'Mano a mano';
    $fav2 = $outcomes[1]->favoritismo ?? 'Mano a mano';

    // Caso 1: ambos son mano a mano
    if ($fav1 === 'Mano a mano' && $fav2 === 'Mano a mano') {
        return 'Mano a mano';
    }

    // Caso 2: si alguno es distinto, mostramos el diferente
    if ($fav1 !== 'Mano a mano') {
        return $fav1;
    }

    if ($fav2 !== 'Mano a mano') {
        return $fav2;
    }

    // Caso por defecto
    return 'Mano a mano';
}
}
