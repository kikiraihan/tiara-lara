<div class="grid md:grid-cols-4 gap-3 px-2">
    <div class="col-span-4">
        @include('livewire.dashboard.cards')
    </div>
    
    <div class="col-span-2">
        @include('livewire.dashboard.component.histo-nra')
    </div>

    <div class="col-span-2">
        @include('livewire.dashboard.component.histo-nra_perbandingan')
    </div>

    <div class="col-span-4">
        @include('livewire.dashboard.component.scatter_selisih_nra')
    </div>

    <div class="col-span-4">
        @include('livewire.dashboard.component.table_sandi_nra')
    </div>

    <div class="col-span-4">
        @include('livewire.dashboard.component.boxplot-pulau-nra')
    </div>

    {{-- <div class="col-span-4">
        @include('livewire.dashboard.component.scatter-pulau-nra')
    </div> --}}

    
    <div class="col-span-4">
        @include('livewire.dashboard.component.bar_top_kpwdn_nra')
    </div>

    <div class="col-span-4">
        @include('livewire.dashboard.component.bar_kpwdn_nra')
    </div>

    <div class="col-span-2">
        @include('livewire.dashboard.component.bar_pemegang_saham_nra')
    </div>

    <div class="col-span-2">
        @include('livewire.dashboard.component.bar_pengurus_nra')
    </div>

    {{-- <div class="col-span-4">
        @include('livewire.dashboard.component.scatter_kurs_tengah_nra')
    </div>

    <div class="col-span-4">
        @include('livewire.dashboard.component.scatter_volume_penjualan_nra')
    </div>

    <div class="col-span-4">
        @include('livewire.dashboard.component.scatter_volume_pembelian_nra')
    </div>

    <div class="col-span-4">
        @include('livewire.dashboard.component.scatter_saldo_awal_nra')
    </div>
    <div class="col-span-4">
        @include('livewire.dashboard.component.scatter_saldo_akhir_nra')
    </div>
    <div class="col-span-4">
        @include('livewire.dashboard.component.scatter_spread_keuntungan_nra')
    </div> --}}
    
</div>