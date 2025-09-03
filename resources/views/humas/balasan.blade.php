@extends('layouts.admin')

@section('content')
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-bold mb-6">Proses Surat Balasan</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        {{-- Menampilkan error validasi --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded overflow-hidden">
            <table class="w-full border text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">Sekolah</th>
                        <th class="p-2 border">Jurusan</th>
                        <th class="p-2 border">Dokumen Awal</th>
                        <th class="p-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permohonans as $p)
                        {{-- Inisialisasi state Alpine.js untuk setiap baris --}}
                        <tr class="hover:bg-gray-50" x-data="{ uploadModal: false }">
                            <td class="p-2 border">{{ $p->nama }}</td>
                            <td class="p-2 border">{{ $p->sekolah }}</td>
                            <td class="p-2 border">{{ $p->jurusan }}</td>
                            <td class="p-2 border text-center">
                                @if ($p->image)
                                    <a href="{{ asset('storage/' . $p->image) }}" target="_blank"
                                        class="text-blue-600 underline hover:text-blue-800">Lihat Dokumen</a>
                                @else
                                    <span class="text-gray-500">Tidak ada</span>
                                @endif
                            </td>
                            <td class="p-2 border text-center">
                                <button @click="uploadModal = true"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs shadow">
                                    ⬆️ Upload Surat
                                </button>

                                <div x-show="uploadModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                    <div class="bg-white p-6 rounded-lg shadow-xl w-1/3" @click.away="uploadModal = false">
                                        <h3 class="text-lg font-bold mb-4">Upload Surat Balasan</h3>
                                        <p class="mb-4 text-left">Upload surat balasan untuk <strong>{{ $p->nama }}</strong>. Permohonan akan ditandai sebagai 'Selesai'.</p>
                                        
                                        {{-- PENTING: enctype="multipart/form-data" untuk upload file --}}
                                        <form action="{{ route('humas.balasan.action', $p->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-4">
                                                <label for="surat_balasan_{{ $p->id }}" class="block mb-2 text-sm font-medium text-gray-900 text-left">Pilih file (PDF, DOC, DOCX):</label>
                                                <input type="file" name="surat_balasan" id="surat_balasan_{{ $p->id }}" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" required>
                                            </div>
                                            <div class="flex justify-end space-x-4">
                                                <button type="button" @click="uploadModal = false" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">Batal</button>
                                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Upload dan Selesaikan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">Belum ada permohonan yang perlu dikirim surat balasan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection