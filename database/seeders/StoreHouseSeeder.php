<?php

namespace Database\Seeders;

use App\Models\StoreHouse;
use Illuminate\Database\Seeder;

class StoreHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StoreHouse::create([
            'code' => 'AL1',
            'name' => 'Almacén 1',
        ]);
        StoreHouse::create([
            'code' => 'AL2',
            'name' => 'Almacén 2',
        ]);
        StoreHouse::create([
            'code' => 'AL3',
            'name' => 'Almacén 3',
        ]);
    }
}
