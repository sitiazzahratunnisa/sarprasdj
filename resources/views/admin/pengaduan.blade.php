@extends('layouts.app')

@section('sidebar')
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>Dashboard
    </a>
    <a href="{{ route('admin.pengaduan') }}" class="nav-link {{ Request::is('admin/pengaduan*') ? 'active' : '' }}">
        <i class="bi bi-clipboard-check"></i>Pengaduan
    </a>
    <a href="{{ route('admin.barang') }}" class="nav-link {{ Request::is('admin/data-barang*') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i>Data Barang
    </a>
    <a href="{{ route('admin.lokasi') }}" class="nav-link {{ Request::is('admin/lokasi*') ? 'active' : '' }}">
        <i class="bi bi-geo-alt"></i>Data Lokasi
    </a>
    <a href="{{ route('admin.siswa') }}" class="nav-link {{ Request::is('admin/data-siswa*') ? 'active' : '' }}">
        <i class="bi bi-people"></i>Data Siswa
    </a>
    <a href="{{ route('admin.laporan') }}" class="nav-link {{ Request::is('admin/laporan*') ? 'active' : '' }}">
        <i class="bi bi-bar-chart"></i>Laporan
    </a>
@endsection

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    Daftar Pengaduan Sarpras
                </h2>
                
                <button type="button" onclick="openExportModal()" style="background-color: #107c41; color: white; padding: 8px 16px; border: none; border-radius: 4px; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                    <i class="bi bi-file-earmark-excel"></i> Cetak Excel + Foto
                </button>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded shadow-sm flex items-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pelapor</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Barang</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Lokasi</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($pengaduans as $p)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $p->user->name ?? 'User Tidak Dikenal' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600" style="padding-left: 15px; padding-right: 15px;">
                                {{ $p->nama_barang }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600" style="padding-left: 15px; padding-right: 15px;">
                                {{ $p->lokasi }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center items-center space-x-3">
                                    <a href="{{ route('admin.pengaduan.detail', $p->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-md">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.pengaduan.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin menghapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-md">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">Belum ada data pengaduan masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $pengaduans->links() }}
            </div>
        </div>
    </div>
</div>

<div id="exportModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); align-items: center; justify-content: center;">
    <div style="background-color: white; padding: 24px; border-radius: 8px; width: 100%; max-width: 450px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); font-family: sans-serif; margin: 15px;">
        
        <div style="display: flex; justify-between: space-between; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0; font-size: 18px; font-weight: bold; color: #333;">Export Laporan Excel</h3>
            <button type="button" onclick="closeExportModal()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #999;">&times;</button>
        </div>

        <form action="{{ route('admin.pengaduan.export') }}" method="GET" onsubmit="closeExportModal()">
            
            <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; padding: 12px; border-radius: 6px; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
                <input type="checkbox" id="export_semua" name="export_semua" value="1" onchange="toggleFilterFields(this)" style="width: 16px; height: 16px; cursor: pointer;">
                <label for="export_semua" style="color: #166534; font-weight: 6px; font-size: 14px; cursor: pointer; user-select: none;">Export Keseluruhan Data</label>
            </div>

            <div id="filter_tanggal_group" style="display: flex; gap: 12px; margin-bottom: 16px;">
                <div style="flex: 1;">
                    <label style="display: block; font-size: 13px; font-weight: bold; margin-bottom: 6px; color: #444;">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                </div>
                <div style="flex: 1;">
                    <label style="display: block; font-size: 13px; font-weight: bold; margin-bottom: 6px; color: #444;">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                </div>
            </div>

            <div id="filter_status_group" style="margin-bottom: 24px;">
                <label style="display: block; font-size: 13px; font-weight: bold; margin-bottom: 6px; color: #444;">Status Laporan</label>
                <select name="status_filter" id="status_filter" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; background-color: white;">
                    <option value="">Semua Status</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeExportModal()" style="padding: 8px 16px; background-color: white; border: 1px solid #ccc; border-radius: 4px; cursor: pointer; font-size: 14px;">Batal</button>
                <button type="submit" style="padding: 8px 16px; background-color: #107c41; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: bold;">Export Excel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openExportModal() {
        document.getElementById('exportModal').style.display = 'flex';
    }

    function closeExportModal() {
        document.getElementById('exportModal').style.display = 'none';
    }

    function toggleFilterFields(checkbox) {
        const tglMulai = document.getElementById('tanggal_mulai');
        const tglSelesai = document.getElementById('tanggal_selesai');
        const statusFilter = document.getElementById('status_filter');

        if (checkbox.checked) {
            tglMulai.disabled = true;
            tglSelesai.disabled = true;
            statusFilter.disabled = true;
            tglMulai.style.backgroundColor = '#f3f4f6';
            tglSelesai.style.backgroundColor = '#f3f4f6';
            statusFilter.style.backgroundColor = '#f3f4f6';
        } else {
            tglMulai.disabled = false;
            tglSelesai.disabled = false;
            statusFilter.disabled = false;
            tglMulai.style.backgroundColor = 'white';
            tglSelesai.style.backgroundColor = 'white';
            statusFilter.style.backgroundColor = 'white';
        }
    }

    // Menutup modal jika pengguna mengklik area luar putih modal
    window.onclick = function(event) {
        const modal = document.getElementById('exportModal');
        if (event.target == modal) {
            closeExportModal();
        }
    }
</script>
@endsection