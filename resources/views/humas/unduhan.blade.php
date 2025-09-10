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
                        
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
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
                            <div class="text-sm font-medium text-gray-900">{{ $p->id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $p->nama }}</div>
                        </td>
                         <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $p->jurusan }}</div>
                            <div class="text-sm font-medium text-gray-900">{{ $p->sekolah }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($p->image)
                            <a href="{{ asset('storage/permohonan/' . $p->image) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 inline-flex items-center text-sm">
                                <i class="fas fa-file-alt mr-1"></i> Download
                            </a>
                            @else
                            <span class="text-sm text-gray-400">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex justify-center items-center space-x-3">
                                <button @click="openConfirmModal({{ json_encode($p) }})"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent 
                   text-xs font-medium rounded-md shadow-sm text-white 
                   bg-green-600 hover:bg-green-700 focus:outline-none">
                                    <i class="fas fa-check mr-1"></i> Confirm
                                </button>
                            </div>
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
             @if ($permohonans->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $permohonans->onEachSide(1)->links('pagination::tailwind') }}
            </div>
            @endif
        </div>
    </div>

    <div x-show="confirmModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black bg-opacity-60" @click="closeModal()"></div>
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md transform transition-all"
        x-show="confirmModalOpen" @click.away="closeModal()">

        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900">Konfirmasi</h3>
            <p class="text-sm text-gray-500 mt-2">
                Yakin ingin meneruskan permohonan
                <strong x-text="selectedPermohonan ? selectedPermohonan.nama : ''"></strong>
                ke Divisi?
            </p>
        </div>
        <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-3 rounded-b-lg">
            <form :action="formActionUrl" method="POST">
                @csrf
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
                    Ya, Teruskan
                </button>
            </form>
            <button type="button" @click="closeModal()"
                class="px-4 py-2 bg-white border border-gray-300 text-sm font-medium rounded-md hover:bg-gray-50">
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
                setTimeout(() => {
                    this.selectedPermohonan = null;
                }, 300);
            },

            updateActionUrl() {
    if (this.selectedPermohonan) {
        this.formActionUrl = `{{ url('/unduhan') }}/${this.selectedPermohonan.id}`;
    }
}

        };
    }
</script>
@endpush