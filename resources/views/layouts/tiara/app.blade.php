<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIARA: Regulation Assistant</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- boxicons --}}
    {{-- <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel='stylesheet'> --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    {{-- <script src="https://unpkg.com/lucide@latest"></script> --}}

    {{-- we use lucide icon. instaled npm. check this documentation https://lucide.dev/guide/basics/stroke-width --}}

    <!-- Scripts -->
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('layouts.tiara.style_custom')
    <style>
        /* Tambahkan ini di file CSS Anda */
        html {
            transition: background-color 0.3s, color 0.3s;
        }
    </style>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .sidebar-item.active {
            background-color: rgba(59, 130, 246, 0.1);
            border-left: 3px solid #2a3f8c;
        }
        .dark .sidebar-item.active {
            background-color: rgba(59, 130, 246, 0.2); /* lebih terang untuk dark */
            border-left-color: #93c5fd; /* warna biru muda */
        }
    </style>

    {{$stylehalaman}}
</head>


<body class="bg-gray-50 dark:bg-gray-900 dark:text-white">
    @include('layouts.tiara.loading_screen')

    <div class="flex h-screen">
        <!-- Left Sidebar -->
        @include('layouts.tiara.app_side')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            {{-- @include('layouts.tiara.app_nav') --}}
            

            <!-- Main Content Area -->
            <div class="flex-1 overflow-y-auto p-6 dark:bg-gray-800 dark:text-gray-100">
                {{$slot}}
            </div>
        </div>
    </div>




    @include('layouts.nra_raisa._darkmode_toggle_script')
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
