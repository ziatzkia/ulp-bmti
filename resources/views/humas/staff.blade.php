@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8">

    {{-- <h2 class="text-2xl font-bold mb-6">Halaman Staff</h2> --}}

    {{-- Tabel Dummy --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full table-auto border-collapse border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border border-gray-200">No</th>
                    <th class="px-4 py-2 border border-gray-200">Nama</th>
                    <th class="px-4 py-2 border border-gray-200">Jurusan</th>
                    <th class="px-4 py-2 border border-gray-200">Periode</th>
                    <th class="px-4 py-2 border border-gray-200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= 3; $i++)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $i }}</td>
                    <td class="px-4 py-2 border">Nama {{ $i }}</td>
                    <td class="px-4 py-2 border">Teknik Informatika</td>
                    <td class="px-4 py-2 border">Jan - Mar 2025</td>
                    <td class="px-4 py-2 border text-center space-x-2">
                        {{-- Upload Surat Balasan --}}
                        <label class="inline-block">
                            <input type="file" class="hidden" />
                            <span class="bg-green-500 text-white px-3 py-1 rounded cursor-pointer hover:bg-green-600">
                                Upload Balasan
                            </span>
                        </label>

                        {{-- Tracking --}}
                        <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                            Tracking
                        </button>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
@endsection
