<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Market;

class MarketSeeder extends Seeder
{
    public function run(): void
    {
        $markets = [
            [
                'name' => 'Pasar Sentral Kota',
                'location' => 'Jl. Merdeka No. 123, Kota Bandung',
                'status' => 'active',
            ],
            [
                'name' => 'Pasar Tradisional Utara',
                'location' => 'Jl. Sudirman No. 45, Bandung Utara',
                'status' => 'active',
            ],
            [
                'name' => 'Pasar Minggu Selatan',
                'location' => 'Jl. Asia Afrika No. 67, Bandung Selatan',
                'status' => 'active',
            ],
            [
                'name' => 'Pasar Lama Timur',
                'location' => 'Jl. Braga No. 89, Bandung Timur',
                'status' => 'inactive',
            ],
        ];

        foreach ($markets as $market) {
            Market::firstOrCreate(
                ['name' => $market['name']],
                $market
            );
        }

        $this->command->info('Created ' . count($markets) . ' markets');
    }
}
