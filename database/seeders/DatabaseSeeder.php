<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            MarketSeeder::class,
            KioskSeeder::class,
            TraderSeeder::class,
            TraderKioskSeeder::class,
            LevyFormulaSeeder::class,
            LevySeeder::class,
            PaymentSeeder::class,
        ]);
    }
}
