<?php

namespace App\Filament\Resources\Mascots\Pages;

use App\Filament\Resources\Mascots\MascotResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListMascots extends ListRecords
{
    protected static string $resource = MascotResource::class;

    // Cambia el título de la parte superior de la página
    public function getTitle(): string | Htmlable
    {
        return 'Mascotas 🐰 ';
    }

    protected function getHeaderActions(): array
    {
        return [
            // Cambia el nombre del botón de "New Mascot" a "Nueva Mascota"
            CreateAction::make()
                ->label('Nueva Mascota'),
        ];
    }
}
