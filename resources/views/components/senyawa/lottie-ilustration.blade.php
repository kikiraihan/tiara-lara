@props([
    'id'=>'lottie-animation',
    'path'=>asset('landing/image/document-diagram.json'),
])

<div id="{{$id}}"></div>
<script>
    // Memuat animasi Lottie
    lottie.loadAnimation({
        container: document.getElementById('{{$id}}'), // ID elemen kontainer
        renderer: 'svg', // Renderer (svg/canvas/html)
        loop: true, // Apakah animasi diulang
        autoplay: true, // Apakah animasi berjalan otomatis
        path: "{{ $path }}" // Path ke file JSON
    });
</script>