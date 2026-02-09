<?php

namespace App\Filament\Resources\Mascots\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
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

class HistorialMedicosRelationManager extends RelationManager
{
    protected static string $relationship = 'historialMedicos';

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

            DatePicker::make('fecha')
                ->label('Fecha')
                ->required(),

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
                CreateAction::make()->label('Agregar Evento'),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('fecha', 'desc');
    }
}
