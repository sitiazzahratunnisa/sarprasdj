@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Data Siswa Baru</h4>
        </div>
        <div class="card-body">
            {{-- Tambahkan Error Message agar tahu kenapa gagal --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Gunakan route yang benar: admin.siswa.store --}}
            <form action="{{ route('admin.siswa.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                {{-- WAJIB ADA: Input Password karena di controller di-required --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    <small class="text-muted">Minimal 6 karakter</small>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Data</button>
                <a href="{{ route('admin.siswa') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection