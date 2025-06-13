<?php

namespace App\Services;

use App\Models\Levy;
use App\Models\Payment;
use App\Models\Receipt;
use App\Services\Contracts\BaseService;
use App\Events\PaymentRecorded;
use App\Jobs\GenerateReceiptPdfJob;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PaymentService extends BaseService
{
    public function __construct(private AuditService $audit) {}

    public function record(Levy $levy, array $data): Payment
    {
        return $this->withTransaction(function () use ($levy, $data) {

            $amountPaid = $data['amount'];
            $status = $amountPaid >= $levy->amount ? 'paid'
                : ($amountPaid > 0 ? 'partial' : 'pending');

            $receiptNo = $this->createReceiptNo();

            $payment = Payment::create([
                'levy_id'       => $levy->id,
                'paid_at'       => $data['paid_at'],
                'amount'        => $amountPaid,
                'method'        => $data['method'] ?? 'cash',
                'collector_name' => $data['collector_name'] ?? auth()->user()->name,
                'receipt_no'    => $receiptNo,
            ]);

            $levy->update(['status' => $status]);

            $this->audit->log('created', $payment);
            PaymentRecorded::dispatch($payment);
            // queue receipt generation
            GenerateReceiptPdfJob::dispatch($payment);

            return $payment;
        });
    }

    private function createReceiptNo(): string
    {
        return \DB::transaction(function () {
            $prefix = 'RCPT-' . now()->format('Ym') . '-';

            $last = Payment::where('receipt_no', 'like', $prefix . '%')
                ->lockForUpdate()
                ->orderByDesc('receipt_no')
                ->first();

            $next = $last ? ((int) substr($last->receipt_no, -4)) + 1 : 1;

            return $prefix . str_pad((string) $next, 4, '0', STR_PAD_LEFT);
        });
    }
}
