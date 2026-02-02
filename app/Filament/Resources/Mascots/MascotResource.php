<?php

namespace App\Filament\Resources\Mascots;

use App\Filament\Resources\Mascots\Pages\CreateMascot;
use App\Filament\Resources\Mascots\Pages\EditMascot;
use App\Filament\Resources\Mascots\Pages\ListMascots;
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

class MascotResource extends Resource
{
    protected static ?string $model = Mascot::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Mascot';

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
