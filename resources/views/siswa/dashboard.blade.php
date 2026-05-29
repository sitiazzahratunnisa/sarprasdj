@extends('layouts.app') {{-- Pastikan kamu punya folder layouts dan file app.blade.php --}}


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
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dashboard Siswa</h6>
                </div>
                <div class="card-body">
                    <h4>Selamat Datang, {{ auth()->user()->name }}! 👋</h4>
                    <p>Melalui halaman ini, kamu bisa melaporkan kerusakan sarana dan prasarana di sekolah.</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white shadow">
                                <div class="card-body">
                                    Buat Pengaduan
                                    <div class="text-white-50 small">Laporkan barang rusak sekarang</div>
                                    <a href="{{ route('siswa.pengaduan.create') }}" class="btn btn-light btn-sm mt-2">Klik di Sini</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection