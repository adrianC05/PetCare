<?php

namespace App\Console\Commands;

use App\Mail\AppointmentCreated;
use App\Models\Appointment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Probar envío de correo con MailerSend';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info('Enviando correo de prueba a: ' . $email);
        
        // Obtener la primera cita para probar
        $appointment = Appointment::with(['mascot.owner', 'veterinarian'])->first();
        
        if (!$appointment) {
            $this->error('No hay citas en la base de datos. Crea una cita primero.');
            return 1;
        }
        
        try {
            Mail::to($email)->send(new AppointmentCreated($appointment));
            $this->info('✓ Correo enviado exitosamente!');
            return 0;
        } catch (\Exception $e) {
            $this->error('Error al enviar correo: ' . $e->getMessage());
            return 1;
        }
    }
}
