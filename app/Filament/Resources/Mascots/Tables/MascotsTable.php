<?php

namespace App\Filament\Resources\Mascots\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MascotsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo_path')
                    ->label('Foto')
                    ->imageHeight(40)
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                TextColumn::make('species')
                    ->label('Especie')
                    ->searchable(),
                TextColumn::make('breed')
                    ->label('Raza')
                    ->searchable(),
                TextColumn::make('weight')
                    ->label('Peso (lb)')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('birthdate')
                    ->label('Fecha de Nacimiento')
                    ->date()
                    ->sortable(),
                TextColumn::make('owner.name')
                    ->label('Dueño')
                    ->description(fn ($record): string => $record->owner?->lastname ?? '')
                    ->extraAttributes(attributes: ['style' => 'row-gap: 0 !important'])
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
            ]);
    }
}
