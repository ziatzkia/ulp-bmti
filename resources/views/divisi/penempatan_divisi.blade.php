@extends('layouts.admin')

@section('content')
    <div class="container mx-auto mt-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Penempatan Divisi</h1>
            <p class="text-gray-500 mt-2">Kelola peserta magang atau PKL yang dibutuhkan untuk di setiap divisi.</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-50 to-blue-100 text-gray-700 text-left">
                            <th class="p-3 border-b">No.</th>
                        <th class="p-3 border-b">Nama</th>
                        <th class="p-3 border-b">Sekolah</th>
                        <th class="p-3 border-b">Jurusan</th>
                        <th class="p-3 border-b">Contact Person</th>
                        <th class="p-3 border-b">Dokumen</th>
                        <th class="p-3 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permohonans as $p)
                        <tr class="hover:bg-gray-50 even:bg-gray-50/50 transition">
                            <td class="p-3 border-b">{{ $p->id }}</td>
                            <td class="p-3 border-b">{{ $p->nama }}</td>
                            <td class="p-3 border-b">{{ $p->sekolah }}</td>
                            <td class="p-3 border-b">{{ $p->jurusan }}</td>
                            <td class="p-3 border-b">{{ $p->kontak }}</td>
                            <td class="p-3 border-b text-center">
                                @if ($p->image)
                                    <a href="{{ asset('storage/permohonan/' . $p->image) }}" target="_blank"
                                        class="text-blue-600 font-medium hover:underline">Dokumen</a>
                                @else
                                    <span class="text-gray-400 italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="p-3 border-b text-center align-middle">
                                <form action="{{ route('divisi.penempatan.action', $p->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="place_division">

                                    <div class="flex items-center justify-center gap-2">
                                        <select name="divisi_id" required
                                            class="border border-gray-300 rounded-lg text-xs p-2 focus:ring focus:ring-blue-200 focus:border-blue-500">
                                            <option value="" disabled selected>-- Pilih Divisi --</option>
                                            @foreach ($divisis as $d)
                                                <option value="{{ $d->id }}">{{ $d->nama_divisi }}</option>
                                            @endforeach
                                        </select>

                                        <button type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-xs shadow transition">
                                            Tempatkan
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-500 italic">
                                Belum ada permohonan untuk divalidasi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
             @if ($permohonans->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $permohonans->onEachSide(1)->links('pagination::tailwind') }}
                    </div>
                @endif
        </div>
    </div>
@endsection
