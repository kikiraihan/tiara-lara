<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- @include('layouts.nra_raisa.guest_nav') --}}
    <button id="darkModeToggle" class="rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 dark:text-white absolute right-5 top-5 py-2 px-4 shadow-sm shadow-gray-500">
        {{-- <i class="fas fa-moon"></i> --}}
    </button>

    <div
        class="bg-gradient-to-br from-gradientLight1 to-gradientLight2 dark:from-gradientDark0 dark:to-gradientDark1 min-h-screen flex items-center justify-center transition-colors duration-300">
        <div class="container mx-auto px-4">
            <div
                class="max-w-md mx-auto bg-white dark:bg-gradient-to-br dark:from-gradientDark1 dark:to-gradientDark2 shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="text-center mb-6">
                        <div class="inline-block p-2 bg-raisaDongker1 text-white mb-4 rounded-full">
                            {{-- <i class="fas fa-shield-alt text-3xl"></i> --}}
                            <x-tiara-logo/>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-gradientLight2">TIARA</h1>
                        <p class="text-sm text-gray-600 dark:text-gradientLight1">Trusted Information Assistant for Regulation Access</p>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-4">
                            <label for="email"
                                class="block text-gray-700 dark:text-gradientLight1 text-sm font-bold mb-2">
                                <i class="fas fa-envelope mr-2"></i>Email
                            </label>
                            <input type="email" id="email" name="email" :value="old('email')"
                                class="shadow appearance-none border w-full py-2 px-3 text-gray-700 dark:text-gradientLight2 leading-tight focus:outline-none focus:ring-2 focus:ring-raisaDongker1 dark:focus:ring-raisaDongker2 focus:border-raisaDongker1 dark:focus:border-raisaDongker2 dark:bg-gradientDark1 dark:border-gradientDark2"
                                required autofocus autocomplete="username">
                            @error('email')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-6">
                            <label for="password"
                                class="block text-gray-700 dark:text-gradientLight1 text-sm font-bold mb-2">
                                <i class="fas fa-lock mr-2"></i>Password
                            </label>
                            <input type="password" id="password" name="password"
                                class="shadow appearance-none border w-full py-2 px-3 text-gray-700 dark:text-gradientLight2 leading-tight focus:outline-none focus:ring-2 focus:ring-raisaDongker1 dark:focus:ring-raisaDongker2 focus:border-raisaDongker1 dark:focus:border-raisaDongker2 dark:bg-gradientDark1 dark:border-gradientDark2"
                                required autocomplete="current-password">
                            @error('password')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between mb-6">
                            {{-- <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" name="remember"
                                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                            </label> --}}
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-raisaDongker1 dark:text-white hover:underline">
                                Forgot Password?
                            </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between">
                            <button type="submit"
                                class="bg-gradient-to-r from-raisaDongker1 to-raisaDongker2 hover:from-raisaDongker2 hover:to-raisaDongker1 text-white font-bold py-2 px-4 focus:outline-none focus:ring-2 focus:ring-raisaDongker1 dark:focus:ring-raisaDongker2 transition duration-300 ease-in-out w-full">
                                Log in
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

</x-guest-layout>
