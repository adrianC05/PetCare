<?php

namespace App\Filament\Resources\Mascots\Pages;

use App\Filament\Resources\Mascots\MascotResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMascot extends ViewRecord
{
    protected static string $resource = MascotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
