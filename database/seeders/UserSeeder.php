<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario admin
        $admin = User::firstOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'name' => 'Admin',
            'lastname' => 'User',
            'phone' => '123456789',
            'password' => bcrypt('admin'), 
        ]);

        $veterinario = User::firstOrCreate([
            'email' => 'veterinario@gmail.com',
        ], [
            'name' => 'Veterinarian',
            'lastname' => 'User',
            'phone' => '987654321',
            'password' => bcrypt(value: 'veterinario'), 
        ]);

        $dueno = User::firstOrCreate([
            'email' => 'dueno@gmail.com',
        ], [
            'name' => 'Owner',
            'lastname' => 'User',
            'phone' => '555555555',
            'password' => bcrypt(value: 'dueno'), 
        ]);

        // Asignar rol super_admin al usuario admin
        $admin->assignRole('super_admin');
        $veterinario->assignRole('veterinario');
        $dueno->assignRole('dueno_de_mascota');
    }
}
