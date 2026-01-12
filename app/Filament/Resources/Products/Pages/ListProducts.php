<?php

namespace App\Filament\Resources\Products\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;
use App\Filament\exports\products\ProductTemplate;
use App\Filament\Resources\Products\ProductResource;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // 1. زر تحميل النموذج
            ExportAction::make('download_template')
                ->label('Download Excel Templat')
                ->color('success')
                ->icon('heroicon-o-document-arrow-down')
                ->exports([
                    ProductTemplate::make(),
                ]),

            // 2. زر الاستيراد
            ExcelImportAction::make('import')// أضف اسماً للأكشن هنا
            ->label('Import Excel')
            ->use(\App\Filament\Resources\Products\importExcel::class),
            CreateAction::make(),
        ];
    }
}
