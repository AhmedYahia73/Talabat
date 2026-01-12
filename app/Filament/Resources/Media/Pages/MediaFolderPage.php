<?php
namespace App\Filament\Resources\Media\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class MediaFolderPage extends Page
{
    protected string $view = 'filament.pages.media-folder-page';

    protected static bool $shouldRegisterNavigation = false; 


    public string $folder; 
    public array $files = [];

    public function mount(): void
    {
        $this->folder = $_GET['folder'];
        $this->loadFiles();
    }

    public function loadFiles(): void
    {
        $this->files = Media::where('collection_name', $this->folder)->get()->toArray();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('upload_files')
            ->label('Upload Files')
            ->icon('heroicon-o-arrow-up-tray')
            ->color('success')
            ->form([
                Forms\Components\FileUpload::make('files')
                    ->label('Select Files')
                    ->multiple()
                    ->required()
                    ->maxFiles(20)
                    ->disk('public')
                    ->directory('media-temp')
                    ->preserveFilenames()
                    ->maxSize(10240)
                    ->acceptedFileTypes(['image/*','application/pdf','video/*']),
            ])
            ->action(function (array $data) {
                foreach ($data['files'] as $filePath) {
                    $disk = 'public';

                    $fileName = basename($filePath); // filename.jpg
                    $fileOriginalName = pathinfo($fileName, PATHINFO_FILENAME);
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION); // jpg, png, pdf...
                    $uniqueName = $fileOriginalName . '-' . Str::uuid() . '.' . $extension;

                    $media = new Media();
                    $media->model_type = 'App\\Models\\Media';
                    $media->model_id = 0;
                    $media->collection_name = $this->folder;
                    $media->name = $fileOriginalName; // اسم للعرض
                    $media->file_name = $uniqueName;  // اسم فريد للملف
                    $media->mime_type = File::mimeType(Storage::disk($disk)->path($filePath));
                    $media->disk = $disk;
                    $media->size = Storage::disk($disk)->size($filePath);
                    $media->manipulations = [];
                    $media->custom_properties = [];
                    $media->generated_conversions = [];
                    $media->responsive_images = [];
                    $media->uuid = Str::uuid();
                    $media->save();

                    // نقل الملف من الـ temp للمجلد النهائي
                    Storage::disk($disk)->move($filePath, $this->folder . '/' . $uniqueName);
                }


                $this->loadFiles();

                Notification::make()
                ->title('Files uploaded successfully')
                ->success()
                ->send();
            })
            ->modalWidth('lg'),
            
        ];
    }

    public function deleteFile($id){

        $file_media = Media::
        where('id', $id)
        ->first();
        if(!empty($file_media)){
            $imagePath = $file_media->collection_name . '/' . $file_media->file_name;
            if ($imagePath && !empty($imagePath) && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $file_media->delete();
    
            Notification::make()
            ->title('File deleted successfully')
            ->success()
            ->send();
        }
        else{
            Notification::make()
            ->title('Faild to deleted')
            ->danger()
            ->send();
        }
    }
}
