<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trader;
use App\Models\Kiosk;
use App\Models\TraderKiosk;
use Carbon\Carbon;

class TraderKioskSeeder extends Seeder
{
    public function run(): void
    {
        $traders = Trader::where('status', 'active')->get();
        $availableKiosks = Kiosk::where('status', 'available')->get();

        $assignments = 0;

        // Assign 70% of active traders to kiosks
        $tradersToAssign = $traders->take(ceil($traders->count() * 0.7));

        foreach ($tradersToAssign as $trader) {
            if ($availableKiosks->isEmpty()) break;

            // Pick random kiosk
            $kiosk = $availableKiosks->random();
            $availableKiosks = $availableKiosks->except([$kiosk->id]);

            // Create assignment (started 1-6 months ago)
            $startDate = Carbon::now()->subMonths(rand(1, 6))->startOfMonth();

            TraderKiosk::firstOrCreate(
                [
                    'trader_id' => $trader->id,
                    'kiosk_id' => $kiosk->id,
                    'end_date' => null, // Active assignment
                ],
                [
                    'start_date' => $startDate,
                ]
            );

            // Update kiosk status
            $kiosk->update(['status' => 'occupied']);
            $assignments++;
        }

        // Create some historical assignments (ended)
        $historicalCount = 5;
        for ($i = 0; $i < $historicalCount; $i++) {
            $trader = $traders->random();
            $kiosk = Kiosk::inRandomOrder()->first();

            $startDate = Carbon::now()->subYear()->addMonths(rand(1, 6));
            $endDate = $startDate->copy()->addMonths(rand(2, 8));

            TraderKiosk::create([
                'trader_id' => $trader->id,
                'kiosk_id' => $kiosk->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);
        }

        $this->command->info("Created {$assignments} active trader-kiosk assignments");
        $this->command->info("Created {$historicalCount} historical assignments");
    }
}
