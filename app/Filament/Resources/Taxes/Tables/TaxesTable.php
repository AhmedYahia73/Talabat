<?php

namespace App\Filament\Resources\Taxes\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class TaxesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label("Tax Name")
                ->searchable()
                ->sortable()
                ->toggleable(),
                TextColumn::make('amount')
                ->label("Tax Value")
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
            ])
            ->recordActions([
                DeleteAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
