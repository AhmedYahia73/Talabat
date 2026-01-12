<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->toggleable(),
                ImageColumn::make('image')
                ->label('image')
                ->circular() // لجعل الصورة دائرية (اختياري)
                ->disk('public') // تأكد من مطابقة الـ Disk المستخدم في الـ Upload
                ->width(50) // تحديد عرض الصورة في الجدول
                ->height(50)
                ->toggleable(),
                TextColumn::make('price')
                ->searchable()
                ->sortable()
                ->toggleable(),
                TextColumn::make('slug')
                ->searchable()
                ->sortable()
                ->toggleable(),
                TextColumn::make('category.name')
                ->label("Category")
                ->searchable()
                ->sortable()
                ->toggleable(), 
                TextColumn::make('slug')
                ->searchable()
                ->sortable()
                ->toggleable(),
                ToggleColumn::make('status')
                ->label('Status')
                ->onColor('success')
                ->offColor('danger')
                ->toggleable(),
            ])
            ->headerActions([
                ExportAction::make()->exports([
                    ExcelExport::make()->fromTable(),
                ]),
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
