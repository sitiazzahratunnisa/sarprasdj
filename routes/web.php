<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PengaduanController;

// ================= HALAMAN UTAMA =================
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('siswa.dashboard');
    }
    return redirect()->route('login');
});

// ================= AUTH =================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ================= ADMIN =================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Data Siswa
    Route::get('/data-siswa', [AdminController::class, 'dataSiswa'])->name('admin.siswa');
    Route::get('/data-siswa/create', [AdminController::class, 'createSiswa'])->name('admin.siswa.create');
    Route::post('/data-siswa', [AdminController::class, 'storeSiswa'])->name('admin.siswa.store');
    Route::get('/data-siswa/{id}/edit', [AdminController::class, 'editSiswa'])->name('admin.edit.siswa');
    Route::put('/data-siswa/{id}', [AdminController::class, 'updateSiswa'])->name('admin.siswa.update');
    Route::delete('/data-siswa/{id}', [AdminController::class, 'destroySiswa'])->name('admin.siswa.delete');

    // Pengaduan (Manajemen Laporan)
    Route::get('/pengaduan', [AdminController::class, 'pengaduan'])->name('admin.pengaduan');
    Route::get('/pengaduan/{id}', [AdminController::class, 'detailPengaduan'])->name('admin.pengaduan.detail');
    Route::patch('/pengaduan/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.pengaduan.status');

    // Data Barang (Inventaris) - INI YANG DITAMBAHKAN
    Route::get('/data-barang', [AdminController::class, 'dataBarang'])->name('admin.barang');
    Route::get('/data-barang/create', [AdminController::class, 'createBarang'])->name('admin.barang.create');
    Route::post('/data-barang', [AdminController::class, 'storeBarang'])->name('admin.barang.store');
    Route::get('/data-barang/{id}/edit', [AdminController::class, 'editBarang'])->name('admin.barang.edit');
    Route::put('/data-barang/{id}', [AdminController::class, 'updateBarang'])->name('admin.barang.update');
    Route::delete('/data-barang/{id}', [AdminController::class, 'destroyBarang'])->name('admin.barang.destroy');

    // Laporan & Cetak
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
    Route::get('/laporan/cetak', [AdminController::class, 'cetakLaporan'])->name('admin.laporan.cetak');
});

// ================= SISWA =================
Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    
    // Fitur Pengaduan Siswa
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('siswa.pengaduan');
    Route::get('/pengaduan/buat', [PengaduanController::class, 'create'])->name('siswa.pengaduan.create');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('siswa.pengaduan.store');
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('siswa.pengaduan.show');
    Route::delete('/pengaduan/{id}', [PengaduanController::class, 'destroy'])->name('siswa.pengaduan.delete');
});