@script
<script>
    Livewire.on('pjpReloadHistoNRA', (fromServer) => {
        // karena di laravel di stringkan semua
        // const params = parseQueryParams(query)
        const NRA_PRED = fromServer[0];
        const elements = getElement();
        setElement(elements);
        createChart(elements.containerElement, NRA_PRED);
        // setTimeout(() => {
        // },0);//pastikan Eksekusi kode ini setelah stack eksekusi kosong
    });

    function getElement() {
        return {
            containerElement: document.getElementById('container_histo_nra'),
        };
    }

    function setElement(elements) {
        // dark:bg-gray-800 bg-white shadow-md rounded-md overflow-hidden
        elements.containerElement.classList.add('dark:bg-gray-800', 'bg-white', 'shadow-md', 'overflow-hidden');
        // Isi kontennya dengan HTML baru
        elements.containerElement.innerHTML = `
            <div class="flex flex-col justify-center items-center animate-pulse">
                <img src="{{ asset('raisa_gambar/data-processing-67.svg') }}" alt="SVG image" width="200px">
                <span class="p-3">Memuat dashboard...</span>
            </div>
        `;
    }

    function createChart(element, data) {
        const nra_PRED_data = data;

        // Tentukan warna berdasarkan mode (light/dark)
        const isDark = isDarkMode();
        const borderColor = isDark ? '#D4D4D8' : 'blue';
        const bgColor = isDark ? '#222224' : '#FFFFFF';
        const textColor = isDark ? '#D4D4D8' : '#000000';

        // Buat histogram dengan teks pada tiap bin
        const trace = {
            x: nra_PRED_data,
            type: 'histogram',
            nbinsx: 20, // Atur jumlah bins secara manual
            texttemplate: '%{y}', // Menampilkan jumlah data di tiap bin
            textposition: 'auto', // Posisikan teks secara otomatis
            marker: {
                line: {
                    color: borderColor, // Warna border
                    width: 1 // Ketebalan border
                }
            }
        };

        const layout = {
            height: 500,
            title: {
                text: 'Sebaran data NRA Prediksi',
                font: {
                    color: textColor
                }
            },
            plot_bgcolor: bgColor,
            paper_bgcolor: bgColor,
            xaxis: {
                title: {
                    text: 'NRA Prediksi',
                    font: {
                        color: textColor
                    }
                },
                tickfont: {
                    color: textColor
                }
            },
            yaxis: {
                title: {
                    text: 'Frekuensi',
                    font: {
                        color: textColor
                    }
                },
                tickfont: {
                    color: textColor
                }
            },
            // bargap: 0.2 // Atur jarak antar bin (opsional)
        };

        const config = {
            responsive: true
        };

        element.textContent = '';

        // Render plot menggunakan Plotly.newPlot
        Plotly.newPlot(element, [trace], layout, config);
    }


</script>
@endscript
