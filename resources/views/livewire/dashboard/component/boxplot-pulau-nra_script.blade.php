@script
<script>
    Livewire.on('loadDataPulauNra', (fromServer) => {
        // karena di laravel di stringkan semua
        // const params = parseQueryParams(query)
        const data = fromServer[0];
        // const data_regression = fromServer[0]['data_regression'];
        // const NRA_PRED = data['NRA_PRED']
        const elements = getElement();
        setElement(elements);
        createChart(elements.containerElement, data);
        // setTimeout(() => {
        // },0);//pastikan Eksekusi kode ini setelah stack eksekusi kosong
    });

    function getElement() {
        return {
            containerElement: document.getElementById('container_boxplot_pulau_nra'),
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
        // Tentukan warna berdasarkan mode (light/dark)
        const isDark = isDarkMode(); // Gunakan fungsi isDarkMode() untuk menentukan mode
        const borderColor = isDark ? '#D4D4D8' : '#0000FF'; // Warna border
        const bgColor = isDark ? '#222224' : '#FFFFFF'; // Warna latar belakang
        const textColor = isDark ? '#D4D4D8' : '#000000'; // Warna teks

        const pulauData = Object.values(data);

        const pulauDataNames = pulauData[0]; // Array of pulau names
        const pulauDataValues = pulauData[1]; // Array of arrays for NRA_PRED values

        // Convert to Plotly.js format
        const plotlyData = pulauDataNames.map((pulau, index) => ({
            y: pulauDataValues[index], // Data NRA_PRED for each pulau
            name: pulau,               // Pulau name
            type: 'box',               // Specify box plot type
            boxpoints: 'all',          // Tampilkan semua titik pada box plot
            jitter: 0.5,               // Tambahkan sedikit jitter untuk menyebarkan titik
            pointpos: -1.8,            // Atur posisi titik di sekitar box
            // marker: {
            //     color: isDark ? '#4A4A4F' : '#1F77B4' // Sesuaikan warna marker untuk dark/light mode
            // },
            // line: {
            //     color: borderColor      // Sesuaikan warna border box plot
            // }
        }));

        // Define layout
        const layout = {
            title: {
                text: "Hubungan antara Pulau dan NRA Prediksi",
                font: {
                    color: textColor // Sesuaikan warna teks judul berdasarkan mode
                }
            },
            xaxis: {
                title: {
                    text: "Pulau",
                    font: {
                        color: textColor // Sesuaikan warna teks axis
                    }
                },
                type: 'category', // Ensure x-axis is treated as categorical
                tickfont: {
                    color: textColor // Sesuaikan warna label axis
                }
            },
            yaxis: {
                title: {
                    text: "NRA_PRED",
                    font: {
                        color: textColor // Sesuaikan warna teks axis
                    }
                },
                tickfont: {
                    color: textColor // Sesuaikan warna label axis
                }
            },
            paper_bgcolor: bgColor, // Warna latar belakang keseluruhan plot
            plot_bgcolor: bgColor,  // Warna latar belakang area plot
            font: {
                color: textColor // Warna teks secara umum
            }
        };

        const config = {
            responsive: true // Pastikan grafik responsif
        };

        element.textContent = '';
        // Render plot menggunakan Plotly.newPlot
        Plotly.newPlot(element, plotlyData, layout, config);
    }



</script>
@endscript
