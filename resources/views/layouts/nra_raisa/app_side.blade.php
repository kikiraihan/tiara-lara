<aside class="flex-none w-1/2 md:w-1/5 fixed md:relative md:flex flex-col space-y-1 bg-gradient-to-r from-gradientLight1 to-gradientLight2 dark:from-gradientDark2 dark:to-gradientDark0 shadow border-r-2 border-gray-200 dark:border-gray-700 p-2 pt-3 h-screen md:h-auto overflow-auto z-30" id="sidebar">
    {{-- x-show="asideOpen"  --}}
    @foreach ([
        ['judul'=>'Home','icon'=>'bx bx-home-alt','route'=>'crud.loby'],
        ['judul'=>'Dataset','icon'=>'bx bx-file','route'=>'crud.dataset'],
        ['judul'=>'Dashboard','icon'=>'bx bxs-dashboard','route'=>'dashboard'],
        ['judul'=>'Profiling','icon'=>'bx bx-box','route'=>'#', 
            'submenu' => [
                ['judul'=>'kupva profil','icon'=>'bx bxs-store-alt','route'=>'crud.kupva-profil'],
                ['judul'=>'kupva nra','icon'=>'bx bxs-store-alt','route'=>'crud.kupva-nra'],
                ['judul'=>'pjp profil','icon'=>'bx bxs-store-alt','route'=>'crud.pjp-profil'],
                ['judul'=>'pjp nra','icon'=>'bx bxs-store-alt','route'=>'crud.pjp-nra'],
            ]
        ],
        ['judul'=>'Master','icon'=>'bx bx-box','route'=>'#', 
            'submenu' => [
                ['judul'=>'Model','icon'=>'bx bx-brain','route'=>'crud.model'],
                // ['judul'=>'Validation','icon'=>'bx bx-list-check','route'=>'crud.validation-model-dataset'],
                ['judul' => 'Users', 'icon' => 'fas fa-users', 'route' => 'crud.user'], // 'fa-users' sesuai untuk pengguna
            ]
        ],
    ] as $item)
    
    @if(isset($item['submenu']))
    <div x-data="{ open: false }">
        <a href="#" @click="open = !open" class="flex items-center space-x-1 rounded-md px-2 py-2 hover:bg-raisaDongker1 hover:text-white dark:hover:bg-gray-700 dark:hover:text-blue-500 transition duration-200">
            <span class="text-2xl"><i class="{{$item['icon']}}"></i></span>
            <span>{{$item['judul']}}</span>
            <span class="ml-auto" x-bind:class="{'transform rotate-90': open}"><i class="bx bx-chevron-right"></i></span>
        </a>
        <div x-show="open" class="pl-4 space-y-1">
            @foreach ($item['submenu'] as $subitem)
                <a href="{{ route($subitem['route']) }}" class="flex items-center 
                    space-x-1 rounded-md px-2 py-2 hover:bg-raisaDongker1 hover:text-white dark:hover:bg-gray-700 
                    dark:hover:text-blue-500 transition duration-200">
                    <span class="text-2xl"><i class="{{$subitem['icon']}}"></i></span>
                    <span>{{$subitem['judul']}}</span>
                </a>
            @endforeach
        </div>
    </div>
    @else
    <a href="{{ route($item['route']) }}" class="flex items-center space-x-1 rounded-md px-2 py-2 hover:bg-raisaDongker1 hover:text-white dark:hover:bg-gray-700 dark:hover:text-blue-500 transition duration-200">
        <span class="text-2xl"><i class="{{$item['icon']}}"></i></span>
        <span>{{$item['judul']}}</span>
    </a>
    @endif
    @endforeach
</aside>
