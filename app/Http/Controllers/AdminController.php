<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\PengaduanExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    // ================= DASHBOARD =================
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

    // ================= MANAJEMEN PENGADUAN =================
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
     * Fitur Cetak Excel Rekap Pengaduan + Foto Bukti
     */
    public function exportExcel(Request $request)
    {
        // Mengirimkan request filter ke class Export jika dibutuhkan di kemudian hari
        return Excel::download(new PengaduanExport($request), 'rekap_sarpras_' . date('Y-m-d') . '.xlsx');
    }

    public function detailPengaduan($id)
    {
        $pengaduan = Pengaduan::with('user')->findOrFail($id);
        return view('admin.detail-pengaduan', compact('pengaduan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'catatan_admin' => 'nullable|string'
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->route('admin.pengaduan')->with('success', 'Status berhasil diperbarui!');
    }

    public function destroyPengaduan($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->delete();

        return redirect()->route('admin.pengaduan')->with('success', 'Laporan berhasil dihapus!');
    }

    // ================= DATA BARANG (INVENTARIS) =================
    public function dataBarang()
    {
        $barang = Pengaduan::select('id', 'nama_barang', 'kategori', 'lokasi')
            ->latest()
            ->get()
            ->unique('nama_barang');
            
        return view('admin.data-barang', compact('barang'));
    }

    public function createBarang() { return view('admin.create-barang'); }

    public function storeBarang(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori'    => 'required',
            'lokasi'      => 'required',
        ]);

        Pengaduan::create([
            'user_id'     => auth()->id(),
            'nama_barang' => $request->nama_barang,
            'kategori'    => $request->kategori,
            'lokasi'      => $request->lokasi,
            'deskripsi'   => 'Data Inventaris Sekolah',
            'status'      => 'selesai',
        ]);

        return redirect()->route('admin.barang')->with('success', 'Barang berhasil ditambah!');
    }

    public function editBarang($id)
    {
        $barang = Pengaduan::findOrFail($id);
        return view('admin.edit-barang', compact('barang'));
    }

    public function updateBarang(Request $request, $id)
    {
        $barang = Pengaduan::findOrFail($id);
        $barang->update($request->only(['nama_barang', 'kategori', 'lokasi']));
        return redirect()->route('admin.barang')->with('success', 'Data diperbarui!');
    }

    public function destroyBarang($id)
    {
        $barang = Pengaduan::findOrFail($id);
        $barang->delete();
        return redirect()->route('admin.barang')->with('success', 'Barang dihapus!');
    }

    // ================= DATA SISWA =================
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