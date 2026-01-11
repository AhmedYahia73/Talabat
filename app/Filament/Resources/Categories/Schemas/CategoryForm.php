<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Schemas\Schema;
use App\Filament\trait\category\category;

class CategoryForm
{
    use category;
    public static function configure(Schema $schema): Schema
    {
        return $schema
        ->components(self::getSharedFormSchema());
    }
}
