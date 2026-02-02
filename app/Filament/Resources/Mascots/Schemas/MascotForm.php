<?php

namespace App\Filament\Resources\Mascots\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MascotForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                Select::make('species')
                    ->label('Especie')
                    ->options([
                        'dog' => 'Perro',
                        'cat' => 'Gato'
                    ])
                    ->required(),
                TextInput::make('breed')
                    ->label('Raza'),
                TextInput::make('weight')
                    ->label('Peso (lb)')
                    ->required()
                    ->numeric(),
                DatePicker::make('birthdate')
                    ->label('Fecha de Nacimiento'),
                Select::make('owner_id')
                    ->label('Dueño')
                    ->searchable()
                    ->options(fn () => \App\Models\User::all()->pluck('name', 'id'))
                    ->required(),
                FileUpload::make('photo_path')
                    ->label('Foto de la Mascota')
                    ->image()
                    ->directory('mascots/photos')
                    ->maxSize(2048),
            ]);
    }
}