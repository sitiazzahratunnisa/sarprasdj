<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nama_barang', 'kategori', 'lokasi',
        'deskripsi', 'foto', 'status', 'catatan_admin',
        'handled_by', 'selesai_at',
    ];

    protected $casts = [
        'selesai_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => '<span class="badge badge-warning">Menunggu</span>',
            'diproses' => '<span class="badge badge-info">Diproses</span>',
            'selesai'  => '<span class="badge badge-success">Selesai</span>',
            'ditolak'  => '<span class="badge badge-danger">Ditolak</span>',
            default    => '<span class="badge">-</span>',
        };
    }
}