<div x-data="{ 
    selected: @entangle($getStatePath()), 
    view: 'folders',
    selectedFolder: '',
    files: @js($allFiles) 
}" class="w-full">

    <div x-show="view === 'folders'" class="grid grid-cols-4 gap-4">
        @foreach($folders as $folder)
            <div @click="selectedFolder = '{{ $folder }}'; view = 'files'" 
                 class="p-4 border rounded-xl cursor-pointer hover:bg-gray-50 flex flex-col items-center">
                <x-filament::icon icon="heroicon-s-folder" class="w-12 h-12 text-yellow-500" />
                <span class="text-xs font-bold mt-2">{{ $folder }}</span>
            </div>
        @endforeach
    </div>

    <div x-show="view === 'files'" x-cloak>
        <button @click="view = 'folders'" class="mb-4 text-sm text-primary-600 flex items-center">
            <x-filament::icon icon="heroicon-m-arrow-left" class="w-4 h-4 mr-1" /> رجوع
        </button>
        
        <div class="grid grid-cols-6 gap-2">
            <template x-for="file in files.filter(f => f.folder === selectedFolder)" :key="file.path">
                <div @click="selected = file.path" 
                     class="relative aspect-square border-2 rounded-lg overflow-hidden cursor-pointer"
                     :class="selected === file.path ? 'border-primary-500 ring-2 ring-primary-500' : 'border-transparent'">
                    <img :src="file.url" class="w-full h-full object-cover">
                </div>
            </template>
        </div>
    </div>
</div>