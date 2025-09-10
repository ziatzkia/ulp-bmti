@extends('layouts.admin')

@section('content')
<div class="p-6">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Kebutuhan Peserta Magang per Divisi</h1>
        <p class="text-gray-500 mt-2">Kelola jumlah kuota peserta magang atau PKL yang dibutuhkan di setiap divisi.</p>
        <p class="text-gray-500">Kuota akan otomatis berkurang setiap kali peserta diterima, dan dapat diatur kembali jika sudah terpenuhi.</p>
    </div>

    <!-- Notifikasi -->
    @if (session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <!-- Grid Divisi -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($divisis as $divisi)
            <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-100 hover:shadow-xl transition">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $divisi->nama_divisi }}</h3>
                <p class="text-gray-600">Jumlah kebutuhan saat ini:
                    <span class="font-bold text-blue-600">{{ $divisi->kebutuhan_magang ?? 0 }}</span>
                </p>
                <button data-id="{{ $divisi->id }}" data-nama="{{ $divisi->nama_divisi }}"
                    data-jumlah="{{ $divisi->kebutuhan_magang ?? 0 }}"
                    class="mt-4 w-full px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition openModal">
                    Atur Kebutuhan
                </button>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal -->
<div id="modalForm" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl shadow-lg max-w-md w-full transform transition-all scale-95">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Atur Kebutuhan Divisi</h2>
        <form id="updateForm" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Divisi</label>
                <input type="text" id="divisiNama" class="w-full border rounded-lg p-2 bg-gray-100" readonly>
            </div>

            <div class="mb-4">
                <label for="kebutuhan_magang" class="block text-sm font-medium text-gray-700">Jumlah Dibutuhkan</label>
                <input type="number" id="jumlahKebutuhan" name="kebutuhan_magang" min="1"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200" required>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" id="closeModal"
                    class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script -->
<script>
    const modal = document.getElementById('modalForm');
    const closeModal = document.getElementById('closeModal');
    const form = document.getElementById('updateForm');
    const divisiNama = document.getElementById('divisiNama');
    const jumlahKebutuhan = document.getElementById('jumlahKebutuhan');

    document.querySelectorAll('.openModal').forEach(button => {
        button.addEventListener('click', () => {
            let id = button.getAttribute('data-id');
            let nama = button.getAttribute('data-nama');
            let jumlah = button.getAttribute('data-jumlah');

            form.setAttribute('action', `/divisi/${id}/update-kebutuhan`);
            divisiNama.value = nama;
            jumlahKebutuhan.value = jumlah;

            modal.classList.remove('hidden');
        });
    });

    closeModal.addEventListener('click', () => {
        modal.classList.add('hidden');
    });
</script>
@endsection
