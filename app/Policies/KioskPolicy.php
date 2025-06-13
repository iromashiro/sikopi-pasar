<?php

namespace App\Policies;

use App\Models\Kiosk;
use App\Models\User;

class KioskPolicy
{
    public function delete(User $u, Kiosk $k): bool
    {
        return $u->hasRole(['Admin', 'SuperAdmin']) && $k->status !== 'occupied';
    }

    public function update(User $u): bool
    {
        return $u->hasRole(['Admin', 'SuperAdmin']);
    }
}
