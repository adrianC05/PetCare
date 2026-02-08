<?php

namespace App\Filament\Resources\Mascots\Pages;

use App\Filament\Resources\Mascots\MascotResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewMascot extends ViewRecord
{
    protected static string $resource = MascotResource::class;

    /**
     * Cambia el título de la página de visualización
     */
    public function getTitle(): string | Htmlable
    {
        return 'Detalles de la Mascota 🐮';
    }

    /**
     * Configura las acciones de la cabecera en español
     */
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Editar Mascota')
                ->color('warning'), // Opcional: le da un color naranja/amarillo típico de editar
        ];
    }
}
