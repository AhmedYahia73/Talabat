<?php
namespace App\Filament\trait\tax;

use Filament\Actions\Action;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;

use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\CheckboxList;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;

trait TaxShema {
    public static function getTaxFormSchema(): array {
        return [
            Section::make('Tax Name')
            ->description('Enter Tax')
            ->schema([
                Tabs::make('Translations')
                ->tabs([
                    Tab::make('Arabic')
                        ->schema([
                            TextInput::make('name.ar')
                                ->label('Tax Name (AR)')
                                ->required(),
                        ]), 
                    Tab::make('English')
                        ->schema([
                            TextInput::make('name.en')
                                ->label('Tax Name (EN)'),
                        ]),
                ]), 
                TextInput::make('amount')
                ->required()
                ->validationMessages([
                    'required' => 'Amount is required',
                ])
                ->placeholder('Enter Amount'),
        
                Select::make('type')
                ->label('Type')
                ->required()
                ->options([
                    "precentage" => 'precentage',
                    "value" => 'value',
                ])
                ->placeholder('Select a Type') 
            ])
        ];
    }
}