<?php

namespace App\Services\Levy;

use App\Models\TraderKiosk;
use App\Services\Levy\Strategies\LevyStrategyInterface;

class LevyCalculationService
{
    public function __construct(private LevyStrategyInterface $strategy) {}

    public function calculate(TraderKiosk $tk): int
    {
        return $this->strategy->calculate($tk);
    }

    public function getStrategy(): LevyStrategyInterface
    {
        return $this->strategy;
    }
}
