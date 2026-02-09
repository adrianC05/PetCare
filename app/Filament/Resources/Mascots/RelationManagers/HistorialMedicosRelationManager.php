<?php

namespace App\Filament\Resources\Mascots\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class HistorialMedicosRelationManager extends RelationManager
{
    protected static string $relationship = 'historialMedicos'; // Asegúrate que este método exista en el modelo Mascot

    protected static ?string $title = 'Historial Médico';
    protected static ?string $modelLabel = 'Evento';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('tipo')
                ->label('Tipo de Evento')
                ->options([
                    'Vacuna' => 'Vacunación',
                    'Consulta' => 'Consulta General',
                    'Desparasitación' => 'Desparasitación',
                    'Cirugía' => 'Cirugía',
                    'Examen' => 'Examen de Laboratorio',
                ])
                ->required(),

        Select::make('appointment_id')
            ->label('Cita Relacionada')
            ->relationship(
                name: 'appointment',
                titleAttribute: null, 
                modifyQueryUsing: function (Builder $query, RelationManager $livewire, ?Model $record) {
                    // 1. Filtrar por mascota (como ya teníamos)
                    $query->where('mascot_id', $livewire->getOwnerRecord()->id);

                    // 2. Filtrar citas que YA tienen historial
                    $query->where(function($q) use ($record) {
                        // Condición A: Que NO tenga historial médico
                        $q->whereDoesntHave('medicalRecord'); 

                        // Condición B (Solo al editar): 
                        // Si estamos editando un historial existente ($record), 
                        // debemos permitir que aparezca SU propia cita ($record->appointment_id)
                        // o de lo contrario el campo saldrá vacío al editar.
                        if ($record && $record->appointment_id) {
                            $q->orWhere('id', $record->appointment_id);
                        }
                    });
                    
                    return $query;
                }
            )
            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->reason} - {$record->appointment_date->format('d/m/Y H:i')}")
            ->searchable()
            ->preload()
            ->placeholder('Selecciona una cita (opcional)'),

            DatePicker::make('fecha')
                ->label('Fecha')
                ->required()
                ->default(now()), // Buen detalle para UX

            TextInput::make('peso')
                ->label('Peso (lb)')
                ->numeric()
                ->suffix('lb'),

            Textarea::make('descripcion')
                ->label('Detalles / Diagnóstico')
                ->rows(3)
                ->columnSpanFull(),

            FileUpload::make('archivo')
                ->label('Archivo adjunto')
                ->directory('historial_medico')
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('tipo')
            ->columns([
                TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('tipo')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'Vacuna' => 'success',
                        'Cirugía' => 'danger',
                        'Consulta' => 'info',
                        'Desparasitación' => 'warning',
                        'Examen' => 'gray', // Agregado color para Examen
                        default => 'gray',
                    }),

                TextColumn::make('descripcion')
                    ->label('Detalles')
                    ->limit(40)
                    ->tooltip(fn($record) => $record->descripcion),

                TextColumn::make('peso')
                    ->label('Peso')
                    ->suffix(' lb'),
            ])
            ->headerActions([
                // SOLO CreateAction. Quitamos AssociateAction porque no vamos a traer historiales de otros perros.
                CreateAction::make()
                    ->label('Agregar Evento')
                    ->mutateFormDataUsing(function (array $data): array {
                        // Aquí podrías forzar datos extra si fuera necesario
                        // pero Filament ya asigna mascot_id automáticamente
                        return $data;
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                // Quitamos DissociateAction. Si se equivocan, deben borrarlo.
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('fecha', 'desc');
    }
}