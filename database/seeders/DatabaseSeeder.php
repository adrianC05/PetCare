<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Ejecutar seeder de roles y permisos
        $this->call(RoleSeeder::class);

        // Ejecutar seeder de permisos
        $this->call(PermissionSeeder::class);

        // Crear usuarios
        $this->call(UserSeeder::class);

        // Crear mascotas
        $this->call(MascotSeeder::class);

        // Crear citas
        $this->call(AppointmentSeeder::class);
    

    }
}
