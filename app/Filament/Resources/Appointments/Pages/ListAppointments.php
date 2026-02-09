<?php

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\AppointmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListAppointments extends ListRecords
{
    protected static string $resource = AppointmentResource::class;

    /**
     * Cambia el título de la página principal de la lista
     */
    public function getTitle(): string | Htmlable
    {
        return 'Citas ⏰ ';
    }

    /**
     * Configura los botones de la cabecera
     */
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nueva Cita')
                ->icon('heroicon-o-plus'), // Opcional: añade un icono de suma
        ];
    }
}
