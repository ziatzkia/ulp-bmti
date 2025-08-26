@extends('layouts.guest')

@section('content')
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #ffffff;
            height: 100%;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem 3rem;   /* tambah padding kanan kiri */
            gap: 2rem;
            max-width: 1200px;   /* biar nggak terlalu lebar */
            margin: 0 auto;      /* center */
        }

        .left-side {
            flex: 1;
            min-width: 320px;
            max-width: 600px;
            text-align: center;
            padding: 1rem;
        }

        .logos {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 1rem;
        }

        .logos img {
            max-width: 120px;
            height: auto;
        }

        .welcome-text h1 {
            font-size: 1.8rem;
            color: #1e3a8a;
            margin-bottom: 0.5rem;
        }

        .welcome-text p {
            font-size: 1rem;
            color: #333;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .quick-links {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .quick-links a {
            text-decoration: none;
            border: 1px solid #1e3a8a;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            color: #1e3a8a;
            font-size: 0.9rem;
            transition: background 0.3s, color 0.3s;
        }

        .quick-links a:hover {
            background: #1e3a8a;
            color: white;
        }

        .right-side {
            flex: 1;
            min-width: 320px;
            max-width: 420px;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
            margin: 0 auto; /* biar nggak nempel kiri */
        }

        .login-form h2 {
            margin-bottom: 1rem;
            color: #1e3a8a;
            text-align: center;
        }

        .login-form input,
        .login-form select {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            font-size: 0.95rem;
        }

        .login-form input:focus,
        .login-form select:focus {
            border-color: #1e3a8a;
        }

        .login-form button {
            width: 100%;
            padding: 0.75rem;
            background: #1e3a8a;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s;
        }

        .login-form button:hover {
            background: #16326f;
        }

        .login-form a {
            color: #1e3a8a;
            text-decoration: none;
        }

        .login-form a:hover {
            text-decoration: underline;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
                padding: 1.5rem;
            }

            .left-side,
            .right-side {
                max-width: 100%;
            }
        }
    </style>

    <div class="container">
        <!-- Kiri -->
        <div class="left-side">
            <div class="logos">
                <img src="{{ asset('images/bmti.png') }}" alt="Logo BMTI">
                <img src="{{ asset('images/kemendikdasmen.png') }}" alt="Logo Kemendikdasmen">
            </div>
            <div class="welcome-text">
                <h1>Selamat Datang di BBPPMPV BMTI</h1>
                <p>
                    Platform ini menyediakan informasi program magang dan praktik kerja lapangan
                    bagi siswa SMA, SMK, dan mahasiswa.
                </p>
            </div>
            {{-- <div class="quick-links">
                <a href="#">Instagram</a>
                <a href="#">Youtube</a>
                <a href="#">WhatsApp</a>
            </div> --}}
        </div>

        <!-- Kanan: Form Register -->
        <div class="right-side">
            <form method="POST" action="{{ route('register') }}" class="login-form">
                @csrf
                <h2>Register</h2>

                <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <span style="color:red;">{{ $message }}</span>
                @enderror

                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                @error('email')
                    <span style="color:red;">{{ $message }}</span>
                @enderror

                <input type="password" name="password" placeholder="Password" required>
                @error('password')
                    <span style="color:red;">{{ $message }}</span>
                @enderror

                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

                <button type="submit">Register</button>

                <p style="text-align:center; margin-top:1rem;">
                    Sudah punya akun? <a href="{{ route('login') }}">Login</a>
                </p>
            </form>
        </div>
    </div>
@endsection
