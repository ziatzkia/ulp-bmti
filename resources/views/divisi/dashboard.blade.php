@extends('layouts.admin')

@section('content')
<div class="p-6">
    {{-- <h2 class="text-2xl font-semibold mb-6">Form Permintaan Jurusan</h2> --}}
    <div class="bg-white p-6 rounded-lg shadow max-w-3xl mb-8">
        <form>
            <div class="mb-4">
                <label for="jurusan" class="block text-sm font-medium text-gray-700">Divisi</label>
                <select id="jurusan" name="jurusan" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Pilih Divisi --</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                    <option value="Teknik Mesin">Teknik Mesin</option>
                    <option value="Teknik Elektro">Teknik Elektro</option>
                    <option value="Teknik Otomotif">Teknik Otomotif</option>
                    <option value="Akuntansi">Akuntansi</option>
                    <option value="Administrasi Perkantoran">Administrasi Perkantoran</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Dibutuhkan</label>
                <input type="number" id="jumlah" name="jumlah" min="1" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                    placeholder="Masukkan jumlah kebutuhan">
            </div>

            {{-- Tombol Kirim --}}
            <div class="flex justify-end">
                <button type="button" 
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Kirim
                </button>
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <h2 class="text-2xl font-semibold mb-4">Data Magang</h2>
    <div class="bg-white p-6 rounded-lg shadow overflow-x-auto">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Jurusan</th>
                    <th class="px-4 py-2 border">Asal Sekolah</th>
                    <th class="px-4 py-2 border">Periode</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-4 py-2 border">Alika</td>
                    <td class="px-4 py-2 border">Teknik Informatika</td>
                    <td class="px-4 py-2 border">SMK Negeri 1 Cimahi</td>
                    <td class="px-4 py-2 border">2025/2026</td>
                    <td class="px-4 py-2 border flex gap-2">
                        <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">Diterima</button>
                        <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Ditolak</button>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2 border">ANita</td>
                    <td class="px-4 py-2 border">Teknik Mesin</td>
                    <td class="px-4 py-2 border">SMK Negeri 2 Bandung</td>
                    <td class="px-4 py-2 border">2025/2026</td>
                    <td class="px-4 py-2 border flex gap-2">
                        <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">Diterima</button>
                        <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Ditolak</button>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2 border">Adina</td>
                    <td class="px-4 py-2 border">Akuntansi</td>
                    <td class="px-4 py-2 border">SMK Negeri 3 Garut</td>
                    <td class="px-4 py-2 border">2025/2026</td>
                    <td class="px-4 py-2 border flex gap-2">
                        <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">Diterima</button>
                        <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Ditolak</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
