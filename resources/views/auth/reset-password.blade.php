@extends('layouts.guest')

@section('content')
    <style>
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
            margin-bottom: 1.5rem;
            color: #1e3a8a;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
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
            font-weight: 600;
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

        .error-message {
            color: red;
            font-size: 0.875rem;
            margin-top: -0.75rem;
            margin-bottom: 1rem;
            display: block;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
            padding: 0.75rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            text-align: center;
            font-weight: 500;
        }

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
        <!-- Kiri: Logo + Welcome -->
        <div class="left-side">
            <div class="logos">
                <img src="{{ asset('images/kemendikdasmen.png') }}" alt="Logo Kemendikdasmen">
                <img src="{{ asset('images/bmti.png') }}" alt="Logo BMTI">
            </div>
            <div class="welcome-text">
                <h1>Selamat Datang di BBPPMPV BMTI</h1>
                <p>
                    Platform ini menyediakan informasi program magang dan praktik kerja lapangan
                    bagi siswa SMK, dan mahasiswa.
                </p>
            </div>
        </div>

        <!-- Kanan: Form Reset Password -->
        <div class="right-side">

            {{-- Notifikasi sukses --}}
            @if (session('status'))
                <div class="alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}" class="form-container">
                @csrf
                <h2>Atur Ulang Password</h2>

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <input type="email" name="email" placeholder="Email" 
                    value="{{ old('email', $request->email) }}" required autofocus>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror

                <input type="password" name="password" placeholder="Password Baru" required>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror

                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
                @error('password_confirmation')
                    <span class="error-message">{{ $message }}</span>
                @enderror

                <button type="submit">Reset Password</button>

                <p style="text-align:center; margin-top:1rem;">
                    Sudah ingat password? <a href="{{ route('login') }}">Login disini</a>
                </p>
            </form>
        </div>
    </div>
@endsection
