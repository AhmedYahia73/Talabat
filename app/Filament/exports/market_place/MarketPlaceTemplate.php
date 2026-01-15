<?php
namespace App\Filament\exports\market_place;

use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class MarketPlaceTemplate extends ExcelExport
{
    public function setUp(): void
    {
        $this->withFilename('market_import_template')
            ->withColumns([
                Column::make('name.ar')->heading('NameAR'),
                Column::make('name.en')->heading('NameEN'),
                Column::make('details.ar')->heading('DetailsAR'),
                Column::make('details.en')->heading('DetailsEN'),
                Column::make('slug')->heading('Slug'),
                Column::make('lng')->heading('MapLatitude'),
                Column::make('lat')->heading('MapLongitude'),
                Column::make('status')->heading('Status'),
                
            ])
            // هذا السطر هو الأهم: يفرغ الملف من أي بيانات موجودة في القاعدة
            ->modifyQueryUsing(fn ($query) => $query->where('id', 0));
    }
}