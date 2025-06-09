<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAISA: Risk Assessment Intelligent System for Anti-Money Laundering</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.10.1/lottie.min.js"></script>

    <!-- Scripts -->
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col dark:bg-gray-900 dark:text-white">

    {{$slot}}

    @include('layouts.nra_raisa._darkmode_toggle_script')
    
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