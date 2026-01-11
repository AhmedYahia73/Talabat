<?php 
namespace App\Filament\Resources\MarketPlaces\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Form; // تأكد من استخدام Form بدلاً من Schema إذا كنت في Filament v3

class MarketPlaceForm
{
    public static function configure(Schema $schema): Schema
    { 
        // '',
        // '',
        // 'image',
        // 'slug',
        // 'status',
        return $schema
            ->components([
                Section::make('MarketPlace Info.')
                    ->description('Enter Data of MarketPlace')
                    ->schema([ 
                        Tabs::make('Translations')
                        ->tabs([
                            Tab::make('Arabic')
                                ->schema([
                                    TextInput::make('name.ar')
                                        ->label('MarketPlace Name (AR)')
                                        ->required(),
                                ]),

                            Tab::make('English')
                                ->schema([
                                    TextInput::make('name.en')
                                        ->label('MarketPlace Name (EN)'),
                                ]),
                        ]), 

                        Tabs::make('Translations')
                        ->tabs([
                            Tab::make('Arabic')
                                ->schema([
                                    Textarea::make('details.ar')
                                    ->label('MarketPlace Details (AR)')
                                    ->rows(7),
                                ]),

                            Tab::make('English')
                            ->schema([
                                Textarea::make('details.en')
                                ->label('MarketPlace Details (EN)')
                                ->rows(7),
                            ]),
                        ]), 
                     
                        FileUpload::make('image') // غيرنا الاسم لجمع ليكون منطقياً
                        ->label('MarketPlace Images')
                        ->image()
                        ->required(), 
                        TextInput::make('slug')
                        ->required(),  
                    ])
                    ->collapsible(),
            ]);
    }
}