@extends('layouts.modern')

@section('title', 'Laporan & Rekapitulasi')

@section('content')
<div class="space-y-6">

    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Header -->
        <div class="text-center md:text-left">
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Pusat Laporan</h1>
            <p class="text-slate-500 text-sm mt-1">Cetak laporan kependudukan dan arsip surat dalam format PDF.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Card Laporan Penduduk -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col h-full">
                <div class="p-6 pb-0 flex-1">
                    <div class="h-14 w-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl mb-4">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Laporan Data Penduduk</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Cetak data penduduk berdasarkan wilayah dusun atau filter jenis kelamin tertentu.
                    </p>
                </div>

                <div class="p-6 pt-4 bg-slate-50/50 mt-4 border-t border-slate-100">
                    <form action="{{ route('kades.laporan.cetakPenduduk') }}" method="GET" target="_blank" class="space-y-3">
                        <div>
                             <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Pilih Dusun</label>
                            <select name="id_dusun" class="w-full bg-white border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 transition-all outline-none">
                                <option value="">- Semua Dusun -</option>
                                @foreach($dusunList as $dusun)
                                    <option value="{{ $dusun->id_dusun }}">{{ $dusun->nama_dusun }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                             <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="w-full bg-white border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 transition-all outline-none">
                                <option value="">- Semua JK -</option>
                                <option value="LAKI-LAKI">Laki-laki</option>
                                <option value="PEREMPUAN">Perempuan</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm px-5 py-3 text-center flex items-center justify-center gap-2 transition-transform active:scale-[0.98]">
                            <i class="fas fa-print"></i> Cetak PDF
                        </button>
                    </form>
                </div>
            </div>

            <!-- Card Laporan Surat -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col h-full">
                <div class="p-6 pb-0 flex-1">
                     <div class="h-14 w-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-4">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Laporan Arsip Surat</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Rekapitulasi surat keluar yang sudah selesai diproses berdasarkan periode bulan.
                    </p>
                </div>

                <div class="p-6 pt-4 bg-slate-50/50 mt-4 border-t border-slate-100">
                    <form action="{{ route('kades.laporan.cetakSurat') }}" method="GET" target="_blank" class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Bulan</label>
                                <select name="bulan" class="w-full bg-white border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 outline-none">
                                    <option value="">- Semua -</option>
                                    @for($m=1; $m<=12; $m++)
                                        <option value="{{ $m }}" {{ $m == date('m') ? 'selected' : '' }}>
                                            {{ date("F", mktime(0, 0, 0, $m, 10)) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tahun</label>
                                <select name="tahun" class="w-full bg-white border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 outline-none">
                                    <option value="">- Semua -</option>
                                    @for($y=date('Y'); $y>=2020; $y--)
                                        <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        
                        <div>
                             <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jenis Surat</label>
                            <select name="id_jenis_surat" class="w-full bg-white border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 outline-none">
                                <option value="">- Semua Jenis -</option>
                                @foreach($jenisSuratList as $surat)
                                    <option value="{{ $surat->id_jenis_surat }}">{{ $surat->nama_surat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm px-5 py-3 text-center flex items-center justify-center gap-2 transition-transform active:scale-[0.98]">
                            <i class="fas fa-print"></i> Cetak PDF
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection