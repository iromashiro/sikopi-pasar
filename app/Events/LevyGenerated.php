<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Levy;

class LevyGenerated
{
    use Dispatchable;
    public function __construct(public Levy $levy) {}
}
