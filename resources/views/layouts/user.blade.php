<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-g">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <!-- Tambahkan ini -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="bg-white flex flex-col min-h-screen">

    <div class="navbar">
        <div class="navbar-inner">
            <div class="navbar-left">
                <img src="{{ asset('images/bmti.png') }}" alt="Logo BMTI">
                <div class="navbar-links">
                    <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('permohonan.index') }}">Permohonan</a>
                    <a href="{{ route('tracking') }}" class="{{ request()->routeIs('tracking') ? 'active' : '' }}">Tracking</a>
                </div>
            </div>
            <div class="navbar-right">
                <div class="profile-dropdown">
                    <button class="profile-dropbtn" id="profileBtn">
                        <i class="fa fa-user"></i>
                    </button>

                    <div class="dropdown-content" id="dropdownMenu">
                        <a href="{{ route('profile.edit') }}">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf 
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();">
                              Logout
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer>
        © 2025 BBPPMVP BMTI - UNIT LAYANAN PUBLIK
    </footer>

    <script>
        // Navbar scroll effect
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Dropdown toggle
        const profileBtn = document.getElementById('profileBtn');
        const dropdownMenu = document.getElementById('dropdownMenu');

        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // biar gak langsung ketutup
            dropdownMenu.classList.toggle('show');
        });

        // Klik di luar dropdown -> close
        window.addEventListener('click', () => {
            dropdownMenu.classList.remove('show');
        });
    </script>

</body>
</html>
