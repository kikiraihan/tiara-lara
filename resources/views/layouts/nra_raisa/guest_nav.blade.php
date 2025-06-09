<nav class=" absolute w-full px-20 py-3">
    <div class="container px-6 py-3 flex justify-between items-center bg-gradient-to-r from-raisaDongker1 to-raisaDongker2 text-white shadow-md rounded-full mx-auto">
        <a href="#" class="text-xl font-bold text-white">RAISA</a>
        <div class="flex items-center space-x-4">
            <a href="{{ route('login') }}" class="text-white hover:bg-blue-400 hover:bg-opacity-20 py-2 px-4 rounded-full">Login</a>
            <button id="darkModeToggle" class="p-2 rounded-full hover:bg-blue-400 hover:bg-opacity-20 text-white py-2 px-4">
                {{-- <i class="fas fa-moon"></i> --}}
            </button>
        </div>
    </div>
</nav>