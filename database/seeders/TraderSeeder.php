<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trader;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TraderSeeder extends Seeder
{
    public function run(): void
    {
        $traders = [
            [
                'nik' => '3273010101850001',
                'name' => 'Ahmad Wijaya',
                'address' => 'Jl. Kebon Jeruk No. 12, Bandung',
                'phone' => '081234567890',
                'status' => 'active',
            ],
            [
                'nik' => '3273010201860002',
                'name' => 'Sari Indah',
                'address' => 'Jl. Cihampelas No. 34, Bandung',
                'phone' => '081234567891',
                'status' => 'active',
            ],
            [
                'nik' => '3273010301870003',
                'name' => 'Bambang Sutrisno',
                'address' => 'Jl. Dago No. 56, Bandung',
                'phone' => '081234567892',
                'status' => 'active',
            ],
            [
                'nik' => '3273010401880004',
                'name' => 'Dewi Sartika',
                'address' => 'Jl. Pasteur No. 78, Bandung',
                'phone' => '081234567893',
                'status' => 'active',
            ],
            [
                'nik' => '3273010501890005',
                'name' => 'Joko Susilo',
                'address' => 'Jl. Setiabudhi No. 90, Bandung',
                'phone' => '081234567894',
                'status' => 'active',
            ],
            [
                'nik' => '3273010601900006',
                'name' => 'Rina Marlina',
                'address' => 'Jl. Buah Batu No. 12, Bandung',
                'phone' => '081234567895',
                'status' => 'active',
            ],
            [
                'nik' => '3273010701910007',
                'name' => 'Hendra Gunawan',
                'address' => 'Jl. Sukajadi No. 34, Bandung',
                'phone' => '081234567896',
                'status' => 'active',
            ],
            [
                'nik' => '3273010801920008',
                'name' => 'Maya Sari',
                'address' => 'Jl. Cipaganti No. 56, Bandung',
                'phone' => '081234567897',
                'status' => 'active',
            ],
            [
                'nik' => '3273010901930009',
                'name' => 'Agus Salim',
                'address' => 'Jl. Ciumbuleuit No. 78, Bandung',
                'phone' => '081234567898',
                'status' => 'active',
            ],
            [
                'nik' => '3273011001940010',
                'name' => 'Lestari Wulan',
                'address' => 'Jl. Setiabudi No. 90, Bandung',
                'phone' => '081234567899',
                'status' => 'inactive',
            ],
        ];

        foreach ($traders as $traderData) {
            $trader = Trader::firstOrCreate(
                ['nik' => $traderData['nik']],
                $traderData
            );

            // Create user account for each trader
            $email = strtolower(str_replace(' ', '.', $trader->name)) . '@trader.sikopi.local';
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $trader->name,
                    'password' => Hash::make('trader123'),
                    'email_verified_at' => now(),
                ]
            );
            $user->assignRole('Trader');
        }

        $this->command->info('Created ' . count($traders) . ' traders with user accounts');
        $this->command->info('Trader login format: firstname.lastname@trader.sikopi.local / trader123');
    }
}
