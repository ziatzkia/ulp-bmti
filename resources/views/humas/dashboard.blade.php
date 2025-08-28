@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8">


    {{-- Input Nama Divisi --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <form>
            <div class="flex items-center gap-4">
                <label for="divisi" class="font-semibold">Nama Divisi:</label>
                <input type="text" id="divisi" name="divisi"
                       class="w-1/2 px-3 py-2 border rounded-lg focus:ring focus:ring-blue-200"
                       placeholder="Masukkan nama divisi">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- Tabel Dummy --}}
    <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
        <table class="min-w-full table-auto border-collapse border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border border-gray-200">No</th>
                    <th class="px-4 py-2 border border-gray-200">Nama Divisi</th>
                    <th class="px-4 py-2 border border-gray-200">Kebutuhan Magang</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">1</td>
                    <td class="px-4 py-2 border">Divisi IT</td>
                    <td class="px-4 py-2 border text-center">5 Orang</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">2</td>
                    <td class="px-4 py-2 border">Divisi Keuangan</td>
                    <td class="px-4 py-2 border text-center">3 Orang</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">3</td>
                    <td class="px-4 py-2 border">Divisi HRD</td>
                    <td class="px-4 py-2 border text-center">4 Orang</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Chart Dummy --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-4">Kebutuhan Magang per Divisi</h3>
        <canvas id="chartDivisi" height="120"></canvas>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartDivisi');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Divisi IT', 'Keuangan', 'HRD'],
            datasets: [{
                label: 'Jumlah Anak Magang',
                data: [5, 3, 4],
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
