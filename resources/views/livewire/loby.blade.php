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
    <h1 class="text-3xl font-semibold text-raisaDongker1 dark:text-white mb-6">Halo, {{$user_login_name}}!</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-gray-50 dark:bg-gray-700 shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Jumlah Pengguna</h2>
            <p class="text-4xl font-bold">{{$count_user}}</p>
        </div>
        <div class="bg-gray-50 dark:bg-gray-700 shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Dataset belum diproses</h2>
            <p class="text-4xl font-bold text-yellow-600">{{$count_dataset_uninfered}}</p>
        </div>
        <div class="bg-gray-50 dark:bg-gray-700 shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Dataset terproses</h2>
            <p class="text-4xl font-bold text-green-600">{{$count_dataset_infered}}</p>
        </div>
    </div>
</div>
