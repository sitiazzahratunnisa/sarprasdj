@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                Daftar Pengaduan Sarpras
            </h2>

            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2">Pelapor</th>
                            <th class="border border-gray-300 px-4 py-2">Nama Barang</th>
                            <th class="border border-gray-300 px-4 py-2">Lokasi</th>
                            <th class="border border-gray-300 px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengaduans as $item)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $item->user->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $item->nama_barang }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $item->lokasi }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <span class="px-2 py-1 rounded text-sm {{ $item->status == 'selesai' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $pengaduans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection