<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Trader permissions
            'traders.view',
            'traders.create',
            'traders.edit',
            'traders.delete',

            // Kiosk permissions
            'kiosks.view',
            'kiosks.create',
            'kiosks.edit',
            'kiosks.delete',

            // Market permissions
            'markets.view',
            'markets.create',
            'markets.edit',
            'markets.delete',

            // Levy permissions
            'levies.view',
            'levies.create',
            'levies.regenerate',

            // Payment permissions
            'payments.view',
            'payments.create',

            // Report permissions
            'reports.view',
            'reports.export',

            // Dashboard permissions
            'dashboard.admin',
            'dashboard.trader',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdmin = Role::firstOrCreate(['name' => 'SuperAdmin']);
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $collector = Role::firstOrCreate(['name' => 'Collector']);
        $trader = Role::firstOrCreate(['name' => 'Trader']);

        // Assign permissions to roles
        $superAdmin->givePermissionTo(Permission::all());

        $admin->givePermissionTo([
            'traders.view',
            'traders.create',
            'traders.edit',
            'kiosks.view',
            'kiosks.create',
            'kiosks.edit',
            'markets.view',
            'markets.create',
            'markets.edit',
            'levies.view',
            'levies.create',
            'payments.view',
            'payments.create',
            'reports.view',
            'reports.export',
            'dashboard.admin',
        ]);

        $collector->givePermissionTo([
            'traders.view',
            'kiosks.view',
            'levies.view',
            'payments.view',
            'payments.create',
            'reports.view',
        ]);

        $trader->givePermissionTo([
            'dashboard.trader',
        ]);
    }
}
