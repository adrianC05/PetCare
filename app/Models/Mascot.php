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
        'gender',
        'owner_id',
        'photo_path',
    ];

    // Un Usuario puede tener muchas mascotas
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function historialMedicos()
    {
        // Asegúrate de importar el modelo HistorialMedico arriba o usar la ruta completa
        return $this->hasMany(\App\Models\HistorialMedico::class, 'mascota_id');
    }
}
