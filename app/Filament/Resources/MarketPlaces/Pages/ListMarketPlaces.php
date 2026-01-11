<?php

namespace App\Filament\Resources\MarketPlaces\Pages;

use App\Filament\Resources\MarketPlaces\MarketPlaceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMarketPlaces extends ListRecords
{
    protected static string $resource = MarketPlaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
