<?php

namespace App\Filament\Resources\Taxes\Tables;

use App\Models\Tax;
use App\Models\Product; 
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;

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
                Action::make('applyBulkDiscount')
                ->icon('heroicon-o-plus-circle') 
                ->iconButton() 
                ->size('xl') 
                ->color('success')
                ->tooltip('Add Products')
                ->form([
                    // اختيار المنتجات
                    Select::make('product_ids')
                        ->label('Select Products')
                        ->multiple()
                        ->options(function(Tax $record){
                            return Product::
                            whereNull("tax_id")
                            ->orWhere("tax_id", $record->id)
                            ->pluck('name', 'id');
                        })
                        ->searchable()
                        ->default(function(Tax $record){
                            return Product:: 
                            Where("tax_id", $record->id)
                            ->pluck('id')
                            ->toArray();
                        })
                        ->required(),
                ])
                ->action(function (array $data, $record): void {
                    Product::where('tax_id', $record->id)
                        ->update(['tax_id' => null]);
                    Product::whereIn('id', $data['product_ids'])
                        ->update(['tax_id' => $record->id]);

                    Notification::make()
                        ->title('Success')
                        ->success()
                        ->send();
                }),
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
