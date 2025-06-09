@script
<script>
    Livewire.on('pjpReloadHistoNRA', (fromServer) => {
        // Ambil data dari server
        // console.log(fromServer);
        const NRA_PRED = fromServer[0];
        const NRA_APU = fromServer[1]; 
        const elements = getElement();
        setElement(elements);
        createChart(elements.containerElement, NRA_PRED, NRA_APU);
    });

    function getElement() {
        return {
            containerElement: document.getElementById('container_histo_nra_perbandingan'),
        };
    }

    function setElement(elements) {
        elements.containerElement.classList.add('dark:bg-gray-800', 'bg-white', 'shadow-md', 'overflow-hidden');
        elements.containerElement.innerHTML = `
            <div class="flex flex-col justify-center items-center animate-pulse">
                <img src="{{ asset('raisa_gambar/data-processing-67.svg') }}" alt="SVG image" width="200px">
                <span class="p-3">Memuat dashboard...</span>
            </div>
        `;
    }

    function createChart(element, NRA_PRED, NRA_APU) {
        const isDark = isDarkMode();

        // Warna untuk histogram
        const trace1 = {
            x: NRA_PRED,
            autobinx: false,
            name: 'NRA Prediksi',
            histnorm: "count",
            marker: {
                color: "rgba(255, 100, 102, 0.7)",
                line: {
                    color: "rgba(255, 100, 102, 1)",
                    width: 1
                }
            },
            opacity: 0.5,
            type: "histogram",
            xbins: {
                start: Math.min(...NRA_PRED),
                end: Math.max(...NRA_PRED),
                size: (Math.max(...NRA_PRED) - Math.min(...NRA_PRED)) / 20
            }
        };

        const trace2 = {
            x: NRA_APU,
            autobinx: false,
            name: 'NRA Existing',
            histnorm: "count",
            marker: {
                color: "rgba(100, 200, 102, 0.7)",
                line: {
                    color: "rgba(100, 200, 102, 1)",
                    width: 1
                }
            },
            opacity: 0.75,
            type: "histogram",
            xbins: {
                start: Math.min(...NRA_APU),
                end: Math.max(...NRA_APU),
                size: (Math.max(...NRA_APU) - Math.min(...NRA_APU)) / 20
            }
        };

        const data = [trace1, trace2];

        const layout = {
            bargap: 0,
            bargroupgap: 0,
            barmode: "overlay",
            title: {
                text: "Perbandingan Sebaran NRA Prediksi dan NRA Existing",
                font: { color: isDark ? '#D4D4D8' : '#000000' }
            },
            xaxis: {
                title: {
                    text: "Nilai NRA",
                    font: { color: isDark ? '#D4D4D8' : '#000000' }
                },
                tickfont: { color: isDark ? '#D4D4D8' : '#000000' }
            },
            yaxis: {
                title: {
                    text: "Frekuensi",
                    font: { color: isDark ? '#D4D4D8' : '#000000' }
                },
                tickfont: { color: isDark ? '#D4D4D8' : '#000000' }
            },
            plot_bgcolor: isDark ? '#222224' : '#FFFFFF',
            paper_bgcolor: isDark ? '#222224' : '#FFFFFF'
        };

        const config = { responsive: true };

        // Bersihkan elemen dan render plot
        element.textContent = '';
        Plotly.newPlot(element, data, layout, config);
    }
</script>

@endscript
