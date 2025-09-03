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
                {{-- Setiap baris tabel memiliki state modalnya sendiri --}}
                <tr class="hover:bg-gray-50" x-data="{ acceptModal: false, rejectModal: false }">
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
                        <div class="flex justify-center space-x-2">
                            <button @click="acceptModal = true" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs shadow">
                                ✅ Terima
                            </button>

                            <button @click="rejectModal = true" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs shadow">
                                ❌ Tolak
                            </button>
                        </div>

                        <div x-show="acceptModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                            <div class="bg-white p-6 rounded-lg shadow-xl" @click.away="acceptModal = false">
                                <h3 class="text-lg font-bold mb-4">Konfirmasi Penerimaan</h3>
                                <p class="mb-4">Anda yakin ingin menerima permohonan dari <strong>{{ $p->nama }}</strong>?</p>
                                <form id="accept-form-{{ $p->id }}" action="{{ route('humas.validasi.action', $p->id) }}" method="POST" class="hidden">
                                    @csrf
                                    <input type="hidden" name="action" value="accept">
                                </form>
                                <div class="flex justify-end space-x-4">
                                    <button @click="acceptModal = false" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">Batal</button>
                                    {{-- Tombol ini men-submit form yang tersembunyi --}}
                                    <button onclick="document.getElementById('accept-form-{{ $p->id }}').submit()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Ya, Terima</button>
                                </div>
                            </div>
                        </div>

                        <div x-show="rejectModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                            <div class="bg-white p-6 rounded-lg shadow-xl w-1/3" @click.away="rejectModal = false">
                                <h3 class="text-lg font-bold mb-4">Tolak Permohonan</h3>
                                <p class="mb-4">Berikan alasan penolakan untuk permohonan dari <strong>{{ $p->nama }}</strong>:</p>
                                <form action="{{ route('humas.validasi.action', $p->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="reject">
                                    <textarea name="feedback" placeholder="Contoh: Dokumen kurang lengkap..." required class="border rounded p-2 w-full mb-4 text-sm"></textarea>
                                    <div class="flex justify-end space-x-4">
                                        <button type="button" @click="rejectModal = false" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">Batal</button>
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Kirim Penolakan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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