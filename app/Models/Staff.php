<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class Staff extends User
{
    protected $table = 'users';

    // 1. OBLIGATORIO: Engañar a Laravel para que busque las relaciones 
    // (roles, permisos) usando el nombre del modelo padre 'User'.
    public function getMorphClass()
    {
        return User::class;
    }

    public static function viewQuery()
    {
        // Devuelve objetos 'Staff' para que Filament use 'StaffPolicy'.
        
        return static::query()->whereHas('roles', function ($query) {
            $query->whereNotIn('name', [
                'dueno_de_mascota', 
                'super_admin' 
            ]);
        });
    }
}