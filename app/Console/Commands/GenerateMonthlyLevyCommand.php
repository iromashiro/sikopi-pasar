<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TraderKiosk;
use App\Models\LevyFormula;
use App\Services\Levy\{
    Strategies\BasicFormulaStrategy,
    LevyCalculationService,
    LevyService
};

class GenerateMonthlyLevyCommand extends Command
{
    protected $signature   = 'levy:generate {--month=}';
    protected $description = 'Generate levies for active trader-kiosk pairs';

    public function handle(LevyService $levyService): int
    {
        $month = $this->option('month') ?? now()->format('Ym');
        $due   = now()->startOfMonth()->addDays(config('levy.due_day', 10));
        $count = 0;

        \DB::transaction(function () use ($levyService, $month, $due, &$count) {
            \App\Models\TraderKiosk::whereNull('end_date')
                ->with(['trader', 'kiosk'])
                ->chunk(100, function ($chunk) use ($levyService, $month, $due, &$count) {
                    foreach ($chunk as $tk) {
                        $levyService->generateFor($tk, $month, $due);
                        $count++;
                    }
                });
        });

        $this->info("Generated {$count} levies for {$month}");
        return self::SUCCESS;
    }
}
