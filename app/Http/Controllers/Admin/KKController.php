<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KK;     // <-- 1. Impor Model KK
use App\Models\Dusun;   // <-- 2. Impor Model Dusun (KITA BUTUHKAN INI)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class KKController extends Controller
{
    /**
     * Menampilkan daftar semua KK.
     */
    public function index()
    {
        // KITA GUNAKAN 'with('dusun')'
        // Ini adalah "Eager Loading" di Laravel.
        // Ini mengambil data KK sekaligus data Dusun yang terelasi
        // agar lebih efisien dan tidak error N+1 query.
        $kkList = KK::with('dusun')->get();

        return view('admin.kk.index', [
            'kkList' => $kkList
        ]);
    }

    /**
     * Menampilkan form untuk menambah KK baru.
     */
    public function create()
    {
        // Kita perlu mengambil semua data dusun
        // untuk ditampilkan sebagai <select> (dropdown) di form.
        $dusunList = Dusun::all();

        return view('admin.kk.create', [
            'dusunList' => $dusunList
        ]);
    }

    /**
     * Menyimpan data KK baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi (termasuk validasi 'id_dusun')
        $request->validate([
            'no_kk' => 'required|string|size:16|unique:tabel_kk',
            'nama_kepala_keluarga' => 'required|string|max:100',
            'id_dusun' => 'required|integer|exists:tabel_dusun,id_dusun', // Pastikan id_dusun ada di tabel_dusun
            'rt' => 'nullable|string|max:3',
            'rw' => 'nullable|string|max:3',
            'alamat_kk' => 'required|string',
        ], [
            'no_kk.required' => 'Nomor KK wajib diisi.',
            'no_kk.unique' => 'Nomor KK ini sudah terdaftar.',
            'id_dusun.required' => 'Dusun wajib dipilih.',
        ]);

        // 2. Simpan data
        $kk = new KK();
        $kk->no_kk = $request->no_kk;
        $kk->nama_kepala_keluarga = $request->nama_kepala_keluarga;
        $kk->id_dusun = $request->id_dusun;
        $kk->rt = $request->rt;
        $kk->rw = $request->rw;
        $kk->alamat_kk = $request->alamat_kk;
        $kk->save();

        // 3. Arahkan kembali
        return Redirect::route('kk.index')->with('success', 'Data Kartu Keluarga berhasil ditambahkan.');
    }

    // ... (biarkan fungsi show, edit, update, destroy kosong dulu) ...
}