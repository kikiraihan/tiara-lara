@script
<script>
    Livewire.on('reloadBarChartKpwdn', (fromServer) => {
        console.log('Reloading chart...');
        const data = fromServer[0];
        const elements = getElement();
        setElement(elements);
        createChart(elements.containerElement, data);
    });

    function getElement() {
        return {
            containerElement: document.getElementById('container-bar_chart_kpwdn'),
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

    function createChart(element, data) {
        // Extract necessary data
        const kpwdn = Object.values(data.kpwdn);
        const NRA_PRED_Mean = Object.values(data.NRA_PRED_mean);
        const sandiUnique = Object.values(data.sandi_nunique);
        const sandiList = Object.values(data.sandi_list);
        const NRA_PREDList = Object.values(data.NRA_PRED_list);

        // Determine colors based on mode (light/dark)
        const isDark = isDarkMode();
        const barColor = isDark ? '#D4D4D8' : '#3498db';
        const pointColor = isDark ? '#E5E7EB' : '#FF5733';
        const bgColor = isDark ? '#222224' : '#FFFFFF';
        const textColor = isDark ? '#D4D4D8' : '#000000';

        // Bar trace
        const barTrace = {
            x: NRA_PRED_Mean,
            y: kpwdn,
            type: 'bar',
            orientation: 'h',
            text: NRA_PRED_Mean.map(val => val.toFixed(2)),
            marker: {
                color: barColor
            },
            name: 'KPwDN'
        };

        // Point trace for triggering table
        const pointTrace = {
            x: NRA_PRED_Mean,
            y: kpwdn,
            mode: 'markers',
            marker: {
                color: pointColor,
                size: 10
            },
            hoverinfo: 'none', // Disable hover info for points
            name: 'Table Trigger'
        };

        // Layout configuration
        const layout = {
            title: {
                text: 'Rata-rata NRA Berdasarkan KPwDN',
                font: {
                    size: 18,
                    color: textColor
                }
            },
            xaxis: {
                title: {
                    text: 'NRA rata-rata',
                    font: {
                        size: 14,
                        color: textColor
                    },
                },
                tickfont: {
                    color: textColor
                }
            },
            yaxis: {
                title: {
                    text: 'KPwDN',
                    font: {
                        size: 14,
                        color: textColor
                    }
                },
                side: 'right', // Menempatkan y-ticks di sisi kanan
                tickfont: {
                    color: textColor,
                },
                categoryorder: 'total ascending',
                automargin: true
            },
            margin: {
                l: 50,
                r: 10,
                t: 50,
                b: 50
            },
            showlegend: false,
            plot_bgcolor: bgColor,
            paper_bgcolor: bgColor
        };

        const config = {
            responsive: true // Pastikan grafik responsif
        };

        element.textContent = '';

        function afterFunction(plot) {
            element.on('plotly_click', function(eventData) {
                if (eventData.points[0].data.name === 'Table Trigger') {
                    const pointIndex = eventData.points[0].pointIndex;

                    // Ambil data untuk tabel
                    const unsortedSandi = sandiList[pointIndex];
                    const unsortedNraPred = NRA_PREDList[pointIndex];

                    // Gabungkan data sandi dan NRA_PRED menjadi array objek untuk diurutkan
                    const combinedData = unsortedSandi.map((sandi, index) => ({
                        sandi: sandi,
                        nraPred: unsortedNraPred[index]
                    }));

                    // Urutkan data berdasarkan NRA_PRED secara descending
                    const sortedData = combinedData.sort((a, b) => b.nraPred - a.nraPred);

                    // Pisahkan kembali menjadi dua array setelah diurutkan
                    const sortedSandi = sortedData.map(item => item.sandi);
                    const sortedNraPred = sortedData.map(item => item.nraPred);

                    const tableData = {
                        type: 'table',
                        header: {
                            values: [["<b>Sandi</b>"], ["<b>NRA PRED</b>"]],
                            align: "center",
                            line: { width: 1, color: 'black' },
                            fill: { color: "#d3d3d3" },
                            font: { family: "Arial", size: 12, color: "black" }
                        },
                        cells: {
                            values: [sortedSandi, sortedNraPred.map(val => val.toFixed(2))],
                            align: "center",
                            line: { color: "black", width: 1 },
                            font: { family: "Arial", size: 11, color: ["black"] }
                        }
                    };

                    Plotly.react(element, [tableData], {
                        title: {
                            text: `Detail Sandi for ${kpwdn[pointIndex]}`,
                            font: {
                                size: 18,
                                color: textColor
                            }
                        },
                        margin: {
                            l: 50,
                            r: 50,
                            t: 50,
                            b: 50
                        },
                        plot_bgcolor: bgColor,
                        paper_bgcolor: bgColor
                    });

                    // Add a button to return to the bar chart
                    const backButton = document.createElement('button');
                    backButton.textContent = 'Kembali ke Grafik';
                    backButton.style.margin = '10px';
                    backButton.style.padding = '10px';
                    backButton.style.border = 'none';
                    backButton.style.borderRadius = '5px';
                    backButton.style.backgroundColor = '#3498db';
                    backButton.style.color = 'white';
                    backButton.style.cursor = 'pointer';
                    backButton.addEventListener('click', () => {
                        createChart(element, data);
                    });

                    element.appendChild(backButton);
                }
            });
        }


        // Render chart and add click handler for points
        Plotly.newPlot(element, [barTrace, pointTrace], layout, config).then(afterFunction);
    }
</script>
@endscript
