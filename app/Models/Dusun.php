<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dusun extends Model
{
    use HasFactory;

    /**
     * Beritahu Laravel untuk menggunakan tabel 'tabel_dusun'
     */
    protected $table = 'tabel_dusun';

    /**
     * Beritahu Laravel bahwa kita TIDAK menggunakan timestamps
     */
    public $timestamps = false;
}