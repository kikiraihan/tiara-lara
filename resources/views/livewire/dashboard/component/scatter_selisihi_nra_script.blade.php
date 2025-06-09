@script
<script>
    Livewire.on('reloadScatterSelisihNRA', (fromServer) => {
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
        const lineColor1 = '#3498db'; //isDark ? '#D4D4D8' :
        const lineColor2 = '#FF5733'; //isDark ? '#E5E7EB' :
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
                title: { text: 'KUPVA', font: { size: 14, color: textColor } },
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
                    "NRA Existing": data.NRA_APU[pointIndex],
                    "NRA Prediksi": data.NRA_PRED[pointIndex],
                    "Selisih NRA": data.selisih[pointIndex],
                    // "Jenis Produk": data.jenis_produk[pointIndex],
                    "Jenis Valuta": data.jenis_valuta[pointIndex],
                    "KPwDN": data.kpwdn[pointIndex],
                    "Pemegang Saham": data.pemegang_saham_list[pointIndex],
                    "Pengurus": data.pengurus_list[pointIndex],
                    "Pulau": data.pulau[pointIndex],
                    "Kurs Tengah (Rp)": formatCurrency(data.kurs_tengah[pointIndex]),
                    // "Rata-rata saldo akhir (Rp)": formatCurrency(data.rata_saldo_akhir[pointIndex]),
                    // "Rata-rata saldo awal (Rp)": formatCurrency(data.rata_saldo_awal[pointIndex]),
                    "Saldo akhir (Rp)": formatCurrency(data.saldo_akhir[pointIndex]),
                    "Saldo awal (Rp)": formatCurrency(data.saldo_awal[pointIndex]),
                    "Volume Pembelian (Rp)": formatCurrency(data.volume_pembelian[pointIndex]),
                    "Volume Penjualan (Rp)": formatCurrency(data.volume_penjualan[pointIndex]),
                    // "Saldo akhir hitung (Rp)": formatCurrency(data._saldo_akhir_hitung[pointIndex]),
                    // "Saldo akhir lebih": data._saldo_akhir_lebih[pointIndex],
                    // "Saldo akhir lebih selisih (Rp)": formatCurrency(data._saldo_akhir_lebih_selisih[pointIndex]),
                    // "Tahun": data.tahun[pointIndex],
                    "Spread keuntungan (Rp)": formatCurrency(data._spread_keuntungan[pointIndex]),
                    "Stok mata uang bertambah (per bulan, per valuta)": data._stok_mata_uang_bertambah[pointIndex]
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
