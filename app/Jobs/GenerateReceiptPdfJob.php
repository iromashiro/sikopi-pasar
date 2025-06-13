<?php

namespace App\Jobs;

use App\Models\Payment;
use App\Models\Receipt;
use App\Services\ReceiptService;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateReceiptPdfJob implements ShouldQueue
{
    public function __construct(private Payment $payment) {}

    public function handle(ReceiptService $service): void
    {
        $service->generate($this->payment);
    }
}
