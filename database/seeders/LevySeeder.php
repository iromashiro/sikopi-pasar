<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TraderKiosk;
use App\Models\Levy;
use App\Models\LevyFormula;
use Carbon\Carbon;

class LevySeeder extends Seeder
{
    public function run(): void
    {
        $activeAssignments = TraderKiosk::whereNull('end_date')->with(['kiosk'])->get();
        $currentFormula = LevyFormula::orderByDesc('version')->first();

        $levyCount = 0;

        // Generate levies for last 6 months
        for ($monthsBack = 5; $monthsBack >= 0; $monthsBack--) {
            $period = Carbon::now()->subMonths($monthsBack);
            $periodString = $period->format('Ym');
            $dueDate = $period->copy()->addDays(10); // Due on 10th of each month

            foreach ($activeAssignments as $assignment) {
                // Skip if assignment started after this period
                if ($assignment->start_date > $period) continue;

                // Calculate amount based on kiosk
                $baseAmount = $currentFormula->base_rate;
                $categoryOverride = $currentFormula->overrides[$assignment->kiosk->category] ?? null;

                if ($categoryOverride) {
                    $amount = $categoryOverride;
                } else {
                    $amount = $baseAmount * $currentFormula->category_mult *
                        ($assignment->kiosk->area_m2 / 10) * $currentFormula->area_mult;
                }

                $amount = (int) round($amount);

                // Determine status based on period
                $status = 'pending';
                if ($monthsBack >= 3) {
                    // Older levies have varied status
                    $rand = rand(1, 10);
                    if ($rand <= 7) $status = 'paid';
                    elseif ($rand <= 9) $status = 'partial';
                    else $status = 'overdue';
                } elseif ($monthsBack >= 1) {
                    $rand = rand(1, 10);
                    if ($rand <= 5) $status = 'paid';
                    elseif ($rand <= 7) $status = 'partial';
                    else $status = 'pending';
                }

                Levy::firstOrCreate(
                    [
                        'trader_kiosk_id' => $assignment->id,
                        'period_month' => $periodString,
                    ],
                    [
                        'due_date' => $dueDate,
                        'amount' => $amount,
                        'status' => $status,
                        'formula_version' => $currentFormula->version,
                    ]
                );

                $levyCount++;
            }
        }

        $this->command->info("Created {$levyCount} levy records for last 6 months");
    }
}
