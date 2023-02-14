<?php

namespace Database\Seeders;

use App\Models\Presentation;
use Illuminate\Database\Seeder;

class PresentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Presentation::create([
            'code' => 'FCC',
            'name' => 'Frizado con Cabeza',
        ]);
        Presentation::create([
            'code' => '1FCC',
            'name' => '1ra. Ncnal. Frizado con Cabeza',
        ]);
        Presentation::create([
            'code' => 'FCCP',
            'name' => 'Frizado con Cabeza Plus',
        ]);
        Presentation::create([
            'code' => 'TOCC',
            'name' => 'Top Open con Cabeza',
        ]);
        Presentation::create([
            'code' => '1TOCC',
            'name' => '1ra. Ncnal. Top Open con Cabeza',
        ]);
        Presentation::create([
            'code' => 'TOCCP',
            'name' => 'Top Open con Cabeza Plus',
        ]);
        Presentation::create([
            'code' => 'FSC',
            'name' => 'Frizado sin Cabeza',
        ]);
        Presentation::create([
            'code' => '1FSC',
            'name' => '1ra. Ncnal. Frizado sin Cabeza',
        ]);
        Presentation::create([
            'code' => 'TOSC',
            'name' => 'Top Open sin Cabeza',
        ]);
    }
}
