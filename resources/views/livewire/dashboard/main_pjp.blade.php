<div class="grid md:grid-cols-4 gap-3 px-2">
    <div class="col-span-4">
        @include('livewire.dashboard.cards')
    </div>
    
    <div class="col-span-2">
        @include('livewire.dashboard.component_pjp.histo-nra')
    </div>

    <div class="col-span-2">
        @include('livewire.dashboard.component_pjp.histo-nra_perbandingan')
    </div>

    <div class="col-span-4">
        @include('livewire.dashboard.component_pjp.scatter_selisih_nra')
    </div>

    <div class="col-span-4">
        @include('livewire.dashboard.component_pjp.table_sandi_nra')
    </div>

    <div class="col-span-4">
        @include('livewire.dashboard.component_pjp.boxplot-pulau-nra')
    </div>

    {{-- <div class="col-span-4">
        @include('livewire.dashboard.component_pjp.scatter-pulau-nra')
    </div> --}}

    
    <div class="col-span-4">
        @include('livewire.dashboard.component_pjp.bar_top_kpwdn_nra')
    </div>

    <div class="col-span-4">
        @include('livewire.dashboard.component_pjp.bar_kpwdn_nra')
    </div>

    <div class="col-span-2">
        @include('livewire.dashboard.component_pjp.bar_pemegang_saham_nra')
    </div>

    <div class="col-span-2">
        @include('livewire.dashboard.component_pjp.bar_pengurus_nra')
    </div>
</div>