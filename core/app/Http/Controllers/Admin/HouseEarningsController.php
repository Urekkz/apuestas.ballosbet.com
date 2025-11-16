<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HouseEarning;
use Illuminate\Http\Request;

class HouseEarningsController extends Controller
{
    /**
     * Mostrar listado de todas las ganancias de la casa
     */
    public function index(Request $request)
    {
        $pageTitle = 'House Earnings';
        $emptyMessage = 'No commission earnings yet';
        
        $query = HouseEarning::with(['user', 'bet']);

        // Filtro de búsqueda
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('bet_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('username', 'like', "%{$search}%")
                                ->orWhere('firstname', 'like', "%{$search}%")
                                ->orWhere('lastname', 'like', "%{$search}%");
                  });
            });
        }

        // Filtro de fecha con inputs separados
        if ($request->start_date || $request->end_date) {
            if ($request->start_date && $request->end_date) {
                // Ambas fechas proporcionadas - filtrar rango
                $query->whereDate('created_at', '>=', $request->start_date)
                      ->whereDate('created_at', '<=', $request->end_date);
            } elseif ($request->start_date) {
                // Solo fecha inicio - desde esa fecha hasta hoy
                $query->whereDate('created_at', '>=', $request->start_date);
            } elseif ($request->end_date) {
                // Solo fecha fin - hasta esa fecha
                $query->whereDate('created_at', '<=', $request->end_date);
            }
        }

        $earnings = $query->orderBy('id', 'desc')->paginate(getPaginate());

        // Calcular totales (respetando filtros si existen)
        $totalQuery = HouseEarning::query();
        $todayQuery = HouseEarning::whereDate('created_at', today());
        $monthQuery = HouseEarning::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);

        $totalEarnings = $totalQuery->sum('commission_amount');
        $todayEarnings = $todayQuery->sum('commission_amount');
        $thisMonthEarnings = $monthQuery->sum('commission_amount');

        // Calcular ganancias filtradas si hay filtros de fecha aplicados
        $filteredEarnings = null;
        $filterDateRange = null;
        if ($request->start_date || $request->end_date) {
            $filteredQuery = HouseEarning::query();
            
            if ($request->start_date && $request->end_date) {
                $filteredQuery->whereDate('created_at', '>=', $request->start_date)
                              ->whereDate('created_at', '<=', $request->end_date);
                $filterDateRange = date('d M Y', strtotime($request->start_date)) . ' - ' . date('d M Y', strtotime($request->end_date));
            } elseif ($request->start_date) {
                $filteredQuery->whereDate('created_at', '>=', $request->start_date);
                $filterDateRange = 'Desde ' . date('d M Y', strtotime($request->start_date));
            } elseif ($request->end_date) {
                $filteredQuery->whereDate('created_at', '<=', $request->end_date);
                $filterDateRange = 'Hasta ' . date('d M Y', strtotime($request->end_date));
            }
            
            $filteredEarnings = $filteredQuery->sum('commission_amount');
        }

        return view('admin.house_earnings.index', compact(
            'pageTitle',
            'earnings',
            'totalEarnings',
            'todayEarnings',
            'thisMonthEarnings',
            'filteredEarnings',
            'filterDateRange',
            'emptyMessage'
        ));
    }

    /**
     * Mostrar detalles de una comisión específica
     */
    public function details($id)
    {
        $pageTitle = 'Earning Details';
        $earning = HouseEarning::with(['user', 'bet.bets.market', 'bet.bets.outcome'])->findOrFail($id);

        return view('admin.house_earnings.details', compact('pageTitle', 'earning'));
    }

    /**
     * API para obtener datos de gráficos
     */
    public function chartData(Request $request)
    {
        $startDate = $request->start_date ?? now()->subDays(30)->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');

        $earnings = HouseEarning::selectRaw('DATE(created_at) as date, SUM(commission_amount) as total')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dates = [];
        $amounts = [];

        foreach ($earnings as $earning) {
            $dates[] = date('M d', strtotime($earning->date));
            $amounts[] = floatval($earning->total);
        }

        return response()->json([
            'dates' => $dates,
            'amounts' => $amounts,
        ]);
    }
}
