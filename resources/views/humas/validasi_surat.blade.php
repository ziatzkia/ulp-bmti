@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-6">Validasi Surat Permohonan</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">NIM</th>
                    <th class="p-2 border">Jurusan</th>
                    <th class="p-2 border">Dokumen</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permohonans as $p)
                <tr>
                    <td class="p-2 border">{{ $p->nama }}</td>
                    <td class="p-2 border">{{ $p->nim }}</td>
                    <td class="p-2 border">{{ $p->jurusan }}</td>
                    <td class="p-2 border">
                        @if($p->image)
                            <a href="{{ asset('storage/permohonan/' . $p->image) }}" target="_blank" class="text-blue-600 underline">Lihat Dokumen</a>
                        @else
                            Tidak ada
                        @endif
                    </td>
                    <td class="p-2 border">
                        <form action="{{ route('humas.validasi.action', $p->id) }}" method="POST" class="flex space-x-2">
                            @csrf
                            <input type="hidden" name="action" value="accept">
                            <button class="bg-green-600 text-white px-3 py-1 rounded">Terima</button>
                        </form>
                        <form action="{{ route('humas.validasi.action', $p->id) }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="action" value="reject">
                            <textarea name="feedback" placeholder="Alasan penolakan" class="border rounded p-1 w-full mb-1"></textarea>
                            <button class="bg-red-600 text-white px-3 py-1 rounded">Tolak</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">Belum ada permohonan untuk divalidasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
