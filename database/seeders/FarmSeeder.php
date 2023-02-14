<?php

namespace Database\Seeders;

use App\Models\Farm;
use Illuminate\Database\Seeder;

class FarmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Farm::create([
            'code' => '001',
            'name' => 'Cuna de Oro',
        ]);
        Farm::create([
            'code' => '002',
            'name' => 'Laguna',
        ]);
        Farm::create([
            'code' => '003',
            'name' => 'Luna Nueva',
        ]);
        Farm::create([
            'code' => '004',
            'name' => 'Playa de Oro',
        ]);
        Farm::create([
            'code' => '005',
            'name' => 'Playa Negra',
        ]);
        Farm::create([
            'code' => '006',
            'name' => 'Ajuste',
        ]);

    }
}
