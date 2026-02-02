<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascot extends Model
{
    protected $fillable = [
        'name',
        'species',
        'breed',
        'weight',
        'birthdate',
        'sex',
        'owner_id',
        'photo_path',
    ];

    // Un Usuario puede tener muchas mascotas
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
