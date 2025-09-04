@extends('layouts.admin')

@section('content')
<div x-data="dashboardHandler()" class="space-y-8">
    {{-- Judul --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
        <p class="text-gray-500 mt-1">Ringkasan aktivitas permohonan magang.</p>
    </div>

    {{-- Cards --}}
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
                <p class="text-gray-500 text-sm font-medium">Diproses</p>
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

    {{-- Tabel --}}
    <div class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Permohonan Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-left text-gray-500">
                    <tr>
                        <th class="p-3 font-medium">No.</th>
                        <th class="p-3 font-medium">Nama</th>
                        <th class="p-3 font-medium">Sekolah</th>
                        <th class="p-3 font-medium">Divisi Penempatan</th>
                        <th class="p-3 font-medium">Status</th>
                        <th class="p-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentPermohonans as $p)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3 font-semibold text-gray-800">{{ $p->id }}</td>
                        <td class="p-3 font-semibold text-gray-800">{{ $p->nama }}</td>
                        <td class="p-3 text-gray-600">{{ $p->sekolah }}</td>
                        <td class="p-3 text-gray-600">{{ $p->divisi->nama_divisi ?? 'N/A' }}</td>
                        <td class="p-3">
                            @php
                            $statusClass = [
                            'SUBMITTED' => 'bg-yellow-100 text-yellow-800',
                            'APPROVED_ADMINISTRATION' => 'bg-blue-100 text-blue-800',
                            'DIVISION_REVIEW' => 'bg-blue-100 text-blue-800',
                            'PENDING_LETTER' => 'bg-indigo-100 text-indigo-800',
                            'SELESAI' => 'bg-green-100 text-green-800',
                            'REJECTED' => 'bg-red-100 text-red-800',
                            ];
                            $statusText = str_replace('_', ' ', Str::title($p->status));
                            @endphp
                            <span class="px-3 py-1 text-xs font-bold rounded-full {{ $statusClass[$p->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td class="p-3">
                            <button @click="openDetail({{ $p->toJson() }})"
                                class="text-blue-600 hover:underline font-semibold">
                                Detail
                            </button>
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

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Kuota per Divisi</h2>
            <div class="h-80">
                <canvas id="divisiChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Distribusi Status</h2>
            <div class="h-80">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Modal Detail - Desain Baru yang Elegan --}}
<div x-show="showModal" 
     x-cloak 
     class="fixed inset-0 z-50 flex items-center justify-center"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">

    <div class="absolute inset-0 bg-black bg-opacity-60" @click="closeModal()"></div>

    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl transform transition-all"
         x-show="showModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Detail Permohonan</h3>
                    <p class="text-sm text-gray-500 mt-1">Diajukan oleh <strong x-text="detail.nama"></strong></p>
                </div>
                <button @click="closeModal()" class="text-gray-400 hover:text-gray-600 rounded-full p-1 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fa fa-times fa-lg"></i>
                </button>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <div>
                <dl>
                    <dt class="text-sm font-medium text-gray-500">Status Permohonan</dt>
                    <dd class="mt-1">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full"
                              :class="{
                                'bg-green-100 text-green-800': detail.status === 'ACCEPTED',
                                'bg-yellow-100 text-yellow-800': detail.status === 'PENDING',
                                'bg-red-100 text-red-800': detail.status === 'REJECTED'
                              }"
                              x-text="detail.status">
                        </span>
                    </dd>
                </dl>

                <template x-if="detail.feedback">
                    <div class="mt-4 rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fa fa-times-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Feedback Penolakan</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p x-text="detail.feedback"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Sekolah/Universitas</dt>
                        <dd class="mt-1 text-base text-gray-900 font-semibold" x-text="detail.sekolah"></dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Jurusan</dt>
                        <dd class="mt-1 text-base text-gray-900 font-semibold" x-text="detail.jurusan"></dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Periode Awal</dt>
                        <dd class="mt-1 text-base text-gray-900 font-semibold" x-text="detail.periode_awal"></dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Periode Akhir</dt>
                        <dd class="mt-1 text-base text-gray-900 font-semibold" x-text="detail.periode_akhir"></dd>
                    </div>
                     <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Kontak (WA/Email)</dt>
                        <dd class="mt-1 text-base text-gray-900 font-semibold" x-text="detail.kontak"></dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Divisi yang Diajukan</dt>
                        <dd class="mt-1 text-base text-gray-900 font-semibold" x-text="detail.divisi?.nama_divisi ?? 'Belum ditentukan'"></dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 rounded-b-lg">
            <div class="flex justify-end items-center space-x-3">
                <template x-if="detail.image">
                    <a :href="'/storage/permohonan/' + detail.image" target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-sm font-semibold text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fa fa-file-alt mr-2"></i>
                        Lihat Dokumen
                    </a>
                </template>

                <template x-if="detail.status === 'ACCEPTED' && detail.surat_balasan">
                    <a :href="'/storage/' + detail.surat_balasan" target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent text-sm font-semibold text-white rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fa fa-download mr-2"></i>
                        Download Surat Balasan
                    </a>
                </template>

                <button @click="closeModal()" type="button" 
                    class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

</div>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('statusChart').getContext('2d');

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
                        '#FBBF24',
                        '#60A5FA',
                        '#4ADE80',
                        '#F87171',
                        '#818CF8',
                        '#A1A1AA'
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

        const ctxDivisi = document.getElementById('divisiChart').getContext('2d');
        const divisiData = @json($divisiChartData);
        const divisiLabels = divisiData.map(d => d.nama_divisi);
        const kebutuhanData = divisiData.map(d => d.kebutuhan_magang);
        const terisiData = divisiData.map(d => d.jumlah_magang);

        new Chart(ctxDivisi, {
            type: 'bar',
            data: {
                labels: divisiLabels,
                datasets: [{
                        label: 'Kebutuhan Magang',
                        data: kebutuhanData,
                        backgroundColor: '#E5E7EB',
                        borderColor: '#D1D5DB',
                        borderWidth: 1
                    },
                    {
                        label: 'Kuota Terisi',
                        data: terisiData,
                        backgroundColor: '#3B82F6',
                        borderColor: '#2563EB',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    });

    function dashboardHandler() {
        return {
            showModal: false,
            detail: {},

            openDetail(data) {
                this.detail = data;
                this.showModal = true;
            },
            closeModal() {
                this.showModal = false;
                this.detail = {};
            }
        }
    }
</script>
@endpush