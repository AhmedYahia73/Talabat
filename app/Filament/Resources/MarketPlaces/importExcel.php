<?php

namespace App\Filament\Resources\MarketPlaces;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Models\MarketPlace;

class importExcel implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            if (!isset($row['namear']) || empty($row['namear'])) {
                continue;
            }
            MarketPlace::create([
                'name' => [
                    "ar" => $row['namear'] ?? null,
                    "en" => $row['nameen'] ?? null,
                ],
                'details' => [
                    "ar" => $row['detailsar'] ?? null,
                    "en" => $row['detailsen'] ?? null,
                ],
                'slug'       => $row['slug'] ?? null,
                'lat'        => $row['maplatitude'] ?? null,
                'lng'        => $row['maplongitude'] ?? null,
                'status'     => $row['status'] ?? 1,
            ]);
        }
    }
}
