@extends('layouts.user')

@section('content')
    <div class="max-w-5xl mx-auto mt-8">

        @if (!$permohonan)
            <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
                <p class="font-semibold">Anda belum mengajukan permohonan.</p>
            </div>
        @else
            @php
                // 1. Definisikan label untuk setiap langkah di timeline
                $steps = [
                    1 => 'Permohonan Diajukan',
                    2 => 'Seleksi Administrasi',
                    3 => 'Review oleh Divisi',
                    4 => 'Menunggu Surat Balasan',
                    5 => 'Diterima',
                ];

                // 2. Petakan setiap status ke nomor langkah yang sesuai
                $statusMap = [
                    'DRAFT' => 0,
                    'SUBMITTED' => 1,
                    'APPROVED_ADMINISTRATION' => 2,
                    'DIVISION_REVIEW' => 3,
                    'PENDING_LETTER' => 4,
                    'ACCEPTED' => 5,
                ];

                // 3. Tentukan langkah saat ini berdasarkan status permohonan
                $currentStep = $statusMap[$permohonan->status] ?? 0;

                // 4. Definisikan teks status yang lebih ramah untuk ditampilkan
                $displayStatus = [
                    'DRAFT' => ['text' => 'Draft', 'color' => 'gray'],
                    'SUBMITTED' => ['text' => 'Sedang Diproses (Administrasi)', 'color' => 'yellow'],
                    'APPROVED_ADMINISTRATION' => ['text' => 'Sedang Diproses (Review Divisi)', 'color' => 'yellow'],
                    'DIVISION_REVIEW' => ['text' => 'Sedang Diproses (Review Divisi)', 'color' => 'yellow'],
                    'PENDING_LETTER' => ['text' => 'Proses Final (Surat Balasan)', 'color' => 'blue'],
                    'ACCEPTED' => ['text' => 'Diterima', 'color' => 'green'],
                    'REJECTED' => ['text' => 'Ditolak', 'color' => 'red'],
                    'CANCELLED' => ['text' => 'Dibatalkan', 'color' => 'gray'],
                ];
                $statusInfo = $displayStatus[$permohonan->status] ?? ['text' => 'Tidak Diketahui', 'color' => 'gray'];
            @endphp

            <!-- Tampilan khusus jika Ditolak atau Dibatalkan -->
            @if ($permohonan->status == 'REJECTED' || $permohonan->status == 'CANCELLED')
                <div class="bg-{{ $statusInfo['color'] }}-50 border-l-4 border-{{ $statusInfo['color'] }}-500 text-{{ $statusInfo['color'] }}-700 p-6 rounded-r-lg shadow-md mb-6"
                    role="alert">
                    <p class="font-bold text-lg">Status Permohonan: {{ $statusInfo['text'] }}</p>
                    @if ($permohonan->status == 'REJECTED' && $permohonan->feedback)
                        <p class="mt-2"><strong>Alasan:</strong> {{ $permohonan->feedback }}</p>
                    @endif
                </div>
            @endif

            <div class="relative flex flex-col md:flex-row gap-8 bg-white p-8 rounded-lg shadow-md">
                <!-- Timeline (dibalik urutannya agar dari atas ke bawah: 1, 2, 3, ...) -->
                <div class="flex flex-col md:w-1/3">
                    @foreach ($steps as $num => $label)
                        <div class="flex items-start relative">
                            <!-- Garis vertikal penghubung -->
                            @if ($num != count($steps))
                                <div class="absolute top-5 left-5 -ml-px w-0.5 h-full bg-gray-200"></div>
                            @endif

                            <!-- Lingkaran Angka -->
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center font-bold z-10 transition-all duration-300
                        @if ($currentStep >= $num) bg-blue-600 text-white border-4 border-white shadow
                        @else bg-gray-200 text-gray-500 border-4 border-white @endif">
                                {{-- Icon centang jika sudah selesai --}}
                                @if ($currentStep > $num || $currentStep == 5)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @else
                                    {{ $num }}
                                @endif
                            </div>

                            <!-- Label -->
                            <div class="ml-4 pb-12">
                                <p
                                    class="font-semibold
                            @if ($currentStep >= $num) text-gray-800 @else text-gray-400 @endif">
                                    {{ $label }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Detail Permohonan -->
                <div class="md:w-2/3 bg-gray-50 p-6 rounded-lg border">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Detail Permohonan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm text-gray-700">
                        <p><strong>Nama:</strong><br>{{ $permohonan->nama }}</p>
                        <p><strong>NIM:</strong><br>{{ $permohonan->nim }}</p>
                        <p><strong>Jurusan:</strong><br>{{ $permohonan->jurusan }}</p>
                        <p><strong>Periode:</strong><br>{{ \Carbon\Carbon::parse($permohonan->periode_awal)->format('d M Y') }}
                            - {{ \Carbon\Carbon::parse($permohonan->periode_akhir)->format('d M Y') }}</p>
                        <p><strong>Kontak:</strong><br>{{ $permohonan->kontak }}</p>
                        <p><strong>Dokumen:</strong><br>
                            @if ($permohonan->image)
                                <a href="{{ asset('storage/permohonan/' . $permohonan->image) }}" target="_blank"
                                    class="text-blue-600 hover:underline font-medium">Lihat Dokumen</a>
                            @else
                                <span class="text-gray-500">Tidak ada</span>
                            @endif
                        </p>
                        <div class="md:col-span-2 mt-2 pt-4 border-t">
                            <p><strong>Status Saat Ini:</strong><br>
                                <span
                                    class="px-3 py-1 text-xs font-bold rounded-full
                                bg-{{ $statusInfo['color'] }}-100 text-{{ $statusInfo['color'] }}-800">
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
