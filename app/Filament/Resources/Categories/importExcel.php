<?php 

namespace App\Filament\Resources\Categories; // تأكد من صحة الـ Namespace حسب مكان الملف

use App\Models\Category; 
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class importExcel implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            
            if (!isset($row['namear']) || empty($row['namear'])) {
                continue;
            }

            Category::create([
                'name' => [
                    "ar" => $row['namear'] ?? null,
                    "en" => $row['nameen'] ?? null,
                ],
                'details' => [
                    "ar" => $row['detailsar'] ?? null,
                    "en" => $row['detailsen'] ?? null,
                ],
                'short_description' => [
                    "ar" => $row['shortdescar'] ?? null,
                    "en" => $row['shortdescen'] ?? null,
                ],
                'slug'        => $row['slug'] ?? null,
                'status'      => $row['status'] ?? 1,
                'category_id' => $row['category_id'] ?? null,
            ]);
        }
    }
}