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
                    this.formActionUrl = `{{ url('/unduhan') }}/${this.selectedPermohonan.id}/action`;
                }
            }
        };
    }
</script>
@endpush