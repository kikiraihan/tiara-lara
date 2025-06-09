{{-- <div>
    <!-- Container for the Bar Chart -->
    <div class="dark:bg-gray-800 bg-white shadow-md rounded-md overflow-hidden" id="container-bar_chart_pemegang_saham" style="height: 800px;">
        <div class="flex flex-col justify-center items-center animate-pulse">
            <img src="{{ asset('raisa_gambar/data-processing-67.svg') }}" alt="SVG image" width="200px">
            <span class="p-3">Memuat dashboard...</span>
        </div>
    </div>
</div> --}}

<div>
    <div id="container-bar_chart_pemegang_saham"></div>
</div>
@include('livewire.dashboard.component.bar_pemegang_saham_nra_script')
