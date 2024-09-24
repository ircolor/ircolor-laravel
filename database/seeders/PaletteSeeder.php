<?php

namespace Database\Seeders;

use App\Models\Palette;
use Illuminate\Database\Seeder;

class PaletteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Palette::factory(5)->create();
    }
}
