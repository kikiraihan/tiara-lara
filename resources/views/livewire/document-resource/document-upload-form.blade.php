<x-slot name="stylehalaman">
    @livewireStyles
</x-slot>

<x-slot name="scripthalaman">
    @livewireScripts    
    <!-- Animasi loading -->
    <script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/ring.js"></script>
</x-slot>

<div class="w-full h-full">
    
    <div class="text-lg mb-3">
        Upload New Document
    </div>

    <div>
        <form wire:submit.prevent="create" class="relative">
            {{ $this->form }}
        
            <br>
            <button 
                type="submit" 
                class="bg-raisaDongker1 hover:bg-raisaDongker2 p-2 text-white font-semibold relative flex gap-2 items-center"
                wire:loading.attr="disabled" 
                wire:target="create"
            >
                <span>
                    Submit 
                </span>
                <div wire:loading wire:target="create" >
                    <l-ring size='15' stroke="3" bg-opacity="0" speed="2" color="white" ></l-ring>
                </div>
            </button>
        </form>
        
        <x-filament-actions::modals />
    </div>
</div>