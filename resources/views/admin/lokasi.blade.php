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
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h1 class="h3 mb-0 text-gray-800" style="font-weight: 700; color: #212529;">Data Lokasi</h1>
            <p class="text-muted mb-0" style="font-size: 14px;">Kelola daftar lokasi untuk pelaporan barang rusak</p>
        </div>
        <button class="btn btn-primary" onclick="toggleModalTambah()" style="background-color: #0d6efd; border: none; font-weight: 600; padding: 8px 16px; border-radius: 6px;">
            Tambah Lokasi
        </button>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 8px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 14px;">
                    <thead class="table-light" style="background-color: #f8f9fa;">
                        <tr>
                            <th class="px-4 py-3" style="width: 10%; color: #6c757d; font-weight: 600;">No</th>
                            <th class="py-3" style="width: 50%; color: #6c757d; font-weight: 600;">Nama Lokasi</th>
                            <th class="px-4 py-3 text-end" style="width: 40%; color: #6c757d; font-weight: 600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($semua_lokasi as $index => $lokasi)
                        <tr>
                            <td class="px-4 py-3 text-muted">{{ $index + 1 }}</td>
                            <td class="py-3" style="font-weight: 500; color: #343a40;">{{ $lokasi->nama_lokasi }}</td>
                            <td class="px-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-3">
                                    <a href="{{ route('admin.lokasi.show', $lokasi->id) }}" class="text-primary text-decoration-none" style="font-weight: 600; font-size: 13px;">Detail</a>
                                    
                                    <form action="/admin/lokasi/delete/{{ $lokasi->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus lokasi ini?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-danger bg-transparent border-0 p-0" style="font-weight: 600; font-size: 13px; cursor: pointer;">Hapus</button>
                                    </form>

                                    {{-- TOMBOL EDIT BARU --}}
                                    <button type="button" class="text-warning bg-transparent border-0 p-0" style="font-weight: 600; font-size: 13px; cursor: pointer;" onclick="openModalEdit({{ $lokasi->id }}, '{{ $lokasi->nama_lokasi }}')">
                                        Edit
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">Belum ada data lokasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH LOKASI --}}
<div class="modal" id="modalTambah" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1050;">
    <div class="modal-dialog" style="width: 100%; max-width: 400px; margin: 1.75rem auto;">
        <div class="modal-content" style="border-radius: 8px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header p-3 border-bottom">
                <h5 class="modal-title" style="font-weight: 700; color: #212529;">Tambah Lokasi Baru</h5>
            </div>
            <form action="/admin/lokasi/store" method="POST">
                @csrf
                <div class="modal-body p-3">
                    <div class="form-group">
                        <label class="form-label text-muted mb-1" style="font-size: 13px; font-weight: 600;">Nama Lokasi</label>
                        <input type="text" name="nama_lokasi" class="form-control" placeholder="Contoh: Lab Industri 2" required style="border-radius: 6px; padding: 10px; font-size: 14px;">
                    </div>
                </div>
                <div class="modal-footer p-3 border-top d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-light" onclick="toggleModalTambah()" style="font-weight: 600; font-size: 14px; border-radius: 6px; padding: 6px 12px;">Batal</button>
                    <button type="submit" class="btn btn-primary" style="font-weight: 600; font-size: 14px; border-radius: 6px; padding: 6px 12px; background-color: #0d6efd; border: none;">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT LOKASI BARU --}}
<div class="modal" id="modalEdit" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1050;">
    <div class="modal-dialog" style="width: 100%; max-width: 400px; margin: 1.75rem auto;">
        <div class="modal-content" style="border-radius: 8px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header p-3 border-bottom">
                <h5 class="modal-title" style="font-weight: 700; color: #212529;">Ubah Data Lokasi</h5>
            </div>
            <form id="formEditLokasi" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-3">
                    <div class="form-group">
                        <label class="form-label text-muted mb-1" style="font-size: 13px; font-weight: 600;">Nama Lokasi</label>
                        <input type="text" id="edit_nama_lokasi" name="nama_lokasi" class="form-control" required style="border-radius: 6px; padding: 10px; font-size: 14px;">
                    </div>
                </div>
                <div class="modal-footer p-3 border-top d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-light" onclick="toggleModalEdit()" style="font-weight: 600; font-size: 14px; border-radius: 6px; padding: 6px 12px;">Batal</button>
                    <button type="submit" class="btn btn-primary" style="font-weight: 600; font-size: 14px; border-radius: 6px; padding: 6px 12px; background-color: #ffc107; border: none; color: #000;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleModalTambah() {
        var modal = document.getElementById('modalTambah');
        modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
    }

    function toggleModalEdit() {
        var modal = document.getElementById('modalEdit');
        modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
    }

    // Fungsi otomatis memasukkan data lama saat modal edit terbuka
    function openModalEdit(id, nama) {
        document.getElementById('formEditLokasi').action = '/admin/lokasi/update/' + id;
        document.getElementById('edit_nama_lokasi').value = nama;
        toggleModalEdit();
    }
</script>
@endsection