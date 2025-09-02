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
        <table class="w-full border text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">Sekolah</th>
                    <th class="p-2 border">Jurusan</th>
                    <th class="p-2 border">Contact Person</th>
                    <th class="p-2 border">Dokumen</th>
                    <th class="p-2 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permohonans as $p)
                <tr class="hover:bg-gray-50">
                    <td class="p-2 border">{{ $p->nama }}</td>
                    <td class="p-2 border">{{ $p->sekolah }}</td>
                    <td class="p-2 border">{{ $p->jurusan }}</td>
                    <td class="p-2 border">{{ $p->kontak }}</td>
                    <td class="p-2 border text-center">
                        @if($p->image)
                            <a href="{{ asset('storage/permohonan/' . $p->image) }}" target="_blank" 
                               class="text-blue-600 underline hover:text-blue-800">Lihat Dokumen</a>
                        @else
                            <span class="text-gray-500">Tidak ada</span>
                        @endif
                    </td>
                    <td class="p-2 border text-center">
                        <!-- Tombol Terima & Tolak sejajar -->
                        <div class="flex justify-center space-x-2 mb-2">
                            <!-- Terima -->
                            <form action="{{ route('humas.validasi.action', $p->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="accept">
                                <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs shadow">
                                    ✅ Terima
                                </button>
                            </form>

                            <!-- Tolak -->
                            <button type="button" 
                                onclick="document.getElementById('reject-form-{{ $p->id }}').classList.toggle('hidden')" 
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs shadow">
                                ❌ Tolak
                            </button>
                        </div>

                        <!-- Form Tolak (muncul kalau tombol ditekan) -->
                        <form id="reject-form-{{ $p->id }}" 
                              action="{{ route('humas.validasi.action', $p->id) }}" 
                              method="POST" 
                              class="hidden mt-2">
                            @csrf
                            <input type="hidden" name="action" value="reject">
                            <textarea name="feedback" placeholder="Alasan penolakan" 
                                class="border rounded p-1 w-full mb-2 text-sm"></textarea>
                            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded shadow w-full text-sm">
                                Kirim Penolakan
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">Belum ada permohonan untuk divalidasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
