<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisSurat; // <-- Untuk mengambil daftar surat
use App\Models\AjuanSurat; // <-- Untuk menyimpan ajuan
use Illuminate\Support\Facades\Auth; // <-- Untuk tahu siapa yang login
use Illuminate\Support\Facades\Redirect;

class AjuanSuratController extends Controller
{
    /**
     * Menampilkan halaman form untuk membuat ajuan baru.
     */
    public function create()
    {
        // Ambil semua jenis surat yang sudah dibuat Admin
        $jenisSuratList = JenisSurat::all();

        // Ambil data warga yang sedang login
        $warga = Auth::user()->warga; // Ingat relasi user->warga yang kita buat

        // Tampilkan view dan kirim data ke sana
        return view('citizen.ajuan.create', [
            'jenisSuratList' => $jenisSuratList,
            'warga' => $warga
        ]);
    }

    /**
     * Menyimpan ajuan surat baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi dasar
        $request->validate([
            'id_jenis_surat' => 'required|integer|exists:tabel_jenis_surat,id_jenis_surat',
            'keperluan' => 'required|string|max:255',
        ]);

        // 2. Definisikan semua kemungkinan input tambahan (sesuai name di HTML)
        $kemungkinanInput = [
            // Untuk SKU
            'bidang_usaha', 
            'nama_usaha', 
            'lokasi_usaha',
            // Untuk SKTM
            'penghasilan', 
            'jumlah_tanggungan', 
            // Untuk Kehilangan
            'barang_hilang', 
            'lokasi_kehilangan',
            // Untuk Kematian
            'hari_meninggal',
            'tgl_meninggal',
            'penyebab_kematian',
            'tempat_meninggal',
            'nama_pemilik_rumah'
        ];

        $dataTambahan = [];

        // 3. Cek satu per satu: jika warga mengisinya, kita simpan
        foreach ($kemungkinanInput as $input) {
            if ($request->filled($input)) {
                $dataTambahan[$input] = $request->input($input);
            }
        }

        // 4. Simpan ke Database
        $ajuan = new AjuanSurat();
        $ajuan->id_warga = Auth::user()->warga->id_warga;
        $ajuan->id_jenis_surat = $request->id_jenis_surat;
        $ajuan->keperluan = $request->keperluan;
        
        // Bungkus array jadi JSON string. Contoh: {"bidang_usaha":"Kuliner"}
        // Jika kosong, biarkan null
        $ajuan->data_tambahan = count($dataTambahan) > 0 ? json_encode($dataTambahan) : null;
        
        $ajuan->tanggal_ajuan = now();
        $ajuan->status = 'BARU';
        $ajuan->save();

        return Redirect::route('warga.dashboard')->with('success', 'Ajuan surat Anda telah berhasil terkirim.');
    }

    public function history()
    {
        // Ambil data warga yang login
        $warga = Auth::user()->warga;

        // Ambil SEMUA riwayat tanpa batas
        $riwayatAjuan = AjuanSurat::with('jenisSurat')
                                  ->where('id_warga', $warga->id_warga)
                                  ->orderBy('tanggal_ajuan', 'desc')
                                  ->get(); // Bisa diganti ->paginate(10) jika ingin halaman 1,2,3

        return view('citizen.ajuan.history', [
            'riwayatAjuan' => $riwayatAjuan
        ]);
    }

    /**
     * Download Surat (Khusus Warga)
     */
    public function downloadSurat(AjuanSurat $ajuan)
    {
        // 1. Cek Kepemilikan (SECURITY)
        if ($ajuan->id_warga != Auth::user()->warga->id_warga) {
            abort(403, 'Anda tidak berhak mengunduh dokumen ini.');
        }

        // 2. Cek Status
        if ($ajuan->status != 'SELESAI') {
            return redirect()->route('warga.ajuan.history')->with('error', 'Surat belum selesai diproses.');
        }

        // 3. Load Data
        $ajuan->load('warga.kk.dusun', 'jenisSurat', 'pejabatDesa', 'pejabatDesa2');

        $warga = $ajuan->warga;
        $kk = $warga->kk;
        $jenisSurat = $ajuan->jenisSurat;

        // 4. Cek File Template
        $templatePath = \Illuminate\Support\Facades\Storage::path('public/template_surat/' . $jenisSurat->template_file);
        if (!\Illuminate\Support\Facades\Storage::exists('public/template_surat/' . $jenisSurat->template_file)) {
            return redirect()->route('warga.ajuan.history')->with('error', 'File template surat tidak ditemukan.');
        }

        try {
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

            // ==========================================
            // A. DATA STATIS WARGA
            // ==========================================
            $templateProcessor->setValue('nama_lengkap', ucwords(strtolower($warga->nama_lengkap)));
            $templateProcessor->setValue('nik', $warga->nik);
            $templateProcessor->setValue('tempat_lahir', ucwords(strtolower($warga->tempat_lahir)));
            $templateProcessor->setValue('tanggal_lahir', \Carbon\Carbon::parse($warga->tanggal_lahir)->isoFormat('D MMMM Y'));
            $templateProcessor->setValue('jenis_kelamin', ucwords(strtolower($warga->jenis_kelamin)));
            $templateProcessor->setValue('agama', ucwords(strtolower($warga->agama)));
            $templateProcessor->setValue('pekerjaan', ucwords(strtolower($warga->pekerjaan)));
            $templateProcessor->setValue('kewarganegaraan', ucwords(strtolower($warga->kewarganegaraan)));

            // Alamat & Dusun
            $alamatKecil = ucwords(strtolower($kk->alamat_kk ?? '-'));
            $namaDusun   = ucwords(strtolower($kk->dusun->nama_dusun ?? 'N/A'));
            
            $templateProcessor->setValue('alamat_kk', $alamatKecil);
            $templateProcessor->setValue('rt', $kk->rt);
            $templateProcessor->setValue('rw', $kk->rw);
            $templateProcessor->setValue('nama_dusun', $namaDusun);

            $alamatLengkap = $alamatKecil . " RT " . ($kk->rt ?? '-') . "/RW " . ($kk->rw ?? '-') . " Desa " . $namaDusun;
            $templateProcessor->setValue('alamat', $alamatLengkap);

            // ==========================================
            // B. DATA HITUNGAN (UMUR)
            // ==========================================
            $umur = \Carbon\Carbon::parse($warga->tanggal_lahir)->age;
            $templateProcessor->setValue('umur', $umur . ' Tahun');

            // ==========================================
            // C. DATA ADMIN (SURAT & PEJABAT)
            // ==========================================
            $templateProcessor->setValue('kode_surat', $ajuan->nomor_surat);
            $templateProcessor->setValue('tanggal_pembuatan', \Carbon\Carbon::now()->isoFormat('D MMMM Y'));
            
            $templateProcessor->setValue('alamat_pejabat', 'Desa Panggulo, Kec. Botupingge');

            if ($ajuan->pejabatDesa) {
                $p1 = $ajuan->pejabatDesa;
                $templateProcessor->setValue('nama_pejabat', ucwords(strtolower($p1->nama_pejabat)));
                $templateProcessor->setValue('jabatan_pejabat', ucwords(strtolower($p1->jabatan)));
                $templateProcessor->setValue('nip_pejabat', $p1->nip ?? '-');
                
                $umurP1 = ($p1->tanggal_lahir) ? \Carbon\Carbon::parse($p1->tanggal_lahir)->age . ' Tahun' : '-';
                $templateProcessor->setValue('umur_pejabat', $umurP1);

                // LOGIKA TANDA TANGAN DIGITAL
                if ($p1->ttd_path && \Illuminate\Support\Facades\Storage::exists($p1->ttd_path)) {
                    $pathTTD = \Illuminate\Support\Facades\Storage::path($p1->ttd_path);
                    $templateProcessor->setImageValue('tanda_tangan', ['path' => $pathTTD, 'width' => 200, 'height' => 120, 'ratio' => true]);
                } else {
                    $templateProcessor->setValue('tanda_tangan', ' '); 
                }

            } else {
                $templateProcessor->setValue('nama_pejabat', '-');
                $templateProcessor->setValue('jabatan_pejabat', '-');
                $templateProcessor->setValue('nip_pejabat', '-');
                $templateProcessor->setValue('umur_pejabat', '-');
                $templateProcessor->setValue('tanda_tangan', ' ');
            }

            if ($ajuan->pejabatDesa2) {
                $p2 = $ajuan->pejabatDesa2;
                $templateProcessor->setValue('nama_pejabat_2', ucwords(strtolower($p2->nama_pejabat)));
                $templateProcessor->setValue('jabatan_pejabat_2', ucwords(strtolower($p2->jabatan)));
                $templateProcessor->setValue('nip_pejabat_2', $p2->nip ?? '-');
                
                $umurP2 = ($p2->tanggal_lahir) ? \Carbon\Carbon::parse($p2->tanggal_lahir)->age . ' Tahun' : '-';
                $templateProcessor->setValue('umur_pejabat_2', $umurP2);
            } else {
                $templateProcessor->setValue('nama_pejabat_2', '');
                $templateProcessor->setValue('jabatan_pejabat_2', '');
                $templateProcessor->setValue('nip_pejabat_2', '');
                $templateProcessor->setValue('umur_pejabat_2', '');
            }

            // ==========================================
            // D. DATA DINAMIS (JSON)
            // ==========================================
            $extra = json_decode($ajuan->data_tambahan, true) ?? [];

            $templateProcessor->setValue('bidang_usaha', $extra['bidang_usaha'] ?? '-');
            $templateProcessor->setValue('nama_usaha', $extra['nama_usaha'] ?? '-');
            $templateProcessor->setValue('lokasi_usaha', $extra['lokasi_usaha'] ?? '-');
            
            $templateProcessor->setValue('penghasilan', $extra['penghasilan'] ?? '-');
            $totalAnggota = \App\Models\Warga::where('id_kk', $kk->id_kk)->count();
            $jumlahTanggungan = $totalAnggota > 0 ? ($totalAnggota - 1) : 0;
            $templateProcessor->setValue('jumlah_tanggungan', $jumlahTanggungan . ' Orang');
            
            $templateProcessor->setValue('barang_hilang', $extra['barang_hilang'] ?? '-');
            $templateProcessor->setValue('lokasi_kehilangan', $extra['lokasi_kehilangan'] ?? '-');
            $templateProcessor->setValue('hari_meninggal', $extra['hari_meninggal'] ?? '-');
            $templateProcessor->setValue('tgl_meninggal', $extra['tgl_meninggal'] ?? '-');
            $templateProcessor->setValue('penyebab_kematian', $extra['penyebab_kematian'] ?? '-');
            $templateProcessor->setValue('tempat_meninggal', $extra['tempat_meninggal'] ?? '-');
            $templateProcessor->setValue('nama_pemilik_rumah', $extra['nama_pemilik_rumah'] ?? '-');
            
            $templateProcessor->setValue('keperluan', $ajuan->keperluan);

            // ==========================================
            // E. LOGIKA TABEL KELUARGA
            // ==========================================
            if ($warga->id_kk) {
                $anggotaKeluarga = \App\Models\Warga::where('id_kk', $warga->id_kk)
                                                    ->orderBy('tanggal_lahir', 'asc')
                                                    ->get();
                $dataTabel = [];
                $no = 1;
                foreach ($anggotaKeluarga as $anggota) {
                    $tglLahirAnggota = $anggota->tanggal_lahir ? \Carbon\Carbon::parse($anggota->tanggal_lahir)->isoFormat('D MMMM Y') : '-';
                    $dataTabel[] = [
                        't_no'   => $no++,
                        't_nama' => ucwords(strtolower($anggota->nama_lengkap)),
                        't_ttl'  => ucwords(strtolower($anggota->tempat_lahir ?? '-')) . ', ' . $tglLahirAnggota,
                        't_jk'   => ucwords(strtolower($anggota->jenis_kelamin)),
                        't_kk'   => $kk->no_kk,
                        't_nik'  => $anggota->nik,
                        't_hub'  => ucwords(strtolower($anggota->status_dalam_keluarga ?? '-'))
                    ];
                }

                try {
                    if(count($dataTabel) > 0) {
                        $templateProcessor->cloneRowAndSetValues('t_no', $dataTabel);
                    }
                } catch (\Exception $e) { }
            }

            // 5. Save & Download
            $namaWargaClean = str_replace(' ', '_', $warga->nama_lengkap);
            $outputFileName = $jenisSurat->kode_surat . '_' . $namaWargaClean . '_' . date('d-m-Y') . '.docx';
            $tempPath = storage_path('app/temp/' . $outputFileName);
            
            if (!\Illuminate\Support\Facades\Storage::exists('temp')) { \Illuminate\Support\Facades\Storage::makeDirectory('temp'); }
            
            $templateProcessor->saveAs($tempPath);
            return response()->download($tempPath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal generate surat: ' . $e->getMessage());
        }
    }
}