<x-slot name="stylehalaman">
    @livewireStyles
</x-slot>

<x-slot name="scripthalaman">
    @livewireScripts
    <script>
        console.log(1)
    </script>
</x-slot>

<div>
    {{ $this->table }}
</div>
