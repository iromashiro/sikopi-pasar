<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Payment;

class PaymentRecorded
{
    use Dispatchable;
    public function __construct(public Payment $payment) {}
}
