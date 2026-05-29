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
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="fas fa-users text-primary fs-4"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">Data Siswa</h4>
                        <p class="text-muted mb-0">Total Siswa Terdaftar: {{ $siswa->total() }}</p>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-secondary">Daftar Akun & Email Siswa</h5>
                    <!-- TOMBOL TAMBAH AKTIF -->
                    <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary btn-sm px-3 rounded-pill shadow-sm">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Siswa
                    </a>
                </div>
                <div class="card-body px-0 pt-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead style="background-color: #3f6ad8; color: white;">
                                <tr>
                                    <th class="text-uppercase text-xs font-weight-bolder ps-4 py-3">NO</th>
                                    <th class="text-uppercase text-xs font-weight-bolder">NIS</th>
                                    <th class="text-uppercase text-xs font-weight-bolder">NAMA SISWA</th>
                                    <th class="text-uppercase text-xs font-weight-bolder">EMAIL (AKUN)</th>
                                    <th class="text-uppercase text-xs font-weight-bolder text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswa as $index => $s)
                                <tr class="border-bottom">
                                    <td class="ps-4">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $siswa->firstItem() + $index }}</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary text-sm font-weight-bold">{{ $s->nis ?? '12345' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark text-sm font-weight-bold text-capitalize">{{ $s->name }}</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary text-sm">{{ $s->email }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- TOMBOL EDIT AKTIF -->
                                            <a href="{{ route('admin.edit.siswa', $s->id) }}" class="btn btn-warning btn-sm text-dark px-3 py-1 fw-bold shadow-sm" style="background-color: #ffc107; border: none;">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>

                                            <!-- TOMBOL HAPUS AKTIF (MENGGUNAKAN FORM) -->
                                            <form action="{{ route('admin.siswa.delete', $s->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm px-3 py-1 fw-bold shadow-sm" style="background-color: #dc3545; border: none;">
                                                    <i class="fas fa-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada data siswa.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Pagination -->
                <div class="card-footer bg-white border-0 py-3">
                    {{ $siswa->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-sm {
        font-size: 11px;
        text-transform: uppercase;
        border-radius: 4px;
        transition: transform 0.2s;
    }
    .btn-sm:hover {
        transform: translateY(-1px);
    }
    .table thead th {
        border: none;
        letter-spacing: 0.5px;
    }
    .card {
        border-radius: 12px;
    }
</style>
@endsection