@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8">
    {{-- Form Input Divisi --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <form action="{{ route('divisis.store') }}" method="POST">
            @csrf
            <div class="flex items-center gap-4">
                <label for="divisi" class="font-semibold">Nama Divisi:</label>
                <input type="text" id="divisi" name="nama_divisi"
                       class="w-1/2 px-3 py-2 border rounded-lg focus:ring focus:ring-blue-200"
                       placeholder="Masukkan nama divisi">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- Tabel Divisi --}}
    <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
        <table class="min-w-full table-auto border-collapse border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border border-gray-200">No</th>
                    <th class="px-4 py-2 border border-gray-200">Nama Divisi</th>
                    <th class="px-4 py-2 border border-gray-200">Jumlah Magang</th>
                    <th class="px-4 py-2 border border-gray-200">Kebutuhan Magang</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($divisis as $divisi)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">{{ $divisi->nama_divisi }}</td>
                        <td class="px-4 py-2 border text-center">{{ $divisi->jumlah_magang }}</td>
                        <td class="px-4 py-2 border text-center">{{ $divisi->kebutuhan_magang }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-4">Belum ada data divisi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
