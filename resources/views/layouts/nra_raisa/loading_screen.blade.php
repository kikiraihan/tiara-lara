<div id="loading-screen" class="fixed inset-0 flex items-center justify-center bg-gray-500 dark:bg-gray-800 z-50">
  <l-reuleaux
    size="50"
    stroke="5"
    stroke-length="0.3"
    bg-opacity="0.1"
    speed="1.2"
    color="#2a3f8c" 
  ></l-reuleaux>
</div>
<script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/reuleaux.js"></script>

{{-- loading screen --}}
<script>
    window.addEventListener('load', () => {
        const loadingScreen = document.getElementById('loading-screen');
        if (loadingScreen) {
            loadingScreen.style.transition = 'opacity 0.5s';
            loadingScreen.style.opacity = '0';
            setTimeout(() => {
                loadingScreen.remove();
            }, 500); // Setelah animasi selesai, hapus elemen loading
        }
    });

</script>
