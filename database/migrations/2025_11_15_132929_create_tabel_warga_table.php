<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tabel_warga', function (Blueprint $table) {
            $table->id('id_warga');
            $table->string('nik', 16)->unique();
            $table->string('nama_lengkap', 100);

            // Relasi ke tabel_kk (dibuat di langkah sebelumnya)
            $table->unsignedBigInteger('id_kk')->nullable();
            $table->foreign('id_kk')->references('id_kk')->on('tabel_kk')->onDelete('set null');

            // Relasi ke tabel_users (dibuat di atas)
            $table->unsignedBigInteger('id_user')->nullable()->unique();
            $table->foreign('id_user')->references('id_user')->on('tabel_users')->onDelete('set null');

            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['LAKI-LAKI', 'PEREMPUAN'])->nullable();
            $table->string('agama', 50)->nullable();
            $table->string('status_perkawinan', 50)->nullable();
            $table->string('pekerjaan', 100)->nullable();
            $table->string('kewarganegaraan', 50)->default('WNI');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tabel_warga');
    }
};