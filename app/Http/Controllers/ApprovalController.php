<?php

namespace App\Http\Controllers;

use App\Models\AjuanSurat;
use App\Models\PejabatDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    /**
     * Menampilkan daftar surat yang MENUNGGU persetujuan pejabat yang sedang login.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Cari data pejabat desa yang terhubung dengan user ini
        $pejabatSaya = PejabatDesa::where('id_user', $user->id_user)->first();

        if (!$pejabatSaya) {
            return redirect()->back()->with('error', 'Akun Anda tidak terdaftar sebagai Pejabat Penandatangan.');
        }

        // Cari surat yang MENUNGGU_TTD dan melibatkan pejabat ini (Pejabat 1 atau 2)
        // Dan belum disetujui oleh pejabat ini
        $pendingList = AjuanSurat::with('warga', 'jenisSurat')
            ->where('status', 'MENUNGGU_TTD')
            ->where(function ($query) use ($pejabatSaya) {
                // Kasus sebagai Pejabat 1
                $query->where(function ($q) use ($pejabatSaya) {
                    $q->where('id_pejabat_desa', $pejabatSaya->id_pejabat_desa)
                      ->whereNull('acc_at_pejabat_1');
                })
                // Kasus sebagai Pejabat 2
                ->orWhere(function ($q) use ($pejabatSaya) {
                    $q->where('id_pejabat_desa_2', $pejabatSaya->id_pejabat_desa)
                      ->whereNull('acc_at_pejabat_2');
                });
            })
            ->orderBy('tanggal_ajuan', 'asc')
            ->get();

        return view('admin.approval.index', compact('pendingList', 'pejabatSaya'));
    }

    /**
     * Setujui surat (Bubuhkan Tanda Tangan Secara Sistem)
     */
    public function approve(Request $request, AjuanSurat $ajuan)
    {
        $user = Auth::user();
        $pejabatSaya = PejabatDesa::where('id_user', $user->id_user)->first();

        if (!$pejabatSaya) {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        if ($ajuan->status != 'MENUNGGU_TTD') {
            return redirect()->back()->with('error', 'Status surat tidak valid untuk disetujui.');
        }

        // Cek peran pejabat di surat ini
        $isP1 = $ajuan->id_pejabat_desa == $pejabatSaya->id_pejabat_desa;
        $isP2 = $ajuan->id_pejabat_desa_2 == $pejabatSaya->id_pejabat_desa;

        if (!$isP1 && !$isP2) {
            return redirect()->back()->with('error', 'Anda tidak terdaftar dalam dokumen ini.');
        }

        // Bubuhkan ACC
        if ($isP1) {
            $ajuan->acc_at_pejabat_1 = now();
        }
        if ($isP2) {
            $ajuan->acc_at_pejabat_2 = now();
        }

        // CEK APAKAH SUDAH LENGKAP?
        // Syarat Selesai:
        // 1. P1 harus sudah acc
        // 2. Jika ada P2, P2 juga harus sudah acc
        
        $p1Ok = !is_null($ajuan->acc_at_pejabat_1);
        $p2Ok = true; // Default true (kalau tidak ada P2)
        if ($ajuan->id_pejabat_desa_2) {
            $p2Ok = !is_null($ajuan->acc_at_pejabat_2);
        }

        if ($p1Ok && $p2Ok) {
            $ajuan->status = 'SELESAI';
            $msg = 'Surat berhasil disetujui dan diterbitkan (SELESAI).';
        } else {
            $msg = 'Persetujuan Anda berhasil dicatat. Menunggu pejabat lainnya.';
        }

        $ajuan->save();

        return redirect()->back()->with('success', $msg);
    }
}
