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
        Schema::table('tabel_users', function (Blueprint $table) {
            // Kolom ini NULLABLE (karena Admin & Warga tidak punya wilayah)
            $table->unsignedBigInteger('id_dusun')->nullable()->after('role');
            
            // Relasi ke tabel dusun
            $table->foreign('id_dusun')->references('id_dusun')->on('tabel_dusun')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('tabel_users', function (Blueprint $table) {
            $table->dropForeign(['id_dusun']);
            $table->dropColumn('id_dusun');
        });
    }
};