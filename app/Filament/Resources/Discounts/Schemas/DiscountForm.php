<?php

namespace App\Filament\Resources\Discounts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

use App\Filament\trait\discount\DiscountSchema;
class DiscountForm
{
    use DiscountSchema;
    public static function configure(Schema $schema): Schema
    {
        return $schema
        ->components(self::getDiscountFormSchema());
    }
}
