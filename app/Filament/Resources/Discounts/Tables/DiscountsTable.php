<?php

namespace App\Filament\Resources\Discounts\Tables;

use App\Models\Product;
use App\Models\Discount;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;

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
                        ->options(function(Discount $record){
                            return Product::
                            whereNull("discount_id")
                            ->orWhere("discount_id", $record->id)
                            ->pluck('name', 'id');
                        })
                        ->searchable()
                        ->default(function(Discount $record){
                            return Product:: 
                            Where("discount_id", $record->id)
                            ->pluck('id')
                            ->toArray();
                        })
                        ->required(),
                ])
                ->action(function (array $data, $record): void {
                    Product::where('discount_id', $record->id)
                        ->update(['discount_id' => null]);
                    Product::whereIn('id', $data['product_ids'])
                        ->update(['discount_id' => $record->id]);

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
