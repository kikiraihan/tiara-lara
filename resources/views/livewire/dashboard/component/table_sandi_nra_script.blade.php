@script
<script>
    Livewire.on('reloadTableChartSandiNRA', (fromServer) => {
        console.log('Reloading table for Sandi NRA');
        const data = fromServer[0];
        const elements = getElement();
        setElement(elements);
        console.log(data);
        createSearchableTable(elements.containerElement, data);
    });

    function getElement() {
        return {
            containerElement: document.getElementById('container-bar_chart_sandi_nra'),
        };
    }

    function setElement(elements) {
        elements.containerElement.classList.add('dark:bg-gray-900', 'bg-white', 'shadow-md', 'rounded-md', 'overflow-hidden', 'p-4');
        elements.containerElement.innerHTML = `
            <div class="flex flex-col items-center">
                <h2 class="text-xl mb-4 dark:text-gray-200 text-gray-800">Tabel Detail KUPVA</h2>
                <input id="search-input" 
                       type="text" 
                       placeholder="Cari Sandi, NRA, KPWDN, Selisih, Pulau, Kurs Tengah, Volume Pembelian, Volume Penjualan, Saldo Awal, Saldo Akhir, Spread Keuntungan" 
                       class="dark:bg-gray-800 dark:text-gray-200 bg-gray-100 text-black rounded-md px-4 py-2 mb-4 w-2/3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div id="table-container" class="w-full overflow-auto"></div>
            </div>
        `;
    }

    function createSearchableTable(element, data) {
        const originalData = {
            sandi: Object.values(data.sandi),
            NRA_APU: Object.values(data.NRA_APU),
            NRA_PRED: Object.values(data.NRA_PRED),
            selisih: Object.values(data.selisih),
            KPWDN: Object.values(data.kpwdn),
            pulau: Object.values(data.pulau),
            kurs_tengah: Object.values(data.kurs_tengah),
            volume_pembelian: Object.values(data.volume_pembelian),
            volume_penjualan: Object.values(data.volume_penjualan),
            saldo_awal: Object.values(data.saldo_awal),
            saldo_akhir: Object.values(data.saldo_akhir),
            _spread_keuntungan: Object.values(data._spread_keuntungan)
        };

        const tableContainer = element.querySelector('#table-container');
        const searchInput = element.querySelector('#search-input');

        function renderTable(filteredData) {
            const isDark = isDarkMode();
            const headerBgColor = isDark ? '#1f2937' : '#1f77b4';
            const headerFontColor = isDark ? '#D4D4D8' : '#FFFFFF';
            const cellBgColor = isDark ? ['#2D2F36', '#1C1E21'] : ['#F9FAFB', '#E5E7EB'];
            const cellFontColor = isDark ? '#D4D4D8' : '#000000';

            // Function to format numbers as currency
            const formatCurrency = (num) => {
                if (num === null || num === undefined || isNaN(num)) return '';
                return new Intl.NumberFormat('id-ID', { style: 'decimal', minimumFractionDigits: 0 }).format(num);
            };

            const tableData = {
                type: 'table',
                header: {
                    values: [
                        ['<b>Sandi KUPVA</b>'], 
                        ['<b>NRA Existing</b>'], 
                        ['<b>NRA Prediksi</b>'], 
                        ['<b>Selisih</b>'], 
                        ['<b>KPwDN</b>'], 
                        ['<b>Pulau</b>'], 
                        ['<b>Kurs Tengah</b>'], 
                        ['<b>Vol. Beli</b>'], 
                        ['<b>Vol. Jual</b>'], 
                        ['<b>Saldo Awal</b>'], 
                        ['<b>Saldo Akhir</b>'], 
                        ['<b>Spread</b>']
                    ],
                    align: 'center',
                    font: { size: 14, color: headerFontColor },
                    fill: { color: headerBgColor }
                },
                cells: {
                    values: [
                        filteredData.sandi, 
                        filteredData.NRA_APU.map(formatCurrency), 
                        filteredData.NRA_PRED.map(formatCurrency), 
                        filteredData.selisih.map(formatCurrency),
                        filteredData.KPWDN,
                        filteredData.pulau,
                        filteredData.kurs_tengah.map(formatCurrency),
                        filteredData.volume_pembelian.map(formatCurrency),
                        filteredData.volume_penjualan.map(formatCurrency),
                        filteredData.saldo_awal.map(formatCurrency),
                        filteredData.saldo_akhir.map(formatCurrency),
                        filteredData._spread_keuntungan.map(formatCurrency)
                    ],
                    align: 'center',
                    font: { size: 12, color: cellFontColor },
                    fill: { color: cellBgColor }
                }
            };

            const layout = {
                height: 400,
                margin: { t: 20, b: 20, l: 10, r: 10 },
                plot_bgcolor: isDark ? '#1E1E24' : '#FFFFFF',
                paper_bgcolor: isDark ? '#1E1E24' : '#FFFFFF'
            };

            const config = {
                responsive: true // Ensure the chart is responsive
            };

            Plotly.newPlot(tableContainer, [tableData], layout, config);
        }


        renderTable(originalData);

        searchInput.addEventListener('input', (event) => {
            const query = event.target.value.toLowerCase();
            const filteredData = { 
                sandi: [], 
                NRA_APU: [], 
                NRA_PRED: [], 
                KPWDN: [],
                selisih: [],
                pulau: [],
                kurs_tengah: [],
                volume_pembelian: [],
                volume_penjualan: [],
                saldo_awal: [],
                saldo_akhir: [],
                _spread_keuntungan: []
            };

            originalData.sandi.forEach((sandi, index) => {
                if (sandi.toLowerCase().includes(query) ||
                    originalData.NRA_APU[index].toString().includes(query) ||
                    originalData.NRA_PRED[index].toString().includes(query) ||
                    originalData.KPWDN[index].toLowerCase().includes(query) ||
                    originalData.selisih[index].toString().includes(query) ||
                    originalData.pulau[index].toLowerCase().includes(query) ||
                    originalData.kurs_tengah[index].toString().includes(query) ||
                    originalData.volume_pembelian[index].toString().includes(query) ||
                    originalData.volume_penjualan[index].toString().includes(query) ||
                    originalData.saldo_awal[index].toString().includes(query) ||
                    originalData.saldo_akhir[index].toString().includes(query) ||
                    originalData._spread_keuntungan[index].toString().includes(query)) {
                    filteredData.sandi.push(sandi);
                    filteredData.NRA_APU.push(originalData.NRA_APU[index]);
                    filteredData.NRA_PRED.push(originalData.NRA_PRED[index]);
                    filteredData.KPWDN.push(originalData.KPWDN[index]);
                    filteredData.selisih.push(originalData.selisih[index]);
                    filteredData.pulau.push(originalData.pulau[index]);
                    filteredData.kurs_tengah.push(originalData.kurs_tengah[index]);
                    filteredData.volume_pembelian.push(originalData.volume_pembelian[index]);
                    filteredData.volume_penjualan.push(originalData.volume_penjualan[index]);
                    filteredData.saldo_awal.push(originalData.saldo_awal[index]);
                    filteredData.saldo_akhir.push(originalData.saldo_akhir[index]);
                    filteredData._spread_keuntungan.push(originalData._spread_keuntungan[index]);
                }
            });

            renderTable(filteredData);
        });
    }
</script>

@endscript
