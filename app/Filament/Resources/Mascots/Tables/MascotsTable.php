<?php

namespace App\Filament\Resources\Mascots\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

// EN FILAMENT V2 NO NECESITAMOS IMPORTAR ACCIONES SI USAMOS LAS DE DEFECTO
// O LAS LLAMAMOS DIRECTAMENTE.

class MascotsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo_path')
                    ->label('Foto')
                    ->rounded(), // En V2 se usa rounded() en vez de circular() a veces, pero probemos.

                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),

                TextColumn::make('species')
                    ->label('Especie')
                    ->searchable(),

                TextColumn::make('owner.name')
                    ->label('Dueño')
                    ->description(fn($record): string => $record->owner?->lastname ?? '')
                    ->extraAttributes(attributes: ['style' => 'row-gap: 0 !important'])
                    ->sortable(),

                // --- SOLUCIÓN WHATSAPP PARA FILAMENT V2 ---
                TextColumn::make('whatsapp_link')
                    ->label('Contacto')
                    ->default('WhatsApp 💬')
                    ->color('success')
                    // EL TRUCO V2: El 'true' al final abre en nueva pestaña
                    ->url(fn($record) => self::getWhatsappUrl($record), true),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Historial Médico
                Action::make('historial')
                    ->label('Historial Médico')
                    ->icon('heroicon-m-clipboard-document-list') // Agregamos un icono bonito
                    ->url(fn($record) => route('filament.admin.resources.mascots.edit', ['record' => $record->id])),
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                //
            ]);
    }

    // --- LÓGICA WHATSAPP (IGUAL QUE ANTES) ---
    public static function getWhatsappUrl($record): string
    {
        if (!$record->owner || empty($record->owner->phone)) {
            return '#';
        }

        $numero = $record->owner->phone;
        $numeroLimpio = preg_replace('/[^0-9]/', '', $numero);

        if (str_starts_with($numeroLimpio, '0')) {
            $numeroLimpio = '593' . substr($numeroLimpio, 1);
        }

        $mensaje = "Hola {$record->owner->name}, le escribimos de PetCare sobre su mascota {$record->name}.";

        return "https://wa.me/{$numeroLimpio}?text=" . urlencode($mensaje);
    }
}
