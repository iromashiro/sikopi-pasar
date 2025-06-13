<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportService
{
    /** Get collection total per day in given month */
    public function daily(Carbon $month): Collection
    {
        return DB::table('payments')
            ->selectRaw('DATE(paid_at) AS day, SUM(amount) AS total')
            ->whereBetween('paid_at', [
                $month->copy()->startOfMonth(),
                $month->copy()->endOfMonth()
            ])
            ->groupBy('day')
            ->orderBy('day')
            ->get();
    }

    /** Monthly totals current year */
    public function monthly(int $year): Collection
    {
        return DB::table('payments')
            ->selectRaw('EXTRACT(MONTH FROM paid_at)::int AS m, SUM(amount) AS total')
            ->whereYear('paid_at', $year)
            ->groupByRaw('m')
            ->orderByRaw('m')
            ->get();
    }

    /** List overdue levies */
    public function overdue(): Collection
    {
        return DB::table('levies as l')
            ->join('trader_kiosk as tk', 'tk.id', '=', 'l.trader_kiosk_id')
            ->join('traders as t', 't.id', '=', 'tk.trader_id')
            ->join('kiosks as k', 'k.id', '=', 'tk.kiosk_id')
            ->select(
                'l.id',
                'l.period_month',
                'l.due_date',
                'l.amount',
                't.name as trader',
                'k.kiosk_no'
            )
            ->where('l.status', 'overdue')
            ->orderBy('l.due_date')
            ->get();
    }

    /** Collection vs target (assume target table later → for now config) */
    public function collectionVsTarget(int $year): Collection
    {
        $monthly = $this->monthly($year)->pluck('total', 'm');
        $target  = config('levy.target_monthly', 100_000_000);   // fallback
        return collect(range(1, 12))->map(fn($m) => [
            'month' => $m,
            'collected' => $monthly[$m] ?? 0,
            'target' => $target
        ]);
    }
}
