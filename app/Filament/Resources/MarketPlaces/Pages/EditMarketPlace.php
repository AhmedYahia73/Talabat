<?php

namespace App\Filament\Resources\MarketPlaces\Pages;

use App\Filament\Resources\MarketPlaces\MarketPlaceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMarketPlace extends EditRecord
{
    protected static string $resource = MarketPlaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
