<?php

namespace App\Filament\Resources\Appointments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Carbon\Carbon; // Importante para manejar fechas

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('mascot.photo_path')
                    ->label('Foto')
                    ->url(fn($record): string => route('filament.admin.resources.mascots.edit', $record->mascot))
                    ->imageHeight(40)
                    ->rounded(),

                TextColumn::make('mascot.name')
                    ->label('Mascota')
                    ->description(fn($record): string => $record->mascot?->owner?->name . ' ' . $record->mascot?->owner?->lastname ?? '')
                    ->extraAttributes(attributes: ['style' => 'row-gap: 0 !important'])
                    ->url(fn($record): string => route('filament.admin.resources.mascots.edit', $record->mascot))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('veterinarian.name')
                    ->label('Veterinario')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('appointment_date')
                    ->label('Fecha de Cita')
                    ->dateTime('d/m/Y H:i') // En la tabla se ve corto (números)
                    ->sortable(),

                // COLUMNA WHATSAPP
                TextColumn::make('whatsapp_link')
                    ->label('Contacto')
                    ->getStateUsing(function ($record) {
                        $phone = $record->mascot->owner->phone ?? null;
                        return $phone ? "WhatsApp ($phone)" : 'SIN TELÉFONO ❌';
                    })
                    ->color(fn($record) => $record->mascot?->owner?->phone ? 'success' : 'danger')
                    ->url(fn($record) => self::getWhatsappUrl($record), true),

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

    // --- LÓGICA WHATSAPP 
    public static function getWhatsappUrl($record): string
    {
        // 1. Acceder al dueño
        $owner = $record->mascot->owner ?? null;

        // 2. Validación
        if (!$owner || empty($owner->phone)) {
            return '#';
        }

        $numero = $owner->phone;
        $numeroLimpio = preg_replace('/[^0-9]/', '', $numero);

        // 3. Lógica Ecuador
        if (str_starts_with($numeroLimpio, '0')) {
            $numeroLimpio = '593' . substr($numeroLimpio, 1);
        }

        // 4. Formatear fecha en ESPAÑOL
        $fechaBonita = $record->appointment_date
            ->locale('es')
            ->translatedFormat('l j \d\e F \a \l\a\s H:i');

        $mensaje = "Hola {$owner->name}, le escribimos de PetCare para recordar la cita de su mascota {$record->mascot->name} programada para el {$fechaBonita}.";

        return "https://wa.me/{$numeroLimpio}?text=" . urlencode($mensaje);
    }
}
