<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
// المسار الصحيح للأكشن في الإصدار 4 ليعمل كـ Header Action
use EightyNine\ExcelImport\ExcelImportAction; 
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction; // لاحظ تغيير Tables إلى Pages هنا
use App\Filament\exports\categries\CategoryTemplate;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // 1. زر تحميل النموذج
            ExportAction::make('download_template')
                ->label('Download Excel Templat')
                ->color('success')
                ->icon('heroicon-o-document-arrow-down')
                ->exports([
                    CategoryTemplate::make(),
                ]),

            // 2. زر الاستيراد
            ExcelImportAction::make('import') // أضف اسماً للأكشن هنا
            ->label('Import Excel')
            ->use(\App\Filament\Resources\Categories\importExcel::class),

            // 3. زر الإنشاء
            CreateAction::make(),
        ];
    }
}