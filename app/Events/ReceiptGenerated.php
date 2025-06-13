<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Receipt;

class ReceiptGenerated
{
    use Dispatchable;
    public function __construct(public Receipt $receipt) {}
}
