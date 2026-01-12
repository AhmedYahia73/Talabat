<?php 

namespace App\Filament\Resources\Products; // تأكد من صحة الـ Namespace حسب مكان الملف

use App\Models\Product; 
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Carbon;

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
            $endDate = null;
            $startDate = null;
            if (isset($row['start_date'])) {
                try {
                    // إذا كان التاريخ نصاً مثل 5/5/2024
                    $startDate = Carbon::createFromFormat('d/m/Y', $row['start_date'])->format('Y-m-d');
                } catch (\Exception $e) {
                    // في حال كان Excel يرسله كـ Serial Number أو بصيغة أخرى
                    $startDate = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['start_date']))->format('Y-m-d');
                }
            }
            if (isset($row['end_date'])) {
                try {
                    // إذا كان التاريخ نصاً مثل 5/5/2024
                    $endDate = Carbon::createFromFormat('d/m/Y', $row['end_date'])->format('Y-m-d');
                } catch (\Exception $e) {
                    // في حال كان Excel يرسله كـ Serial Number أو بصيغة أخرى
                    $endDate = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['end_date']))->format('Y-m-d');
                }
            }
            Product::create([
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
                "price" => $row['price'],
                "offer_price" => !empty($row['offer_price']) ?? null,
                "start_date" => $startDate,
                "end_date" => $endDate,
            ]);
        }
    }
}