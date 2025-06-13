<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Levy\Strategies\{
    LevyStrategyInterface,
    BasicFormulaStrategy
};
use App\Models\LevyFormula;
use Illuminate\Support\Facades\Cache;

class LevyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LevyStrategyInterface::class, function () {
            $formula = Cache::remember(
                'current_levy_formula',
                3600,
                fn() =>
                LevyFormula::orderByDesc('version')->first()
            );

            return new BasicFormulaStrategy($formula);
        });
    }
}
