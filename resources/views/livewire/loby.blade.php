<x-slot name="stylehalaman">
    @livewireStyles
</x-slot>

<x-slot name="scripthalaman">
    @livewireScripts

    <script>
        console.log(1)

    </script>
</x-slot>

<div>
    <div>Welcome</div> 

    <div class="w-full h-full">
        nice
    </div>

</div>

{{-- <div class="max-w-6xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500">Kelola dokumen kebijakan Bank Indonesia yang telah diunggah</p>
        </div>
        <div class="flex space-x-3">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="search" class="h-5 w-5 text-gray-400"></i>
                </div>
                <input type="text"
                    class="pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Cari dokumen...">
            </div>
            <button
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i data-lucide="filter" class="h-4 w-4 mr-2"></i>
                Filter
            </button>
        </div>
    </div>

    <!-- Document List -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                            File</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Upload</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ukuran</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <i data-lucide="file-text" class="flex-shrink-0 h-5 w-5 text-gray-400 mr-3"></i>
                                <div class="text-sm font-medium text-gray-900">PBI_No.25_1_2023.pdf</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15 Mei 2025</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2.4 MB</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="admin-preview.html?file=PBI_No.25_1_2023.pdf"
                                    class="text-blue-600 hover:text-blue-900" title="Preview">
                                    <i data-lucide="eye" class="h-5 w-5"></i>
                                </a>
                                <button class="text-gray-600 hover:text-gray-900" title="Edit">
                                    <i data-lucide="edit" class="h-5 w-5"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900" title="Delete">
                                    <i data-lucide="trash-2" class="h-5 w-5"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <i data-lucide="file-text" class="flex-shrink-0 h-5 w-5 text-gray-400 mr-3"></i>
                                <div class="text-sm font-medium text-gray-900">SE_Kebijakan_Moneter_2024.docx</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">14 Mei 2025</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Dalam
                                Proses</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1.8 MB</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="admin-preview.html?file=SE_Kebijakan_Moneter_2024.docx"
                                    class="text-blue-600 hover:text-blue-900 opacity-50 pointer-events-none"
                                    title="Preview">
                                    <i data-lucide="eye" class="h-5 w-5"></i>
                                </a>
                                <button class="text-gray-600 hover:text-gray-900 opacity-50 pointer-events-none"
                                    title="Edit">
                                    <i data-lucide="edit" class="h-5 w-5"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900" title="Delete">
                                    <i data-lucide="trash-2" class="h-5 w-5"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <i data-lucide="file-text" class="flex-shrink-0 h-5 w-5 text-gray-400 mr-3"></i>
                                <div class="text-sm font-medium text-gray-900">Peraturan_BI_No.24_11_2022.pdf</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">10 Mei 2025</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Gagal</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3.1 MB</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="admin-preview.html?file=Peraturan_BI_No.24_11_2022.pdf"
                                    class="text-blue-600 hover:text-blue-900" title="Preview">
                                    <i data-lucide="eye" class="h-5 w-5"></i>
                                </a>
                                <button class="text-gray-600 hover:text-gray-900" title="Edit">
                                    <i data-lucide="edit" class="h-5 w-5"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900" title="Delete">
                                    <i data-lucide="trash-2" class="h-5 w-5"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <i data-lucide="file-text" class="flex-shrink-0 h-5 w-5 text-gray-400 mr-3"></i>
                                <div class="text-sm font-medium text-gray-900">Laporan_Inflasi_Q1_2025.pdf</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">5 Mei 2025</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4.2 MB</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="admin-preview.html?file=Laporan_Inflasi_Q1_2025.pdf"
                                    class="text-blue-600 hover:text-blue-900" title="Preview">
                                    <i data-lucide="eye" class="h-5 w-5"></i>
                                </a>
                                <button class="text-gray-600 hover:text-gray-900" title="Edit">
                                    <i data-lucide="edit" class="h-5 w-5"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900" title="Delete">
                                    <i data-lucide="trash-2" class="h-5 w-5"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                <a href="#"
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </a>
                <a href="#"
                    class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </a>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing <span class="font-medium">1</span> to <span class="font-medium">4</span> of <span
                            class="font-medium">12</span> results
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <a href="#"
                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Previous</span>
                            <i data-lucide="chevron-left" class="h-5 w-5"></i>
                        </a>
                        <a href="#" aria-current="page"
                            class="z-10 bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                            1
                        </a>
                        <a href="#"
                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                            2
                        </a>
                        <a href="#"
                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                            3
                        </a>
                        <a href="#"
                            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Next</span>
                            <i data-lucide="chevron-right" class="h-5 w-5"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div> --}}
