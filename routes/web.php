<?php

// --- BAGIAN 1: DAFTAR SEMUA CONTROLLER KITA ---
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Citizen\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DusunController;
use App\Http\Controllers\Admin\KKController;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\Admin\JenisSuratController;
use App\Http\Controllers\Admin\PejabatDesaController;
use App\Http\Controllers\Admin\ImportWargaController;
// Alias untuk Controller yang namanya sama
use App\Http\Controllers\Admin\AjuanSuratController as AdminAjuanSuratController;
use App\Http\Controllers\Citizen\AjuanSuratController as CitizenAjuanSuratController;


// --- BAGIAN 2: RUTE HALAMAN UTAMA & WARGA ---

// Rute Halaman Utama (default-nya adalah form login)
Route::get('/', function () {
    return redirect()->route('warga.login.form');
});

// Grup Rute Warga
Route::prefix('warga')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('warga.login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('warga.login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('warga.logout');

    // Rute yang HANYA bisa diakses setelah login
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('warga.dashboard');
        Route::get('/ajuan-surat', [CitizenAjuanSuratController::class, 'create'])->name('warga.ajuan.create');
        Route::post('/ajuan-surat', [CitizenAjuanSuratController::class, 'store'])->name('warga.ajuan.store');
    });
});


// --- BAGIAN 3: RUTE ADMIN ---

Route::prefix('admin')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // CRUD Biasa
    Route::resource('dusun', DusunController::class);
    Route::resource('kk', KKController::class);
    Route::resource('warga', WargaController::class);
    Route::resource('jenis-surat', JenisSuratController::class);
    Route::resource('pejabat-desa', PejabatDesaController::class);

    // Rute Spesial (Import, Anggota KK)
    Route::get('kk/{kk}/members', [KKController::class, 'showMembers'])->name('kk.members');
    Route::get('import-warga', [ImportWargaController::class, 'showForm'])->name('admin.warga.import.form');
    Route::post('import-warga', [ImportWargaController::class, 'import'])->name('admin.warga.import.submit');

    // --- BLOK RUTE AJUAN SURAT (YANG SUDAH DIPERBAIKI) ---
    
    // Rute Resource (index, create, store, edit, update, destroy)
    Route::resource('ajuan-surat', AdminAjuanSuratController::class);
    
    // Rute Halaman Arsip
    Route::get('arsip-surat', [AdminAjuanSuratController::class, 'arsip'])->name('ajuan-surat.arsip');

    // Rute Aksi (dari Modal)
    Route::post('ajuan-surat/{ajuan}/tolak', [AdminAjuanSuratController::class, 'tolakAjuan'])
        ->name('ajuan-surat.tolak');
    Route::post('ajuan-surat/{ajuan}/konfirmasi', [AdminAjuanSuratController::class, 'konfirmasiAjuan'])
        ->name('ajuan-surat.konfirmasi');

    // Rute Aksi (dari Arsip)
    Route::get('ajuan-surat/{ajuan}/cetak', [AdminAjuanSuratController::class, 'cetakSurat'])
        ->name('ajuan-surat.cetak');
    Route::get('ajuan-surat/{ajuan}/detail', [AdminAjuanSuratController::class, 'detailSurat'])
        ->name('ajuan-surat.detail');
        
    // (Rute 'ajuan-surat.proses' yang lama sudah saya hapus)
});