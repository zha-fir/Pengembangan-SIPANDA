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
        Schema::create('tabel_kk', function (Blueprint $table) {
        $table->id('id_kk');
        $table->string('no_kk', 16)->unique();
        $table->string('nama_kepala_keluarga', 100);
        $table->text('alamat_kk');
        $table->string('rt', 3)->nullable();
        $table->string('rw', 3)->nullable();

        // Ini cara membuat Foreign Key (Relasi)
        $table->unsignedBigInteger('id_dusun')->nullable();
        $table->foreign('id_dusun')
              ->references('id_dusun')
              ->on('tabel_dusun')
              ->onDelete('set null'); // Jika dusun dihapus, id_dusun di KK jadi NULL

        // $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_kk');
    }
};
