<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear rol super_admin si no existe
        $role = Role::firstOrCreate(['name' => 'super_admin']);

        // Recursos existentes
        $resources = ['Role', 'Permission', 'User', 'Mascot', 'Appointment'];

        // Acciones
        $actions = ['ViewAny', 'View', 'Create', 'Update', 'Delete', 'Restore', 'ForceDelete', 'ForceDeleteAny', 'RestoreAny', 'Replicate', 'Reorder'];

        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => $action . ':' . $resource]);
            }
        }

        // Asignar todos los permisos al rol
        $role->syncPermissions(Permission::all());
    }
}
