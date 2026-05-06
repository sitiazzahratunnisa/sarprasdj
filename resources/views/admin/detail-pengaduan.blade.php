@extends('layouts.app')
@section('title', 'Detail Pengaduan - Admin')

@section('content')
<div class="container-fluid">
    {{-- Menampilkan Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.pengaduan') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pengaduan #{{ $pengaduan->id }}</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Pelapor</th>
                            <td>: {{ $pengaduan->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Barang</th>
                            <td>: {{ $pengaduan->nama_barang }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>: {{ $pengaduan->lokasi }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>: {{ $pengaduan->kategori }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Masuk</th>
                            <td>: {{ $pengaduan->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>: <p class="mt-1">{{ $pengaduan->deskripsi }}</p></td>
                        </tr>
                    </table>
                    
                    @if($pengaduan->foto)
                        <label class="fw-bold">Foto Bukti:</label>
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $pengaduan->foto) }}" class="img-fluid rounded border shadow-sm" style="max-height: 300px;">
                        </div>
                    @else
                        <div class="alert alert-light border small text-muted">
                            <i class="bi bi-image me-1"></i> Tidak ada foto bukti yang diunggah.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Update Status</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pengaduan.status', $pengaduan->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Saat Ini:</label>
                            <div class="mb-2">
                                @if($pengaduan->status == 'menunggu')
                                    <span class="badge bg-warning text-dark p-2">Menunggu Konfirmasi</span>
                                @elseif($pengaduan->status == 'diproses')
                                    <span class="badge bg-info text-dark p-2">Sedang Diproses</span>
                                @elseif($pengaduan->status == 'selesai')
                                    <span class="badge bg-success p-2">Selesai</span>
                                @else
                                    <span class="badge bg-danger p-2">Ditolak</span>
                                @endif
                            </div>
                            
                            {{-- Value harus sesuai dengan validasi di Controller: menunggu, diproses, selesai, ditolak --}}
                            <select name="status" class="form-select mt-2" required>
                                <option value="menunggu" {{ $pengaduan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $pengaduan->status == 'ditolak' ? 'selected' : '' }}>Tolak Laporan</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 shadow-sm">
                            <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection