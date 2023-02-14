<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Size::create([
            'code' => '1020',
            'name' => '10/20',
        ]);
        Size::create([
            'code' => '2030',
            'name' => '20/30',
        ]);
        Size::create([
            'code' => '3040',
            'name' => '30/40',
        ]);
        Size::create([
            'code' => '4050',
            'name' => '40/50',
        ]);
        Size::create([
            'code' => '5060',
            'name' => '50/60',
        ]);
        Size::create([
            'code' => '6070',
            'name' => '60/70',
        ]);
        Size::create([
            'code' => 'LARVA',
            'name' => 'Larva',
        ]);
    }
}
