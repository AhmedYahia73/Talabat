<?php

namespace App\Filament\Resources\MarketPlaces;

use App\Filament\Resources\MarketPlaces\Pages\CreateMarketPlace;
use App\Filament\Resources\MarketPlaces\Pages\EditMarketPlace;
use App\Filament\Resources\MarketPlaces\Pages\ListMarketPlaces;
use App\Filament\Resources\MarketPlaces\Schemas\MarketPlaceForm;
use App\Filament\Resources\MarketPlaces\Tables\MarketPlacesTable;
use App\Models\MarketPlace;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MarketPlaceResource extends Resource
{
    protected static ?string $model = MarketPlace::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Brands';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'MarketPlace';

    public static function form(Schema $schema): Schema
    {
        return MarketPlaceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MarketPlacesTable::configure($table);
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
            'index' => ListMarketPlaces::route('/'),
            'create' => CreateMarketPlace::route('/create'),
            'edit' => EditMarketPlace::route('/{record}/edit'),
        ];
    }
}
