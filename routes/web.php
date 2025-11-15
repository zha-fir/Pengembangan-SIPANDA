<?php
use App\Http\Controllers\Admin\DusunController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KKController;
use App\Http\Controllers\Admin\WargaController;

Route::get('/', function () {
    return view('welcome');
});

// --- TAMBAHKAN INI ---
// Grup Rute untuk Admin, dengan prefix 'admin'
Route::prefix('admin')->group(function () {
    
    // Ini akan otomatis membuat semua URL untuk CRUD Dusun
    // seperti: admin/dusun, admin/dusun/create, admin/dusun/1/edit, dll.
    Route::resource('dusun', DusunController::class);
    Route::resource('kk', KKController::class);
    Route::resource('warga', WargaController::class);
});
