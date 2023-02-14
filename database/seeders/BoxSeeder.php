<?php

namespace Database\Seeders;

use App\Models\Box;
use App\Models\Presentation;
use App\Models\Size;
use Illuminate\Database\Seeder;

class BoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $presentations = Presentation::all();
        $sizes = Size::whereIn('id', [1,2,3,4,5,6])->get();
        foreach($presentations as $presentation) {
            foreach($sizes as $size) {
                Box::create([
                    'id_presentation' => $presentation->id,
                    'id_size' => $size->id,
                    'code' => $presentation->code.$size->code,
                    'name' => $presentation->name . ' ' . $size->name,
                    'kilograms' => '2',
                    'price' => 100,
                    'cost' => 100
                ]);
            }
        }

        Box::create([
            'id_presentation' => 1,
            'id_size' => 7,
            'code' => 'FCL',
            'name' => 'Larva',
            'kilograms' => '2',
            'price' => 100,
            'cost' => 100
        ]);

    }
}
