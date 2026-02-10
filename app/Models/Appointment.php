<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Guava\Calendar\ValueObjects\CalendarEvent;
use Guava\Calendar\Contracts\Eventable;

class Appointment extends Model implements Eventable
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

    public function toCalendarEvent(): CalendarEvent
    {
        return CalendarEvent::make($this)
            ->title(($this->mascot?->name ?? 'Sin mascota') . ' - ' . ($this->reason ?? 'Cita'))
            ->start($this->appointment_date)
            ->end($this->appointment_date->addMinutes($this->duration ?? 30))
            ->backgroundColor($this->getStatusColor())
            ->textColor('#FFFFFF')
            ->action('view');
    }

    private function getStatusColor(): string
    {
        return match($this->status ?? 'pending') {
            'pending' => '#FFA500',
            'confirmed' => '#4CAF50',
            'completed' => '#2196F3',
            'cancelled' => '#F44336',
            default => '#9E9E9E',
        };
    }
}
