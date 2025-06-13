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
        // Bind interface → concrete strategy using latest formula (cached 1h)
        $this->app->bind(LevyStrategyInterface::class, function () {
            $formula = Cache::remember('current_levy_formula', 3600, function () {
                return LevyFormula::orderByDesc('version')->first();
            });
            return new BasicFormulaStrategy($formula);
        });
    }
}
