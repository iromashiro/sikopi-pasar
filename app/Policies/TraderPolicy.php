<?php

namespace App\Policies;

use App\Models\Trader;
use App\Models\User;

class TraderPolicy
{
    public function view(User $user, Trader $trader): bool
    {
        return $user->hasRole(['Admin', 'SuperAdmin']);
    }

    public function update(User $user, Trader $trader): bool
    {
        return $user->hasRole(['Admin', 'SuperAdmin']) && $trader->status === 'active';
    }

    public function delete(User $user, Trader $trader): bool
    {
        return $user->hasRole('SuperAdmin');
    }
}
