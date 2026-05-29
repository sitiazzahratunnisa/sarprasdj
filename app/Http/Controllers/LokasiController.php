<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    // === SISI ADMIN ===

    // 1. Menampilkan halaman Data Lokasi di Admin
    public function index()
    {
        $semua_lokasi = Lokasi::all();
        return view('admin.lokasi', compact('semua_lokasi'));
    }

    // 2. Menyimpan lokasi baru yang ditambah oleh Admin
    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
        ]);

        Lokasi::create([
            'nama_lokasi' => $request->nama_lokasi
        ]);

        return redirect()->back()->with('success', 'Lokasi baru berhasil ditambahkan!');
    }

    // 3. Menghapus data lokasi
    public function destroy($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $lokasi->delete();

        return redirect()->back()->with('success', 'Lokasi berhasil dihapus!');
    }

    // 4. Menampilkan detail lokasi admin
    public function show($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        return view('admin.detail_lokasi', compact('lokasi'));
    }

    // 5. Mengubah data lokasi lama (Update)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
        ]);

        $lokasi = Lokasi::findOrFail($id);
        $lokasi->update([
            'nama_lokasi' => $request->nama_lokasi
        ]);

        return redirect()->route('admin.lokasi')->with('success', 'Data lokasi berhasil diperbarui!');
    }


    // === SISI SISWA ===

    // 6. Menampilkan Form Laporan Kerusakan untuk Siswa
    public function formSiswa()
    {
        $data_lokasi = Lokasi::all();
        return view('siswa.lapor_kerusakan', compact('data_lokasi'));
    }
}