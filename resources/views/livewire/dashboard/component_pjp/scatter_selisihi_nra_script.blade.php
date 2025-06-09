@script
<script>
    Livewire.on('pjpReloadScatterSelisihNRA', (fromServer) => {
        console.log('Reloading chart...');
        const data = fromServer[0];
        const elements = getElement();
        setElement(elements);
        createChart(elements.containerElement, data);
    });

    function getElement() {
        return {
            containerElement: document.getElementById('container-line_chart_selisih_nra'),
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
        const sandi = Object.values(data.sandi).map(String);
        const NRA_PRED = Object.values(data.NRA_PRED);
        const NRA_REAL = Object.values(data.NRA_APU);

        const xIndex = Array.from({ length: sandi.length }, (_, i) => i + 1);

        const isDark = isDarkMode();
        const lineColor1 = '#3498db'; //isDark ? '#D4D4D8' : '#3498db';
        const lineColor2 = '#FF5733'; //isDark ? '#E5E7EB' : '#FF5733';
        const bgColor = isDark ? '#222224' : '#FFFFFF';
        const textColor = isDark ? '#D4D4D8' : '#000000';

        const predTrace = {
            x: xIndex,
            y: NRA_PRED,
            mode: 'lines+markers',
            name: 'NRA Prediksi',
            hovertext: sandi,
            hoverinfo: 'text+name+y',
            line: { color: lineColor1 },
            marker: { color: lineColor1 }
        };

        const realTrace = {
            x: xIndex,
            y: NRA_REAL,
            mode: 'lines+markers',
            name: 'NRA Existing',
            hovertext: sandi,
            hoverinfo: 'text+name+y',
            line: { color: lineColor2 },
            marker: { color: lineColor2 }
        };

        const layout = {
            title: {
                text: 'Perbandingan NRA Prediksi dan NRA Existing',
                font: { size: 18, color: textColor }
            },
            xaxis: {
                title: { text: 'PJP', font: { size: 14, color: textColor } },
                tickfont: { color: textColor }
            },
            yaxis: {
                title: { text: 'NRA', font: { size: 14, color: textColor } },
                tickfont: { color: textColor },
                automargin: true
            },
            margin: { l: 50, r: 10, t: 60, b: 80 },
            showlegend: true,
            plot_bgcolor: bgColor,
            paper_bgcolor: bgColor
        };

        const config = { responsive: true };

        element.textContent = '';

        Plotly.newPlot(element, [predTrace, realTrace], layout, config).then((plot) => {
            element.on('plotly_click', function(eventData) {
                const pointIndex = eventData.points[0].pointIndex;

                function formatCurrency(value) {
                    return parseFloat(value).toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    });
                }

                // Prepare data for table
                const detail = {
                    "Sandi": data.sandi[pointIndex],
                    // "Nama": data.nama[pointIndex],
                    "NRA Existing": data.NRA_APU[pointIndex],
                    "NRA Prediksi": data.NRA_PRED[pointIndex],
                    "Selisih NRA": data.selisih[pointIndex],
                    "KPwDN": data.kpwdn[pointIndex],
                    "Pulau": data.pulau[pointIndex], // Tidak ditampilkan
                    "Kota": data.kota[pointIndex], // Tidak ditampilkan
                    "Most Frequent City": data.most_frequent_city_list[pointIndex], // Tidak ditampilkan
                    "Most Frequent Country": data.most_frequent_country_list[pointIndex],
                    "Most Frequent Receiver": data.most_frequent_receiver_list[pointIndex], // Tidak ditampilkan
                    "Most Frequent Sender": data.most_frequent_sender_list[pointIndex], // Tidak ditampilkan
                    "Pemegang Saham": data.pemegang_saham_list[pointIndex],
                    "Pengurus": data.pengurus_list[pointIndex],
                    "Frekuensi Pengiriman": data.frekuensi_pengiriman_sum[pointIndex],
                    "Total Nominal Transaksi (Rp)": formatCurrency(data.total_nominal_transaksi_sum[pointIndex]),
                    "Modal Disetor": formatCurrency(data.modal_disetor[pointIndex]), // Tidak ditampilkan
                    "Selisih Transaksi Outgoing-Incoming": formatCurrency(data.selisih_transaksi_outgoing_incoming[pointIndex]), // Tidak ditampilkan
                    "Other Sandi Related (Receiver)": data.other_sandi_related_through_receiver[pointIndex], // Tidak ditampilkan
                    "Other Sandi Related (Sender)": data.other_sandi_related_through_sender[pointIndex] // Tidak ditampilkan
                };

                const tableData = {
                    type: 'table',
                    header: {
                        values: ['<b>Fitur</b>', '<b>Nilai</b>'],
                        align: "center",
                        line: { width: 1, color: 'black' },
                        fill: { color: "#d3d3d3" },
                        font: { family: "Arial", size: 12, color: "black" }
                    },
                    cells: {
                        values: [
                            Object.keys(detail),
                            Object.values(detail).map(val => val.toString())
                        ],
                        align: "left",
                        line: { color: "black", width: 1 },
                        font: { family: "Arial", size: 11, color: ["black"] }
                    }
                };

                Plotly.react(element, [tableData], {
                    title: {
                        text: `Detail Data Sandi for ${data.sandi[pointIndex]}`,
                        font: { size: 18, color: textColor }
                    },
                    margin: { l: 50, r: 50, t: 50, b: 50 },
                    plot_bgcolor: bgColor,
                    paper_bgcolor: bgColor
                });

                // Add back button
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
            });
        });
    }
</script>
@endscript
