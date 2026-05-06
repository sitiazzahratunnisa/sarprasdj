@extends('layouts.app')
@section('title', 'Detail Pengaduan')

@section('sidebar')
    <a href="{{ route('siswa.dashboard') }}" class="nav-link">
        <i class="bi bi-house"></i> Dashboard
    </a>
    <a href="{{ route('siswa.pengaduan.create') }}" class="nav-link">
        <i class="bi bi-plus-circle"></i> Buat Pengaduan
    </a>
    <a href="{{ route('siswa.pengaduan') }}" class="nav-link active">
        <i class="bi bi-clock-history"></i> Riwayat
    </a>
@endsection

@section('content')
<div class="mb-4">
    <a href="{{ route('siswa.pengaduan') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
    </a>
</div>

<div class="card shadow-sm" style="max-width: 800px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-primary">Detail Laporan #{{ $pengaduan->id }}</h5>
        <span>
            @if($pengaduan->status == 'pending')
                <span class="badge bg-warning text-dark p-2">Menunggu Konfirmasi</span>
            @elseif($pengaduan->status == 'proses')
                <span class="badge bg-info text-dark p-2">Sedang Diproses</span>
            @else
                <span class="badge bg-success p-2">Selesai</span>
            @endif
        </span>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-7">
                <table class="table table-borderless">
                    <tr>
                        <td width="35%" class="text-muted">Nama Barang</td>
                        <td class="fw-bold">: {{ $pengaduan->nama_barang }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Kategori</td>
                        <td>: {{ $pengaduan->kategori }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Lokasi</td>
                        <td>: {{ $pengaduan->lokasi }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tanggal Lapor</td>
                        <td>: {{ $pengaduan->created_at->format('d F Y H:i') }}</td>
                    </tr>
                </table>
                
                <div class="mt-3 p-3 bg-light rounded">
                    <label class="fw-bold d-block mb-2">Deskripsi Kerusakan:</label>
                    <p class="mb-0 small text-secondary">{{ $pengaduan->deskripsi }}</p>
                </div>
            </div>
            
            <div class="col-md-5">
                <label class="fw-bold d-block mb-2">Foto Bukti:</label>
                @if($pengaduan->foto)
                    <img src="{{ asset('storage/' . $pengaduan->foto) }}" class="img-fluid rounded shadow-sm" alt="Foto Barang">
                @else
                    <div class="border rounded d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                        <span class="text-muted small">Tidak ada foto</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer bg-white py-3 text-end">
        @if($pengaduan->status == 'pending')
            <form action="{{ route('siswa.pengaduan.delete', $pengaduan->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin membatalkan laporan ini?')">
                    <i class="bi bi-trash me-1"></i> Batalkan Laporan
                </button>
            </form>
        @endif
    </div>
</div>
@endsection