<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'lokasis';

    // Menentukan kolom mana saja yang boleh diisi
    protected $fillable = ['nama_lokasi'];
}