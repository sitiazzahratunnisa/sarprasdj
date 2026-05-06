<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::where('user_id', auth()->id())->latest()->paginate(10);
        return view('siswa.pengaduan', compact('pengaduans'));
    }

    public function create()
    {
        return view('siswa.buat-pengaduan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:150',
            'kategori'    => 'required|in:Furnitur,Elektronik,Fasilitas,Lainnya',
            'lokasi'      => 'required|string|max:150',
            'deskripsi'   => 'required|string|min:10|max:1000',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'kategori.required'    => 'Kategori wajib dipilih.',
            'lokasi.required'      => 'Lokasi wajib diisi.',
            'deskripsi.required'   => 'Deskripsi kerusakan wajib diisi.',
            'deskripsi.min'        => 'Deskripsi minimal 10 karakter.',
            'foto.image'           => 'File harus berupa gambar.',
            'foto.max'             => 'Ukuran foto maksimal 2MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengaduan-foto', 'public');
        }

        Pengaduan::create([
            'user_id'     => auth()->id(),
            'nama_barang' => $request->nama_barang,
            'kategori'    => $request->kategori,
            'lokasi'      => $request->lokasi,
            'deskripsi'   => $request->deskripsi,
            'foto'        => $fotoPath,
            'status'      => 'menunggu',
        ]);

        return redirect()->route('siswa.pengaduan')
            ->with('success', 'Pengaduan berhasil dikirim! Kami akan segera menindaklanjuti.');
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::where('user_id', auth()->id())->findOrFail($id);
        return view('siswa.detail-pengaduan', compact('pengaduan'));
    }

    public function riwayat()
    {
        $pengaduans = Pengaduan::where('user_id', auth()->id())
            ->latest()->paginate(15);
        return view('siswa.riwayat', compact('pengaduans'));
    }
}
