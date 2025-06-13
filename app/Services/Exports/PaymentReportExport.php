<?php

namespace App\Services\Exports;

use App\Services\ReportService;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping};

class PaymentReportExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private string $type) {}

    public function collection()
    {
        $svc = app(ReportService::class);
        return match ($this->type) {
            'daily'   => $svc->daily(now()),
            'monthly' => $svc->monthly(now()->year),
            default   => $svc->overdue(),
        };
    }

    public function headings(): array
    {
        return match ($this->type) {
            'daily'   => ['Tanggal', 'Total (Rp)'],
            'monthly' => ['Bulan', 'Total (Rp)'],
            default   => ['ID Levy', 'Periode', 'Jatuh Tempo', 'Jumlah', 'Pedagang', 'Kios'],
        };
    }

    public function map($row): array
    {
        if ($this->type === 'overdue') return [
            $row->id,
            $row->period_month,
            $row->due_date,
            $row->amount,
            $row->trader,
            $row->kiosk_no
        ];
        return [$row->day ?? $row->m, $row->total];
    }
}
