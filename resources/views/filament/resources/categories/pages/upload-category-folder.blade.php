<x-filament-panels::page>
    
    <div x-data="...">
        <x-filament::button @click="$wire.mountAction('CreateFolder')">
            Create Folder
        </x-filament::button>
    </div>

    <x-filament-actions::modals />

</x-filament-panels::page>