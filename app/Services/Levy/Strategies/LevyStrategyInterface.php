<?php

namespace App\Services\Levy\Strategies;

use App\Models\TraderKiosk;

interface LevyStrategyInterface
{
    public function calculate(TraderKiosk $tk): int;
}
