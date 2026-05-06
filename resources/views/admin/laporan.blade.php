@extends('layouts.app') {{-- Ganti ke 'layouts.admin' jika kamu punya layout khusus admin --}}

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Laporan Pengaduan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Laporan</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Rekap Data Pengaduan Per Bulan
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Status Pengaduan</th>
                        <th>Total Laporan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $lapor)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @php
                                    // Mengubah angka bulan menjadi nama bulan Indonesia
                                    $bulanName = Carbon\Carbon::create()->month($lapor->bulan)->translatedFormat('F');
                                @endphp
                                {{ $bulanName }}
                            </td>
                            <td>
                                @if($lapor->status == 'proses')
                                    <span class="badge bg-warning text-dark">Proses</span>
                                @elseif($lapor->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-secondary">{{ $lapor->status }}</span>
                                @endif
                            </td>
                            <td><strong>{{ $lapor->total }}</strong> Laporan</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada data pengaduan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection