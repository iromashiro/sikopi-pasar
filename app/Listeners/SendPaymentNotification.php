<?php

namespace App\Listeners;

use App\Events\PaymentRecorded;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPaymentNotification implements ShouldQueue
{
    public function handle(PaymentRecorded $e): void
    {
        $trader = $e->payment->levy->traderKiosk->trader;
        $trader->notify(new \App\Notifications\PaymentSuccessNotification($e->payment));
    }
}
