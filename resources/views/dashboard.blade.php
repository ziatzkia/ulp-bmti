@extends('layouts.admin')

@section('content')
    <div class="space-y-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
            <p class="text-gray-500 mt-1">Ringkasan aktivitas permohonan magang.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-md flex items-center space-x-4">
                <div class="bg-indigo-100 p-3 rounded-full">
                    <i class="fa-solid fa-file-alt text-2xl text-indigo-600"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Permohonan</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['TOTAL'] }}</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md flex items-center space-x-4">
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fa-solid fa-clock text-2xl text-yellow-600"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Berkas yang Diproses</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['PROCESS'] }}</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md flex items-center space-x-4">
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fa-solid fa-check-circle text-2xl text-green-600"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Diterima</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['ACCEPTED'] }}</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md flex items-center space-x-4">
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fa-solid fa-times-circle text-2xl text-red-600"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Ditolak</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['REJECTED'] }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2 bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Permohonan Terbaru</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="p-3 font-medium">Nama</th>
                                <th class="p-3 font-medium">Sekolah</th>
                                <th class="p-3 font-medium">Tgl. Pengajuan</th>
                                <th class="p-3 font-medium">Divisi Penempatan</th>
                                <th class="p-3 font-medium">Status</th>
                                <th class="p-3 font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentPermohonans as $p)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="p-3 font-semibold text-gray-800">{{ $p->nama }}</td>
                                    <td class="p-3 text-gray-600">{{ $p->sekolah }}</td>
                                    <td class="p-3 text-gray-600">{{ $p->created_at->format('d M Y') }}</td>
                                    <td class="p-3 text-gray-600">
                                        {{-- Tampilkan nama divisi jika statusnya sudah ditempatkan/selesai --}}
                                        {{ $p->divisi->nama_divisi ?? 'N/A' }}
                                    </td>
                                    <td class="p-3">
                                        @php
                                            $statusClass = [
                                                'SUBMITTED' => 'bg-yellow-100 text-yellow-800', 'APPROVED_ADMINISTRATION' => 'bg-blue-100 text-blue-800',
                                                'DIVISION_REVIEW' => 'bg-blue-100 text-blue-800', 'PENDING_LETTER' => 'bg-indigo-100 text-indigo-800',
                                                'SELESAI' => 'bg-green-100 text-green-800', 'REJECTED' => 'bg-red-100 text-red-800',
                                            ];
                                            $statusText = str_replace('_', ' ', Str::title($p->status));
                                        @endphp
                                        <span class="px-3 py-1 text-xs font-bold rounded-full {{ $statusClass[$p->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <a href="#" class="text-blue-600 hover:underline font-semibold">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-gray-500">Belum ada data permohonan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Distribusi Status</h2>
                <div class="h-80">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('statusChart').getContext('2d');
        
        // Ambil data dari controller
        const statusData = @json($statusCounts);
        
        const labels = Object.keys(statusData);
        const data = Object.values(statusData);

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Permohonan',
                    data: data,
                    backgroundColor: [
                        '#FBBF24', // Yellow (SUBMITTED)
                        '#60A5FA', // Blue (APPROVED/REVIEW)
                        '#4ADE80', // Green (SELESAI)
                        '#F87171', // Red (REJECTED)
                        '#818CF8', // Indigo (PENDING_LETTER)
                        '#A1A1AA'  // Gray (Lainnya)
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    });
</script>
@endpush