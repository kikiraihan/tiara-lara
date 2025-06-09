<x-slot name="stylehalaman">
    @livewireStyles
    {{-- datatable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
</x-slot>

<x-slot name="scripthalaman">
    @livewireScripts
    @include('livewire.dashboard.dashboard_script')
</x-slot>


<div class="w-full h-full relative flex flex-col bg-gradient-to-r from-gradientLight1 to-gradientLight2 dark:from-gradientDark1 dark:to-gradientDark2 overflow-scroll" id="toFullScreen">
    
    <div class="space-x-1 flex items-center justify-between"> 
        <div class="space-x-1 flex"> 
            <div class="px-2 py-2 hover:text-orange-300 hover:bg-gray-50 dark:hover:bg-gray-700 bg-white dark:bg-gray-800 rounded-md border-2 border-gray-200 dark:border-gray-700">
                {{ $this->filterAction->iconButton()->icon('eos-manage-search') }}
                <x-filament-actions::modals class="z-50"/>
            </div>
            <button id="toggleFullscreenButton" class="px-2 py-1 hover:text-orange-300 hover:bg-gray-50 dark:hover:bg-gray-700 bg-white dark:bg-gray-800 rounded-md border-2 border-gray-200 dark:border-gray-700" wire:ignore>
                <span class="text-lg"><i class="bx bx-fullscreen"></i></span>
            </button>
        </div>
        @if ($on_search)
        <div>
            
            @if ($on_search['dataset'])
                <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 shadow-sm shadow-gray-100">
                    {{ "Dataset : ".$on_search['dataset']}} 
                </span>
            @endif

        </div>
        @endif
    </div>
    
    <div class="w-full h-full" wire:ignore>

        {{-- {{json_encode($on_search)}} --}}
        <div x-data="{ onSearch: @entangle('on_search') }" class="w-full h-full">
            <!-- Kondisi untuk menampilkan grid jika onSearch adalah true -->
            {{-- <template x-if="onSearch"> --}}
                @include('livewire.dashboard.main_pjp')

                @include('livewire.dashboard.main_kupva')
            {{-- </template> --}}

            <!-- Kondisi untuk menampilkan pesan default jika onSearch adalah false -->
            <template x-if="!onSearch">
                <div class=" w-full h-full rounded shadow-lg flex justify-center">
                    <div class="flex flex-col justify-start items-center">
                        <img src="{{ asset('raisa_gambar/finance-app-1-98.svg') }}" alt="SVG image" class="w-full -my-12">
                        <span class="mb-2">Dashboard</span>
                        {{ $this->filterAction }}
                    </div>
                </div>
            </template>

        </div>



    </div>

</div>