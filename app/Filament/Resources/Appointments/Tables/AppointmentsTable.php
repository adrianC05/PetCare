<?php

namespace App\Filament\Resources\Appointments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('mascot.photo_path')
                    ->label('Foto')
                    ->url(fn ($record): string => route('filament.admin.resources.mascots.edit', $record->mascot))
                    ->imageHeight(40)
                    ->circular(),
                TextColumn::make('mascot.name')
                    ->label('Mascota')
                    //  Nombre completo del dueño de la mascota como descripción
                    ->description(fn ($record): string => $record->mascot?->owner?->name . ' ' . $record->mascot?->owner?->lastname ?? '')
                    ->extraAttributes(attributes: ['style' => 'row-gap: 0 !important'])
                    // Link to mascot edit page
                    ->url(fn ($record): string => route('filament.admin.resources.mascots.edit', $record->mascot))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('veterinarian.name')
                    ->label('Veterinario')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('appointment_date')
                    ->label('Fecha de Cita')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('reason')
                    ->label('Motivo')
                    ->searchable()
                    ->limit(30),
                SelectColumn::make('status')
                    ->label('Estado')
                    ->options([
                        'pending' => 'Pendiente',
                        'confirmed' => 'Confirmada',
                        'completed' => 'Completada',
                        'cancelled' => 'Cancelada',
                    ]),
                TextColumn::make('duration')
                    ->label('Tiempo')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('appointment_date', 'desc');
    }
}
