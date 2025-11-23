<?php

namespace App\Http\Controllers\Kades;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    /**
     * Menampilkan daftar penduduk dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        // 1. Siapkan Query (Eager load KK dan Dusun agar efisien)
        $query = Warga::with('kk.dusun');

        // 2. Logika Pencarian (NIK atau Nama)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        // 3. Ambil data (Paginate 10 per halaman)
        // withQueryString() penting agar saat pindah halaman, hasil pencarian tidak hilang
        $wargaList = $query->orderBy('nama_lengkap', 'asc')->paginate(10)->withQueryString();

        return view('kades.penduduk.index', compact('wargaList'));
    }

    /**
     * Menampilkan detail lengkap satu warga.
     */
    public function show($id)
    {
        // Cari warga berdasarkan ID, jika tidak ada -> 404 Not Found
        $warga = Warga::with(['kk.dusun', 'kk.kepalaKeluarga'])->findOrFail($id);

        return view('kades.penduduk.show', compact('warga'));
    }
}