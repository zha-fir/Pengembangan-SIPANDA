@extends('layouts.modern')

@section('title', 'Detail Ajuan Surat')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('ajuan-surat.arsip') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 mb-2 transition-colors">
                <i class="fas fa-arrow-left"></i> Kembali ke Arsip
            </a>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-3">
                Detail Ajuan #{{ $ajuan->id_ajuan }}
                 @if($ajuan->status == 'SELESAI')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                         SELESAI
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 border border-rose-200">
                         DITOLAK
                    </span>
                @endif
            </h1>
        </div>
    </div>

    @if($ajuan->status == 'DITOLAK')
        <div class="bg-rose-50 border border-rose-200 rounded-2xl p-6">
            <h3 class="font-bold text-rose-900 mb-2 flex items-center gap-2">
                <i class="fas fa-times-circle"></i> Alasan Penolakan
            </h3>
            <p class="text-rose-800 text-sm leading-relaxed">{{ $ajuan->catatan_penolakan }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Data Pemohon -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden h-full">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h3 class="font-bold text-slate-800">
                    <i class="fas fa-user-circle text-indigo-500 mr-2"></i> Data Pemohon
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Nama Lengkap</label>
                    <p class="font-medium text-slate-800 text-lg">{{ optional($ajuan->warga)->nama_lengkap ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-wider text-slate-500 font-semibold">NIK</label>
                    <p class="font-mono text-slate-700 bg-slate-100 px-2 py-1 rounded inline-block">{{ optional($ajuan->warga)->nik ?? 'N/A' }}</p>
                </div>
                 <div>
                    <label class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Tempat, Tanggal Lahir</label>
                    <p class="text-slate-700">
                        {{ optional($ajuan->warga)->tempat_lahir ?? 'N/A' }}, 
                        {{ optional($ajuan->warga)->tanggal_lahir ? \Carbon\Carbon::parse($ajuan->warga->tanggal_lahir)->isoFormat('D MMMM Y') : 'N/A' }}
                    </p>
                </div>
                 <div>
                    <label class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Alamat</label>
                    <p class="text-slate-700 leading-relaxed">{{ optional(optional($ajuan->warga)->kk)->alamat_kk ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Data Surat -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden h-full">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h3 class="font-bold text-slate-800">
                    <i class="fas fa-file-alt text-blue-500 mr-2"></i> Data Surat
                </h3>
            </div>
            <div class="p-6 space-y-4">
                 <div>
                    <label class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Jenis Surat</label>
                    <p class="font-medium text-blue-700">{{ optional($ajuan->jenisSurat)->nama_surat ?? 'N/A' }}</p>
                </div>
                 <div>
                    <label class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Keperluan</label>
                    <p class="text-slate-700">{{ $ajuan->keperluan }}</p>
                </div>
                 <div>
                    <label class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Nomor Surat Resmi</label>
                    <p class="font-mono text-slate-700">{{ $ajuan->nomor_surat ?? '-' }}</p>
                </div>
                 <div class="pt-4 border-t border-slate-100">
                     <div class="flex items-center gap-3">
                         <div class="h-10 w-10 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-600">
                             <i class="fas fa-signature"></i>
                         </div>
                         <div>
                             <label class="text-xs uppercase tracking-wider text-slate-500 font-semibold block">Penandatangan</label>
                             <p class="text-sm font-bold text-slate-800">{{ optional($ajuan->pejabatDesa)->nama_pejabat ?? 'N/A' }}</p>
                             <p class="text-xs text-slate-500">{{ optional($ajuan->pejabatDesa)->jabatan ?? 'N/A' }}</p>
                         </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection