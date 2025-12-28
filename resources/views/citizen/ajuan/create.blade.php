@extends('layouts.citizen')

@section('title', 'Buat Pengajuan Baru')

@section('content')

    <div class="max-w-4xl mx-auto">
        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            
            <div class="p-6 md:p-8">
                
                {{-- Error Validation --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-600 text-sm">
                        <div class="font-bold flex items-center gap-2 mb-2">
                            <i class="fas fa-exclamation-triangle"></i> Terjadi Kesalahan:
                        </div>
                        <ul class="list-disc list-inside space-y-1 ml-1 text-rose-500">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('warga.ajuan.store') }}" method="POST">
                    @csrf

                    <!-- User Info Alert -->
                    <div class="mb-8 p-4 rounded-xl bg-indigo-50 border border-indigo-100 flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                            <i class="fas fa-user-circle text-lg"></i>
                        </div>
                        <div>
                            <h6 class="font-bold text-indigo-900 text-sm uppercase tracking-wide mb-1">Informasi Pemohon</h6>
                            <p class="text-indigo-700 text-sm">
                                NIK: <span class="font-semibold">{{ $warga->nik }}</span> <span class="mx-2">•</span> 
                                Nama: <span class="font-semibold">{{ $warga->nama_lengkap }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        
                        {{-- 1. PILIH JENIS SURAT --}}
                        <div>
                            <label for="id_jenis_surat" class="block text-sm font-bold text-slate-700 mb-2">
                                Pilih Jenis Surat <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <select id="id_jenis_surat" name="id_jenis_surat" required
                                    class="w-full pl-4 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all appearance-none cursor-pointer">
                                    <option value="">-- Silakan Pilih Surat --</option>
                                    @foreach ($jenisSuratList as $surat)
                                        <option value="{{ $surat->id_jenis_surat }}">
                                            {{ $surat->nama_surat }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-brand-600 flex items-center gap-1.5">
                                <i class="fas fa-info-circle"></i> Pilih jenis surat di atas, formulir isian akan muncul otomatis di bawah.
                            </p>
                        </div>

                        {{-- ================================================= --}}
                        {{-- AREA FORM DINAMIS (Awalnya Tersembunyi / hidden) --}}
                        {{-- ================================================= --}}

                        {{-- A. FORM KHUSUS SKU (Usaha) --}}
                        <div class="hidden extra-form" id="form_sku">
                            <div class="p-5 rounded-xl bg-slate-50 border border-slate-200 border-l-4 border-l-brand-500">
                                <h6 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                                    <i class="fas fa-store text-brand-500"></i> Detail Usaha
                                </h6>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-1.5">Jenis/Bidang Usaha</label>
                                        <input type="text" name="bidang_usaha" class="input-extra w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none" placeholder="Contoh: Kuliner / Pertanian">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-1.5">Nama Usaha (Opsional)</label>
                                        <input type="text" name="nama_usaha" class="input-extra w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none" placeholder="Contoh: Warung Makan Berkah">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-bold text-slate-500 mb-1.5">Alamat/Lokasi Usaha</label>
                                        <input type="text" name="lokasi_usaha" class="input-extra w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none" placeholder="Contoh: Dusun I, Desa Panggulo">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- B. FORM KHUSUS SKTM --}}
                        <div class="hidden extra-form" id="form_sktm">
                            <div class="p-5 rounded-xl bg-slate-50 border border-slate-200 border-l-4 border-l-brand-500">
                                <h6 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                                    <i class="fas fa-wallet text-brand-500"></i> Detail Ekonomi
                                </h6>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Penghasilan Rata-rata (Per Bulan)</label>
                                    <input type="text" name="penghasilan" class="input-extra w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none" placeholder="Contoh: Rp 500.000">
                                </div>
                                <p class="mt-2 text-xs text-slate-400 italic">
                                    * Jumlah tanggungan akan dihitung otomatis berdasarkan data Kartu Keluarga Anda di sistem.
                                </p>
                            </div>
                        </div>

                        {{-- C. FORM KHUSUS KEHILANGAN --}}
                        <div class="hidden extra-form" id="form_kehilangan">
                            <div class="p-5 rounded-xl bg-slate-50 border border-slate-200 border-l-4 border-l-brand-500">
                                <h6 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                                    <i class="fas fa-search text-brand-500"></i> Detail Kehilangan
                                </h6>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-1.5">Barang/Dokumen yang Hilang</label>
                                        <input type="text" name="barang_hilang" class="input-extra w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none" placeholder="Contoh: KTP, SIM, atau ATM">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-1.5">Lokasi & Waktu Kejadian</label>
                                        <input type="text" name="lokasi_kehilangan" class="input-extra w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none" placeholder="Contoh: Pasar Sentral, Hari Senin jam 10 pagi">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- D. FORM KHUSUS KEMATIAN --}}
                        <div class="hidden extra-form" id="form_kematian">
                            <div class="p-5 rounded-xl bg-slate-50 border border-slate-200 border-l-4 border-l-brand-500">
                                <h6 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                                    <i class="fas fa-book-dead text-brand-500"></i> Detail Kematian
                                </h6>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-1.5">Hari Meninggal</label>
                                        <input type="text" name="hari_meninggal" class="input-extra w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none" placeholder="Contoh: Senin">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-1.5">Tanggal Meninggal</label>
                                        <input type="date" name="tgl_meninggal" class="input-extra w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-1.5">Penyebab Kematian</label>
                                        <input type="text" name="penyebab_kematian" class="input-extra w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none" placeholder="Contoh: Sakit Tua">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-1.5">Tempat Meninggal</label>
                                        <input type="text" name="tempat_meninggal" class="input-extra w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none" placeholder="Contoh: Rumah Sakit">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- E. FORM KHUSUS MENUMPANG --}}
                        <div class="hidden extra-form" id="form_menumpang">
                            <div class="p-5 rounded-xl bg-slate-50 border border-slate-200 border-l-4 border-l-brand-500">
                                <h6 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                                    <i class="fas fa-home text-brand-500"></i> Detail Tempat Tinggal
                                </h6>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Nama Orang Tua / Pemilik Rumah</label>
                                    <input type="text" name="nama_pemilik_rumah" class="input-extra w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none" placeholder="Contoh: Budi Santoso (Ayah)">
                                    <p class="mt-1 text-xs text-slate-400">Masukkan nama lengkap orang tua atau pemilik rumah yang Anda tumpangi.</p>
                                </div>
                            </div>
                        </div>

                        {{-- BATAS AKHIR FORM DINAMIS --}}

                        {{-- 2. KEPERLUAN --}}
                        <div>
                            <label for="keperluan" class="block text-sm font-bold text-slate-700 mb-2">
                                Keperluan Surat <span class="text-rose-500">*</span>
                            </label>
                            <textarea id="keperluan" name="keperluan" rows="3" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all placeholder-slate-400"
                                placeholder="Contoh: Persyaratan Melamar Pekerjaan">{{ old('keperluan') }}</textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('warga.dashboard') }}" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl shadow-lg shadow-brand-200 hover:shadow-brand-300 transform transition-all active:scale-95 flex items-center gap-2">
                                <i class="fas fa-paper-plane text-sm"></i>
                                <span>Kirim Permohonan</span>
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Saat dropdown berubah
            $('#id_jenis_surat').change(function () {
                var selectedText = $(this).find("option:selected").text().toLowerCase();

                // 1. RESET: Sembunyikan SEMUA form (tambah class hidden), Hapus animasi
                $('.extra-form').addClass('hidden').removeClass('animate__animated animate__fadeInUp');
                $('.input-extra').val('');

                // 2. TAMPILKAN Form Sesuai Kondisi
                var targetId = '';
                if (selectedText.includes('usaha')) targetId = '#form_sku';
                else if (selectedText.includes('miskin') || selectedText.includes('tidak mampu') || selectedText.includes('sktm')) targetId = '#form_sktm';
                else if (selectedText.includes('hilang') || selectedText.includes('kehilangan')) targetId = '#form_kehilangan';
                else if (selectedText.includes('mati') || selectedText.includes('meninggal')) targetId = '#form_kematian';
                else if (selectedText.includes('menumpang')) targetId = '#form_menumpang';

                // Jika ada target, tampilkan + animasi
                if (targetId) {
                    $(targetId).removeClass('hidden').addClass('animate__animated animate__fadeInUp');
                }
            });
        });
    </script>
@endpush