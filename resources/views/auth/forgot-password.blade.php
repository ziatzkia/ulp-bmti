@extends('layouts.guest')

@section('content')
<style>
    /* This CSS is copied directly from your login page for consistency */
    body, html {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f9fafb; /* A slightly softer background */
        height: 100%;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 2rem 3rem;
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
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

    .right-side {
        flex: 1;
        min-width: 320px;
        max-width: 420px;
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
    }

    .form-container h2 {
        margin-bottom: 0.5rem; /* Reduced margin */
        color: #1e3a8a;
        text-align: center;
        font-size: 1.5rem; /* Matched h2 size */
    }
    
    .form-container p {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #6b7280;
    }

    .form-container input {
        width: 100%;
        padding: 0.75rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 6px;
        outline: none;
        font-size: 0.95rem;
    }

    .form-container input:focus {
        border-color: #1e3a8a;
    }

    .form-container button {
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

    .form-container button:hover {
        background: #16326f;
    }
    
    .form-container a {
        color: #1e3a8a;
        text-decoration: none;
    }

    .form-container a:hover {
        text-decoration: underline;
    }

    /* Mobile */
    @media (max-width: 768px) {
        .container {
            flex-direction: column;
            align-items: center;
            padding: 1.5rem;
        }

        .left-side, .right-side {
            max-width: 100%;
        }
    }
</style>

<div class="container">
    <!-- Kiri: Logo + Welcome (Same as login page) -->
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

    <!-- Kanan: Form Lupa Password -->
    <div class="right-side">
        <div class="form-container">
            <h2>Lupa Password?</h2>
            <p>
                Masukan email anda untuk menerima link reset password.
            </p>

            <!-- Session Status Message -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Input -->
                <input id="email" 
                       type="email" 
                       name="email" 
                       placeholder="Email"
                       value="{{ old('email') }}" 
                       required 
                       autofocus>
                
                <!-- Validation Error Message -->
                @error('email')
                    <span style="color:red; font-size: 0.9rem; display: block; margin-bottom: 1rem;">{{ $message }}</span>
                @enderror

                <!-- Submit Button -->
                <button type="submit">
                    Kirim 
                </button>

                <p style="text-align:center; margin-top:1.5rem;">
                    Ingat password? <a href="{{ route('login') }}">Login disini</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
