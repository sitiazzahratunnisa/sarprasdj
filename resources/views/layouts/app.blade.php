<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SARPRASDJ - @yield('title', 'Sistem Pengaduan Sarana Prasarana')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --biru-utama: #1565C0;
            --biru-gelap: #0D47A1;
            --biru-muda: #E3F2FD;
            --biru-medium: #42A5F5;
            --putih: #ffffff;
        }
        body { background-color: #F0F7FF; font-family: 'Segoe UI', sans-serif; }

        /* Topbar */
        .topbar { background: var(--biru-utama); padding: 12px 20px; display: flex; align-items: center; justify-content: space-between; }
        .topbar-brand { color: var(--putih); font-weight: 700; font-size: 18px; letter-spacing: 1px; }
        .topbar-brand span { color: var(--biru-medium); }

        /* Sidebar */
        .sidebar { background: var(--biru-gelap); min-height: calc(100vh - 56px); padding-top: 1rem; }
        .sidebar .nav-link { color: #90CAF9; padding: 10px 20px; border-left: 3px solid transparent; font-size: 14px; }
        .sidebar .nav-link:hover { color: var(--putih); background: rgba(255,255,255,0.07); }
        .sidebar .nav-link.active { color: var(--putih); background: var(--biru-utama); border-left-color: var(--biru-medium); font-weight: 500; }
        .sidebar .nav-link i { margin-right: 8px; width: 18px; }

        /* Cards & Badges */
        .card { border: 1px solid #BBDEFB; border-radius: 10px; }
        .card-header { background: var(--biru-utama); color: var(--putih); font-weight: 500; }
        .stat-card { background: var(--putih); border-radius: 10px; padding: 16px; text-align: center; border: 1px solid #BBDEFB; }
        .stat-card .number { font-size: 28px; font-weight: 700; color: var(--biru-utama); }
        .stat-card .label { font-size: 12px; color: #777; }

        /* Badge status */
        .badge-menunggu  { background: #FFF8E1; color: #F57F17; }
        .badge-diproses  { background: #E3F2FD; color: var(--biru-utama); }
        .badge-selesai   { background: #E8F5E9; color: #2E7D32; }
        .badge-ditolak   { background: #FFEBEE; color: #C62828; }

        /* Table */
        .table thead th { background: var(--biru-muda); color: var(--biru-gelap); font-weight: 500; }

        /* Alert */
        .alert-success { background: #E8F5E9; border-color: #A5D6A7; color: #2E7D32; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="topbar">
        <div class="topbar-brand">SARPRAS<span>DJ</span></div>
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold"
                 style="width:34px;height:34px;font-size:13px;background:#42A5F5!important;">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <span class="text-white" style="font-size:13px;">{{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" class="ms-2">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light" style="font-size:12px;">Logout</button>
            </form>
        </div>
    </div>

    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-auto">
                <div class="sidebar" style="width:210px;">
                    <nav class="nav flex-column">
                        @yield('sidebar')
                    </nav>
                </div>
            </div>
            <div class="col">
                <div class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
