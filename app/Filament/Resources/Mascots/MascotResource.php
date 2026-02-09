<?php

namespace App\Filament\Resources\Mascots;

use App\Filament\Resources\Mascots\Pages\CreateMascot;
use App\Filament\Resources\Mascots\Pages\EditMascot;
use App\Filament\Resources\Mascots\Pages\ListMascots;
use App\Filament\Resources\Mascots\Pages\ManageHistorial;
use App\Filament\Resources\Mascots\Pages\ViewMascot;
use App\Filament\Resources\Mascots\Schemas\MascotForm;
use App\Filament\Resources\Mascots\Schemas\MascotInfolist;
use App\Filament\Resources\Mascots\Tables\MascotsTable;
use App\Models\Mascot;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;

class MascotResource extends Resource
{
    protected static ?string $model = Mascot::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string | \UnitEnum | null $navigationGroup = 'Gestión Clínica';

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationLabel = 'Mascotas';
    protected static ?string $modelLabel = 'Mascota';
    protected static ?string $pluralModelLabel = 'Mascotas';

    public static function form(Schema $schema): Schema
    {
        return MascotForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MascotInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MascotsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\HistorialMedicosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMascots::route('/'),
            'create' => CreateMascot::route('/create'),
            'view' => ViewMascot::route('/{record}'),
            'edit' => EditMascot::route('/{record}/edit'),
        ];
    }
}
