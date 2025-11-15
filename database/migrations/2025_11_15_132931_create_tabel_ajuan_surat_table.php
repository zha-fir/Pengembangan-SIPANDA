<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tabel_ajuan_surat', function (Blueprint $table) {
            $table->id('id_ajuan');

            // Relasi ke tabel_warga
            $table->unsignedBigInteger('id_warga');
            $table->foreign('id_warga')->references('id_warga')->on('tabel_warga')->onDelete('cascade');

            // Relasi ke tabel_jenis_surat
            $table->unsignedBigInteger('id_jenis_surat')->nullable();
            $table->foreign('id_jenis_surat')->references('id_jenis_surat')->on('tabel_jenis_surat')->onDelete('set null');

            $table->timestamp('tanggal_ajuan')->useCurrent();
            $table->enum('status', ['BARU', 'DIPROSES', 'DITOLAK', 'SELESAI'])->default('BARU');
            
            $table->string('nomor_surat_lengkap', 100)->nullable();
            $table->text('catatan_penolakan')->nullable();
            $table->string('file_hasil', 255)->nullable(); // Path ke file .docx hasil generate
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tabel_ajuan_surat');
    }
};