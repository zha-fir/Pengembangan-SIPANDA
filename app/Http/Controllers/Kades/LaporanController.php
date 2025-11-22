<?php

namespace App\Http\Controllers\Kades;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\AjuanSurat;
use App\Models\Dusun;
use App\Models\JenisSurat;
use Barryvdh\DomPDF\Facade\Pdf; // <-- Panggil Library PDF

class LaporanController extends Controller
{
    /**
     * Halaman Utama Menu Laporan (Pilih Filter)
     */
    public function index()
    {
        $dusunList = Dusun::all();
        $jenisSuratList = JenisSurat::all();
        
        return view('kades.laporan.index', compact('dusunList', 'jenisSuratList'));
    }

    /**
     * Cetak Laporan Kependudukan (PDF)
     */
    public function cetakPenduduk(Request $request)
    {
        $query = Warga::with('kk.dusun');

        // Filter berdasarkan Dusun
        if ($request->filled('id_dusun')) {
            $query->whereHas('kk', function($q) use ($request) {
                $q->where('id_dusun', $request->id_dusun);
            });
            $judul = 'Laporan Penduduk - Dusun ' . Dusun::find($request->id_dusun)->nama_dusun;
        } else {
            $judul = 'Laporan Penduduk - Semua Dusun';
        }

        // Filter Jenis Kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $dataWarga = $query->get();

        // Generate PDF
        $pdf = Pdf::loadView('kades.laporan.pdf_penduduk', [
            'data' => $dataWarga,
            'judul' => $judul,
            'tanggal' => date('d F Y')
        ]);

        return $pdf->stream('Laporan_Penduduk.pdf');
    }

    /**
     * Cetak Laporan Arsip Surat (PDF)
     */
    public function cetakSurat(Request $request)
    {
        // Hanya ambil yang SELESAI (yang sah)
        $query = AjuanSurat::with(['warga', 'jenisSurat', 'pejabatDesa'])
                           ->where('status', 'SELESAI');

        // Filter Bulan & Tahun
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereMonth('tanggal_ajuan', $request->bulan)
                  ->whereYear('tanggal_ajuan', $request->tahun);
            $periode = "Periode " . date("F", mktime(0, 0, 0, $request->bulan, 10)) . " " . $request->tahun;
        } else {
            $periode = "Semua Periode";
        }

        // Filter Jenis Surat
        if ($request->filled('id_jenis_surat')) {
            $query->where('id_jenis_surat', $request->id_jenis_surat);
        }

        $dataSurat = $query->get();

        // Generate PDF
        $pdf = Pdf::loadView('kades.laporan.pdf_surat', [
            'data' => $dataSurat,
            'periode' => $periode,
            'tanggal' => date('d F Y')
        ]);

        return $pdf->stream('Laporan_Arsip_Surat.pdf');
    }
}