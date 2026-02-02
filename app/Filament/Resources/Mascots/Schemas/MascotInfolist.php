<?php

namespace App\Filament\Resources\Mascots\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MascotInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nombre'),
                TextEntry::make('owner_id')
                    ->label('Dueño')
                    ->formatStateUsing(fn ($state) => \App\Models\User::find($state)?->name ?? 'N/A'),
                TextEntry::make('species')
                    ->label('Especie'),
                TextEntry::make('breed')
                    ->label('Raza'),
                TextEntry::make('weight')
                    ->label('Peso (lb)')
                    ->numeric(),
                TextEntry::make('birthdate')
                    ->label('Fecha de Nacimiento'),
                FileUpload::make('photo_path')
                    ->label('Foto de la Mascota')
                    ->image()
                    ->directory('mascots/photos')
                    ->maxSize(2048),
            ]);
    }
}
