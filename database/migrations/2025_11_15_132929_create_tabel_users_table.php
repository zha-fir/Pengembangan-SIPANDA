<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tabel_users', function (Blueprint $table) {
            $table->id('id_user'); // Sesuai SQL kita: id_user
            $table->string('username', 50)->unique();
            $table->string('password'); // Nanti akan di-hash
            $table->string('nama_lengkap', 100);
            $table->enum('role', ['warga', 'admin', 'kades']);
            // Kita tidak tambahkan timestamps() agar sesuai desain SQL awal
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tabel_users');
    }
};