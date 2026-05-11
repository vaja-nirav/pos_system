<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Role
        $adminRole = \Spatie\Permission\Models\Role::findOrCreate('admin');
        $adminRole->syncPermissions(\Spatie\Permission\Models\Permission::all());

        // Cashier Role
        $cashierRole = \Spatie\Permission\Models\Role::findOrCreate('cashier');
        $cashierRole->syncPermissions([
            'view_dashboard',
            'view_pos_screen',
            'create_sale',
            'view_products',
        ]);

        // Manager Role
        $managerRole = \Spatie\Permission\Models\Role::findOrCreate('manager');
        $managerRole->syncPermissions(\Spatie\Permission\Models\Permission::where('name', 'like', 'view_%')
            ->orWhere('name', 'like', 'create_%')
            ->orWhere('name', 'like', 'update_%')
            ->get());
    }
}
