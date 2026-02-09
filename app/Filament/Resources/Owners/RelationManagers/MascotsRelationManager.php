<?php

namespace App\Filament\Resources\Owners\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
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
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MascotsRelationManager extends RelationManager
{
    protected static string $relationship = 'mascots';
    protected static ?string $inverseRelationship = 'owner';

    protected static ?string $title = 'Mascotas';
    protected static ?string $modelLabel = 'Mascota';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('photo_path')
                    ->label('Foto')
                    ->image()
                    ->avatar()
                    ->directory('mascots_photos')
                    ->columnSpanFull(),

                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),

                Select::make('species')
                    ->label('Especie')
                    ->options([
                        'Perro' => 'Perro',
                        'Gato' => 'Gato',
                    ])
                    ->required(),

                TextInput::make('breed')
                    ->label('Raza')
                    ->maxLength(255),

                Select::make('gender')
                    ->label('Género')
                    ->options([
                        'Macho' => 'Macho',
                        'Hembra' => 'Hembra',
                    ])
                    ->required(),

                DatePicker::make('birthdate')
                    ->label('Fecha de Nacimiento')
                    ->maxDate(now()),

                TextInput::make('weight')
                    ->label('Peso (kg/lb)')
                    ->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('photo_path')
                    ->label('Foto')
                    ->circular(),

                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('species')
                    ->label('Especie')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Perro' => 'info',
                        'Gato' => 'warning',
                        'Ave' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('breed')
                    ->label('Raza')
                    ->searchable(),

                TextColumn::make('gender')
                    ->label('Género'),

                TextColumn::make('birthdate')
                    ->label('Edad')
                    ->date('d/m/Y')
                    ->description(fn ($record) => $record->birthdate ? \Carbon\Carbon::parse($record->birthdate)->age . ' años' : null),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Nueva Mascota'),
            ])
            ->recordActions([
                Action::make('historial')
                ->label('Historial Médico')
                ->icon('heroicon-m-clipboard-document-list') // Agregamos un icono bonito
                ->url(fn($record) => route('filament.admin.resources.mascots.edit', ['record' => $record->id])),
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}