<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk tambah kolom role.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek dulu apakah kolom role sudah ada, jika belum baru buat
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('siswa')->after('email');
            }
        });
    }

    /**
     * Batalkan migrasi (hapus kolom role).
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};