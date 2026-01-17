<?php
namespace App\Filament\trait\market_place;

use Filament\Actions\Action;
use Dotswan\MapPicker\Fields\Map;
use Filament\Forms\Components\Hidden;

use Filament\Forms\Components\Select;

use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\CheckboxList;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Filament\trait\activity\ActivitySchema;

trait MarketPlaceSchema {
    use ActivitySchema;

    public static function getMaerketFormSchema(): array {
        return [
            Section::make('MarketPlace Info.')
                ->description('Enter Data of MarketPlace')
                ->schema([ 
                    Tabs::make('Translations')
                    ->tabs([
                        Tab::make('Arabic')
                            ->schema([
                                TextInput::make('name.ar')
                                ->label('MarketPlace Name (AR)')
                                ->required(),
                        ]),

                        Tab::make('English')
                            ->schema([
                            TextInput::make('name.en')
                            ->label('MarketPlace Name (EN)'),
                        ]),
                    ]), 

                    Tabs::make('Translations')
                    ->tabs([
                        Tab::make('Arabic')
                        ->schema([
                            Textarea::make('details.ar')
                            ->label('MarketPlace Details (AR)')
                            ->rows(7),
                        ]),

                        Tab::make('English')
                        ->schema([
                            Textarea::make('details.en')
                            ->label('MarketPlace Details (EN)')
                            ->rows(7),
                        ]),
                    ]), 
                    
        
                    TextInput::make('image')
                    ->label('image path')
                    ->live()
                    ->hintAction(
                        Action::make('open_picker')
                            ->label('open media library')
                            ->icon('heroicon-m-photo')
                            ->modalWidth('6xl')
                            ->form([
                                // 1. اختيار المجلد (الفلتر)
                                Select::make('folder_filter')
                                    ->label('select Folder (Folder)')
                                    ->options(
                                        Media::distinct()
                                            ->pluck('collection_name', 'collection_name')
                                    )
                                    ->live() // يجعل المعرض يتحدث فور تغيير المجلد
                                    ->afterStateUpdated(fn ($set) => $set('selected_file_path', null))
                                    ->placeholder('Select Folder For Show Files...'),

                                // 2. قسم الرفع (اختياري: يظهر فقط عند اختيار مجلد)
                                Section::make('upload image for this folder')
                                ->hidden(fn ($get) => !$get('folder_filter')) // مخفي حتى تختار مجلد
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    FileUpload::make('new_upload')
                                    ->image()
                                    ->disk('public')
                                    ->directory('media')
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        if (!$state) return;

                                        // 1. الحصول على اسم الملف الأصلي
                                        // ملاحظة: $state هنا يكون كائن من نوع TemporaryUploadedFile
                                        $originalName = \Illuminate\Support\Str::uuid() . $state->getClientOriginalName();
                                        $folder = $get('folder_filter') ?? 'media';

                                        // 2. نقل الملف يدوياً من المجلد المؤقت إلى المجلد النهائي
                                        // هذا السطر هو السر في تحويله من .tmp إلى ملف حقيقي
                                        $finalPath = \Illuminate\Support\Facades\Storage::disk('public')
                                            ->putFileAs($folder, $state, $originalName);

                                        // 3. الآن نسجل البيانات في قاعدة البيانات بالمسار النهائي
                                        $media = new \Spatie\MediaLibrary\MediaCollections\Models\Media();
                                        $media->model_type = 'App\Models\Media';
                                        $media->model_id = 0;
                                        $media->collection_name = $folder;
                                        $media->file_name = $originalName; // الاسم الحقيقي
                                        $media->name = pathinfo($originalName, PATHINFO_FILENAME);
                                        $media->disk = 'public';
                                        $media->uuid = \Illuminate\Support\Str::uuid();
                                        $media->size = $state->getSize();
                                        $media->mime_type = $state->getMimeType();
                                        $media->manipulations = [];
                                        $media->custom_properties = [];
                                        $media->generated_conversions = [];
                                        $media->responsive_images = [];
                                        $media->save();

                                        // 4. إجبار الخانة على اختيار الملف الجديد بالمسار الصحيح
                                        $set('selected_file_path', [$folder . '/' . $originalName]);

                                        // 5. تنظيف خانة الرفع لاستقبال ملف آخر إذا أردت
                                        $set('new_upload', null);

                                        \Filament\Notifications\Notification::make()
                                            ->title('تم حفظ الصورة في المجلد: ' . $folder)
                                            ->success()
                                            ->send();
                                    }),
                                ]),

                                // 3. معرض الصور المفلتر
                                CheckboxList::make('selected_file_path')
                                    ->label('الصور المتاحة في المجلد:')
                                    ->hidden(fn ($get) => !$get('folder_filter')) // مخفي حتى تختار مجلد
                                    ->options(function ($get) {
                                        $folder = $get('folder_filter');
                                        if (!$folder) return [];

                                        return \Spatie\MediaLibrary\MediaCollections\Models\Media::where('collection_name', $folder)
                                            ->latest()
                                            ->get()
                                            ->mapWithKeys(function ($file) {
                                                $url = asset('storage/' . $file->collection_name . '/' . $file->file_name);
                                                return [
                                                    $file->collection_name . '/' . $file->file_name => 
                                                    "<div class='flex flex-col items-center p-2 border rounded-lg hover:bg-primary-50 transition border-gray-200'>
                                                        <img src='{$url}' class='w-full aspect-square object-cover rounded-md mb-1'>
                                                        <span class='text-[9px] truncate w-20 text-center text-gray-400'>{$file->file_name}</span>
                                                    </div>"
                                                ];
                                            });
                                    })
                                    ->allowHtml()
                                    ->columns(['sm' => 3, 'md' => 4, 'lg' => 6])
                                    ->maxItems(1)
                                    ->required(),
                            ])
                            ->action(function (array $data, $component) {
                                if (!empty($data['selected_file_path'])) {
                                    $path = is_array($data['selected_file_path']) ? $data['selected_file_path'][0] : $data['selected_file_path'];
                                    $component->state($path);
                                }
                            }) 
                    )
                    ->helperText(fn ($state) => view('filament.components.image-preview-helper', [
                        'state' => $state
                    ])),
                    TextInput::make('slug')
                    ->required(),  

                    Select::make('activity_id')
                    ->label('Activity (Optional)')
                    ->required()
                    ->relationship(
                        name: 'activity',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query) => $query
                            ->where('status', 1)
                    )
                    ->placeholder('Select a Activity')
                    // هذا هو الجزء المسؤول عن زر الـ Plus
                    ->createOptionAction(
                        fn (Action $action) => $action
                            ->modalHeading('Create New Activity') // عنوان النافذة
                            ->modalButton('Create')              // نص زر الحفظ
                            ->modalWidth('md')                   // حجم النافذة
                    )
                    // هنا نحدد الحقول التي ستظهر داخل الـ Modal لإضافة القسم
                    ->createOptionForm([
                        Section::make('Activity Info.')
                        ->description('Enter Data of Activity')
                        ->schema(self::getActivityFormSchema())
                        ->collapsible(),
                    ]), 
                    ToggleColumn::make('status')
                    ->label('Status')
                    ->onColor('success')
                    ->offColor('danger'),
                    // Map::make('location')
                    //     ->label('Market Location')
                    //     ->columnSpanFull()
                    //     ->defaultLocation(latitude: 30.0444, longitude: 31.2357) // القاهرة كبداية
                    //     ->afterStateUpdated(function ($state, callable $set) {
                    //         // تحديث حقول الـ lat و lng المخفية أو الظاهرة عند تحريك الخريطة
                    //         $set('lat', $state['lat']);
                    //         $set('lng', $state['lng']);
                    //     })
                    //     // تأكد من ربط الحقول عند تحميل الصفحة (اختياري حسب تصميمك)
                    //     ->afterStateHydrated(function ($state, $record, callable $set) {
                    //         if ($record) {
                    //             $set('location', ['lat' => $record->lat, 'lng' => $record->lng]);
                    //         }
                    //     }),

                    // // حقول مخفية لحفظ القيم في الداتابيز
                    // Hidden::make('lat'),
                    // Hidden::make('lng'),
                ])
                ->collapsible(),
        ];
    }
}