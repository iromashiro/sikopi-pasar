<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LevyFormula;

class LevyFormulaSeeder extends Seeder
{
    public function run(): void
    {
        LevyFormula::firstOrCreate(
            ['version' => 1],
            [
                'base_rate'     => 5000,
                'category_mult' => 1,
                'area_mult'     => 1,
                'overrides'     => null,
                'effective_date' => now(),
            ]
        );
    }
}
