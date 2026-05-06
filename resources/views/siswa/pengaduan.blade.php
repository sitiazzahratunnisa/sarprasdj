@extends('layouts.app')
@section('title', 'Riwayat Pengaduan')

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
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold" style="color:#1565C0;">Riwayat Pengaduan Saya</h5>
    <a href="{{ route('siswa.pengaduan.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Pengaduan
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" style="font-size: 14px;">
                <thead class="bg-light">
                    <tr>
                        <th class="px-3">Tanggal</th>
                        <th>Barang</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduans as $item)
                        <tr>
                            <td class="px-3">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="fw-bold">{{ $item->nama_barang }}</td>
                            <td>{{ $item->lokasi }}</td>
                            <td>
                                @if($item->status == 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($item->status == 'proses')
                                    <span class="badge bg-info text-dark">Diproses</span>
                                @else
                                    <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('siswa.pengaduan.show', $item->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-clipboard-x d-block mb-2" style="font-size: 24px;"></i>
                                Belum ada riwayat pengaduan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $pengaduans->links() }}
</div>
@endsection