<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lokasi; // Menghubungkan model Lokasi

class SiswaController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk siswa.
     */
    public function dashboard()
    {
        return view('siswa.dashboard');
    }

    /**
     * Menampilkan halaman buat pengaduan dengan data lokasi otomatis.
     */
    public function create()
    {
        // Ambil semua data lokasi dari database
        $lokasis = Lokasi::all(); 

        // FIX FIX FIX: Jalurnya langsung 'siswa.buat-pengaduan' karena tidak ada folder 'pengaduan'
        return view('siswa.buat-pengaduan', compact('lokasis'));
    }
}