<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Market;
use App\Models\Kiosk;

class KioskSeeder extends Seeder
{
    public function run(): void
    {
        $markets = Market::all();
        $categories = ['Sayuran', 'Buah-buahan', 'Daging', 'Ikan', 'Bumbu', 'Kue', 'Pakaian', 'Elektronik'];
        $totalKiosks = 0;

        foreach ($markets as $market) {
            // Setiap market punya 15-25 kiosk
            $kioskCount = rand(15, 25);

            for ($i = 1; $i <= $kioskCount; $i++) {
                $kioskNo = sprintf('%s%02d', substr($market->name, 6, 1), $i); // A01, B01, etc

                Kiosk::firstOrCreate(
                    [
                        'market_id' => $market->id,
                        'kiosk_no' => $kioskNo,
                    ],
                    [
                        'category' => $categories[array_rand($categories)],
                        'area_m2' => rand(6, 20), // 6-20 m²
                        'status' => rand(1, 10) <= 8 ? 'available' : 'occupied', // 80% available
                    ]
                );
                $totalKiosks++;
            }
        }

        $this->command->info("Created {$totalKiosks} kiosks across all markets");
    }
}
