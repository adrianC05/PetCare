<?php

namespace App\Observers;

use App\Mail\AppointmentCreated;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;

class AppointmentObserver
{
    /**
     * Handle the Appointment "created" event.
     */
    public function created(Appointment $appointment): void
    {
        // Enviar correo al dueño de la mascota
        if ($appointment->mascot && $appointment->mascot->owner && $appointment->mascot->owner->email) {
            Mail::to($appointment->mascot->owner->email)
                ->send(new AppointmentCreated($appointment));
        }
    }
}
