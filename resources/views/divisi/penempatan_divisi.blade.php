@extends('layouts.admin')

@section('content')
    <div class="container mx-auto mt-8">
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
                            <td class="p-3 border-b">{{ $loop->iteration }}</td>
                            <td class="p-3 border-b font-medium">{{ $p->nama }}</td>
                            <td class="p-3 border-b">{{ $p->sekolah }}</td>
                            <td class="p-3 border-b">{{ $p->jurusan }}</td>
                            <td class="p-3 border-b">{{ $p->kontak }}</td>
                            <td class="p-3 border-b text-center">
                                @if ($p->image)
                                    <a href="{{ asset('storage/permohonan/' . $p->image) }}" target="_blank"
                                        class="text-blue-600 font-medium hover:underline flex items-center justify-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat
                                    </a>
                                @else
                                    <span class="text-gray-400 italic text-xs">Tidak ada</span>
                                @endif
                            </td>
                            <td class="p-3 border-b text-center align-middle">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button"
                                        onclick="openPlaceModal('{{ route('divisi.process.place', $p->id) }}', '{{ addslashes($p->nama) }}')"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs shadow">
                                        Tempatkan
                                    </button>

                                    <button type="button"
                                        onclick="openRejectModal('{{ route('divisi.process.reject', $p->id) }}', '{{ addslashes($p->nama) }}')"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-xs shadow">
                                        Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-500 italic">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 mb-2 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Belum ada permohonan untuk divalidasi
                                </div>
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

    {{-- MODAL TEMPATKAN --}}
    <div id="modalPlace" class="fixed inset-0 z-50 hidden flex items-center justify-center">
        <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeModal('modalPlace')"></div>
        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-md p-6 z-10">
            <h3 class="text-lg font-bold text-gray-800 mb-2">Tempatkan Peserta</h3>
            <p class="text-sm text-gray-600 mb-4">Peserta: <span id="placeName" class="font-bold text-blue-600"></span></p>

            <form id="formPlace" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Divisi</label>
                    <select name="divisi_id" required class="w-full border rounded-lg p-2 text-sm">
                        <option value="" disabled selected>-- Pilih Divisi --</option>
                        @foreach ($divisis as $d)
                            <option value="{{ $d->id }}">{{ $d->nama_divisi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('modalPlace')"
                        class="px-4 py-2 bg-gray-200 rounded text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL TOLAK --}}
    <div id="modalReject" class="fixed inset-0 z-50 hidden flex items-center justify-center">
        <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeModal('modalReject')"></div>
        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-md p-6 z-10">
            <h3 class="text-lg font-bold text-red-600 mb-2">Tolak Permohonan</h3>
            <p class="text-sm text-gray-600 mb-4">Peserta: <span id="rejectName" class="font-bold text-gray-800"></span></p>

            <form id="formReject" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                    <textarea name="alasan" id="alasan" rows="3" required class="w-full border rounded-lg p-2 text-sm"></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal('modalReject')"
                        class="px-4 py-2 bg-gray-200 rounded text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded text-sm">Tolak</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Parameter pertama sekarang adalah URL Full (String), bukan ID
        function openPlaceModal(fullUrl, name) {
            document.getElementById('placeName').textContent = name;

            // Langsung masukkan URL yang dikirim dari Blade ke action form
            document.getElementById('formPlace').action = fullUrl;

            document.getElementById('modalPlace').classList.remove('hidden');
        }

        function openRejectModal(fullUrl, name) {
            document.getElementById('rejectName').textContent = name;
            document.getElementById('alasan').value = '';

            // Langsung masukkan URL yang dikirim dari Blade ke action form
            document.getElementById('formReject').action = fullUrl;

            document.getElementById('modalReject').classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
@endsection
