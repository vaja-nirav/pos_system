<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            'adjustments',
            'brands',
            'currency',
            'customers',
            'dashboard',
            'expense_categories',
            'expenses',
            'language',
            'pos_screen',
            'product_categories',
            'products',
            'purchase',
            'purchase_return',
            'quotations',
            'reports',
            'roles',
            'sale',
            'sale_return',
            'setting',
            'suppliers',
            'transfers',
            'units',
            'users',
            'variations',
            'warehouses',
        ];

        $actions = ['view', 'create', 'update', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::findOrCreate($action . '_' . $module);
            }
        }

        // Create Admin Role and assign all permissions
        $adminRole = Role::findOrCreate('admin');
        $adminRole->givePermissionTo(Permission::all());
    }
}
