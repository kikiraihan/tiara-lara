<div class="mt-2">
    <div id="container_cards"></div>
</div>

@script
<script>
    Livewire.on('reloadCards', (cardData) => {
        const elements = getElement();
        setElement(elements, cardData[0]);
    });

    function getElement() {
        return {
            containerElement: document.getElementById('container_cards'),
        };
    }

    function setElement(elements, cardData) {
        // Tambahkan kelas tambahan untuk styling jika diperlukan
        elements.containerElement.classList.add('grid', 'grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-3', 'gap-6');
        console.log(cardData);

        // Buat isi konten card secara dinamis berdasarkan data
        elements.containerElement.innerHTML = cardData.map(card => `
            <div class="bg-gray-50 dark:bg-gray-800 shadow p-6">
                <h2 class="text-xl font-semibold mb-4">${card.title}</h2>
                <p class="text-4xl font-bold text-blue-600">${card.value}</p>
            </div>
        `).join('');
    }
</script>
@endscript
