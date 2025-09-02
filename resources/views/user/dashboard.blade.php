@extends('layouts.user')

@section('content')
    <!-- Hero Section -->
    <div class="relative">
        <div class="hero h-[400px]" style="background: url('/images/BMTI.JPG') center/cover no-repeat;">
            <div class="absolute inset-0 bg-black/40 flex flex-col justify-center items-center text-center text-white">
                <h1 class="text-4xl md:text-5xl font-bold drop-shadow-lg">SELAMAT DATANG</h1>
                <p class="text-lg md:text-xl mt-2">Unit Layanan Publik</p>
            </div>
        </div>
    </div>

    <!-- Statistik Section -->
    <div class="max-w-7xl mx-auto px-6 -mt-10 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center border-t-4 border-blue-500">
                <h3 class="text-gray-500 text-sm uppercase tracking-wide">Total Permohonan Draft</h3>
                <p class="text-3xl font-bold text-blue-600 mt-2">120</p>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center border-t-4 border-green-500">
                <h3 class="text-gray-500 text-sm uppercase tracking-wide">Total Permohonan Selesai</h3>
                <p class="text-3xl font-bold text-green-600 mt-2">85</p>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center border-t-4 border-red-500">
                <h3 class="text-gray-500 text-sm uppercase tracking-wide">Total Permohonan Ditolak</h3>
                <p class="text-3xl font-bold text-red-600 mt-2">15</p>
            </div>
        </div>
    </div>

    <!-- Informasi Divisi Section -->
    <div class="max-w-7xl mx-auto px-6 mt-12">
        <div class="flex flex-col items-center mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Informasi Ketersediaan Divisi Magang</h2>
            <p class="text-gray-500 mt-2 text-center">Cek jumlah ketersediaan magang di setiap divisi secara real-time</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($divisis as $divisi)
                <div class="p-6 rounded-2xl shadow-lg border flex flex-col justify-between min-h-[230px]
                    @if($divisi->jumlah_magang >= $divisi->kebutuhan_magang) border-red-500 bg-red-50 
                    @else border-green-500 bg-white @endif">

                    <!-- Judul -->
                    <h3 class="text-lg font-bold text-gray-800 mb-4 text-center line-clamp-2">
                        {{ $divisi->nama_divisi }}
                    </h3>

                    <!-- Isi -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Jumlah Terisi</span>
                            <span class="font-semibold text-gray-900">{{ $divisi->jumlah_magang }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Kebutuhan</span>
                            <span class="font-semibold text-gray-900">{{ $divisi->kebutuhan_magang }}</span>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mt-4 text-center">
                        @if($divisi->jumlah_magang >= $divisi->kebutuhan_magang)
                            <p class="text-sm font-bold text-red-600">Penuh</p>
                        @else
                            <p class="text-sm font-bold text-green-600">Tersedia</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-6 text-gray-500">
                    Belum ada data divisi
                </div>
            @endforelse
        </div>
    </div>
@endsection
