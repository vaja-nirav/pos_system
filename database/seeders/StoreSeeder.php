<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::updateOrCreate(
            ['name' => 'Local Store'],
            [
                'code' => 'LOCAL-01',
                'status' => 1,
            ]
        );
    }
}
