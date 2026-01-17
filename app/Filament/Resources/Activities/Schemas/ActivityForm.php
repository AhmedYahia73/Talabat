<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Schemas\Schema;
use App\Filament\trait\activity\ActivitySchema;

class ActivityForm
{
    use ActivitySchema;

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(self::getActivityFormSchema());
    }
}
