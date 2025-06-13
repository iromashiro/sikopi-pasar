<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use App\Services\Exports\PaymentReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Admin|SuperAdmin');
    }

    public function show(string $type, ReportService $service)
    {
        abort_unless(in_array($type, ['daily', 'monthly', 'overdue']), 404);
        $data = match ($type) {
            'daily'   => $service->daily(now()),
            'monthly' => $service->monthly(now()->year),
            default   => $service->overdue(),
        };
        return view('admin.reports.show', compact('data', 'type'));
    }

    public function export(string $type, string $fmt)
    {
        abort_unless(in_array($fmt, ['xlsx', 'csv']), 404);
        return Excel::download(new PaymentReportExport($type), "report-{$type}.{$fmt}");
    }
}
