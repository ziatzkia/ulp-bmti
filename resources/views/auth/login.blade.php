@extends('layouts.guest')

@section('content')
<style>
    body, html {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #ffffff;
        height: 100%;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 2rem 3rem; /* tambah padding kiri-kanan */
        gap: 2rem;
        max-width: 1200px;  /* biar tidak terlalu lebar */
        margin: 0 auto;     /* posisi tengah */
    }

    .left-side {
        flex: 1;
        min-width: 320px;
        max-width: 600px;
        text-align: center;
        padding: 1rem; /* tambah padding */
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

    .right-side {
        flex: 1;
        min-width: 320px;
        max-width: 420px;
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
        margin: 0 auto; /* supaya nggak nempel kiri */
    }

    .login-form h2 {
        margin-bottom: 1rem;
        color: #1e3a8a;
        text-align: center;
    }

    .login-form input {
        width: 100%;
        padding: 0.75rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 6px;
        outline: none;
        font-size: 0.95rem;
    }

    .login-form input:focus {
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

    .remember-me {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    .remember-me input[type="checkbox"] {
        width: auto;
        height: auto;
        margin: 0;
    }

    /* Mobile */
    @media (max-width: 768px) {
        .container {
            flex-direction: column;
            align-items: center;
            padding: 1.5rem; /* lebih rapat di hp */
        }

        .left-side, .right-side {
            max-width: 100%;
        }
    }
</style>

<div class="container">
    <!-- Kiri: Logo + Welcome -->
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
    </div>

    <!-- Kanan: Form Login -->
    <div class="right-side">
        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf
            <h2>Login</h2>

            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <span style="color:red;">{{ $message }}</span>
            @enderror

            <input type="password" name="password" placeholder="Password" required>
            @error('password')
                <span style="color:red;">{{ $message }}</span>
            @enderror

            <div class="remember-me">
                <label for="remember">
                    <input id="remember" type="checkbox" name="remember">
                    Remember me
                </label>
            </div>

            <button type="submit">Login</button>

            <p style="text-align:center; margin-top:1rem;">
                Belum punya akun? <a href="{{ route('register') }}">Register</a>
            </p>
            @if (Route::has('password.request'))
                <p style="text-align:center;">
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                </p>
            @endif
        </form>
    </div>
</div>
@endsection
