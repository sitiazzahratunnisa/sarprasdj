<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SARPRASDJ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0D47A1 0%, #1565C0 50%, #1976D2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-box {
            background: #fff;
            border-radius: 16px;
            padding: 36px 32px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }
        .logo-circle {
            width: 64px; height: 64px;
            background: #1565C0;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; font-weight: 800; color: #fff;
            margin: 0 auto 12px;
        }
        .site-name { font-size: 22px; font-weight: 700; color: #1565C0; text-align: center; }
        .site-sub  { font-size: 12px; color: #888; text-align: center; margin-bottom: 24px; }
        .role-toggle { display: flex; background: #E3F2FD; border-radius: 8px; padding: 4px; margin-bottom: 20px; }
        .role-toggle .btn { flex: 1; border: none; border-radius: 6px; font-size: 13px; padding: 7px;
            background: transparent; color: #555; transition: all 0.2s; }
        .role-toggle .btn.active { background: #1565C0; color: #fff; font-weight: 500; }
        .form-label { font-size: 13px; color: #444; font-weight: 500; }
        .form-control { border: 1px solid #BBDEFB; border-radius: 8px; font-size: 14px; padding: 10px 12px; }
        .form-control:focus { border-color: #1565C0; box-shadow: 0 0 0 3px rgba(21,101,192,0.12); }
        .btn-login { background: #1565C0; color: #fff; border: none; border-radius: 8px; padding: 11px;
            font-size: 14px; font-weight: 600; width: 100%; letter-spacing: 0.5px; }
        .btn-login:hover { background: #0D47A1; color: #fff; }
        .footer-text { font-size: 11px; color: #aaa; text-align: center; margin-top: 16px; }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="logo-circle">SP</div>
        <div class="site-name">SARPRASDJ</div>
        <div class="site-sub">Sistem Pengaduan Sarana &amp; Prasarana Sekolah</div>

        <div class="role-toggle" id="roleToggle">
            <button type="button" class="btn active" onclick="setRole('admin', this)">
                <i class="bi bi-shield-check me-1"></i>Admin
            </button>
            <button type="button" class="btn" onclick="setRole('siswa', this)">
                <i class="bi bi-person me-1"></i>Siswa
            </button>
        </div>

        @if($errors->any())
            <div class="alert alert-danger py-2 mb-3" style="font-size:13px;border-radius:8px;">
                <i class="bi bi-exclamation-circle me-1"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <input type="hidden" name="role" id="roleInput" value="admin">

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                    placeholder="Masukkan email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="position-relative">
                    <input type="password" name="password" id="pwdInput" class="form-control pe-5"
                        placeholder="Masukkan password" required>
                    <i class="bi bi-eye position-absolute top-50 translate-middle-y end-0 me-3"
                       style="cursor:pointer;color:#aaa;" onclick="togglePwd()"></i>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
            </button>
        </form>
        <div class="footer-text">© 2026 SARPRASDJ &mdash; Sarana Prasarana Sekolah</div>
    </div>

    <script>
        function setRole(role, el) {
            document.querySelectorAll('#roleToggle .btn').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('roleInput').value = role;
        }
        function togglePwd() {
            const i = document.getElementById('pwdInput');
            i.type = i.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>