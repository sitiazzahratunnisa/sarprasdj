# SARPRASDJ
## Sistem Pengaduan Sarana & Prasarana Sekolah

Website Laravel untuk pengaduan barang rusak di sekolah,
dengan dua peran: **Admin** dan **Siswa**.

---

## Persyaratan
- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Node.js (untuk asset kompilasi)

---

## Cara Instalasi

### 1. Buat project Laravel baru
```bash
composer create-project laravel/laravel sarprasdj
cd sarprasdj
```

### 2. Salin semua file dari repo ini ke folder project

### 3. Konfigurasi .env
```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env`:
```env
APP_NAME=SARPRASDJ
APP_URL=http://localhost:8000

DB_DATABASE=sarprasdj
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Buat database
```sql
CREATE DATABASE sarprasdj;
```

### 5. Jalankan migrasi & seeder
```bash
php artisan migrate
php artisan db:seed --class=UserSeeder
```

### 6. Storage link (untuk upload foto)
```bash
php artisan storage:link
```

### 7. Daftarkan middleware di bootstrap/app.php
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
    ]);
})
```

### 8. Jalankan server
```bash
php artisan serve
```

Buka browser: `http://localhost:8000`

---

## Akun Default (setelah seeder)

| Role  | Username | Password  |
|-------|----------|-----------|
| Admin | admin    | admin123  |
| Siswa | siswa1   | siswa123  |

---

## Fitur

### Admin
- Dashboard statistik pengaduan
- Lihat & filter semua pengaduan
- Update status: Menunggu → Diproses → Selesai / Ditolak
- Tambah catatan untuk setiap pengaduan
- Data barang & data siswa
- Laporan bulanan

### Siswa
- Login dengan username & password
- Buat pengaduan baru (nama barang, kategori, lokasi, deskripsi, foto)
- Lihat status pengaduan secara real-time
- Riwayat semua pengaduan

---

## Struktur File Penting

```
app/
  Http/
    Controllers/
      AuthController.php       ← Login/Logout
      AdminController.php      ← Semua fungsi admin
      SiswaController.php      ← Dashboard siswa
      PengaduanController.php  ← CRUD pengaduan siswa
    Middleware/
      CheckRole.php            ← Proteksi route by role
  Models/
    User.php
    Pengaduan.php

database/migrations/
  ..._create_users_table.php
  ..._create_pengaduans_table.php

resources/views/
  auth/login.blade.php
  layouts/app.blade.php
  admin/dashboard.blade.php
  siswa/buat-pengaduan.blade.php

routes/web.php
```

---

## Warna Tema
- Biru Utama: `#1565C0`
- Biru Gelap: `#0D47A1`
- Biru Muda: `#E3F2FD`
- Putih: `#FFFFFF`
