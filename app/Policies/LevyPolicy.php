<?php

namespace App\Policies;

use App\Models\Levy;
use App\Models\User;

class LevyPolicy
{
    public function view(User $u): bool
    {
        return $u->hasRole(['Admin', 'SuperAdmin']);
    }
    public function regenerate(User $u): bool
    {
        return $u->hasRole('SuperAdmin');
    }
}
