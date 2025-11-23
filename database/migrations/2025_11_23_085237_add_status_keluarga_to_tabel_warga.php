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
        Schema::table('tabel_warga', function (Blueprint $table) {
            $table->enum('status_dalam_keluarga', ['KEPALA KELUARGA', 'ISTRI', 'ANAK', 'FAMILI LAIN'])
                ->default('FAMILI LAIN')
                ->after('id_kk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tabel_warga', function (Blueprint $table) {
            $table->dropColumn('status_dalam_keluarga');
        });
    }
};