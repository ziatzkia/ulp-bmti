@extends('layouts.user') 

@section('content')
    <!-- Hero Section -->
    <div class="hero" style="background: url('/images/BMTI.JPG') center/cover no-repeat;">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>SELAMAT DATANG</h1>
            <p>Unit Layanan Publik</p>
        </div>
    </div>

    <!-- Cards Section -->
    <div class="card-container">
        <div class="card">TOTAL PERMOHONAN DRAFT</div>
        <div class="card">TOTAL PERMOHONAN SELESAI</div>
        <div class="card">TOTAL PERMOHONAN DI TOLAK</div>
    </div>
@endsection
