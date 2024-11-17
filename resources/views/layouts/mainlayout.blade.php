<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @livewireStyles
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @livewireScriptConfig
    @yield('scriptsrc')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"
        integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css"
        integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>@yield('title','')</title>
</head>
<script>
    function navData() {
    return {
        showNav: false
    }
    }
</script>
<body class="no-scrollbar">
    {{-- Start Nav --}}
    <nav class="bg-green-main" x-data="navData()" x-cloak>
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <button type="button"
                        class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        x-on:click="showNav=!showNav">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-1 items-end justify-center sm:items-stretch sm:justify-start">
                    <div class="flex flex-shrink-0 items-center">
                        {{-- <img class="h-8 w-auto" src="{{ asset('assets/images/Rasakopi-logo.png') }}" alt="Your Company"> --}}
                        <img class="h-8 w-auto" src="{{ asset('assets/images/Rasakopi-logo.png') }}" alt="Your Company">
                        <h2 class="text-white px-3 font-['DM Sans'] font-extrabold">RASA KOPI</h2>
                    </div>
                </div>
                <div class="flex justify-end">
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <a href="{{ route('home') }}" 
                            class="{{ request()->is('raskop') ? 'bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium' : 'text-white hover:bg-white-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium' }}"
                            >
                            Home
                            </a>
                            <a href="{{ route('reservasi') }}"
                            class="{{ request()->is('reservasi') ? 'bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium' : 'text-white hover:bg-white-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium' }}"
                            >
                                Reservasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="sm:hidden" id="mobile-menu" x-show="showNav" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90">
            <div class="space-y-1 px-2 pb-3 pt-2">
                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                <a href="{{ route('home') }}"
                    class="{{ request()->is('raskop') ? 'bg-gray-900 text-white block rounded-md px-3 py-2 text-base font-medium' : 'text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium' }}">Home
                </a>
                <a href="{{ route('reservasi') }}"
                class="{{ request()->is('reservasi') ? 'bg-gray-900 text-white block rounded-md px-3 py-2 text-base font-medium' : 'text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium' }}">Reservasi
                </a>
            </div>
        </div>
    </nav>
    @yield('content')
    @yield('script')
    <footer class="mt-8 bg-green-main h-full">
        <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
            <span class="text-sm text-white sm:text-center dark:text-gray-400">© 2023 <a
                    href="https://flowbite.com/" class="hover:underline">Rasa Kopi</a>. All Rights Reserved.
            </span>
            <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-white dark:text-gray-400 sm:mt-0">
                <li>
                    <a href="#" class="mr-4 hover:underline md:mr-6 ">About</a>
                </li>
                <li>
                    <a href="#" class="mr-4 hover:underline md:mr-6">Privacy Policy</a>
                </li>
                <li>
                    <a href="#" class="mr-4 hover:underline md:mr-6">Licensing</a>
                </li>
                <li>
                    <a href="#" class="hover:underline">Contact</a>
                </li>
            </ul>
        </div>
    </footer>
</body>
</html>

  
   