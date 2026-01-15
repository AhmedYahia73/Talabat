<?php

namespace App\Filament\Resources\Discounts\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class DiscountsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label("Discount Name")
                ->searchable()
                ->sortable()
                ->toggleable(),
                TextColumn::make('amount')
                ->label("Discount Value")
                ->searchable()
                ->sortable()
                ->toggleable()
                ->formatStateUsing(function($record){
                    if($record->type == "precentage"){
                        return $record->amount . ' %';
                    }
                    else{
                        return $record->amount . ' Pound';
                    }
                }),
                TextColumn::make('type')
                ->label("Tax Type")
                ->searchable()
                ->sortable()
                ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
