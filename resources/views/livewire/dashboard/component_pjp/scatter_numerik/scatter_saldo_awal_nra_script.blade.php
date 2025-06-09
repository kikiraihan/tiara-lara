@script
<script>
    Livewire.on('reloadScatterSaldoAwal', (fromServer) => {
        const data = fromServer[0];
        const elements = getElementSaldoAwal();
        setElementSaldoAwal(elements);
        createChartSaldoAwal(elements.containerElement, data.data, data.data_regression);
    });

    function getElementSaldoAwal() {
        return {
            containerElement: document.getElementById('container-scatter_saldo_awal_nra'),
        };
    }

    function setElementSaldoAwal(elements) {
        elements.containerElement.classList.add('dark:bg-gray-800', 'bg-white', 'shadow-md', 'overflow-hidden');
        elements.containerElement.innerHTML = `
            <div class="flex flex-col justify-center items-center animate-pulse">
                <img src="{{ asset('raisa_gambar/data-processing-67.svg') }}" alt="SVG image" width="200px">
                <span class="p-3">Memuat dashboard...</span>
            </div>
        `;
    }

    function createChartSaldoAwal(element, data, data_regression) {
        const NRA_PRED = Object.values(data.NRA_PRED);
        const saldo_awal = Object.values(data.saldo_awal);
        const regression_line = Object.values(data_regression);

        const isDark = isDarkMode();
        const borderColor = isDark ? '#D4D4D8' : 'orange';
        const bgColor = isDark ? '#222224' : '#FFFFFF';
        const textColor = isDark ? '#D4D4D8' : '#000000';
        const lineColor = isDark ? '#FF7F7F' : 'red';
        const legendFontColor = isDark ? '#D4D4D8' : '#000000';

        const scatterTrace = {
            x: NRA_PRED,
            y: saldo_awal,
            mode: 'markers',
            marker: {
                color: borderColor,
                opacity: 0.6,
                symbol: 'x'
            },
            name: 'Data Points'
        };

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

        const layout = {
            title: {
                text: 'Hubungan antara saldo_awal dan NRA_PRED',
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
                    text: 'saldo_awal',
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

        const traces = [scatterTrace, regressionTrace];
        element.textContent = '';

        Plotly.newPlot(element, traces, layout);
    }
</script>
@endscript
