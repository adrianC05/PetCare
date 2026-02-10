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

use Filament\Schemas\Components\Grid as ComponentsGrid;
use Filament\Schemas\Components\Section as ComponentsSection;
class AppointmentForm
{
 public static function configure(Schema $schema): Schema
{
    return $schema
        ->columns(3) // 👈 AGREGAR ESTO - Define las columnas del contenedor principal
        ->components([
            ComponentsSection::make('Información de la Cita')
                ->description('Detalles del paciente y motivo de consulta.')
                ->icon('heroicon-m-clipboard-document-list')
                ->columnSpan(2) // Ocupa 2 de las 3 columnas
                ->schema([
                    ComponentsGrid::make(2)->schema([
                        Select::make('mascot_id')
                            ->label('Mascota')
                            ->relationship('mascot', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Mascot $record) => "{$record->name} - " . ($record->owner ? "{$record->owner->name} {$record->owner->lastname}" : 'Sin Dueño'))
                            ->searchable(['name', 'owner.name', 'owner.lastname'])
                            ->preload()
                            ->required()
                            ->prefixIcon('heroicon-m-heart'),

                        Select::make('veterinarian_id')
                            ->label('Veterinario')
                            ->relationship('veterinarian', 'name', fn (Builder $query) => 
                                $query->whereHas('roles', fn($q) => $q->where('name', 'veterinario'))
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->prefixIcon('heroicon-m-user-circle'),
                    ]),

                    TextInput::make('reason')
                        ->label('Motivo de la Cita')
                        ->placeholder('Ej: Control post-operatorio')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Textarea::make('notes')
                        ->label('Notas Adicionales')
                        ->rows(5)
                        ->placeholder('Observaciones importantes...')
                        ->columnSpanFull(),
                ]),

            ComponentsSection::make('Programación')
                ->description('Control de tiempo y estado.')
                ->icon('heroicon-m-clock')
                ->columnSpan(1) // Ocupa 1 de las 3 columnas
                ->schema([
                    DateTimePicker::make('appointment_date')
                        ->label('Fecha y Hora')
                        ->timezone('America/Guayaquil')
                        ->displayFormat('d/m/Y H:i')
                        ->native(false)
                        ->required()
                        ->prefixIcon('heroicon-m-calendar'),

                    Select::make('status')
                        ->label('Estado Actual')
                        ->options([
                            'pending' => 'Pendiente',
                            'confirmed' => 'Confirmada',
                        ])
                        ->default('pending')
                        ->required()
                        ->native(false),

                    TextInput::make('duration')
                        ->label('Duración Estimada')
                        ->suffix('minutos')
                        ->numeric()
                        ->default(30)
                        ->required()
                        ->prefixIcon('heroicon-m-clock'),
                ]),
        ]);
}
}