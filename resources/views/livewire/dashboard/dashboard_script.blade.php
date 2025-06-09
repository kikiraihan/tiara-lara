{{-- axios --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
{{-- plotly --}}
<script src="https://cdn.plot.ly/plotly-2.34.0.min.js" charset="utf-8"></script>
{{-- <script src="https://cdn.plot.ly/plotly-latest.min.js"></script> --}}

{{-- datatable --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>


{{-- fullscreen --}}
<script src="https://cdn.jsdelivr.net/npm/screenfull@5/dist/screenfull.js"></script>
<script>
    document.getElementById('toggleFullscreenButton').addEventListener('click', function() {
        if (screenfull.isEnabled) {
            screenfull.toggle(document.getElementById('toFullScreen'));
        }
    });

    if (screenfull.isEnabled) {
        screenfull.on('change', () => {
            let btn = document.getElementById('toggleFullscreenButton');
            if (screenfull.isFullscreen) {
                btn.innerHTML = '<span class="text-lg"><i class="bx bx-exit-fullscreen"></i></span>';
            } else {
                btn.innerHTML = '<span class="text-lg"><i class="bx bx-fullscreen"></i></span>';
            }
        });
    }
</script>


<script>
    function parseQueryParams(query) {
        return {
            'dataset': query[0]?.dataset || null,
        };
    }
</script>


<script>
    // function isDarkMode() {
    //     return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    // }

    function isDarkMode() {
        const html = document.documentElement;
        return html.classList.contains('dark');
    }
</script>
