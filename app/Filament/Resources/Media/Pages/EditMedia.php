<?php

namespace App\Filament\Resources\Media\Pages;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Filament\Resources\Media\MediaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Illuminate\Support\Facades\URL;

class EditMedia extends EditRecord
{
    protected static string $resource = MediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
             Action::make('view_folder')
            ->label('View Files')
            ->icon('heroicon-o-eye')
            ->url(fn () => MediaFolderPage::getUrl([
                'folder' => $this->record->collection_name
            ])),
            DeleteAction::make(),
        ];
    }
        
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->oldCollectionName = $this->record->collection_name;

        return $data;
    }

    protected function afterSave(): void
    {
        if ($this->oldCollectionName !== $this->record->collection_name) {
            Media::where('collection_name', $this->oldCollectionName)
                ->update([
                    'collection_name' => $this->record->collection_name,
                ]);
        }
    }
}
