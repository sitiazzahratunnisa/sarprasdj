<?php

namespace App\Exports;

use App\Models\Pengaduan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class PengaduanExport implements FromCollection, WithHeadings, WithMapping, WithDrawings, WithStyles
{
    protected $rowNumber = 0;
    protected $pengaduans;

    /**
    * Jalankan query filter langsung saat class di-instansiasi
    */
    public function collection()
    {
        $query = Pengaduan::with('user');

        // Jika checkbox "Export Keseluruhan Data" TIDAK dicentang, jalankan filter rentang data
        if (!request()->has('export_semua')) {
            
            // Filter Berdasarkan Tanggal Mulai
            if (request()->filled('tanggal_mulai')) {
                $query->whereDate('created_at', '>=', request()->tanggal_mulai);
            }

            // Filter Berdasarkan Tanggal Selesai
            if (request()->filled('tanggal_selesai')) {
                $query->whereDate('created_at', '<=', request()->tanggal_selesai);
            }

            // Filter Berdasarkan Status Laporan
            if (request()->filled('status_filter')) {
                $query->where('status', request()->status_filter);
            }
        }

        // Simpan data final ke properti agar sinkron dengan drawings() dan styles()
        $this->pengaduans = $query->latest()->get();
        return $this->pengaduans;
    }

    /**
    * Judul Kolom Excel
    */
    public function headings(): array
    {
        return [
            'No',
            'Nama Pelapor',
            'Nama Barang',
            'Lokasi / Ruang',
            'Deskripsi Kerusakan',
            'Status',
            'Foto Bukti'
        ];
    }

    /**
    * Mapping Data ke Kolom Excel
    */
    public function map($pengaduan): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $pengaduan->user->name ?? 'User Tidak Dikenal',
            $pengaduan->nama_barang,
            $pengaduan->lokasi,
            $pengaduan->deskripsi ?? '-',
            ucfirst($pengaduan->status),
            '' // Kolom G dikosongkan untuk tempat gambar
        ];
    }

    /**
    * Fungsi Khusus menyisipkan Foto ke dalam Kolom Excel (G)
    */
    public function drawings()
    {
        $drawings = [];
        
        // Jaga-jaga jika properti kosong, jalankan collection()
        if (!$this->pengaduans) {
            $this->collection();
        }

        foreach ($this->pengaduans as $index => $pengaduan) {
            $row = $index + 2; // Data dimulai dari baris 2 (Baris 1 Judul)

            if ($pengaduan->foto) {
                // Alternatif path 1: Jika file disimpan lewat Storage::disk('public')
                $path = public_path('storage/' . $pengaduan->foto);
                
                // Alternatif path 2: Jika di database tersimpan string beserta kata 'storage/' (misal: storage/pengaduan/foto.jpg)
                if (!file_exists($path)) {
                    $path = public_path($pengaduan->foto);
                }

                if (file_exists($path)) {
                    $drawing = new Drawing();
                    $drawing->setName('Foto');
                    $drawing->setDescription($pengaduan->nama_barang);
                    $drawing->setPath($path);
                    $drawing->setHeight(50); // Tinggi gambar dalam pixel
                    $drawing->setCoordinates('G' . $row); // Taruh di kolom G
                    $drawing->setOffsetX(15); // Geser horizontal agar di tengah sel
                    $drawing->setOffsetY(5);  // Geser vertikal agar di tengah sel
                    
                    $drawings[] = $drawing;
                }
            }
        }

        return $drawings;
    }

    /**
    * Mengatur tata letak tinggi baris dan lebar kolom
    */
    public function styles(Worksheet $sheet)
    {
        if (!$this->pengaduans) {
            $this->collection();
        }

        // Judul Bold
        $sheet->getStyle('1')->getFont()->setBold(true);

        // Atur tinggi setiap baris data agar menampung gambar dengan pas
        foreach ($this->pengaduans as $index => $pengaduan) {
            $row = $index + 2;
            $sheet->getRowDimension($row)->setRowHeight(55); // Set tinggi baris excel
        }

        // Lebar kolom
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(35);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(22); // Kolom G tempat gambar
    }
}