<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'mascot_id',
        'veterinarian_id',
        'appointment_date',
        'reason',
        'status',
        'notes',
        'duration',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    public function mascot(): BelongsTo
    {
        return $this->belongsTo(Mascot::class);
    }

    // Una veterinario puede tener muchas citas
    public function veterinarian(): BelongsTo
    {
        return $this->belongsTo(User::class, 'veterinarian_id');
    }

    public function medicalRecord()
    {
        // HasOne porque una cita solo genera UN historial
        return $this->hasOne(HistorialMedico::class); 
    }
}
