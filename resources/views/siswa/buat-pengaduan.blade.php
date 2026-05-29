@extends('layouts.app')
@section('title', 'Buat Pengaduan')

@section('sidebar')
    <a href="{{ route('siswa.dashboard') }}" class="nav-link">
        <i class="bi bi-house"></i> Dashboard
    </a>
    <a href="{{ route('siswa.pengaduan.create') }}" class="nav-link active">
        <i class="bi bi-plus-circle"></i> Buat Pengaduan
    </a>
    {{-- PERBAIKAN: Mengubah 'siswa.riwayat' menjadi 'siswa.pengaduan' agar sesuai dengan web.php --}}
    <a href="{{ route('siswa.pengaduan') }}" class="nav-link">
        <i class="bi bi-clock-history"></i> Riwayat
    </a>
@endsection

@section('content')
<h5 class="fw-bold mb-4" style="color:#1565C0;">Form Pengaduan Barang Rusak</h5>

<div class="card" style="max-width:640px;">
    <div class="card-header">
        <i class="bi bi-clipboard-plus me-2"></i> Isi Data Pengaduan
    </div>
    <div class="card-body">
        {{-- Menampilkan Pesan Error --}}
        @if($errors->any())
            <div class="alert alert-danger py-2 mb-3" style="font-size:13px;">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Menampilkan Pesan Sukses (Tambahan) --}}
        @if(session('success'))
            <div class="alert alert-success py-2 mb-3" style="font-size:13px;">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('siswa.pengaduan.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-500" style="font-size:13px;">Nama Barang <span class="text-danger">*</span></label>
                <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror"
                    placeholder="Contoh: Kursi Kelas, Proyektor, AC" value="{{ old('nama_barang') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-500" style="font-size:13px;">Kategori <span class="text-danger">*</span></label>
                <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Furnitur" {{ old('kategori') == 'Furnitur' ? 'selected' : '' }}>Furnitur (Kursi, Meja, Lemari)</option>
                    <option value="Elektronik" {{ old('kategori') == 'Elektronik' ? 'selected' : '' }}>Elektronik (Proyektor, AC, Komputer)</option>
                    <option value="Fasilitas" {{ old('kategori') == 'Fasilitas' ? 'selected' : '' }}>Fasilitas (Toilet, Pintu, Jendela)</option>
                    <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            {{-- PERBAIKAN: Mengubah input manual menjadi dropdown otomatis dari database --}}
            <div class="mb-3">
                <label class="form-label fw-500" style="font-size:13px;">Lokasi <span class="text-danger">*</span></label>
                <select name="lokasi" id="lokasi" class="form-select @error('lokasi') is-invalid @enderror" required>
                    <option value="" disabled selected>-- Pilih Lokasi Keberadaan Barang --</option>
                    @foreach($lokasis as $lok)
                        <option value="{{ $lok->nama_lokasi }}" {{ old('lokasi') == $lok->nama_lokasi ? 'selected' : '' }}>
                            {{ $lok->nama_lokasi }}
                        </option>
                    @endforeach
                </select>
                @error('lokasi')
                    <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-500" style="font-size:13px;">Deskripsi Kerusakan <span class="text-danger">*</span></label>
                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4" required
                    placeholder="Jelaskan kondisi kerusakan secara detail...">{{ old('deskripsi') }}</textarea>
                <div style="font-size:11px;color:#aaa;margin-top:4px;">Minimal 10 karakter</div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-500" style="font-size:13px;">Foto Bukti <span style="color:#aaa;font-weight:400;">(opsional)</span></label>
                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                <div style="font-size:11px;color:#aaa;margin-top:4px;">Format JPG/PNG/JPEG, maksimal 2MB</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn" style="background:#1565C0;color:#fff;font-size:13px;padding:10px 24px;border-radius:8px;">
                    <i class="bi bi-send me-2"></i> Kirim Pengaduan
                </button>
                <a href="{{ route('siswa.dashboard') }}" class="btn btn-outline-secondary" style="font-size:13px;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection