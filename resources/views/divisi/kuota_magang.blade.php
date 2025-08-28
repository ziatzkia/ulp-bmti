@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold mb-6">Kebutuhan Peserta Magang per Divisi</h2>

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($divisis as $divisi)
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-2">{{ $divisi->nama_divisi }}</h3>
            <p class="text-gray-600">Jumlah kebutuhan saat ini:
                <span class="font-bold">{{ $divisi->kebutuhan_magang ?? 0 }}</span>
            </p>
            <button
                data-id="{{ $divisi->id }}"
                data-nama="{{ $divisi->nama_divisi }}"
                data-jumlah="{{ $divisi->kebutuhan_magang ?? 0 }}"
                class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 openModal">
                Atur Kebutuhan
            </button>
        </div>
        @endforeach
    </div>
</div>

{{-- Modal --}}
<div id="modalForm" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow max-w-md w-full">
        <h2 class="text-xl font-semibold mb-4">Atur Kebutuhan Divisi</h2>
        <form id="updateForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Divisi</label>
                <input type="text" id="divisiNama" class="w-full border rounded p-2 bg-gray-100" readonly>
            </div>
            <div class="mb-4">
                <label for="kebutuhan_magang" class="block text-sm font-medium text-gray-700">Jumlah Dibutuhkan</label>
                <input type="number" id="jumlahKebutuhan" name="kebutuhan_magang" min="1"
                    class="w-full border rounded p-2" required>

            </div>
            <div class="flex justify-end gap-2">
                <button type="button" id="closeModal" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

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