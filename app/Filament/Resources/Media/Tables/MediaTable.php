<?php

namespace App\Filament\Resources\Media\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Filament\Resources\Media\Pages\MediaFolderPage;

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
                ->url(fn ($record) => MediaFolderPage::getUrl([
                    'folder' => $record->collection_name
                ])),
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
