<?php
namespace App\Filament\exports\products;

use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ProductTemplate extends ExcelExport
{
    public function setUp(): void
    {
        $this->withFilename('product_import_template')
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
                Column::make('price')->heading('Price'),
                Column::make('offer_price')->heading('Offer Price'),
                Column::make('start_date')->heading('Start Date'),
                Column::make('end_date')->heading('End Date'),
            ])
            // هذا السطر هو الأهم: يفرغ الملف من أي بيانات موجودة في القاعدة
            ->modifyQueryUsing(fn ($query) => $query->where('id', 0));
    }
}