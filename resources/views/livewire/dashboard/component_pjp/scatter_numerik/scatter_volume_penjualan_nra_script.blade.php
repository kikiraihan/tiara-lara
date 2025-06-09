@script
<script>
    Livewire.on('reloadScatterVolumePenjualan', (fromServer) => {
        const data = fromServer[0];
        const elements = getElement();
        setElement(elements);
        createChart(elements.containerElement, data.data, data.data_regression);
    });

    function getElement() {
        return {
            containerElement: document.getElementById('container-scatter_volume_penjualan_nra'),
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

    function createChart(element, data, data_regression) {
        // Extract data for scatter points and regression line
        const NRA_PRED = Object.values(data.NRA_PRED);
        const volume_penjualan = Object.values(data.volume_penjualan);
        const regression_line = Object.values(data_regression);

        // Determine colors based on mode (light/dark)
        const isDark = isDarkMode();
        const borderColor = isDark ? '#D4D4D8' : 'orange';
        const bgColor = isDark ? '#222224' : '#FFFFFF';
        const textColor = isDark ? '#D4D4D8' : '#000000';
        const lineColor = isDark ? '#FF7F7F' : 'red';
        const legendFontColor = isDark ? '#D4D4D8' : '#000000';

        // Create scatter trace
        const scatterTrace = {
            x: NRA_PRED,
            y: volume_penjualan,
            mode: 'markers',
            marker: {
                color: borderColor,
                opacity: 0.6,
                symbol: 'x'
            },
            name: 'Data Points'
        };

        // Create regression line trace
        const regressionTrace = {
            x: NRA_PRED,
            y: regression_line,
            mode: 'lines',
            line: {
                color: lineColor,
                width: 2
            },
            name: 'Regression Line'
        };

        // Define layout
        const layout = {
            title: {
                text: 'Hubungan antara volume_penjualan dan NRA_PRED',
                font: {
                    size: 18,
                    color: textColor
                }
            },
            xaxis: {
                title: {
                    text: 'NRA_PRED',
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
                    text: 'volume_penjualan',
                    font: {
                        size: 14,
                        color: textColor
                    }
                },
                tickfont: {
                    color: textColor
                }
            },
            plot_bgcolor: bgColor,
            paper_bgcolor: bgColor,
            legend: {
                font: {
                    color: legendFontColor
                }
            }
        };

        // Combine traces
        const traces = [scatterTrace, regressionTrace];
        element.textContent = '';

        // Render plot
        Plotly.newPlot(element, traces, layout);
    }
</script>
@endscript
