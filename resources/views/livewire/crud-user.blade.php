<x-slot name="stylehalaman">
    @livewireStyles
</x-slot>

<x-slot name="scripthalaman">
    @livewireScripts
    <!-- crud user -->
    <script>
        console.log(1)
    </script>
</x-slot>


<div class="w-full h-full">
    
    {{-- <div class="text-lg mb-3">
        Group
    </div> --}}

    <div>
        {{ $this->table }}
    </div>
</div>