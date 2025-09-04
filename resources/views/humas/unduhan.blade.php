@extends('layouts.admin')

@section('content')
<div class.blade.php" container mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="pageController()">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Unduh Surat Balasan</h1>
        <p class="text-gray-500 mt-1">Generate surat balasan untuk permohonan yang telah diterima.</p>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow" role="alert">
            <p class="font-bold">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Dokumen Permohonan</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($permohonans as $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $p->nama }}</div>
                                <div class="text-sm text-gray-500">{{ $p->sekolah }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $p->jurusan }}</div>
                                <div class="text-sm text-gray-500">{{ $p->kontak }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($p->image)
                                    <a href="{{ asset('storage/permohonan/' . $p->image) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 inline-flex items-center text-sm">
                                        <i class="fas fa-file-alt mr-1"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <button @click="openConfirmModal({{ json_encode($p) }})" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <i class="fas fa-file-download mr-2"></i> Buat Surat
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center px-6 py-12">
                                <div class="text-center">
                                    <i class="fas fa-inbox fa-3x text-gray-300"></i>
                                    <p class="mt-4 text-sm font-medium text-gray-600">Tidak ada permohonan yang siap dibuatkan surat balasan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="confirmModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-black bg-opacity-60" @click="closeModal()"></div>
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md transform transition-all"
             x-show="confirmModalOpen" @click.away="closeModal()"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <div class="p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-file-signature text-indigo-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Konfirmasi Pembuatan Surat</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Anda akan membuat surat balasan untuk <strong x-text="selectedPermohonan ? selectedPermohonan.nama : ''"></strong>. Lanjutkan?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg">
                <form :action="formActionUrl" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="accept">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">
                        Ya, Buat Surat
                    </button>
                </form>
                <button @click="closeModal()" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function pageController() {
        return {
            confirmModalOpen: false,
            selectedPermohonan: null,
            formActionUrl: '',

            openConfirmModal(permohonan) {
                this.selectedPermohonan = permohonan;
                this.updateActionUrl();
                this.confirmModalOpen = true;
            },

            closeModal() {
                this.confirmModalOpen = false;
                setTimeout(() => { this.selectedPermohonan = null; }, 300); 
            },

            updateActionUrl() {
                if (this.selectedPermohonan) {
                    // Membuat URL action form secara dinamis
                    this.formActionUrl = `{{ url('humas/unduhan') }}/${this.selectedPermohonan.id}/action`;
                }
            }
        };
    }
</script>
@endpush