<?php

namespace App\Filament\Resources\MarketPlaces\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;
use App\Filament\Resources\MarketPlaces\importExcel;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use App\Filament\exports\market_place\MarketPlaceTemplate;
use App\Filament\Resources\MarketPlaces\MarketPlaceResource;

class ListMarketPlaces extends ListRecords
{
    protected static string $resource = MarketPlaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // 1. زر تحميل النموذج
            ExportAction::make('download_template')
                ->label('Download Excel Templat')
                ->color('success')
                ->icon('heroicon-o-document-arrow-down')
                ->exports([
                    MarketPlaceTemplate::make(),
                ]),

            // 2. زر الاستيراد
            ExcelImportAction::make('import')// أضف اسماً للأكشن هنا
            ->label('Import Excel')
            ->use(importExcel::class),
            CreateAction::make(),
        ];
    }
}
