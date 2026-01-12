<?php

namespace App\Filament\Resources\Categories\Tables;

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

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([ 
                TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->toggleable(), 
                TextColumn::make('slug')
                ->searchable()
                ->toggleable(),
                ImageColumn::make('image')
                ->label('image')
                ->circular() // لجعل الصورة دائرية (اختياري)
                ->disk('public') // تأكد من مطابقة الـ Disk المستخدم في الـ Upload
                ->width(50) // تحديد عرض الصورة في الجدول
                ->height(50)
                ->toggleable(),
                TextColumn::make('category.name')
                ->label('Category Name')
                ->sortable()
                ->searchable()
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
