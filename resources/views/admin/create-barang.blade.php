@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="font-semibold text-xl mb-6">Tambah Inventaris Baru</h2>

                <form action="{{ route('admin.barang.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Barang</label>
                        <input type="text" name="nama_barang" class="shadow border rounded w-full py-2 px-3 text-gray-700" placeholder="Contoh: Kursi Siswa" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                        <input type="text" name="kategori" class="shadow border rounded w-full py-2 px-3 text-gray-700" placeholder="Contoh: Furnitur" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Lokasi</label>
                        <input type="text" name="lokasi" class="shadow border rounded w-full py-2 px-3 text-gray-700" placeholder="Contoh: Ruang 17" required>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Simpan Barang
                        </button>
                        <a href="{{ route('admin.barang') }}" class="text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection