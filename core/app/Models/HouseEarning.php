<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseEarning extends Model
{
    protected $fillable = [
        'bet_id',
        'user_id',
        'bet_amount',
        'commission_amount',
        'commission_percent',
        'bet_number',
        'type',
        'description',
    ];

    protected $casts = [
        'bet_amount' => 'decimal:8',
        'commission_amount' => 'decimal:8',
        'commission_percent' => 'decimal:2',
    ];

    /**
     * Relación con la apuesta
     */
    public function bet()
    {
        return $this->belongsTo(Bet::class);
    }

    /**
     * Relación con el usuario que hizo la apuesta
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope para filtrar por tipo
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope para filtrar por rango de fechas
     */
    public function scopeDateFilter($query)
    {
        if (request()->date) {
            $dates = explode(' - ', request()->date);
            if (count($dates) == 2) {
                $query->whereBetween('created_at', [
                    $dates[0] . ' 00:00:00',
                    $dates[1] . ' 23:59:59'
                ]);
            }
        }
        return $query;
    }

    /**
     * Scope para búsqueda
     */
    public function scopeSearchable($query, array $fields = [])
    {
        $search = request()->search;
        if (!$search) {
            return $query;
        }

        return $query->where(function ($q) use ($search, $fields) {
            $q->where('bet_number', 'like', "%{$search}%");
            
            if (in_array('user:username', $fields)) {
                $q->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('username', 'like', "%{$search}%");
                });
            }
        });
    }
}
