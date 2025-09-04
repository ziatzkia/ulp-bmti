@extends('layouts.admin')

@section('content')
<div class.blade.php" container mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="pageController()">

    <!-- Header Halaman -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Proses Surat Balasan</h1>
        <p class="text-gray-500 mt-1">Upload surat balasan untuk menandai permohonan sebagai "Selesai".</p>
    </div>

    <!-- Pesan Sukses -->
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow" role="alert">
            <p class="font-bold">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Pesan Error Validasi -->
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow" role="alert">
            <p class="font-bold">Terjadi Kesalahan</p>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Tabel Permohonan -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penempatan</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Dokumen Awal</th>
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
                                <div class="text-sm font-medium text-gray-900">{{ $p->divisi->nama_divisi ?? 'Belum Ditentukan' }}</div>
                                <div class="text-sm text-gray-500">{{ $p->jurusan }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($p->image)
                                    <a href="{{ asset('storage/' . $p->image) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 inline-flex items-center text-sm">
                                        <i class="fas fa-file-alt mr-1"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <button @click="openUploadModal({{ json_encode($p) }})" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-upload mr-2"></i> Upload Surat
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center px-6 py-12">
                                <div class="text-center">
                                    <i class="fas fa-folder-open fa-3x text-gray-300"></i>
                                    <p class="mt-4 text-sm font-medium text-gray-600">Tidak ada permohonan yang menunggu surat balasan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Upload Global -->
    <div x-show="uploadModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-black bg-opacity-60" @click="closeModal()"></div>
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg transform transition-all"
             x-show="uploadModalOpen" @click.away="closeModal()"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <form :action="formActionUrl" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900">Upload Surat Balasan</h3>
                    <p class="text-sm text-gray-500 mt-2">Pilih file balasan untuk <strong x-text="selectedPermohonan ? selectedPermohonan.nama : ''"></strong>.</p>
                    
                    <!-- File Input Area -->
                    <div class="mt-4" x-data="fileUpload()">
                        <div class="flex items-center justify-center w-full">
                            <label @dragover.prevent @drop.prevent="handleDrop" for="surat_balasan_input" 
                                   class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-gray-400"></i>
                                    <p class="mb-2 text-sm text-gray-500" x-show="!fileName">
                                        <span class="font-semibold">Klik untuk upload</span> atau seret file ke sini
                                    </p>
                                    <p class="text-xs text-gray-500" x-show="!fileName">PDF, DOC, DOCX (MAX. 2MB)</p>
                                    <p class="text-sm font-semibold text-blue-600" x-show="fileName" x-text="fileName"></p>
                                </div>
                                <input id="surat_balasan_input" name="surat_balasan" type="file" class="hidden" @change="handleFileSelect" required>
                            </label>
                        </div> 
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 rounded-b-lg">
                    <button type="button" @click="closeModal()" class="px-4 py-2 bg-white border border-gray-300 text-sm font-medium rounded-md shadow-sm hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-700">
                        <i class="fas fa-check mr-2"></i> Upload dan Selesaikan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function pageController() {
        return {
            uploadModalOpen: false,
            selectedPermohonan: null,
            formActionUrl: '',

            openUploadModal(permohonan) {
                this.selectedPermohonan = permohonan;
                this.updateActionUrl();
                this.uploadModalOpen = true;
            },

            closeModal() {
                this.uploadModalOpen = false;
                // Reset state setelah modal ditutup
                setTimeout(() => { 
                    this.selectedPermohonan = null; 
                    //dispatchEvent untuk mereset nama file di modal
                    window.dispatchEvent(new CustomEvent('reset-file-input'));
                }, 300); 
            },

            updateActionUrl() {
                if (this.selectedPermohonan) {
                    this.formActionUrl = `{{ url('humas/balasan') }}/${this.selectedPermohonan.id}/action`;
                }
            }
        };
    }

    function fileUpload() {
        return {
            fileName: '',
            init() {
                window.addEventListener('reset-file-input', () => {
                    this.fileName = '';
                    document.getElementById('surat_balasan_input').value = '';
                });
            },
            handleFileSelect(event) {
                const file = event.target.files[0];
                if (file) {
                    this.fileName = file.name;
                } else {
                    this.fileName = '';
                }
            },
            handleDrop(event) {
                const file = event.dataTransfer.files[0];
                if (file) {
                    document.getElementById('surat_balasan_input').files = event.dataTransfer.files;
                    this.fileName = file.name;
                }
            }
        }
    }
</script>
@endpush