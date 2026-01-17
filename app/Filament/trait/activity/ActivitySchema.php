<?php
namespace App\Filament\trait\activity;

use Filament\Actions\Action;
use Dotswan\MapPicker\Fields\Map;
use Filament\Forms\Components\Hidden;

use Filament\Forms\Components\Select;

use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Tables\Columns\ToggleColumn;

trait ActivitySchema {
    public static function getActivityFormSchema(): array {
        return [
            Section::make('Activity Info.')
                ->description('Enter Data of Activity')
                ->schema([ 
                    Tabs::make('Translations')
                    ->tabs([
                        Tab::make('Arabic')
                            ->schema([
                                TextInput::make('name.ar')
                                ->label('Activity Name (AR)')
                                ->required(),
                        ]),

                        Tab::make('English')
                            ->schema([
                            TextInput::make('name.en')
                            ->label('Activity Name (EN)'),
                        ]),
                    ]), 
 
                    
                    Toggle::make('status')
                    ->label('Status')
                    ->onColor('success')
                    ->offColor('danger')
                    ->default(true),
                ])
                ->collapsible(),
        ];
    }
}