<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Receipt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Events\ReceiptGenerated;

class ReceiptService
{
    public function generate(Payment $payment): Receipt
    {
        // authorization via policy
        if (!auth()->user()?->can('generate-receipt', $payment)) {
            throw new \Illuminate\Auth\Access\AuthorizationException;
        }

        try {
            $data = ['payment' => $payment->load('levy.traderKiosk.trader', 'levy.traderKiosk.kiosk')];
            $pdf  = Pdf::loadView('pdf.receipt', $data);

            $path = 'receipts/' . $payment->receipt_no . '.pdf';
            if (!Storage::put($path, $pdf->output())) {
                throw new \Exception('Failed to store PDF');
            }

            $receipt = Receipt::create([
                'payment_id' => $payment->id,
                'pdf_path'  => $path,
            ]);

            ReceiptGenerated::dispatch($receipt);
            return $receipt;
        } catch (\Throwable $e) {
            Log::error('Receipt gen failed', ['payment_id' => $payment->id, 'msg' => $e->getMessage()]);
            throw $e;
        }
    }
}
