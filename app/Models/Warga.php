<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'tabel_warga'; // Hubungkan ke 'tabel_warga'
    protected $primaryKey = 'id_warga'; // Tentukan primary key
    public $timestamps = false; // Kita tidak pakai timestamps

    /**
     * Relasi ke KK: Satu Warga dimiliki oleh satu KK.
     */
    public function kk()
    {
        return $this->belongsTo(KK::class, 'id_kk', 'id_kk');
    }

    /**
     * Relasi ke User: Satu Warga bisa punya satu akun User (untuk login).
     * Relasi ini bersifat opsional (nullable).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}