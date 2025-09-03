@extends('layouts.user')

@section('content')
    <div class="max-w-5xl mx-auto mt-8">

        @if (!$permohonan)
            <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
                <p class="font-semibold">Anda belum mengajukan permohonan.</p>
            </div>
        @else
            @php
                // (Blok @php Anda tidak perlu diubah, sudah bagus)
                $steps = 
                [ 
                    1 => 'Permohonan Diajukan', 
                    2 => 'Seleksi Administrasi', 
                    3 => 'Review oleh Divisi', 
                    4 => 'Proses Surat Balasan', 
                    5 => 'Selesai & Diterima'
                ];

                $statusMap = 
                [ 
                    'DRAFT' => 0, 
                    'SUBMITTED' => 1, 
                    'APPROVED_ADMINISTRATION' => 2, 
                    'DIVISION_REVIEW' => 3, 
                    'PENDING_LETTER' => 4, 
                    'ACCEPTED' => 5 
                ];

                $currentStep = $statusMap[$permohonan->status] ?? 0;

                $displayStatus = 
                [ 
                    'DRAFT' => ['text' => 'Draft', 'color' => 'gray'], 
                    'SUBMITTED' => ['text' => 'Sedang Diproses (Administrasi)', 'color' => 'yellow'], 
                    'APPROVED_ADMINISTRATION' => ['text' => 'Sedang Diproses (Review Divisi)', 'color' => 'yellow'], 
                    'APPROVED_ADMINISTRATION' => ['text' => 'Sedang Diproses (Review Divisi)', 'color' => 'yellow'], 
                    'PENDING_LETTER' => ['text' => 'Proses Final (Surat Balasan)', 'color' => 'blue'], 
                    'ACCEPTED' => ['text' => 'Diterima', 'color' => 'green'], 
                    'REJECTED' => ['text' => 'Ditolak', 'color' => 'red'], 
                    'CANCELLED' => ['text' => 'Dibatalkan', 'color' => 'gray'] 
                ];

                $statusInfo = $displayStatus[$permohonan->status] ?? ['text' => 'Tidak Diketahui', 'color' => 'gray'];
            @endphp
            
            {{-- Kotak notifikasi dipindahkan ke sini, di dalam wrapper utama --}}
            @if ($permohonan->status == 'REJECTED')
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-6 rounded-r-lg shadow-md mb-6" role="alert">
                    <p class="font-bold text-lg">Status Permohonan: {{ $statusInfo['text'] }}</p>
                    @if ($permohonan->feedback)
                        <p class="mt-2"><strong>Alasan:</strong> {{ $permohonan->feedback }}</p>
                    @endif
                </div>
            @elseif ($permohonan->status == 'ACCEPTED')
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-6 rounded-r-lg shadow-md mb-6" role="alert">
                    <p class="font-bold text-lg">Selamat! Permohonan Anda Telah Diterima.</p>
                    @if ($permohonan->surat_balasan)
                        <p class="mt-2">Silakan unduh surat balasan resmi melalui link di bawah ini.</p>
                        <a href="{{ asset('storage/' . $permohonan->surat_balasan) }}" target="_blank"
                            class="inline-block mt-3 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">
                            Download Surat Balasan
                        </a>
                    @endif
                </div>
            @endif

            <div class="relative flex flex-col md:flex-row gap-8 bg-white p-8 rounded-lg shadow-md">
                <div class="flex flex-col md:w-1/3">
                    {{-- (Kode timeline Anda tidak perlu diubah) --}}
                    @foreach ($steps as $num => $label)
                    <div class="flex items-start relative">
                        @if ($num != count($steps))
                        <div class="absolute top-5 left-5 -ml-px w-0.5 h-full @if($currentStep > $num) bg-blue-600 @else bg-gray-200 @endif"></div>
                        @endif
                        <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center font-bold z-10 transition-all duration-300 @if ($currentStep >= $num) bg-blue-600 text-white border-4 border-white shadow @else bg-gray-200 text-gray-500 border-4 border-white @endif">
                            @if ($currentStep > $num || $currentStep == 5)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @else
                            {{ $num }}
                            @endif
                        </div>
                        <div class="ml-4 pb-12">
                            <p class="font-semibold @if ($currentStep >= $num) text-gray-800 @else text-gray-400 @endif">
                                {{ $label }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="md:w-2/3 bg-gray-50 p-6 rounded-lg border">
                    {{-- (Kode detail permohonan Anda tidak perlu diubah) --}}
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Detail Permohonan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm text-gray-700">
                        <p><strong>Nama:</strong><br>{{ $permohonan->nama }}</p>
                        <p><strong>NIM:</strong><br>{{ $permohonan->nim }}</p>
                        <p><strong>Jurusan:</strong><br>{{ $permohonan->jurusan }}</p>
                        <p><strong>Periode:</strong><br>{{ \Carbon\Carbon::parse($permohonan->periode_awal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($permohonan->periode_akhir)->format('d M Y') }}</p>
                        <p><strong>Kontak:</strong><br>{{ $permohonan->kontak }}</p>
                        <p><strong>Dokumen:</strong><br>
                            @if ($permohonan->image)
                                <a href="{{ asset('storage/' . $permohonan->image) }}" target="_blank" class="text-blue-600 hover:underline font-medium">Lihat Dokumen</a>
                            @else
                                <span class="text-gray-500">Tidak ada</span>
                            @endif
                        </p>
                        <div class="md:col-span-2 mt-2 pt-4 border-t">
                            <p><strong>Status Saat Ini:</strong><br>
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-{{ $statusInfo['color'] }}-100 text-{{ $statusInfo['color'] }}-800">
                                    {{ $statusInfo['text'] }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection