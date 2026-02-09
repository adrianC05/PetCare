<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Owner extends User
{
    protected $table = 'users';

    // --- AGREGA ESTE MÉTODO ---
    // Esto le dice a Laravel: "Cuando busques mis relaciones (roles, posts, etc)
    // en la base de datos, búscame como 'App\Models\User', no como Owner".
    public function getMorphClass()
    {
        return User::class; // O string 'App\Models\User'
    }

    public static function viewQuery()
    {
        return static::query()->whereHas('roles', function ($query) {
            $query->where('name', 'dueno_de_mascota');
        });
    }

    public function mascots(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Mascot::class);
    }
}