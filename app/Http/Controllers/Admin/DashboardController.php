<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Levy;
use App\Models\Trader;
use App\Models\Kiosk;
use App\Models\Market;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', now()->year);

        // Today's collection
        $today = Payment::whereDate('paid_at', today())->sum('amount');

        // Overdue levies count
        $overdue = Levy::where('status', 'overdue')->count();

        // Monthly trend data for chart
        $trend = collect();
        for ($month = 1; $month <= 12; $month++) {
            $collected = Payment::whereYear('paid_at', $year)
                ->whereMonth('paid_at', $month)
                ->sum('amount');

            $target = config('levy.target_monthly', 100000000); // 100M default

            $trend->push([
                'month' => $month,
                'collected' => $collected,
                'target' => $target,
            ]);
        }

        // Kiosk occupancy data per market
        $kioskOccupancy = Market::withCount([
            'kiosks',
            'kiosks as occupied_kiosks_count' => function ($query) {
                $query->where('status', 'occupied');
            },
            'kiosks as available_kiosks_count' => function ($query) {
                $query->where('status', 'available');
            },
            'kiosks as inactive_kiosks_count' => function ($query) {
                $query->where('status', 'inactive');
            }
        ])->where('status', 'active')
            ->orderBy('name')
            ->get()
            ->map(function ($market) {
                $occupancyRate = $market->kiosks_count > 0
                    ? round(($market->occupied_kiosks_count / $market->kiosks_count) * 100, 1)
                    : 0;

                return [
                    'name' => $market->name,
                    'total' => $market->kiosks_count,
                    'occupied' => $market->occupied_kiosks_count,
                    'available' => $market->available_kiosks_count,
                    'inactive' => $market->inactive_kiosks_count,
                    'occupancy_rate' => $occupancyRate
                ];
            });

        // Market comparison data
        $marketComparison = Market::select('markets.name')
            ->withCount('kiosks')
            ->where('markets.status', 'active')
            ->orderBy('kiosks_count', 'desc')
            ->get()
            ->map(function ($market) {
                return [
                    'name' => $market->name,
                    'total_kiosks' => $market->kiosks_count
                ];
            });

        // Overall statistics
        $totalKiosks = Kiosk::count();
        $occupiedKiosks = Kiosk::where('status', 'occupied')->count();
        $availableKiosks = Kiosk::where('status', 'available')->count();
        $inactiveKiosks = Kiosk::where('status', 'inactive')->count();
        $overallOccupancyRate = $totalKiosks > 0 ? round(($occupiedKiosks / $totalKiosks) * 100, 1) : 0;

        // Active traders count
        $activeTraders = Trader::where('status', 'active')->count();

        // Recent activities (last 7 days)
        $recentPayments = Payment::with(['levy.traderKiosk.trader', 'levy.traderKiosk.kiosk.market'])
            ->whereDate('paid_at', '>=', now()->subDays(7))
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'today',
            'overdue',
            'trend',
            'year',
            'kioskOccupancy',
            'marketComparison',
            'totalKiosks',
            'occupiedKiosks',
            'availableKiosks',
            'inactiveKiosks',
            'overallOccupancyRate',
            'activeTraders',
            'recentPayments'
        ));
    }
}
