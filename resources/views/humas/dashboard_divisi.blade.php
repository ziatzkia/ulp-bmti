@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Divisi</h1>
        <p class="text-gray-500 mt-1">Tambah, lihat, dan kelola divisi untuk program magang.</p>
    </div>

    @if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
        <p class="font-bold">Sukses!</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Tambah Divisi Baru</h2>
        <form action="{{ route('divisis.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                <div class="md:col-span-2">
                    <label for="nama_divisi" class="block text-sm font-medium text-gray-700">Nama Divisi</label>
                    <input type="text" id="nama_divisi" name="nama_divisi"
                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Contoh: IT Development"
                        value="{{ old('nama_divisi') }}">
                    @error('nama_divisi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:pt-6">
                    <button type="submit"
                        class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fa fa-plus-circle mr-2"></i> Tambah Divisi
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-700">Daftar Divisi</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Divisi
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah Magang
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kebutuhan Magang
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($divisis as $divisi)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $divisi->nama_divisi }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">{{ $divisi->jumlah_magang }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">{{ $divisi->kebutuhan_magang }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center items-center gap-2">
                                <form action="{{ route('divisis.destroy', $divisi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus divisi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                        <i class="fa fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center px-6 py-12">
                            <div class="text-center">
                                <i class="fa fa-folder-open fa-3x text-gray-300"></i>
                                <p class="mt-4 text-sm font-medium text-gray-600">Belum ada data divisi.</p>
                                <p class="text-xs text-gray-500">Silakan tambahkan divisi baru melalui form di atas.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection