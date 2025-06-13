<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@sikopi.go.id'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole('SuperAdmin');

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@sikopi.go.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('Admin');

        // Collector 1
        $collector1 = User::firstOrCreate(
            ['email' => 'collector1@sikopi.go.id'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $collector1->assignRole('Collector');

        // Collector 2
        $collector2 = User::firstOrCreate(
            ['email' => 'collector2@sikopi.go.id'],
            [
                'name' => 'Siti Rahayu',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $collector2->assignRole('Collector');

        // Trader users (will be created after traders)
        $this->command->info('Created system users with default password: password');
    }
}
