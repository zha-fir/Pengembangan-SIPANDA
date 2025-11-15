<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tabel_jenis_surat', function (Blueprint $table) {
            $table->id('id_jenis_surat');
            $table->string('nama_surat', 150);
            $table->string('kode_surat', 20)->nullable();
            $table->string('template_file', 255); // Nama file, mis: 'template_sku.docx'
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tabel_jenis_surat');
    }
};