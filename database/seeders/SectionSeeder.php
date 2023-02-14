<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Section::create([
            'code' => 'A',
            'name' => 'A',
        ]);
        Section::create([
            'code' => 'B',
            'name' => 'B',
        ]);
        Section::create([
            'code' => 'C',
            'name' => 'C',
        ]);
        Section::create([
            'code' => 'D',
            'name' => 'D',
        ]);
    }
}
