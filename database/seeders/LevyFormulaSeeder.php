<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LevyFormula;
use Carbon\Carbon;

class LevyFormulaSeeder extends Seeder
{
    public function run(): void
    {
        $formulas = [
            [
                'base_rate' => 5000,
                'category_mult' => 1.0,
                'area_mult' => 1.0,
                'overrides' => [
                    'Sayuran' => 4000,
                    'Buah-buahan' => 4500,
                    'Daging' => 7000,
                    'Ikan' => 6000,
                ],
                'version' => 1,
                'effective_date' => Carbon::now()->subYear(),
            ],
            [
                'base_rate' => 6000,
                'category_mult' => 1.2,
                'area_mult' => 1.1,
                'overrides' => [
                    'Sayuran' => 5000,
                    'Buah-buahan' => 5500,
                    'Daging' => 8000,
                    'Ikan' => 7000,
                    'Elektronik' => 12000,
                ],
                'version' => 2,
                'effective_date' => Carbon::now()->subMonths(6),
            ],
            [
                'base_rate' => 7000,
                'category_mult' => 1.3,
                'area_mult' => 1.2,
                'overrides' => [
                    'Sayuran' => 6000,
                    'Buah-buahan' => 6500,
                    'Daging' => 9000,
                    'Ikan' => 8000,
                    'Elektronik' => 15000,
                    'Pakaian' => 10000,
                ],
                'version' => 3,
                'effective_date' => Carbon::now(),
            ],
        ];

        foreach ($formulas as $formula) {
            LevyFormula::firstOrCreate(
                ['version' => $formula['version']],
                $formula
            );
        }

        $this->command->info('Created ' . count($formulas) . ' levy formulas');
    }
}
