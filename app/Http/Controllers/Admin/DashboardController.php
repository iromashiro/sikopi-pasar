<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Levy;
use App\Models\Trader;
use App\Models\Kiosk;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

        return view('admin.dashboard', compact('today', 'overdue', 'trend', 'year'));
    }
}
