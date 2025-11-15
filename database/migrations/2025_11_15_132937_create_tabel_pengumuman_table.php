<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tabel_pengumuman', function (Blueprint $table) {
            $table->id('id_pengumuman');
            $table->string('judul', 255);
            $table->text('isi_pengumuman');
            $table->timestamp('tanggal_post')->useCurrent();

            // Relasi ke admin/kades yang memposting
            $table->unsignedBigInteger('id_user_admin')->nullable();
            $table->foreign('id_user_admin')->references('id_user')->on('tabel_users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tabel_pengumuman');
    }
};