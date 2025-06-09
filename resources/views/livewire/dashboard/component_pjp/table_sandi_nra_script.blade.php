@script
<script>
    Livewire.on('pjpReloadTableChartSandiNRA', (fromServer) => {
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
                <h2 class="text-xl mb-4 dark:text-gray-200 text-gray-800">Tabel Detail PJP</h2>
                <input id="search-input" 
                       type="text" 
                       placeholder="Cari Sandi, Nama, NRA, KPWDN, Selisih, Pulau, Kota, Most Frequent City, Most Frequent Country, Most Frequent Receiver, Most Frequent Sender, Pemegang Saham, Pengurus, Frekuensi Pengiriman, Total Nominal Transaksi, Modal Disetor, Selisih Transaksi Outgoing-Incoming, Spread Keuntungan, Other Sandi Related (Receiver), Other Sandi Related (Sender)"
                       class="dark:bg-gray-800 dark:text-gray-200 bg-gray-100 text-black rounded-md px-4 py-2 mb-4 w-2/3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div id="table-container" class="w-full overflow-auto"></div>
            </div>
        `;
    }

    function createSearchableTable(element, data) {
        const originalData = {
            sandi: Object.values(data.sandi),
            // nama: Object.values(data.nama),
            NRA_APU: Object.values(data.NRA_APU),
            NRA_PRED: Object.values(data.NRA_PRED),
            selisih: Object.values(data.selisih),
            KPWDN: Object.values(data.kpwdn),
            // pulau: Object.values(data.pulau),
            // kota: Object.values(data.kota),
            // most_frequent_city_list: Object.values(data.most_frequent_city_list),
            most_frequent_country_list: Object.values(data.most_frequent_country_list),
            // most_frequent_receiver_list: Object.values(data.most_frequent_receiver_list),
            // most_frequent_sender_list: Object.values(data.most_frequent_sender_list),
            pemegang_saham_list: Object.values(data.pemegang_saham_list),
            pengurus_list: Object.values(data.pengurus_list),
            frekuensi_pengiriman_sum: Object.values(data.frekuensi_pengiriman_sum),
            total_nominal_transaksi_sum: Object.values(data.total_nominal_transaksi_sum),
            // modal_disetor: Object.values(data.modal_disetor),
            // selisih_transaksi_outgoing_incoming: Object.values(data.selisih_transaksi_outgoing_incoming),
            // other_sandi_related_through_receiver: Object.values(data.other_sandi_related_through_receiver),
            // other_sandi_related_through_sender: Object.values(data.other_sandi_related_through_sender),
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
                        ['<b>Sandi PJP</b>'],
                        // ['<b>Nama</b>'],
                        ['<b>NRA Existing</b>'],
                        ['<b>NRA Prediksi</b>'],
                        ['<b>Selisih NRA</b>'],
                        ['<b>KPwDN</b>'],
                        // ['<b>Pulau</b>'],
                        // ['<b>Kota</b>'],
                        // ['<b>Most Frequent City</b>'],
                        ['<b>Most Frequent Country</b>'],
                        // ['<b>Most Frequent Receiver</b>'],
                        // ['<b>Most Frequent Sender</b>'],
                        ['<b>Pemegang Saham</b>'],
                        ['<b>Pengurus</b>'],
                        ['<b>Frekuensi Pengiriman</b>'],
                        ['<b>Total Nominal Transaksi</b>'],
                        // ['<b>Modal Disetor</b>'],
                        // ['<b>Selisih Transaksi Outgoing-Incoming</b>'],
                        // ['<b>Other Sandi (Through Receiver)</b>'],
                        // ['<b>Other Sandi (Through Sender)</b>'],
                    ],
                    align: 'center',
                    font: { size: 14, color: headerFontColor },
                    fill: { color: headerBgColor }
                },
                cells: {
                    values: [
                        filteredData.sandi,
                        // filteredData.nama,
                        filteredData.NRA_APU,
                        filteredData.NRA_PRED,
                        filteredData.selisih,
                        filteredData.KPWDN,
                        // filteredData.pulau,
                        // filteredData.kota,
                        // filteredData.most_frequent_city_list,
                        filteredData.most_frequent_country_list,
                        // filteredData.most_frequent_receiver_list,
                        // filteredData.most_frequent_sender_list,
                        filteredData.pemegang_saham_list,
                        filteredData.pengurus_list,
                        filteredData.frekuensi_pengiriman_sum,
                        filteredData.total_nominal_transaksi_sum.map(formatCurrency),
                        // filteredData.modal_disetor,
                        // filteredData.selisih_transaksi_outgoing_incoming,
                        // filteredData.other_sandi_related_through_receiver,
                        // filteredData.other_sandi_related_through_sender,
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
                responsive: true
            };

            Plotly.newPlot(tableContainer, [tableData], layout, config);
        }

        renderTable(originalData);

        searchInput.addEventListener('input', (event) => {
            const query = event.target.value.toLowerCase();
            const filteredData = {
                sandi: [],
                // nama: [],
                NRA_APU: [],
                NRA_PRED: [],
                selisih: [],
                KPWDN: [],
                // pulau: [],
                // kota: [],
                // most_frequent_city_list: [],
                most_frequent_country_list: [],
                // most_frequent_receiver_list: [],
                // most_frequent_sender_list: [],
                pemegang_saham_list: [],
                pengurus_list: [],
                frekuensi_pengiriman_sum: [],
                total_nominal_transaksi_sum: [],
                // modal_disetor: [],
                // selisih_transaksi_outgoing_incoming: [],
                // other_sandi_related_through_receiver: [],
                // other_sandi_related_through_sender: []
            };

            originalData.sandi.forEach((sandi, index) => {
                if (sandi.toLowerCase().includes(query) ||
                    // originalData.nama[index].toLowerCase().includes(query) ||
                    originalData.NRA_APU[index].toString().includes(query) ||
                    originalData.NRA_PRED[index].toString().includes(query) ||
                    originalData.KPWDN[index].toLowerCase().includes(query) ||
                    originalData.selisih[index].toString().includes(query) ||
                    // originalData.pulau[index].toLowerCase().includes(query) ||
                    // originalData.kota[index].toLowerCase().includes(query) ||
                    // originalData.most_frequent_city_list[index].toLowerCase().includes(query) ||
                    originalData.most_frequent_country_list[index].toLowerCase().includes(query) ||
                    // originalData.most_frequent_receiver_list[index].toLowerCase().includes(query) ||
                    // originalData.most_frequent_sender_list[index].toLowerCase().includes(query) ||
                    originalData.pemegang_saham_list[index].toLowerCase().includes(query) ||
                    originalData.pengurus_list[index].toLowerCase().includes(query) ||
                    originalData.frekuensi_pengiriman_sum[index].toString().includes(query) ||
                    originalData.total_nominal_transaksi_sum[index].toString().includes(query)
                    // originalData.modal_disetor[index].toString().includes(query) ||
                    // originalData.selisih_transaksi_outgoing_incoming[index].toString().includes(query) ||
                    // originalData.other_sandi_related_through_receiver[index].toLowerCase().includes(query) ||
                    // originalData.other_sandi_related_through_sender[index].toLowerCase().includes(query)
                ) {
                    filteredData.sandi.push(sandi);
                    // filteredData.nama.push(originalData.nama[index]);
                    filteredData.NRA_APU.push(originalData.NRA_APU[index]);
                    filteredData.NRA_PRED.push(originalData.NRA_PRED[index]);
                    filteredData.selisih.push(originalData.selisih[index]);
                    filteredData.KPWDN.push(originalData.KPWDN[index]);
                    // filteredData.pulau.push(originalData.pulau[index]);
                    // filteredData.kota.push(originalData.kota[index]);
                    // filteredData.most_frequent_city_list.push(originalData.most_frequent_city_list[index]);
                    filteredData.most_frequent_country_list.push(originalData.most_frequent_country_list[index]);
                    // filteredData.most_frequent_receiver_list.push(originalData.most_frequent_receiver_list[index]);
                    // filteredData.most_frequent_sender_list.push(originalData.most_frequent_sender_list[index]);
                    filteredData.pemegang_saham_list.push(originalData.pemegang_saham_list[index]);
                    filteredData.pengurus_list.push(originalData.pengurus_list[index]);
                    filteredData.frekuensi_pengiriman_sum.push(originalData.frekuensi_pengiriman_sum[index]);
                    filteredData.total_nominal_transaksi_sum.push(originalData.total_nominal_transaksi_sum[index]);
                    // filteredData.modal_disetor.push(originalData.modal_disetor[index]);
                    // filteredData.selisih_transaksi_outgoing_incoming.push(originalData.selisih_transaksi_outgoing_incoming[index]);
                    // filteredData.other_sandi_related_through_receiver.push(originalData.other_sandi_related_through_receiver[index]);
                    // filteredData.other_sandi_related_through_sender.push(originalData.other_sandi_related_through_sender[index]);
                }
            });

            renderTable(filteredData);
        });
    }
</script>

@endscript
