<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAISA: Risk Assessment Intelligent System for Anti-Money Laundering</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- boxicons --}}
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel='stylesheet'>

    <!-- Scripts -->
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('layouts.nra_raisa.style_custom')

    <style>
        /* Tambahkan ini di file CSS Anda */
        html {
            transition: background-color 0.3s, color 0.3s;
        }
    </style>

    {{$stylehalaman}}
</head>
<body class="bg-gradient-to-b from-gradientLight1 to-gradientLight2 dark:from-gradientDark1 dark:to-gradientDark2 text-gray-800 dark:text-gray-200 min-h-screen flex flex-col">

    @include('layouts.nra_raisa.loading_screen')
    
    <!-- Top Navigation Bar -->
    @include('layouts.nra_raisa.app_nav')

    <!-- Sidebar and Main Content -->
    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar -->
        @include('layouts.nra_raisa.app_side')
        

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gradient-to-r from-gradientLight1 to-gradientLight2 dark:from-gradientDark1 dark:to-gradientDark2 p-6">
            {{$slot}}
        </main>
    </div>

    <script>

        // Toggle sidebar
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        // console.log(sidebar);
        // console.log(sidebarToggle);
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('hidden'); // Menyembunyikan elemen
            sidebar.classList.toggle('md:flex');   // Pastikan elemen tetap bisa muncul
        });

        // Toggle user dropdown
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-dropdown');
        userMenuButton.addEventListener('click', () => userDropdown.classList.toggle('hidden'));

        document.addEventListener('click', (event) => {
            if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.classList.add('hidden');
            }
        });
    </script>

    @include('layouts.nra_raisa._darkmode_toggle_script')
    <script src="{{ url('/') }}/assets/js/util.js"> </script>
    @livewire('notifications')
    @filamentScripts

    <script>
        let pressedKeys = [];
        document.addEventListener('keydown', function(event) {
            pressedKeys.push(event.key);
            if (pressedKeys.includes('`') && pressedKeys.includes('1') ) {
                window.location.href = '{{ route('landing.home') }}';
            }
        });
        document.addEventListener('keyup', function(event) {
            let keyIndex = pressedKeys.indexOf(event.key);
            if (keyIndex > -1) {
                pressedKeys.splice(keyIndex, 1);
            }
        });
    </script>

    {{$scripthalaman}}
</body>
</html>
