{{-- <div>
    <!-- Container untuk Bar Chart Pengurus -->
    <div class="dark:bg-gray-800 bg-white shadow-md rounded-md overflow-hidden" id="container-bar_chart_pengurus" style="height: 800px;">
        <div class="flex flex-col justify-center items-center animate-pulse">
            <img src="{{ asset('raisa_gambar/data-processing-67.svg') }}" alt="SVG image" width="200px">
            <span class="p-3">Memuat dashboard...</span>
        </div>
    </div>
</div> --}}

<div>
    <div id="container-bar_chart_pengurus"></div>
</div>
@include('livewire.dashboard.component_pjp.bar_pengurus_nra_script')
