@script
<script>
    Livewire.on('pjpLoadDataPulauNra', (fromServer) => {
        const data = fromServer[0];
        const elements = getElement();
        setElement(elements);
        createScatterPlot(elements.containerElement, data);
    });

    function getElement() {
        return {
            containerElement: document.getElementById('container_scatter_pulau_nra'),
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

    function createScatterPlot(element, data) {
        // Tentukan warna berdasarkan mode (light/dark)
        const isDark = isDarkMode(); // Gunakan fungsi isDarkMode() untuk menentukan mode
        const borderColor = isDark ? '#D4D4D8' : '#0000FF'; // Warna border
        const bgColor = isDark ? '#222224' : '#FFFFFF'; // Warna latar belakang
        const textColor = isDark ? '#D4D4D8' : '#000000'; // Warna teks

        const pulauData = Object.values(data);

        const pulauDataNames = pulauData[0]; // Array of pulau names
        const pulauDataValues = pulauData[1]; // Array of arrays for NRA_PRED values

        // Convert to Plotly.js format for scatter plot
        const plotlyData = pulauDataNames.map((pulau, index) => ({
            x: Array(pulauDataValues[index].length).fill(pulau), // Duplicate pulau name for each data point
            y: pulauDataValues[index], // Data NRA_PRED for each pulau
            mode: 'markers',           // Specify scatter plot mode
            type: 'scatter',           // Specify scatter plot type
            name: pulau                // Pulau name
        }));

        // Define layout
        const layout = {
            title: {
                text: "Hubungan antara Pulau dan NRA_PRED",
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
