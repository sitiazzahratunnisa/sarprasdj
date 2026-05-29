<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SARPRASDJ - @yield('title')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        /* Mengatur layout utama agar memenuhi layar penuh */
        .wrapper {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        /* Mengatur style Sidebar di sisi kiri */
        .sidebar {
            width: 260px;
            background-color: #0d47a1; /* Biru gelap khas SARPRASDJ */
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            display: block;
            text-decoration: none;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #1565C0;
            color: white;
        }
        /* Mengatur area konten utama di sisi kanan */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
            overflow-y: auto;
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <div class="sidebar p-3">
            <div>
                <div class="fs-4 fw-bold mb-4 px-2">SARPRAS<span class="text-info">DJ</span></div>
                <nav class="nav flex-column">
                    @yield('sidebar')
                </nav>
            </div>
            
            <div class="border-top pt-3 text-sm px-2">
                <div class="fw-bold">Admin Sarpras</div>
                <small class="text-white-50">Saa</small>
                
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm w-100">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="main-content">
            <header class="bg-primary text-white p-3 d-flex justify-content-between align-items-center shadow-sm">
                <h5 class="mb-0">Dashboard Admin</h5>
                <div class="d-flex align-items-center">
                    <span class="badge bg-light text-primary me-2">AD</span>
                    <small>Admin Sarpras</small>
                </div>
            </header>

            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>