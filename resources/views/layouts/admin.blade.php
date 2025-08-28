<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="bg-white flex">

    {{-- Sidebar --}}
    <aside class="w-64 bg-white border-r border-gray-300 min-h-screen">
        <div class="p-7 flex items-center justify-center">
            <img src="{{ asset('images/bmti.png') }}" alt="Logo" class="h-20">
        </div>
        <nav class="mt-6 flex flex-col space-y-2">

            <a href="{{ route('dashboard') }}"
                class="flex items-center px-4 py-2 rounded-lg font-semibold 
               hover:bg-gray-100 transition 
               {{ request()->routeIs('dashboard') ? 'bg-gray-200 text-blue-700' : 'text-gray-700' }}">
                Dashboard
            </a>

            @if(auth()->user()->role === 'humas')
            <a href="{{ route('divisis.index') }}"
                class="flex items-center px-4 py-2 rounded-lg font-semibold 
               hover:bg-gray-100 transition 
               {{ request()->routeIs('divisis.index') ? 'bg-gray-200 text-blue-700' : 'text-gray-700' }}">
                Divisi
            </a>
            <a href="{{ route('validasi') }}"
                class="flex items-center px-4 py-2 rounded-lg font-semibold 
               hover:bg-gray-100 transition 
               {{ request()->routeIs('validasi') ? 'bg-gray-200 text-blue-700' : 'text-gray-700' }}">
                Validasi Surat
            </a>
            <a href="{{ route('unduhan') }}"
                class="flex items-center px-4 py-2 rounded-lg font-semibold 
               hover:bg-gray-100 transition 
               {{ request()->routeIs('unduhan') ? 'bg-gray-200 text-blue-700' : 'text-gray-700' }}">
                unduhan
            </a>
            <a href="{{ route('balasan') }}"
                class="flex items-center px-4 py-2 rounded-lg font-semibold 
               hover:bg-gray-100 transition 
               {{ request()->routeIs('balasan') ? 'bg-gray-200 text-blue-700' : 'text-gray-700' }}">
                Surat Balasan
            </a>
            @endif
            @if(auth()->user()->role === 'divisi')

            <a href="{{ route('kuota') }}"
                class="flex items-center px-4 py-2 rounded-lg font-semibold 
               hover:bg-gray-100 transition 
               {{ request()->routeIs('kuota') ? 'bg-gray-200 text-blue-700' : 'text-gray-700' }}">
                Kuota Magang
            </a>
            @endif
        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-h-screen">
        <header class="bg-white shadow sticky top-0 z-50">
            <div class="w-full flex items-center justify-between px-6 py-5 h-20">
                <div class="flex-1 ml-1">
                    <div class="relative w-full max-w-lg">
                        <input type="text" placeholder="Cari sesuatu..."
                            class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        <i class="fa fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                    </div>
                </div>


                {{-- Profile --}}
                <div class="relative">
                    <button id="profileBtn" class="p-2 rounded-full hover:bg-gray-100 transition text-3xl">
                        <i class="fa fa-user-circle"></i>
                    </button>
                    <div id="dropdownMenu"
                        class="absolute right-0 mt-2 w-40 bg-white text-black rounded-lg shadow hidden">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="block px-4 py-2 hover:bg-gray-100">
                                Logout
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="flex-1 p-6 bg-gray-100">
            @yield('content')
        </main>

    </div>

    <script>
        const profileBtn = document.getElementById('profileBtn');
        const dropdownMenu = document.getElementById('dropdownMenu');

        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });

        window.addEventListener('click', () => {
            dropdownMenu.classList.add('hidden');
        });
    </script>

</body>

</html>