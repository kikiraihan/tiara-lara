<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIARA: Regulation Assistant</title>
    {{-- boxicons --}}
    {{-- <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel='stylesheet'> --}}
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.10.1/lottie.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
            border-left: 3px solid #3b82f6;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col dark:bg-gray-900 dark:text-white">

    {{$slot}}

    @include('layouts.tiara._darkmode_toggle_script')
    
    @filamentScripts


    <script>
        let pressedKeys = [];
        document.addEventListener('keydown', function(event) {
            pressedKeys.push(event.key);
            if (pressedKeys.includes('`') && pressedKeys.includes('1') ) {
                window.location.href = '{{ route('crud.loby') }}';
            }
        });
        document.addEventListener('keyup', function(event) {
            let keyIndex = pressedKeys.indexOf(event.key);
            if (keyIndex > -1) {
                pressedKeys.splice(keyIndex, 1);
            }
        });
    </script>
</body>
</html>