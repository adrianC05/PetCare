<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Models\Mascot;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('mascot_id')
                    ->label('Mascota')
                    ->required()
                    ->searchable()
                    ->preload()
                    // 1. Opciones iniciales (cuando abres la lista sin escribir nada)
                    ->options(function () {
                        return Mascot::with('owner')
                            ->limit(50)
                            ->get()
                            ->mapWithKeys(function ($mascot) {
                                $ownerName = $mascot->owner ? "{$mascot->owner->name} {$mascot->owner->lastname}" : 'Sin Dueño';
                                return [$mascot->id => "{$mascot->name} - {$ownerName}"];
                            });
                    })
                    // 2. Lógica de Búsqueda (Aquí agregamos el Lastname)
                    ->getSearchResultsUsing(function (string $search) {
                        return Mascot::query()
                            ->with('owner')
                            // A. Buscar por nombre de la mascota
                            ->where('name', 'like', "%{$search}%") 
                            // B. O buscar dentro del dueño...
                            ->orWhereHas('owner', function (Builder $query) use ($search) {
                                $query->where('name', 'like', "%{$search}%")      // ...por Nombre
                                    ->orWhere('lastname', 'like', "%{$search}%"); // ...O por Apellido
                            })
                            ->limit(50)
                            ->get()
                            ->mapWithKeys(function ($mascot) {
                                $ownerName = $mascot->owner ? "{$mascot->owner->name} {$mascot->owner->lastname}" : 'Sin Dueño';
                                return [$mascot->id => "{$mascot->name} - {$ownerName}"];
                            });
                    })
                    // 3. Mostrar la etiqueta correctamente al editar un registro existente
                    ->getOptionLabelUsing(function ($value): ?string {
                        $mascot = Mascot::with('owner')->find($value);
                        if (!$mascot) return null;
                        
                        $ownerName = $mascot->owner ? "{$mascot->owner->name} {$mascot->owner->lastname}" : 'Sin Dueño';
                        return "{$mascot->name} - {$ownerName}";
                    }),
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
