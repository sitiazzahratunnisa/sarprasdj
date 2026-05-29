<?php

namespace App\Exports;

use App\Models\Pengaduan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PengaduanExport implements FromCollection, WithHeadings, WithMapping, WithDrawings, WithStyles
{
    protected $pengaduanData;

    public function __construct()
    {
        // Mengambil semua data pengaduan beserta data user pelapornya
        $this->pengaduanData = Pengaduan::with('user')->latest()->get();
    }

    public function collection()
    {
        return $this->pengaduanData;
    }

    // 1. Membuat Judul Kolom Excel
    public function headings(): array
    {
        return [
            'No',
            'Nama Pelapor',
            'Nama Barang',
            'Kategori',
            'Lokasi / Ruangan',
            'Deskripsi Kerusakan',
            'Status',
            'Foto Bukti' // Kolom H untuk Gambar/Foto
        ];
    }

    // 2. Memetakan data dari database ke kolom teks Excel
    public function map($pengaduan): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $pengaduan->user->name ?? 'Anonim', // Mengambil nama user pelapor
            $pengaduan->nama_barang,
            $pengaduan->kategori,
            $pengaduan->lokasi,
            $pengaduan->deskripsi,
            ucfirst($pengaduan->status), // Menampilkan status (Menunggu, Proses, Selesai)
            '' // Kolom H dikosongkan karena akan ditempeli gambar lewat fungsi drawings()
        ];
    }

    // 3. Menempelkan File Foto ke Kolom H
    public function drawings()
    {
        $drawings = [];
        
        foreach ($this->pengaduanData as $index => $pengaduan) {
            // Path mengarah ke folder storage/public/pengaduan-foto/... sesuai controller Anda
            $fotoPath = public_path('storage/' . $pengaduan->foto); 

            if ($pengaduan->foto && file_exists($fotoPath)) {
                $drawing = new Drawing();
                $drawing->setName('Foto Kerusakan');
                $drawing->setDescription($pengaduan->nama_barang);
                $drawing->setPath($fotoPath); 
                $drawing->setHeight(55); // Tinggi gambar dalam pixel
                
                // Baris data dimulai dari baris ke-2 (Baris 1 adalah Heading)
                $row = $index + 2; 
                $drawing->setCoordinates('H' . $row); // Menaruh foto di kolom H
                
                // Posisi tengah sedikit di dalam cell
                $drawing->setOffsetX(12);
                $drawing->setOffsetY(6);

                $drawings[] = $drawing;
            }
        }

        return $drawings;
    }

    // 4. Mengatur Tinggi Baris Agar Cell Muat Gambar dan Rapih
    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        
        // Atur tinggi baris judul (Heading)
        $sheet->getRowDimension(1)->setRowHeight(28);

        // Atur semua baris data menjadi tinggi 65 pixel agar gambar tidak menumpuk
        for ($i = 2; $i <= $highestRow; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(65);
        }
        
        // Otomatis melebarkan kolom A sampai G sesuai panjang teks
        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Khusus kolom H (Foto) kita beri lebar manual yang pas
        $sheet->getColumnDimension('H')->setWidth(18);
    }
}