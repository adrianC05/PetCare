<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    // Cambia el título de la página
    public function getTitle(): string | Htmlable
    {
        return 'Crear Usuario 👤';
    }

    // Cambia el texto del botón de crear
    protected function getCreateFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateFormAction()
            ->label('Crear usuario');
    }

    // Cambia el texto del botón de crear y crear otro
    protected function getCreateAnotherFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateAnotherFormAction()
            ->label('Crear y crear otro');
    }

    // Cambia el texto del botón cancelar
    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('Cancelar');
    }
}
