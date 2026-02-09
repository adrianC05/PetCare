<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistorialMedico extends Model
{
    protected $fillable = [
        'mascota_id',
        'tipo',
        'descripcion',
        'peso',
        'fecha',
        'proxima_visita',
        'archivo'
    ];

    protected $casts = [
        'fecha' => 'date',
        'proxima_visita' => 'date',
    ];

    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascot::class);
    }
}
