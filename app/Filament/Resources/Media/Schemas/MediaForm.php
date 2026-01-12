<?php

namespace App\Filament\Resources\Media\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput; 

class MediaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('collection_name')
                ->label('Folder Name')
                ->required()
                ->unique(ignoreRecord: true),
            ]);
    }
}
