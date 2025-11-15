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
        // Ini adalah "penerjemahan" dari SQL kita ke kode Laravel
    Schema::create('tabel_dusun', function (Blueprint $table) {
        $table->id('id_dusun'); // Otomatis jadi INT(11) AUTO_INCREMENT PRIMARY KEY
        $table->string('nama_dusun', 100);
        // $table->timestamps(); // Kita tidak perlu created_at/updated_at di tabel ini
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_dusun');
    }
};
