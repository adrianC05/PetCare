<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Models\Mascot;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('mascot_id')
                    ->label('Mascota')
                    ->relationship('mascot', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('veterinarian_id')
                    // Role filter to show only veterinarians                    
                    ->options(function () {
                        return User::whereHas('roles', function ($query) {
                            $query->where('name', 'veterinario');
                        })->pluck('name', 'id');
                    })
                    ->label('Veterinario')
                    ->required()
                    ->searchable()
                    ->preload(),
                DateTimePicker::make('appointment_date')
                    ->label('Fecha y Hora de la Cita')
                    ->timezone('America/Guayaquil')
                    ->displayFormat('d/m/Y H:i')
                    ->seconds(false)
                    ->required(),
                TextInput::make('reason')
                    ->label('Motivo de la Cita')
                    ->required(),
                Select::make('status')
                    ->label('Estado')
                    ->required()
                    ->options([
                        'pending' => 'Pendiente',
                        'confirmed' => 'Confirmada',
                        'completed' => 'Completada',
                        'cancelled' => 'Cancelada',
                    ])
                    ->default('pending'),
                Textarea::make('notes')
                    ->label('Notas')
                    ->columnSpanFull(),
                TextInput::make('duration')
                    ->label('Duración (minutos)')
                    ->required()
                    ->numeric()
                    ->default(30),
            ]);
    }
}
