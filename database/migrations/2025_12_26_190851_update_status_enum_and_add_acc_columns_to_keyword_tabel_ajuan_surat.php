<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ubah ENUM status untuk menambahkan 'MENUNGGU_TTD'
        // Kita gunakan Raw Statement agar kompatibel
        DB::statement("ALTER TABLE tabel_ajuan_surat MODIFY COLUMN status ENUM('BARU','MENUNGGU_TTD','SELESAI','DITOLAK') NOT NULL DEFAULT 'BARU'");

        // 2. Tambahkan Kolom Timestamp Approval
        Schema::table('tabel_ajuan_surat', function (Blueprint $table) {
            $table->timestamp('acc_at_pejabat_1')->nullable()->after('catatan_penolakan');
            $table->timestamp('acc_at_pejabat_2')->nullable()->after('acc_at_pejabat_1');
        });
    }

    public function down(): void
    {
        // 1. Hapus Kolom
        Schema::table('tabel_ajuan_surat', function (Blueprint $table) {
            $table->dropColumn(['acc_at_pejabat_1', 'acc_at_pejabat_2']);
        });

        // 2. Kembalikan ENUM (Warning: Data 'MENUNGGU_TTD' mungkin akan error jika tidak dibersihkan dulu)
        // Disini kita asumsikan rollback aman
        DB::statement("ALTER TABLE tabel_ajuan_surat MODIFY COLUMN status ENUM('BARU','SELESAI','DITOLAK') NOT NULL DEFAULT 'BARU'");
    }
};
