<?php 
namespace App\Filament\Resources\MarketPlaces\Schemas;

use Filament\Schemas\Schema;
use App\Filament\trait\market_place\MarketPlaceSchema;

class MarketPlaceForm
{
    use MarketPlaceSchema;
    public static function configure(Schema $schema): Schema
    {
        return $schema
        ->components(self::getMaerketFormSchema());
    }
}