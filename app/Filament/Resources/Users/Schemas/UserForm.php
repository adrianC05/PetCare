<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),

                TextInput::make('lastname')
                    ->label('Apellido'),

                TextInput::make('phone')
                    ->label('Teléfono')
                    ->tel(),

                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required(),

                Select::make('roles')
                    ->label('Roles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload()
                    ->searchable(),

                // EXPLICACIÓN EMAIL: Si pones una fecha aquí, el usuario queda verificado manualmente.
                // No se envía correo, solo se guarda la fecha en la base de datos.
                DateTimePicker::make('email_verified_at')
                    ->label('Verificado manual (Fecha)'),

                // --- AQUÍ ESTABA EL ERROR ---
                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->confirmed() // Esto exige que exista el campo de abajo 'password_confirmation'
                    ->dehydrateStateUsing(fn(string $state): string => bcrypt($state))
                    ->dehydrated(fn(?string $state): bool => filled($state))
                    ->required(fn(string $operation): bool => $operation === 'create'),

                // --- ESTE CAMPO FALTABA ---
                TextInput::make('password_confirmation')
                    ->label('Confirmar Contraseña')
                    ->password()
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->dehydrated(false) // Esto es importante: no intentamos guardar este campo en la BD
            ]);
    }
}
