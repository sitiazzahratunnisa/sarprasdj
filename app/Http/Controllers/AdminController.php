<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Menampilkan ringkasan statistik di Dashboard Admin.
     */
    public function dashboard()
    {
        $stats = [
            'total'    => Pengaduan::count(),
            'menunggu' => Pengaduan::where('status', 'menunggu')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai'  => Pengaduan::where('status', 'selesai')->count(),
        ];
        
        $terbaru = Pengaduan::with('user')->latest()->take(10)->get();
        
        return view('admin.dashboard', compact('stats', 'terbaru'));
    }

    /**
     * Menampilkan daftar semua pengaduan dengan fitur filter dan pencarian.
     */
    public function pengaduan(Request $request)
    {
        $query = Pengaduan::with('user');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_barang', 'like', "%{$request->search}%")
                  ->orWhere('lokasi', 'like', "%{$request->search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$request->search}%"));
            });
        }

        $pengaduans = $query->latest()->paginate(15);
        return view('admin.pengaduan', compact('pengaduans'));
    }

    /**
     * Menampilkan detail pengaduan spesifik.
     */
    public function detailPengaduan($id)
    {
        $pengaduan = Pengaduan::with('user')->findOrFail($id);
        return view('admin.detail-pengaduan', compact('pengaduan'));
    }

    /**
     * Memperbarui status pengaduan (Tanpa Catatan Admin).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update([
            'status'     => $request->status,
            'handled_by' => auth()->id(),
            'selesai_at' => $request->status === 'selesai' ? now() : null,
        ]);

        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    // ================= FITUR DATA BARANG (INVENTARIS) =================

    /**
     * Menampilkan daftar barang (Menggunakan groupBy agar tombol aksi punya ID).
     */
    public function dataBarang()
    {
        // Menggunakan id agar tombol edit/hapus bisa berfungsi
        $barang = Pengaduan::select('id', 'nama_barang', 'kategori', 'lokasi')
            ->latest()
            ->get()
            ->unique('nama_barang'); // Memastikan daftar barang tidak duplikat di tabel inventaris
            
        return view('admin.data-barang', compact('barang'));
    }

    public function createBarang()
    {
        return view('admin.create-barang');
    }

    public function storeBarang(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori'    => 'required',
            'lokasi'      => 'required',
        ]);

        // Menyimpan barang baru ke tabel pengaduan sebagai data master inventaris
        Pengaduan::create([
            'user_id'     => auth()->id(),
            'nama_barang' => $request->nama_barang,
            'kategori'    => $request->kategori,
            'lokasi'      => $request->lokasi,
            'deskripsi'   => 'Data Inventaris Sekolah',
            'status'      => 'selesai',
        ]);

        return redirect()->route('admin.barang')->with('success', 'Barang berhasil ditambahkan ke inventaris');
    }

    public function editBarang($id)
    {
        $barang = Pengaduan::findOrFail($id);
        return view('admin.edit-barang', compact('barang'));
    }

    public function updateBarang(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori'    => 'required',
            'lokasi'      => 'required',
        ]);

        $barang = Pengaduan::findOrFail($id);
        $barang->update($request->only(['nama_barang', 'kategori', 'lokasi']));

        return redirect()->route('admin.barang')->with('success', 'Data inventaris berhasil diperbarui');
    }

    public function destroyBarang($id)
    {
        $barang = Pengaduan::findOrFail($id);
        $barang->delete();

        return redirect()->route('admin.barang')->with('success', 'Barang berhasil dihapus dari inventaris');
    }

    // ================= FITUR DATA SISWA =================

    public function dataSiswa()
    {
        $siswa = User::where('role', 'siswa')->withCount('pengaduans')->paginate(20);
        return view('admin.data-siswa', compact('siswa'));
    }

    public function createSiswa()
    {
        return view('admin.create-siswa');
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'siswa'
        ]);

        return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil ditambahkan');
    }

    public function editSiswa($id)
    {
        $siswa = User::findOrFail($id);
        return view('admin.edit-siswa', compact('siswa'));
    }

    public function updateSiswa(Request $request, $id)
    {
        $siswa = User::findOrFail($id);

        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $siswa->update($data);

        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroySiswa($id)
    {
        $siswa = User::findOrFail($id);
        $siswa->delete();

        return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil dihapus');
    }

    // ================= LAPORAN =================

    public function laporan()
    {
        $data = Pengaduan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total, status')
            ->groupBy('bulan', 'status')
            ->get();
        return view('admin.laporan', compact('data'));
    }
}