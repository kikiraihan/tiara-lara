<div class="dark:bg-gray-900 dark:text-white">

    @include('layouts.nra_raisa.guest_nav')
    <main class="flex-grow">

        <!-- Hero Section -->
        <section class="py-16 bg-gradient-to-l from-gradientLight1 to-gradientLight2 dark:from-gradientDark1 dark:to-gradientDark2">
            <div class="mx-auto px-20 py-3 flex flex-col-reverse md:grid md:grid-cols-2 items-center">
                <div class="text-left text-raisaDongker1">
                    <h1 class="text-4xl font-bold mb-4 dark:text-raisaBlueLight">TIARA: Trusted Information Assistant for Regulation Access</h1>
                    <p class="dark:text-white text-md italic mb-2">Asisten AI untuk Akses Informasi Kebijakan Bank Indonesia</p>
                    <p class="dark:text-white text-lg mb-8">TIARA membantu menemukan jawaban berbasis dokumen kebijakan Bank Indonesia secara cerdas, cepat, dan referensial.</p>
                    <div class="flex justify-start space-x-4">
                        <a href="{{ route('login') }}" 
                            class="px-6 py-2 font-bold bg-raisaDongker1 text-white hover:bg-raisaDongker2 dark:bg-raisaBlueLight dark:hover:bg-raisaDongker2 transition duration-300">
                            Mulai Sekarang
                        </a>
                        <button
                            class="px-6 py-2 font-bold text-raisaDongker1 border-2 border-raisaDongker1 hover:bg-raisaDongker1 hover:text-white transition duration-300 dark:border-raisaBlueLight dark:text-raisaBlueLight dark:hover:bg-raisaDongker2 dark:hover:border-raisaDongker2 dark:hover:text-white"
                            onclick="document.getElementById('features').scrollIntoView({ behavior: 'smooth' });">
                            Pelajari Lebih Lanjut
                        </button>
                    </div>
                </div>
            
                <div>
                    {{-- <x-senyawa.lottie-ilustration path="{{ asset('landing/image/knowledge-search.json') }}" id="ilustrasi_tiara"/> --}}
                    <x-senyawa.lottie-ilustration path="{{ asset('landing/image/seeking-development.json') }}" id="manajemen_model"/>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-20 bg-gradient-to-bl from-gradientLight1 to-gradientLight2 dark:from-gradientDark1 dark:to-gradientDark2">
            <div class="mx-auto px-20 py-3">
                <h2 class="text-3xl font-bold text-center mb-12">Apa yang Bisa Dilakukan TIARA?</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
                    @foreach ([
                        [
                            'icon' => 'fas fa-file-upload',
                            'title' => 'Upload Dokumen Kebijakan',
                            'description' => 'Admin mengunggah file dokumen kebijakan Bank Indonesia untuk dianalisis oleh sistem.'
                        ],
                        [
                            'icon' => 'fas fa-brain',
                            'title' => 'Pemrosesan AI (RAG)',
                            'description' => 'Dokumen diproses dan disimpan dalam database vektor agar AI bisa menjawab pertanyaan berbasis isi dokumen.'
                        ],
                        [
                            'icon' => 'fas fa-comments',
                            'title' => 'Tanya Jawab Interaktif',
                            'description' => 'Pengguna dapat mengajukan pertanyaan, dan AI menjawab berdasarkan isi kebijakan, lengkap dengan referensi dokumen.'
                        ],
                        [
                            'icon' => 'fas fa-eye',
                            'title' => 'Preview & Referensi',
                            'description' => 'TIARA menampilkan kutipan isi file terkait jawaban yang diberikan dan memungkinkan akses ke file sumbernya.'
                        ],
                    ] as $feature)
                        <div class="bg-white dark:bg-gray-800 shadow-lg p-6">
                            <i class="{{ $feature['icon'] }} text-4xl text-blue-600 mb-4"></i>
                            <h3 class="text-xl font-semibold mb-2">{{ $feature['title'] }}</h3>
                            <p>{{ $feature['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="py-20">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold text-center mb-12 text-gray-800 dark:text-white">Bagaimana TIARA Bekerja?</h2>
                
                <ol class="relative border-l border-gray-200 dark:border-gray-700 max-w-2xl mx-auto">                  
                    <li class="mb-10 ml-10">
                        <span class="absolute flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full -left-6 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                            <i class="fas fa-file-alt text-2xl text-blue-600 dark:text-blue-300"></i>
                        </span>
                        <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">Unggah Dokumen</h3>
                        <p class="text-base font-normal text-gray-500 dark:text-gray-400">Admin mengunggah dokumen resmi kebijakan Bank Indonesia dalam format digital.</p>
                    </li>
                    <li class="mb-10 ml-10">
                        <span class="absolute flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full -left-6 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                            <i class="fas fa-cogs text-2xl text-blue-600 dark:text-blue-300"></i>
                        </span>
                        <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">Embedding & Indexing</h3>
                        <p class="text-base font-normal text-gray-500 dark:text-gray-400">Sistem memproses dokumen ke dalam bentuk vektor dan menyimpannya di basis data PostgreSQL vector.</p>
                    </li>
                    <li class="ml-10">
                        <span class="absolute flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full -left-6 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                            <i class="fas fa-comment-dots text-2xl text-blue-600 dark:text-blue-300"></i>
                        </span>
                        <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">Tanya & Dapatkan Jawaban</h3>
                        <p class="text-base font-normal text-gray-500 dark:text-gray-400">User mengajukan pertanyaan, AI menjawab berdasarkan konteks dokumen serta menyediakan link referensi file sumber.</p>
                    </li>
                </ol>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-20 text-center">
            <p>&copy; <span id="year"></span> TIARA. All rights reserved. Departemen Regional Bank Indonesia. <a href="https://kikiraihan.github.io/">Katili Dev</a></p>
        </div>
    </footer>

    <script>
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>    
</div>
