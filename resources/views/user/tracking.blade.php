@extends('layouts.user')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-3xl font-bold mb-8 text-center text-blue-700">Tracking Permohonan</h2>

    @if(!$permohonan)
        <div class="bg-white p-6 rounded shadow text-center text-gray-500">
            Belum ada pengajuan
        </div>
    @else
        @php
            $steps = [
                1 => 'Pengajuan Permohonan',
                2 => 'Operator Surat',
                3 => 'Penanggung Jawab Humas',
                4 => 'Staff Hubungan Masyarakat',
                5 => 'Selesai',
            ];
            $currentJenjang = $permohonan->jenjang ?? 1;
        @endphp

        <div class="relative flex flex-col md:flex-row gap-8 bg-white p-6 rounded shadow">
            <!-- Timeline Vertikal -->
            <div class="relative flex flex-col items-center md:items-start md:w-1/4">
                @foreach(array_reverse($steps, true) as $num => $label)
                    <div class="flex items-center mb-8 relative">
                        <!-- Garis vertikal -->
                        @if($num != 1)
                        <div class="absolute left-1/2 transform -translate-x-1/2 h-full border-l-4 border-gray-300 z-0"></div>
                        @endif

                        <!-- Lingkaran step -->
                        <div class="w-12 h-12 rounded-full flex items-center justify-center z-10
                            @if($currentJenjang >= $num) bg-blue-600 text-white border-2 border-blue-700 @else bg-gray-300 text-gray-600 border-2 border-gray-400 @endif">
                            {{ $num }}
                        </div>

                        <!-- Label step -->
                        <div class="ml-4 max-w-xs">
                            <p class="font-semibold @if($currentJenjang >= $num) text-blue-600 @else text-gray-500 @endif">
                                {{ $label }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Detail Permohonan -->
            <div class="md:w-3/4 bg-gray-50 p-6 rounded shadow-inner">
                <h3 class="text-xl font-bold mb-4 text-blue-700">Detail Permohonan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                    <p><strong>Nama:</strong> {{ $permohonan->nama }}</p>
                    <p><strong>NIM:</strong> {{ $permohonan->nim }}</p>
                    <p><strong>Jurusan:</strong> {{ $permohonan->jurusan }}</p>
                    <p><strong>Periode:</strong> {{ $permohonan->periode_awal }} - {{ $permohonan->periode_akhir }}</p>
                    <p><strong>Kontak:</strong> {{ $permohonan->kontak }}</p>
                    <p><strong>Dokumen:</strong>
                        @if($permohonan->image)
                            <a href="{{ asset('storage/permohonan/' . $permohonan->image) }}" target="_blank" class="text-blue-600 underline">Download</a>
                        @else
                            Tidak ada
                        @endif
                    </p>
                    <p><strong>Status Validasi:</strong>
                        @if($currentJenjang >= 5)
                            <span class="text-green-600 font-semibold">Selesai</span>
                        @else
                            <span class="text-yellow-600 font-semibold">Proses</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    @media (max-width: 768px) {
        .relative.flex.flex-col.md\\:flex-row {
            flex-direction: column;
        }
    }
</style>
@endsection
