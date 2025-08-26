<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBPPMVP BMTI - Unit Layanan Publik</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }

        /* Navbar atas */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #ffffff;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar .logo {
            height: 40px;
        }

        /* Sidebar */
        #sidebar {
            position: fixed;
            top: 0;
            left: -260px;
            width: 260px;
            height: 100%;
            background-color: #005baa;
            transition: left 0.3s ease;
            z-index: 1100;
            color: white;
        }

        #sidebar.active {
            left: 0;
        }

        #sidebar .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
            padding: 0 16px;
            border-bottom: 1px solid #ffffff66;
        }

        #sidebar nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #sidebar nav ul li a {
            display: block;
            padding: 16px 20px;
            color: white;
            background-color: #005baa;
            text-decoration: none;
            border-bottom: 1px solid #ffffff33;
            transition: background 0.2s ease;
        }

        #sidebar nav ul li a:hover,
        #sidebar nav ul li a.active {
            background-color: #014f94;
        }

        /* Overlay */
        #sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.3);
            display: none;
            z-index: 1050;
        }

        #sidebar-overlay.active {
            display: block;
        }

        /* Main Content */
        main {
            padding: 16px;
            margin-top: 64px;
        }

        /* Footer */
        footer {
            background-color: #005baa;
            color: white;
            text-align: center;
            padding: 8px 0;
            font-size: 14px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        /* Icon Buttons */
        .btn-icon {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            color: #000;
        }

        .btn-icon:hover {
            color: #0284c7;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<header class="navbar">
    <div class="flex items-center gap-4">
        <img src="{{ asset('images/bmti.png') }}" alt="Logo" class="logo">
        <button id="open-sidebar-btn" class="btn-icon"><i class="fas fa-bars"></i></button>
    </div>
    <button class="btn-icon"><i class="fas fa-user-circle"></i></button>
</header>

<!-- Sidebar -->
<aside id="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('images/bmti.png') }}" alt="Logo" style="height:40px;">
        <button id="close-sidebar-btn" class="btn-icon" style="color:white;"><i class="fas fa-times"></i></button>
    </div>
    <nav>
        <ul>
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Operator Surat
                </a>
            </li>
            <li>
                <a href="{{ route('permohonan.index') }}" class="{{ request()->routeIs('permohonan.*') ? 'active' : '' }}">
                    Penanggung Jawab
                </a>
            </li>
            <li>
                <a href="{{ route('tracking') }}" class="{{ request()->routeIs('tracking') ? 'active' : '' }}">
                    Staff Humas
                </a>
            </li>
        </ul>
    </nav>
</aside>

<!-- Overlay -->
<div id="sidebar-overlay"></div>

<!-- Main -->
<main>
    @yield('content')
</main>

<!-- Footer -->
<footer>
    © {{ date('Y') }} BBPPMVP BMTI - UNIT LAYANAN PUBLIK
</footer>

<!-- Script -->
<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const openBtn = document.getElementById('open-sidebar-btn');
    const closeBtn = document.getElementById('close-sidebar-btn');

    openBtn.addEventListener('click', () => {
        sidebar.classList.add('active');
        overlay.classList.add('active');
    });

    closeBtn.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });
</script>

</body>
</html>
