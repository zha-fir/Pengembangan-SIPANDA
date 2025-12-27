@extends('layouts.modern')

@section('title', 'Detail Penduduk')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

     <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
             <a href="{{ route('warga.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 mb-2 transition-colors">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Detail Data Penduduk</h1>
        </div>
        <a href="{{ route('warga.edit', $warga->id_warga) }}" class="inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm shadow-amber-200">
            <i class="fas fa-edit"></i> Edit Data
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Left: Profile Summary -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 text-center sticky top-24">
                 <div class="w-24 h-24 mx-auto bg-slate-100 rounded-full border-4 border-slate-50 flex items-center justify-center text-slate-400 text-3xl font-bold mb-4">
                     {{ substr($warga->nama_lengkap, 0, 1) }}
                 </div>
                 
                 <h2 class="text-xl font-bold text-slate-800 leading-tight">{{ $warga->nama_lengkap }}</h2>
                 <p class="text-sm text-slate-500 font-mono mt-1">{{ $warga->nik }}</p>

                 <div class="mt-4 flex flex-wrap justify-center gap-2">
                     <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                        {{ $warga->jenis_kelamin }}
                     </span>
                      @if($warga->user)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                            Akun Aktif
                        </span>
                     @endif
                 </div>

                 <hr class="my-6 border-slate-100">

                 <div class="text-left space-y-3 text-sm">
                     <div class="flex justify-between">
                         <span class="text-slate-500">Status Keluarga</span>
                         <span class="font-medium text-slate-700">{{ $warga->status_dalam_keluarga }}</span>
                     </div>
                      <div class="flex justify-between">
                         <span class="text-slate-500">Pekerjaan</span>
                         <span class="font-medium text-slate-700">{{ $warga->pekerjaan }}</span>
                     </div>
                 </div>
            </div>
        </div>

        <!-- Right: Detailed Info -->
         <div class="md:col-span-2 space-y-6">
            
            <!-- Biodata Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center gap-2 font-bold text-slate-700">
                    <i class="fas fa-id-card-alt text-indigo-500"></i> Biodata Lengkap
                </div>
                <div class="p-6">
                    <dl class="space-y-4 text-sm">
                         <div class="grid grid-cols-3 gap-4 border-b border-slate-50 pb-4">
                            <dt class="text-slate-500 font-medium">Tempat, Tgl Lahir</dt>
                            <dd class="col-span-2 text-slate-800 font-semibold">
                                {{ $warga->tempat_lahir }}, {{ \Carbon\Carbon::parse($warga->tanggal_lahir)->isoFormat('D MMMM Y') }}
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4 border-b border-slate-50 pb-4">
                            <dt class="text-slate-500 font-medium">Agama</dt>
                            <dd class="col-span-2 text-slate-800 font-semibold">{{ $warga->agama }}</dd>
                        </div>
                         <div class="grid grid-cols-3 gap-4 border-b border-slate-50 pb-4">
                            <dt class="text-slate-500 font-medium">Status Perkawinan</dt>
                            <dd class="col-span-2 text-slate-800 font-semibold">{{ $warga->status_perkawinan }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-slate-500 font-medium">Kewarganegaraan</dt>
                            <dd class="col-span-2 text-slate-800 font-semibold">{{ $warga->kewarganegaraan }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Kartu Keluarga Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center gap-2 font-bold text-slate-700">
                    <i class="fas fa-home text-indigo-500"></i> Data Kartu Keluarga
                </div>
                <div class="p-6">
                     @if($warga->kk)
                        <dl class="space-y-4 text-sm">
                            <div class="grid grid-cols-3 gap-4 border-b border-slate-50 pb-4">
                                <dt class="text-slate-500 font-medium">Nomor KK</dt>
                                <dd class="col-span-2 text-slate-800 font-bold font-mono text-base">{{ $warga->kk->no_kk }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 border-b border-slate-50 pb-4">
                                <dt class="text-slate-500 font-medium">Kepala Keluarga</dt>
                                <dd class="col-span-2 text-slate-800 font-semibold">
                                     {{ $warga->kk->kepalaKeluarga->nama_lengkap ?? 'Belum ditentukan' }}
                                </dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-slate-500 font-medium">Alamat Domisili</dt>
                                <dd class="col-span-2 text-slate-800">
                                    {{ $warga->kk->alamat_kk }} <br>
                                    <span class="text-slate-500">RT {{ $warga->kk->rt }} / RW {{ $warga->kk->rw }}, {{ $warga->kk->dusun->nama_dusun ?? '-' }}</span>
                                </dd>
                            </div>
                        </dl>
                        <div class="mt-4 pt-4 border-t border-slate-100 text-right">
                            <a href="{{ route('kk.members', $warga->id_kk) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                Lihat Anggota Keluarga Lainnya &rarr;
                            </a>
                        </div>
                     @else
                        <div class="text-center py-6 text-slate-400 italic">
                            Belum terdaftar dalam Kartu Keluarga manapun.
                        </div>
                     @endif
                </div>
            </div>

         </div>
    </div>
</div>
@endsection