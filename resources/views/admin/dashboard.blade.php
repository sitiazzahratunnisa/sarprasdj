@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('sidebar')
    <a href="{{ route('admin.dashboard') }}" class="nav-link active">
        <i class="bi bi-speedometer2"></i>Dashboard
    </a>
    <a href="{{ route('admin.pengaduan') }}" class="nav-link">
        <i class="bi bi-clipboard-check"></i>Pengaduan
    </a>
    <a href="{{ route('admin.barang') }}" class="nav-link">
        <i class="bi bi-box-seam"></i>Data Barang
    </a>
    <a href="{{ route('admin.siswa') }}" class="nav-link">
        <i class="bi bi-people"></i>Data Siswa
    </a>
    <a href="{{ route('admin.laporan') }}" class="nav-link">
        <i class="bi bi-bar-chart"></i>Laporan
    </a>
@endsection

@section('content')
<h5 class="fw-bold mb-4" style="color:#1565C0;">Dashboard Admin</h5>

{{-- Statistik --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="number">{{ $stats['total'] }}</div>
            <div class="label"><i class="bi bi-clipboard-data me-1"></i>Total Pengaduan</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="number" style="color:#F57F17;">{{ $stats['menunggu'] }}</div>
            <div class="label"><i class="bi bi-hourglass-split me-1"></i>Menunggu</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="number" style="color:#1565C0;">{{ $stats['diproses'] }}</div>
            <div class="label"><i class="bi bi-gear me-1"></i>Diproses</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="number" style="color:#2E7D32;">{{ $stats['selesai'] }}</div>
            <div class="label"><i class="bi bi-check-circle me-1"></i>Selesai</div>
        </div>
    </div>
</div>

{{-- Tabel Pengaduan Terbaru --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clock-history me-2"></i>Pengaduan Terbaru</span>
        <a href="{{ route('admin.pengaduan') }}" class="btn btn-sm btn-outline-light" style="font-size:12px;">
            Lihat Semua
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Barang</th>
                        <th>Lokasi</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($terbaru as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $p->user->name }}</td>
                        <td>{{ $p->nama_barang }}</td>
                        <td>{{ $p->lokasi }}</td>
                        <td>{{ $p->created_at->format('d M Y') }}</td>
                        <td>
                            <span class="badge badge-{{ $p->status }} px-2 py-1" style="font-size:11px;border-radius:20px;">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.pengaduan.detail', $p->id) }}"
                               class="btn btn-sm" style="background:#E3F2FD;color:#1565C0;font-size:11px;">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pengaduan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
