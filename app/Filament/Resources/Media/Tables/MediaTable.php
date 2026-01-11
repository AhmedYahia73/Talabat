<?php

namespace App\Filament\Resources\Media\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action; 

class MediaTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->query(
            Media::query()
            ->selectRaw('MIN(id) as id, collection_name, COUNT(*) as files_count, MAX(created_at) as latest_file')
            ->groupBy('collection_name')
        )
        ->columns([ 
            TextColumn::make('collection_name')
                ->label("Folders")
                ->formatStateUsing(fn ($state, $record) => "{$state} ({$record->files_count})") 
                ->color('warning')
                ->color('yellow')
                ->weight('bold')
                ->icon('heroicon-s-folder')
                ->iconColor('info')
                // نربط العمود بالأكشن
                ->action(
                    Action::make('view_files')
                    ->label(fn ($record) => $record->collection_name)
                    ->icon('heroicon-s-folder')
                    ->color('yellow')
                    ->badge(fn ($record) => $record->files_count)
                    ->badgeColor('info')
                    ->modalContent(fn ($record) => view('filament.resources.media-folder.pages.manage-folder-files', [
                        'files' => Media::where('collection_name', $record->collection_name)
                                    ->where('file_name', '!=', '.placeholder')
                                    ->get(),
                        'folder' => $record->collection_name
                    ]))
                    ->modalSubmitAction(false) // لإخفاء زر الحفظ في المودال
                    ->modalWidth('8xl'), 
                )
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
