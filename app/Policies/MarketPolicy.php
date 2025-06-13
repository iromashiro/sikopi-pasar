<?php

namespace App\Policies;

use App\Models\Market;
use App\Models\User;

class MarketPolicy
{
    public function delete(User $user, Market $market): bool
    {
        if ($market->kiosks()->exists()) {
            return $user->hasRole('SuperAdmin');
        }
        return $user->hasRole(['Admin', 'SuperAdmin']);
    }

    public function update(User $u): bool
    {
        return $u->hasRole(['Admin', 'SuperAdmin']);
    }
}
