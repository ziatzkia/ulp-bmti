@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-6">Daftar Permohonan</h2>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full table-auto border-collapse border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border border-gray-200">No</th>
                    <th class="px-4 py-2 border border-gray-200">Nama</th>
                    <th class="px-4 py-2 border border-gray-200">NIM</th>
                    <th class="px-4 py-2 border border-gray-200">Jurusan</th>
                    <th class="px-4 py-2 border border-gray-200">Periode</th>
                    <th class="px-4 py-2 border border-gray-200">Kontak</th>
                    <th class="px-4 py-2 border border-gray-200">Dokumen</th>
                    <th class="px-4 py-2 border border-gray-200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permohonans ?? [] as $index => $permohonan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border border-gray-200">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $permohonan->nama ?? '-' }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $permohonan->nim ?? '-' }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $permohonan->jurusan ?? '-' }}</td>
                        <td class="px-4 py-2 border border-gray-200">
                            {{ $permohonan->periode_awal ?? '-' }} - {{ $permohonan->periode_akhir ?? '-' }}
                        </td>
                        <td class="px-4 py-2 border border-gray-200">{{ $permohonan->kontak ?? '-' }}</td>
                        <td class="px-4 py-2 border border-gray-200 text-center">
                            @if(!empty($permohonan->image))
                                <a href="{{ asset('storage/permohonan/' . $permohonan->image) }}" 
                                   target="_blank" 
                                   class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                   Download
                                </a>
                            @else
                                <span class="text-gray-400">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 border border-gray-200 text-center space-x-2">
                            <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Tracking</button>
                            <button class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Kirim Email</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">
                            Belum ada data permohonan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
