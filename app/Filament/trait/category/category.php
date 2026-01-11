<?php
namespace App\Filament\trait\category;

use Filament\Forms\Components\TextInput;

use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;

use Filament\Actions\Action;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;

trait category {
    public static function getSharedFormSchema(): array {
        return [
            Section::make('Category Info.')
            ->description('Enter Data of Category')
            ->schema([

                
                Tabs::make('Translations')
                ->tabs([
                    Tab::make('Arabic')
                        ->schema([
                            TextInput::make('name.ar')
                                ->label('Category Name (AR)')
                                ->required(),
                        ]),

                    Tab::make('English')
                        ->schema([
                            TextInput::make('name.en')
                                ->label('Category Name (EN)')
                ->live(onBlur: true) // يجعل الحقل يتفاعل بمجرد الخروج منه أو الكتابة فيه
                ->afterStateUpdated(function ($state, $set, $get) {
                    // إذا كان حقل الـ slug فارغاً، قم بتعبئته تلقائياً من الاسم
                    if (blank($get('slug'))) {
                        $set('slug', \Illuminate\Support\Str::slug($state));
                    }
                }),
                        ]),
                ]),
                
                Tabs::make('Translations')
                ->tabs([
                    Tab::make('Arabic')
                        ->schema([
                        
                            Textarea::make('short_description.ar')
                            ->label('Short Description (AR)')
                            ->placeholder('Enter Long short description (AR)')
                            ->rows(2),
                        ]),

                    Tab::make('English')
                        ->schema([
                        
                            Textarea::make('short_description.en')
                            ->label('Short Description (EN)')
                            ->placeholder('Enter Long short description (EN)')
                            ->rows(2),
                        ]),
                ]),
                
                Tabs::make('Translations')
                ->tabs([
                    Tab::make('Arabic')
                        ->schema([
                        
                            Textarea::make('details.ar')
                            ->label('Description Name (AR)')
                            ->placeholder('Enter Long details (AR)')
                            ->rows(7),
                        ]),

                    Tab::make('English')
                        ->schema([
                        
                        Textarea::make('details.en')
                            ->placeholder('Enter Long details (EN)')
                            ->rows(7),
                        ]),
                ]),

                TextInput::make('slug')
                ->required()
                ->validationMessages([
                    'required' => 'Slug is required',
                ])
                ->placeholder('Enter Slug'),
        
                Select::make('category_id')
                ->label('Parent Category (Optional)')
                ->required()
                ->relationship('category', 'name', function ($query) {
                    $query->where('status', 1);
                })
                ->placeholder('Select a category'),
            
                
                TextInput::make('image') 
                ->id('media-category-input') 
                ->label('Image Path') 
                ->live() // مهم جداً لجعل المعاينة تتحدث فوراً
                ->afterStateUpdated(fn ($state) => $state)// معرف للوصول إليه بسهولة
                ->hintAction(
                    Action::make('open_picker')
                        ->label('Select Media')
                        ->icon('heroicon-m-folder-open')
                        ->modalHeading('Media Library Picker')
                        ->modalWidth('4xl')
                        ->modalContent(fn ($component) => view('filament.components.media-picker-logic', [
                            'target_state_path' => $component->getStatePath(),
                            'folders' => \Spatie\MediaLibrary\MediaCollections\Models\Media::query()
                                ->select('collection_name')
                                ->distinct()
                                ->pluck('collection_name'),
                            'allFiles' => \Spatie\MediaLibrary\MediaCollections\Models\Media::all()->map(fn($f) => [
                                'folder' => $f->collection_name,
                                'name' => $f->file_name,
                                'url' => url('storage/' . $f->collection_name . '/' . $f->file_name ),
                                'path' => $f->collection_name . '/' . $f->file_name 
                            ]),
                        ]))
                        ->modalSubmitAction(false)
                        
                        ->registerModalActions([
                        Action::make('uploadToFolder')
                        ->label('رفع ملف جديد')
                        ->form([
                            \Filament\Forms\Components\FileUpload::make('new_file')
                                ->label('اختر الملف')
                                ->required()
                                ->disk('public')
                                ->directory('temp') 
                        ])
                        ->action(function (array $data, array $arguments, $livewire) {
                            $folder = $arguments['folder'];
                            $file = $data['new_file'];
                            $fullPath = \Illuminate\Support\Facades\Storage::disk('public')->path($file);
                            $mediaModel = new Media();

                            // لوجيك الحفظ (نفس الكود السابق الخاص بسجل الميديا)
                            $mediaModel = new \Spatie\MediaLibrary\MediaCollections\Models\Media();
                            $mediaModel->model_type = 'App\Models\Media';
                            $mediaModel->model_id = 
                            
                            0;
                            $mediaModel->collection_name = $folder;
                            $mediaModel->name = pathinfo($file, PATHINFO_FILENAME);
                            $mediaModel->file_name = basename($file);
                            $mediaModel->mime_type = \Illuminate\Support\Facades\File::mimeType($fullPath);
                            $mediaModel->disk = 'public';
                            $mediaModel->size = \Illuminate\Support\Facades\Storage::disk('public')->size($file);
                            $mediaModel->uuid = \Illuminate\Support\Str::uuid();
                            $mediaModel->manipulations = [];
                            $mediaModel->custom_properties = [];
                            $mediaModel->generated_conversions = [];
                            $mediaModel->responsive_images = [];
                            $mediaModel->order_column = 1;
                            $mediaModel->save();
                            
                            // لوجيك الحفظ (نفس الكود الس  

                            // نقل الملف
                            \Illuminate\Support\Facades\Storage::disk('public')->move($file, $folder . '/' . basename($file));

                            \Filament\Notifications\Notification::make()->title('Uploaded!')->success()->send();
                            $livewire->dispatch('refreshMediaPicker');
                        })
                ]),
                )
                ->helperText(fn ($state) => view('filament.components.image-preview-helper', [
                    'state' => $state
                ])),
                
                Toggle::make('status')
                ->label('Status')
                ->onColor('success')
                ->offColor('danger')
                ->default(true),
            ])
            ->collapsible(),
        ];
    }
}