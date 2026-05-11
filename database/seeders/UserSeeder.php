<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('password'),
                'status'   => true,
                'phone'    => '1234567890',
            ]
        );

        // Assign Role
        $admin->assignRole('admin');

        $cashier = User::firstOrCreate(
            ['email' => 'cashier@admin.com'],
            [
                'name'     => 'Test Cashier',
                'password' => Hash::make('password'),
                'status'   => true,
                'phone'    => '0987654321',
            ]
        );

        $cashier->assignRole('cashier');
    }
}
