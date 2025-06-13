<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    public function create(User $u): bool
    {
        return $u->hasRole(['Collector', 'Admin', 'SuperAdmin']);
    }

    public function generateReceipt(User $u, Payment $p): bool
    {
        return $u->hasRole(['Collector', 'Admin', 'SuperAdmin']);
    }
}
