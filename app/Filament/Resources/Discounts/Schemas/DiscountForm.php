<?php

namespace App\Filament\Resources\Discounts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

class DiscountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Discount Name')
                ->description('Enter Discount')
                ->schema([
                    Tabs::make('Translations')
                    ->tabs([
                        Tab::make('Arabic')
                            ->schema([
                                TextInput::make('name.ar')
                                    ->label('Discount Name (AR)')
                                    ->required(),
                            ]),

                        Tab::make('English')
                            ->schema([
                                TextInput::make('name.en')
                                    ->label('Discount Name (EN)'),
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
                    
                
            ]), 
        ]);
    }
}
