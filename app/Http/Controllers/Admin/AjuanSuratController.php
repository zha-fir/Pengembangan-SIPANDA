<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AjuanSurat;
use App\Models\PejabatDesa; // <-- Gunakan model baru
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon; // <-- Kita butuh ini untuk format tanggal

class AjuanSuratController extends Controller
{
    /**
     * Halaman "Ajuan Surat Masuk" (Hanya status BARU).
     */
    public function index()
    {
        $ajuanList = AjuanSurat::with('warga', 'jenisSurat')
                                ->where('status', 'BARU')
                                ->orderBy('tanggal_ajuan', 'asc')
                                ->get();

        // Ambil daftar pejabat untuk dropdown di modal
        $pejabatList = PejabatDesa::all();

        return view('admin.ajuan-surat.index', compact('ajuanList', 'pejabatList'));
    }

    /**
     * Halaman "Arsip Surat" (Hanya status SELESAI atau DITOLAK).
     */
    public function arsip()
    {
        $arsipList = AjuanSurat::with('warga', 'jenisSurat', 'pejabatDesa') // <-- Ganti ke pejabatDesa
                                ->whereIn('status', ['SELESAI', 'DITOLAK'])
                                ->orderBy('tanggal_ajuan', 'desc')
                                ->get();

        return view('admin.ajuan-surat.arsip', compact('arsipList'));
    }

    /**
     * Aksi: Konfirmasi ajuan dari modal.
     */
    public function konfirmasiAjuan(Request $request, AjuanSurat $ajuan)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:100',
            'id_pejabat_desa' => 'required|integer|exists:tabel_pejabat_desa,id_pejabat_desa', // <-- Cek ke tabel baru
        ]);

        $ajuan->nomor_surat = $request->nomor_surat;
        $ajuan->id_pejabat_desa = $request->id_pejabat_desa; // <-- Simpan id pejabat
        $ajuan->status = 'SELESAI'; // Langsung ubah jadi SELESAI
        $ajuan->catatan_penolakan = null; // Bersihkan catatan (jika ada)
        $ajuan->save();

        return Redirect::route('ajuan-surat.index')->with('success', 'Ajuan berhasil dikonfirmasi dan dipindahkan ke arsip.');
    }

    /**
     * Aksi: Tolak ajuan dari modal.
     */
    public function tolakAjuan(Request $request, AjuanSurat $ajuan)
    {
        $request->validate([
            'catatan_penolakan' => 'required|string|max:255',
        ]);

        $ajuan->catatan_penolakan = $request->catatan_penolakan;
        $ajuan->status = 'DITOLAK';
        $ajuan->nomor_surat = null; // Pastikan data surat kosong
        $ajuan->id_pejabat_desa = null;
        $ajuan->save();

        return Redirect::route('ajuan-surat.index')->with('success', 'Ajuan telah ditolak dan dipindahkan ke arsip.');
    }

    /**
     * Aksi: Cetak surat dari halaman arsip.
     */
    /**
     * Memproses dan men-download file Word (dari Arsip).
     */
    public function cetakSurat(AjuanSurat $ajuan)
    {
        // 1. Cek Status
        if ($ajuan->status != 'SELESAI') {
            return redirect()->route('ajuan-surat.arsip')->with('error', 'Surat ini tidak dapat dicetak.');
        }

        // 2. Load semua data relasi
        $ajuan->load('warga.kk.dusun', 'jenisSurat', 'pejabatDesa');

        $warga = $ajuan->warga;
        $kk = $warga->kk;
        $jenisSurat = $ajuan->jenisSurat;
        $pejabat = $ajuan->pejabatDesa;

        // 3. Cari file template
        $templatePath = Storage::path('public/template_surat/' . $jenisSurat->template_file);
        if (!Storage::exists('public/template_surat/' . $jenisSurat->template_file)) {
            return redirect()->route('ajuan-surat.arsip')->with('error', 'File template surat tidak ditemukan. Harap upload ulang di Manajemen Jenis Surat.');
        }

        try {
            // 4. Proses PHPWord
            $templateProcessor = new TemplateProcessor($templatePath);

            // --- Isi Data Warga ---
            $templateProcessor->setValue('nama_lengkap', $warga->nama_lengkap);
            $templateProcessor->setValue('nik', $warga->nik);
            $templateProcessor->setValue('tempat_lahir', $warga->tempat_lahir);
            $templateProcessor->setValue('tanggal_lahir', Carbon::parse($warga->tanggal_lahir)->isoFormat('D MMMM Y'));
            $templateProcessor->setValue('jenis_kelamin', $warga->jenis_kelamin);
            $templateProcessor->setValue('agama', $warga->agama);
            $templateProcessor->setValue('pekerjaan', $warga->pekerjaan);
            $templateProcessor->setValue('status_perkawinan', $warga->status_perkawinan);
            $templateProcessor->setValue('kewarganegaraan', $warga->kewarganegaraan);

            // --- Isi Data KK & Alamat ---
            $templateProcessor->setValue('alamat_kk', $kk->alamat_kk);
            $templateProcessor->setValue('rt', $kk->rt);
            $templateProcessor->setValue('rw', $kk->rw);
            $templateProcessor->setValue('nama_dusun', $kk->dusun->nama_dusun ?? 'N/A');

            // --- Isi Data Ajuan (YANG BARU) ---
            $templateProcessor->setValue('keperluan', $ajuan->keperluan);
            $templateProcessor->setValue('nomor_surat', $ajuan->nomor_surat);
            
            // --- Isi Data Pejabat (YANG BARU) ---
            $templateProcessor->setValue('nama_pejabat', $pejabat->nama_pejabat ?? 'N/A');
            $templateProcessor->setValue('jabatan_pejabat', $pejabat->jabatan ?? 'N/A');

            // --- INI BAGIAN YANG DIPERBAIKI ---
            
            // 5. Buat nama file dan simpan sementara
            $namaWargaClean = str_replace(' ', '_', $warga->nama_lengkap);
            $outputFileName = $jenisSurat->kode_surat . '_' . $namaWargaClean . '_' . date('d-m-Y') . '.docx';
            
            // Tentukan path sementara di 'storage/app/temp/'
            $tempPath = storage_path('app/temp/' . $outputFileName);

            // Pastikan folder 'temp' ada
            if (!Storage::exists('temp')) {
                Storage::makeDirectory('temp');
            }
            
            // Simpan file yang sudah diisi ke path sementara
            $templateProcessor->saveAs($tempPath);

            // 6. Download file tersebut dan hapus setelah selesai
            return response()->download($tempPath)->deleteFileAfterSend(true);
            
            // --- AKHIR PERBAIKAN ---

        } catch (\Exception $e) {
            // Tangkap error jika template ${variabel} tidak cocok
            return redirect()->route('ajuan-surat.arsip')->with('error', 'Gagal generate surat. Pastikan template Word sesuai. Error: ' . $e->getMessage());
        }
    }

    /**
     * Aksi: Menampilkan halaman detail (dari Arsip).
     */
    public function detailSurat(AjuanSurat $ajuan)
    {
        $ajuan->load('warga.kk.dusun', 'jenisSurat', 'pejabatDesa');
        return view('admin.ajuan-surat.detail', compact('ajuan'));
    }
}