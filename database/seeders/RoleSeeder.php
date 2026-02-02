<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Veterinario']);
        Role::create(['name' => 'Dueño de Mascota']);
    }
}
