<?php

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\AppointmentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateAppointment extends CreateRecord
{
    protected static string $resource = AppointmentResource::class;

    // Título de la página (arriba a la izquierda)
    public function getTitle(): string | Htmlable
    {
        return 'Nueva Cita 📅 ';
    }

    // Etiqueta del botón principal de enviar
    protected function getCreateFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateFormAction()
            ->label('Crear cita');
    }

    // Etiqueta del botón "Crear y crear otro"
    protected function getCreateAnotherFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateAnotherFormAction()
            ->label('Crear y agendar otra');
    }

    // Etiqueta del botón cancelar
    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('Cancelar');
    }
}
