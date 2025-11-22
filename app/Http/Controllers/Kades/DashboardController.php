<?php

namespace App\Http\Controllers\Kades;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\KK;
use App\Models\AjuanSurat;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Kependudukan
        $totalWarga = Warga::count();
        $totalKK = KK::count();
        $wargaLaki = Warga::where('jenis_kelamin', 'LAKI-LAKI')->count();
        $wargaPerempuan = Warga::where('jenis_kelamin', 'PEREMPUAN')->count();

        // Statistik Surat (Bulan Ini)
        $bulanIni = date('m');
        $suratMasuk = AjuanSurat::whereMonth('tanggal_ajuan', $bulanIni)->count();
        $suratSelesai = AjuanSurat::whereMonth('tanggal_ajuan', $bulanIni)
                                  ->where('status', 'SELESAI')->count();
        $suratDitolak = AjuanSurat::whereMonth('tanggal_ajuan', $bulanIni)
                                  ->where('status', 'DITOLAK')->count();

        return view('kades.dashboard', compact(
            'totalWarga', 'totalKK', 'wargaLaki', 'wargaPerempuan',
            'suratMasuk', 'suratSelesai', 'suratDitolak'
        ));
    }
}