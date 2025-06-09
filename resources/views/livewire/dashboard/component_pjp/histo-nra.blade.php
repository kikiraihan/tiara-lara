{{-- 
<div class="dark:bg-gray-800 bg-white shadow-md rounded-md overflow-hidden" id="container_histo_nra" style="height: 300px;">
    <div class="flex flex-col justify-center items-center animate-pulse">
        <img src="{{ asset('raisa_gambar/data-processing-67.svg') }}" alt="SVG image" width="200px">
        <span class="p-3">Memuat dashboard...</span>
    </div>
</div> --}}

<div>
    <div id="container_histo_nra"></div>
</div>

@include('livewire.dashboard.component_pjp.histo-nra_script')
{{-- @include('livewire.dashboard.component.histo-nra_perbandingan_script') --}}