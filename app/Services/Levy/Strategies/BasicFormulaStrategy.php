<?php

namespace App\Services\Levy\Strategies;

use App\Models\TraderKiosk;
use App\Models\LevyFormula;
use InvalidArgumentException;

class BasicFormulaStrategy implements LevyStrategyInterface
{
    public function __construct(private LevyFormula $formula) {}

    public function getFormula(): LevyFormula
    {
        return $this->formula;
    }

    public function calculate(TraderKiosk $tk): int
    {
        if ($this->formula->base_rate <= 0) {
            throw new InvalidArgumentException('Base rate must be positive');
        }

        $rate = $this->formula->base_rate;
        $rate *= max(0, $this->formula->category_mult);
        $rate *= (max(0, $this->formula->area_mult) * max(0, $tk->kiosk->area_m2)) / 10;

        $override = $this->formula->overrides[$tk->kiosk->category] ?? null;
        if ($override !== null && $override > 0) {
            $rate = $override;
        }

        $result = (int) round($rate, 0);
        if ($result < 0 || $result > 100_000_000) {
            throw new InvalidArgumentException('Calculated levy out of bounds');
        }

        return $result;
    }
}
