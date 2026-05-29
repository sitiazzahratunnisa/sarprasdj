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
    <div class="mb-4">
        <a href="{{ route('admin.lokasi') }}" class="btn btn-light shadow-sm" style="font-weight: 600; font-size: 14px; border-radius: 6px; padding: 8px 16px; border: 1px solid #dee2e6;">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Lokasi
        </a>
    </div>

    <div class="card shadow-sm border-0 p-4" style="border-radius: 8px;">
        <h1 class="h3 mb-1 text-gray-800" style="font-weight: 700; color: #212529;">Detail Informasi Lokasi</h1>
        <p class="text-muted mb-4" style="font-size: 14px;">Informasi spesifik mengenai lokasi terpilih</p>
        
        <div class="p-3 rounded" style="background-color: #e3f2fd; border-left: 4px solid #1565C0;">
            <span class="text-muted d-block mb-1" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Nama Lokasi</span>
            <h4 class="mb-0" style="color: #0d47a1; font-weight: 600;">{{ $lokasi->nama_lokasi }}</h4>
        </div>
    </div>
</div>
@endsection