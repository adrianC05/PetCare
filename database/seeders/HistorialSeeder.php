<?php

namespace Database\Seeders;

use App\Models\HistorialMedico;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistorialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Historial::factory()->count(10)->create(); --- IGNORE ---

            HistorialMedico::firstOrCreate([
                'mascot_id' => 1,
                'veterinarian_id' => 2,
                'visit_date' => '2023-01-01',
                'diagnosis' => 'Gripe canina',
                'treatment' => 'Reposo y medicamentos',
            ]);
    }
}
