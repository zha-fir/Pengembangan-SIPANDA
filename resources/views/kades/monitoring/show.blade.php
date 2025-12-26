@extends('layouts.modern')

@section('title', 'Detail Surat')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <a href="{{ route('kades.monitoring.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-indigo-600 font-medium transition-colors">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        
        <!-- Status Badge -->
        @if($ajuan->status == 'BARU')
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                PROSES (BELUM SELESAI)
            </span>
        @elseif($ajuan->status == 'MENUNGGU_TTD')
             <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                <i class="fas fa-pen-nib"></i> MENUNGGU TANDA TANGAN
            </span>
        @elseif($ajuan->status == 'SELESAI')
             <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                <i class="fas fa-check-circle"></i> SELESAI
            </span>
        @elseif($ajuan->status == 'DITOLAK')
             <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                <i class="fas fa-times-circle"></i> DITOLAK
            </span>
        @endif
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Left: Applicant Data -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden h-fit">
            <div class="p-5 border-b border-slate-50 bg-slate-50/50">
                 <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-user text-indigo-500"></i> Data Pemohon
                </h3>
            </div>
            <div class="p-6 space-y-4 text-sm">
                <div>
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</span>
                    <div class="font-bold text-slate-800 text-base">{{ $ajuan->warga->nama_lengkap }}</div>
                </div>
                <div>
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">NIK</span>
                    <div class="font-mono text-slate-600">{{ $ajuan->warga->nik }}</div>
                </div>
                <div>
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tempat, Tanggal Lahir</span>
                    <div class="text-slate-800">{{ $ajuan->warga->tempat_lahir }}, {{ $ajuan->warga->tanggal_lahir }}</div>
                </div>
                <div>
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat Domisili</span>
                    <div class="text-slate-800">{{ $ajuan->warga->kk->alamat_kk ?? '-' }}</div>
                    <div class="text-slate-500 text-xs mt-0.5">Dusun {{ $ajuan->warga->kk->dusun->nama_dusun ?? '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Right: Letter Info -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden h-fit">
            <div class="p-5 border-b border-slate-50 bg-slate-50/50">
                 <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-file-alt text-indigo-500"></i> Informasi Surat
                </h3>
            </div>
            <div class="p-6 space-y-4 text-sm">
                <div>
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Jenis Surat</span>
                    <div class="font-bold text-indigo-600 text-base">{{ $ajuan->jenisSurat->nama_surat }}</div>
                </div>
                 <div>
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Keperluan</span>
                    <div class="text-slate-800 leading-relaxed">{{ $ajuan->keperluan }}</div>
                </div>
                 <div>
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Pengajuan</span>
                    <div class="text-slate-800">{{ \Carbon\Carbon::parse($ajuan->tanggal_ajuan)->isoFormat('dddd, D MMMM Y') }}</div>
                </div>

                @if($ajuan->status == 'SELESAI')
                    <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-100 mt-4 space-y-2">
                        <div>
                            <span class="block text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">Nomor Surat</span>
                            <div class="font-mono font-bold text-emerald-800">{{ $ajuan->nomor_surat }}</div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 pt-2">
                            <div>
                                <span class="block text-[10px] font-bold text-emerald-600 uppercase mb-0.5">TTD Pejabat 1</span>
                                <div class="text-emerald-900 text-xs">{{ $ajuan->pejabatDesa->nama_pejabat ?? '-' }}</div>
                            </div>
                            <div>
                                <span class="block text-[10px] font-bold text-emerald-600 uppercase mb-0.5">TTD Pejabat 2</span>
                                <div class="text-emerald-900 text-xs">{{ $ajuan->pejabatDesa2->nama_pejabat ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($ajuan->status == 'DITOLAK')
                    <div class="bg-red-50 rounded-xl p-4 border border-red-100 mt-4">
                        <span class="block text-xs font-bold text-red-600 uppercase tracking-wider mb-1">Alasan Penolakan</span>
                        <div class="text-red-800 font-medium">{{ $ajuan->catatan_penolakan }}</div>
                    </div>
                @endif
            </div>

            @if($ajuan->data_tambahan)
                <div class="border-t border-slate-100 p-6 bg-slate-50/30">
                     <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Data Tambahan</span>
                     <ul class="space-y-2 text-sm text-slate-700">
                        @foreach(json_decode($ajuan->data_tambahan, true) as $key => $value)
                            <li class="flex justify-between border-b border-slate-100 pb-1 last:border-0">
                                <span class="text-slate-500 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                <span class="font-medium text-slate-900">{{ $value }}</span>
                            </li>
                        @endforeach
                     </ul>
                </div>
            @endif
        </div>

    </div>

</div>
@endsection