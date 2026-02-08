<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Appointment::factory()->count(10)->create(); --- IGNORE ---
        Appointment::firstOrCreate([
            'mascot_id' => 1,
            'veterinarian_id' => 2,
            'appointment_date' => '2023-02-01 10:00:00',
            'reason' => 'Consulta general',
        ]);
    }
}
