@script
<script>
    Livewire.on('pjpReloadBarChartPengurus', (fromServer) => {
        console.log('Reloading chart for Pengurus');
        const data = fromServer[0];
        const elements = getElementPengurus();
        setElementPengurus(elements);
        createChartPengurus(elements.containerElement, data);
    });

    function getElementPengurus() {
        return {
            containerElement: document.getElementById('container-bar_chart_pengurus'),
        };
    }

    function setElementPengurus(elements) {
        elements.containerElement.classList.add('dark:bg-gray-800', 'bg-white', 'shadow-md', 'overflow-hidden');
        elements.containerElement.innerHTML = `
            <div class="flex flex-col justify-center items-center animate-pulse">
                <img src="{{ asset('raisa_gambar/data-processing-67.svg') }}" alt="SVG image" width="200px">
                <span class="p-3">Memuat dashboard...</span>
            </div>
        `;
    }

    function createChartPengurus(element, data) {
        // Extract necessary data
        const pengurus = Object.values(data.pengurus);
        const NRA_PRED_Mean = Object.values(data.NRA_PRED_mean);
        const sandiUnique = Object.values(data.sandi_nunique);
        const sandiList = Object.values(data.sandi_list);
        const NRA_PREDList = Object.values(data.NRA_PRED_list);

        // Determine colors based on mode (light/dark)
        const isDark = isDarkMode();
        const borderColor = isDark ? '#D4D4D8' : 'blue';
        const bgColor = isDark ? '#222224' : '#FFFFFF';
        const textColor = isDark ? '#D4D4D8' : '#000000';
        const legendFontColor = isDark ? '#D4D4D8' : '#000000';

        // Create the hover text array for hover info (additional details)
        const hoverText = NRA_PRED_Mean.map((_, index) => {
            return `Pengurus : ${pengurus[index]}<br>
            NRA APU Mean: ${NRA_PRED_Mean[index]}<br>
            Jumlah PJP: ${sandiUnique[index]}<br>
            PJP List: ${sandiList[index]}<br>
            NRA APU List: ${NRA_PREDList[index]}`;
        });

        // Create bar chart trace
        const barTrace = {
            x: NRA_PRED_Mean,
            y: pengurus,
            type: 'bar',
            orientation: 'h',  // Horizontal bars
            text: hoverText,   // Display NRA_PRED_Mean on bars
            texttemplate: '%{y},%{x}', // Menampilkan jumlah data di tiap bin
            hoverinfo: 'text',    // Display the custom hover text when hovering over bars
            marker: {
                color: borderColor,
            },
            name: 'Pengurus'
        };

        // Define layout
        const layout = {
            title: {
                text: 'Keterkaitan Pengurus dan NRA',
                font: {
                    size: 18,
                    color: textColor
                }
            },
            margin: {
                l: 30, // Set left margin for better readability of y-tick labels
                r: 10,
                t: 50,
                b: 50
            },
            xaxis: {
                title: {
                    text: 'NRA rata-rata',
                    font: {
                        size: 14,
                        color: textColor
                    }
                },
                tickfont: {
                    color: textColor
                }
            },
            yaxis: {
                title: {
                    text: 'Pengurus',
                    font: {
                        size: 14,
                        color: textColor
                    }
                },
                showticklabels: false, // Sembunyikan label ticks di Y kiri
                side: 'left', // Ticks di sisi kanan
                tickfont: {
                    color: textColor
                },
                categoryorder: 'total ascending'
            },
            plot_bgcolor: bgColor,
            paper_bgcolor: bgColor,
            legend: {
                font: {
                    color: legendFontColor
                }
            },
            height: 800
        };

        const config = {
            responsive: true // Pastikan grafik responsif
        };

        element.textContent = '';

        // Render plot
        Plotly.newPlot(element, [barTrace], layout, config);
    }
</script>
@endscript
