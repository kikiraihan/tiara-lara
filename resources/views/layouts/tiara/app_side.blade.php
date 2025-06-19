<div class="w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 overflow-y-auto">
    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center space-x-3">
            {{-- <img src="https://img.favpng.com/24/14/21/bank-indonesia-central-bank-logo-png-favpng-fmrrs1thB28gyQieJKu6f7qxG.jpg" alt="BI Logo" class="h-8 w-8"> --}}
            {{-- <div data-lucide="gem"></div> --}}
            <x-tiara-logo/>
            <div>
                <h1 class="text-lg font-semibold text-gray-800 dark:text-white">TIARA</h1>
                <p class="text-xs text-gray-500 dark:text-gray-400">Admin Panel</p>
            </div>
        </div>
    </div>
    
    @php
        $currentUrl = url()->current(); // Get the current full URL

        $navItems = [
            [
                'icon' => 'home',
                'text' => 'Home',
                'href' => route('crud.loby'),
            ],
            [
                'icon' => 'upload',
                'text' => 'Upload Dokumen',
                'href' => route('crud.document.upload'),
            ],
            [
                'icon' => 'Files',
                'text' => 'Dokumen',
                'href' => route('crud.document'),
            ],
            [
                'icon' => 'Brain',
                'text' => 'Knowledge',
                'href' => route('crud.knowledge'),
            ],
            [
                'icon' => 'User',
                'text' => 'User',
                'href' => route('crud.user'),
            ],
            // [
            //     'icon' => 'settings',
            //     'text' => 'Pengaturan',
            //     'href' => '#',
            // ],
            // [
            //     'icon' => 'activity',
            //     'text' => 'Statistik',
            //     'href' => '#',
            // ],
        ];
    @endphp

    <nav class="p-4 space-y-1">
        @foreach ($navItems as $item)
            @php
                // Check if the current URL matches the item's href
                $isActive = ($currentUrl === $item['href']);
                $activeClass = $isActive ? 'active' : ''; // Apply appropriate active styles
            @endphp
            <a href="{{ $item['href'] }}"
                class="sidebar-item flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-md hover:bg-blue-50 dark:hover:bg-gray-800 transition-all {{ $activeClass }}">
                <i data-lucide="{{ $item['icon'] }}" class="h-5 w-5 mr-3 text-gray-500 dark:text-gray-400 {{ $isActive ? 'text-blue-600 dark:text-blue-400' : '' }}"></i>
                <span>{{ $item['text'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="p-4 border-t border-gray-200 dark:border-gray-700 mt-auto">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{auth()->user()->name}}&background=2a3f8c&color=fff" alt="avatar">
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-100">{{auth()->user()->name}}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{auth()->user()->email}}</p>
            </div>
        </div>

        <div class="flex items-center mt-4 gap-2">
            <form method="POST" action="{{ route('logout') }}" class="flex-1">
                @csrf
                <button href="#" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-raisaDongker1 hover:bg-raisaDongker2">
                    <i data-lucide="log-out" class="h-4 w-4 mr-2"></i>
                    Logout
                </button>
                
            </form>
            <button id="darkModeToggle" class="rounded-md bg-gray-300 dark:bg-gray-800 hover:bg-blue-400 dark:hover:bg-raisaDongker2 dark:text-white hover:bg-opacity-20 py-2 px-4">
            </button>
        </div>
    



    </div>
</div>
