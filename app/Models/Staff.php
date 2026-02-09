<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class Staff extends User
{
    protected $table = 'users';

    public static function viewQuery()
    {
        // LÓGICA: "Tráeme los usuarios que tengan AL MENOS UN rol 
        // que NO esté en la lista de prohibidos".
        
        return User::query()->whereHas('roles', function ($query) {
            $query->whereNotIn('name', [
                'dueno_de_mascota', 
                'super_admin' // Mantenlo aquí si también quieres ocultar al Super Admin
            ]);
        });
    }
}