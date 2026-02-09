<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class Owner extends User
{
    // Forzamos a que use la tabla de usuarios
    protected $table = 'users';

    public static function viewQuery()
    {
        return User::query()->whereHas('roles', function ($query) {
            $query->where('name', 'dueno_de_mascota');
        });
    }
}
