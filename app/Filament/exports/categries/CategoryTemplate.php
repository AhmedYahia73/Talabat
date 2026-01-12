<?php
namespace App\Filament\exports\categries;

use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class CategoryTemplate extends ExcelExport
{
    public function setUp(): void
    {
        $this->withFilename('category_import_template')
            ->withColumns([
                Column::make('name.ar')->heading('NameAR'),
                Column::make('name.en')->heading('NameEN'),
                Column::make('details.ar')->heading('DetailsAR'),
                Column::make('details.en')->heading('DetailsEN'),
                Column::make('short_description.en')->heading('ShortDescEN'),
                Column::make('short_description.ar')->heading('ShortDescAR'),
                Column::make('slug')->heading('Slug'),
                Column::make('status')->heading('Status'),
                Column::make('category_id')->heading('Category ID'),
            ])
            // هذا السطر هو الأهم: يفرغ الملف من أي بيانات موجودة في القاعدة
            ->modifyQueryUsing(fn ($query) => $query->where('id', 0));
    }
}