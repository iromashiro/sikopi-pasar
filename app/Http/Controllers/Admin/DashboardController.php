<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Admin|SuperAdmin');
    }

    public function __invoke(ReportService $rs)
    {
        $year = now()->year;
        $trend = $rs->collectionVsTarget($year);
        $overdue = $rs->overdue()->count();
        $today   = $rs->daily(now())->where('day', now()->toDateString())->first()->total ?? 0;

        return view('admin.dashboard', compact('trend', 'overdue', 'today', 'year'));
    }
}
