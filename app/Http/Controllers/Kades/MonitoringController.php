<?php

namespace App\Http\Controllers\Kades;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AjuanSurat;
use App\Models\Dusun;
use App\Models\JenisSurat;

class MonitoringController extends Controller
{
    /**
     * Menampilkan daftar surat dengan fitur Filter.
     */
    public function index(Request $request)
    {
        // 1. Siapkan Query Builder (dengan relasi yang dibutuhkan)
        $query = AjuanSurat::with(['warga.kk.dusun', 'jenisSurat'])
                           ->orderBy('tanggal_ajuan', 'desc');

        // 2. Logika Filter Berdasarkan Request

        // Filter: Jenis Surat
        if ($request->filled('id_jenis_surat')) {
            $query->where('id_jenis_surat', $request->id_jenis_surat);
        }

        // Filter: Tanggal (Spesifik)
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_ajuan', $request->tanggal);
        }

        // Filter: Dusun (Agak rumit karena relasinya jauh: Surat -> Warga -> KK -> Dusun)
        if ($request->filled('id_dusun')) {
            $query->whereHas('warga.kk', function($q) use ($request) {
                $q->where('id_dusun', $request->id_dusun);
            });
        }

        // Filter: Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Eksekusi Query (Pagination 10 per halaman)
        $ajuanList = $query->paginate(10)->withQueryString();

        // 4. Ambil Data Master untuk Dropdown Filter
        $dusunList = Dusun::all();
        $jenisSuratList = JenisSurat::all();

        return view('kades.monitoring.index', compact('ajuanList', 'dusunList', 'jenisSuratList'));
    }

    /**
     * Menampilkan Detail Surat (Read Only).
     */
    public function show($id)
    {
        $ajuan = AjuanSurat::with(['warga.kk.dusun', 'jenisSurat', 'pejabatDesa', 'pejabatDesa2'])
                           ->findOrFail($id);

        return view('kades.monitoring.show', compact('ajuan'));
    }
}