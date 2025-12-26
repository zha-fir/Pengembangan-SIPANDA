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
        Schema::table('tabel_pejabat_desa', function (Blueprint $table) {
            // Relasi ke tabel_users (agar sistem tahu akun mana yang boleh approve)
            $table->unsignedBigInteger('id_user')->nullable()->after('id_pejabat_desa');
            // Opsional: Foreign key
             $table->foreign('id_user')->references('id_user')->on('tabel_users')->onDelete('set null');
        });

        // Seed / Update Data yang sudah ada (Hardcoded berdasarkan analisis DB)
        // Pejabat 1 (Hardware/Kades) -> User 20
        DB::table('tabel_pejabat_desa')->where('id_pejabat_desa', 1)->update(['id_user' => 20]);
        // Pejabat 2 (Asep/Mawar) -> User 21
        DB::table('tabel_pejabat_desa')->where('id_pejabat_desa', 2)->update(['id_user' => 21]);
        // Pejabat 3 (Joko/Melati) -> User 22
        DB::table('tabel_pejabat_desa')->where('id_pejabat_desa', 3)->update(['id_user' => 22]);
        // Pejabat 4 (Dedi/Anggrek) -> User 23
        DB::table('tabel_pejabat_desa')->where('id_pejabat_desa', 4)->update(['id_user' => 23]);
    }

    public function down(): void
    {
        Schema::table('tabel_pejabat_desa', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->dropColumn('id_user');
        });
    }
};
