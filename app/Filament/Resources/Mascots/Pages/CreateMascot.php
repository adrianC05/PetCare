<?php

namespace App\Filament\Resources\Mascots\Pages;

use App\Filament\Resources\Mascots\MascotResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateMascot extends CreateRecord
{
    protected static string $resource = MascotResource::class;

    // ESTO es lo que cambia el encabezado de la página
    public function getTitle(): string | Htmlable
    {
        return 'Registrar Nueva Mascota 🐱 ';
    }

    protected function getCreateFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateFormAction()
            ->label('Guardar Mascota');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getCreateAnotherFormAction(): \Filament\Actions\Action

    {
        return parent::getCreateAnotherFormAction()
            ->label('Guardar y crear otro');
    }

    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('Cancelar');
    }
}
