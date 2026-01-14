<?php

namespace App\Filament\Resources\MarketPlaces\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Actions\DeleteAction;

class MarketPlacesTable
{
    public static function configure(Table $table): Table
    {       
        // 'name',
        // 'details',
        // 'image',
        // 'slug',
        // 'status',
        return $table
            ->columns([
                TextColumn::make('name')
                ->sortable()
                ->searchable(),
                ImageColumn::make('image')
                ->label('image')
                ->circular() // لجعل الصورة دائرية (اختياري)
                ->disk('public') // تأكد من مطابقة الـ Disk المستخدم في الـ Upload
                ->width(50) // تحديد عرض الصورة في الجدول
                ->height(50)
                ->toggleable(),
                TextColumn::make('slug')
                ->sortable()
                ->searchable(),
                ToggleColumn::make('status')
                ->label('Status')
                ->onColor('success')
                ->offColor('danger'),
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
