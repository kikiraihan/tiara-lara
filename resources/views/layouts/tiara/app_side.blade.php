<div class="w-64 bg-white border-r border-gray-200 overflow-y-auto">
    <div class="p-4 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            {{-- <img src="https://img.favpng.com/24/14/21/bank-indonesia-central-bank-logo-png-favpng-fmrrs1thB28gyQieJKu6f7qxG.jpg" alt="BI Logo" class="h-8 w-8"> --}}
            <div>
                <h1 class="text-lg font-semibold text-gray-800">TIARA</h1>
                <p class="text-xs text-gray-500">Admin Panel</p>
            </div>
        </div>
    </div>
    
    @php
        $navItems = [
            [
                'icon' => 'upload',
                'text' => 'Upload Dokumen',
                'href' => 'admin-upload.html',
                'active' => false
            ],
            [
                'icon' => 'list',
                'text' => 'Daftar Dokumen',
                'href' => 'admin-listing.html',
                'active' => true
            ],
            [
                'icon' => 'settings',
                'text' => 'Pengaturan',
                'href' => '#',
                'active' => false
            ],
            [
                'icon' => 'activity',
                'text' => 'Statistik',
                'href' => '#',
                'active' => false
            ],
        ];
    @endphp

    <nav class="p-4 space-y-1">
        @foreach ($navItems as $item)
            @php
                $activeClass = $item['active'] ? 'active' : '';
            @endphp
            <a href="{{ $item['href'] }}"
                class="sidebar-item flex items-center px-4 py-3 text-gray-700 rounded-md hover:bg-blue-50 transition-all {{ $activeClass }}">
                <i data-lucide="{{ $item['icon'] }}" class="h-5 w-5 mr-3 text-gray-500"></i>
                <span>{{ $item['text'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="p-4 border-t border-gray-200 mt-auto">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full"
                    src="https://ui-avatars.com/api/?name=Admin&background=3b82f6&color=fff" alt="Admin">
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-700">Admin User</p>
                <p class="text-xs text-gray-500">admin@bi.go.id</p>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            {{-- <button href="#" class="w-full text-left">Logout</button> --}}
            {{-- <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-dropdown-link> --}}
            <button href="#"
                class="mt-4 w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                <i data-lucide="log-out" class="h-4 w-4 mr-2"></i>
                Logout
            </button>
        </form>

    </div>
</div>
