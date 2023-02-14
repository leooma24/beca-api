<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'name' => 'Precosecha',
            'type' => 1,
            'shipment' => 0,
        ]);
        Type::create([
            'name' => 'Cosecha',
            'type' => 1,
            'shipment' => 0,
        ]);
        Type::create([
            'name' => 'Embarque',
            'type' => 2,
            'shipment' => 1,
        ]);
        Type::create([
            'name' => 'Merma',
            'type' => 2,
            'shipment' => 0,
        ]);
    }
}
