<?php

namespace Database\Seeders;

use App\Models\Mascot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MascotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mascota::factory()->count(10)->create(); --- IGNORE ---

        Mascot::firstOrCreate([
            'name' => 'Firulais',
            'species' => 'Perro',
            'breed' => 'Labrador',
            "birthdate" => '2020-01-01',
            "weight" => 30.5,
            'owner_id' => 3,
        ]);
    }
}
