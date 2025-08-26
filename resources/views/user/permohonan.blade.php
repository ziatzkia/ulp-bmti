@extends('layouts.user')

@section('content')
    <div x-data="permohonanHandler()" class="max-w-5xl mx-auto mt-8">

        {{-- Tombol tambah --}}
        <div class="flex justify-end mb-4">
            <button @click="openModal()"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                <i class="fa fa-plus mr-2"></i> Tambah
            </button>
        </div>

        {{-- Tabel List Permohonan --}}
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full border">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-2 border">No</th>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">NIM</th>
                        <th class="p-2 border">Jurusan</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data dari Database --}}
                    @forelse ($permohonans as $index => $p)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border">{{ $index + 1 }}</td>
                            <td class="p-2 border">{{ $p->nama }}</td>
                            <td class="p-2 border">{{ $p->nim }}</td>
                            <td class="p-2 border">{{ $p->jurusan }}</td>
                            <td class="p-2 border">
                                <span
                                    class="px-2 py-1 rounded text-xs
                                {{ $p->status == 'draft'
                                    ? 'bg-yellow-100 text-yellow-700'
                                    : ($p->status == 'selesai'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-red-100 text-red-700') }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="p-2 border">
                                <form action="{{ route('permohonan.destroy', $p->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus permohonan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="px-2 py-1 bg-red-500 text-white rounded text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">Belum ada permohonan</td>
                        </tr>
                    @endforelse

                    {{-- Data Draft Sementara (AlpineJS) --}}
                    <template x-for="(d, i) in drafts" :key="i">
                        <tr class="bg-yellow-50">
                            <td class="p-2 border" x-text="`D${i+1}`"></td>
                            <td class="p-2 border" x-text="d.nama"></td>
                            <td class="p-2 border" x-text="d.nim"></td>
                            <td class="p-2 border" x-text="d.jurusan"></td>
                            <td class="p-2 border">
                                <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-700">Draft</span>
                            </td>
                            <td class="p-2 border flex space-x-2">
                                <button @click="editLocalDraft(i)"
                                    class="px-2 py-1 bg-blue-500 text-white rounded text-sm">Edit</button>
                                <button @click="deleteLocalDraft(i)"
                                    class="px-2 py-1 bg-red-500 text-white rounded text-sm">Hapus</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        {{-- Modal --}}
        <div x-show="open" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center"
            @keydown.escape.window="closeModal()">
            <div class="absolute inset-0 bg-black bg-opacity-50" @click="closeModal()"></div>

            <div class="relative bg-white w-full max-w-2xl rounded-2xl shadow-xl p-6 z-[10000]" @click.away="closeModal()">
                <button @click="closeModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                    <i class="fa fa-times"></i>
                </button>

                <form :action="editingId ? `/permohonan/${editingId}` : '{{ route('permohonan.store') }}'" method="POST"
                    enctype="multipart/form-data" x-ref="mainForm">
                    @csrf
                    <template x-if="editingId">
                        @method('PUT')
                    </template>

                    <div class="space-y-4">
                        <div>
                            <label>Nama</label>
                            <input type="text" name="nama" x-model="formData.nama" required
                                class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label>NIM</label>
                            <input type="text" name="nim" x-model="formData.nim" required
                                class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label>Jurusan</label>
                            <input type="text" name="jurusan" x-model="formData.jurusan" required
                                class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label>Sekolah</label>
                            <input type="text" name="sekolah" x-model="formData.sekolah" required
                                class="w-full border rounded-lg px-3 py-2">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label>Periode Awal</label>
                                <input type="date" name="periode_awal" x-model="formData.periode_awal" required
                                    class="w-full border rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label>Periode Akhir</label>
                                <input type="date" name="periode_akhir" x-model="formData.periode_akhir" required
                                    class="w-full border rounded-lg px-3 py-2">
                            </div>
                        </div>
                        <div>
                            <label>Kontak</label>
                            <input type="text" name="kontak" x-model="formData.kontak" required
                                class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label>Dokumen (PDF)</label>
                            <input type="file" name="image" @change="handleFile($event)" accept="application/pdf"
                                class="w-full border rounded-lg px-3 py-2">
                        </div>
                    </div>

                    <div class="flex justify-between mt-6">
                        {{-- Simpan hanya ke draft lokal --}}
                        <button type="button" @click="saveLocalDraft()"
                            class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                            Simpan Draft
                        </button>
                        {{-- Submit ke database --}}
                        <button type="submit" @click="formData.status='selesai'"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Yakin & Simpan
                        </button>
                    </div>

                    <input type="hidden" name="status" :value="formData.status">
                </form>
            </div>
        </div>
    </div>

    <script>
        function permohonanHandler() {
            return {
                open: false,
                editingId: null,
                editingDraftIndex: null,
                drafts: [],

                formData: {
                    nama: '',
                    nim: '',
                    jurusan: '',
                    sekolah: '',
                    periode_awal: '',
                    periode_akhir: '',
                    kontak: '',
                    imageName: '',
                    status: 'draft'
                },

                openModal() {
                    this.editingId = null;
                    this.editingDraftIndex = null;
                    this.formData = {
                        nama: '',
                        nim: '',
                        jurusan: '',
                        periode_awal: '',
                        periode_akhir: '',
                        kontak: '',
                        imageName: '',
                        status: 'draft'
                    };
                    this.open = true;
                },
                closeModal() {
                    this.open = false;
                },

                handleFile(event) {
                    const f = event.target.files[0];
                    if (f && f.type === 'application/pdf') {
                        this.formData.imageName = f.name;
                    } else {
                        alert('Hanya file PDF yang diperbolehkan.');
                        event.target.value = '';
                    }
                },

                saveLocalDraft() {
                    if (this.editingDraftIndex !== null) {
                        this.drafts[this.editingDraftIndex] = {
                            ...this.formData
                        };
                    } else {
                        this.drafts.push({
                            ...this.formData
                        });
                    }
                    this.closeModal();
                },

                editLocalDraft(i) {
                    this.editingDraftIndex = i;
                    this.editingId = null;
                    this.formData = {
                        ...this.drafts[i]
                    };
                    this.open = true;
                },

                deleteLocalDraft(i) {
                    this.drafts.splice(i, 1);
                }
            }
        }
    </script>
@endsection
