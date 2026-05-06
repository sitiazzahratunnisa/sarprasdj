<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk siswa.
     */
    public function dashboard()
    {
        // Pastikan kamu punya file di resources/views/siswa/dashboard.blade.php
        return view('siswa.dashboard');
    }
}