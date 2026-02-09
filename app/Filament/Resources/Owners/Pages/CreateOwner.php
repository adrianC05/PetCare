<?php

namespace App\Filament\Resources\Owners\Pages;

use App\Filament\Resources\Owners\OwnerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOwner extends CreateRecord
{
    protected static string $resource = OwnerResource::class;

    protected function afterCreate(): void
    {
        // $this->record es el usuario recién creado
        $this->record->assignRole('dueno_de_mascota'); 
    }
}
