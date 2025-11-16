<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Outcome extends Model {
    use GlobalStatus;

    protected $guarded = ['id'];

    public function market() {
        return $this->belongsTo(Market::class);
    }
    public function bets() {
        return $this->hasMany(BetItem::class);
    }

    public function scopeLocked($query) {
        return $query->where('locked', Status::OUTCOME_LOCKED);
    }

    public function scopeUnLocked($query) {
        return $query->where('locked', Status::OUTCOME_UNLOCKED);
    }

    public function scopeAvailableForBet($query) {
        // Validaciones MÍNIMAS para permitir apuestas:
        // Solo excluir outcomes de juegos CANCELADOS (2) o TERMINADOS (4)
        return $query->active()
            ->whereHas('market', function ($market) {
                $market->where('result_declared', Status::NO)
                    ->whereHas('game', function ($game) {
                        $game->whereNotIn('status', [Status::GAME_CANCELLED, Status::GAME_ENDED]);
                    });
            });
    }
}
