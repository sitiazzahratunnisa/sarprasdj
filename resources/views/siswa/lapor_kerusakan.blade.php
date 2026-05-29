<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Siswa - Laporkan Kerusakan Barang</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f7fafc; padding: 40px; }
        .form-card { max-width: 500px; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin: 0 auto; }
        h2 { color: #2b6cb0; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: 600; color: #4a5568; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box; }
        .btn-kirim { background-color: #3182ce; color: white; border: none; padding: 12px; width: 100%; border-radius: 6px; font-weight: bold; cursor: pointer; margin-top: 10px; }
        .btn-kirim:hover { background-color: #2b6cb0; }
    </style>
</head>
<body>

    <div class="form-card">
        <h2>Laporkan Barang Rusak</h2>
        
        <form action="/siswa/lapor/store" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" placeholder="Contoh: Proyektor, AC, Kursi" required>
            </div>

            <div class="form-group">
                <label>Pilih Lokasi Barang</label>
                <select name="lokasi_id" required>
                    <option value="">-- Pilih Lokasi Kerusakan --</option>
                    @foreach($data_lokasi as $lokasi)
                        <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Deskripsi Kerusakan</label>
                <textarea name="deskripsi_kerusakan" rows="4" placeholder="Jelaskan detail kerusakannya..." required></textarea>
            </div>

            <button type="submit" class="btn-kirim">Kirim Laporan Ke Admin</button>
        </form>
    </div>

</body>
</html>