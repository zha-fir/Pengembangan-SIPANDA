@extends('layouts.modern')

@section('title', 'Monitoring Surat')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Surat Wilayah</h1>
        <p class="text-slate-500 text-sm mt-1">
            Riwayat dan monitoring pengajuan surat di <span class="font-semibold text-indigo-600">{{ Auth::user()->dusun->nama_dusun ?? '...' }}</span>
        </p>
    </div>

    <!-- Content Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        
        <!-- Layout List (Responsive) -->
        <div class="divide-y divide-slate-100">
            @forelse ($ajuanList as $ajuan)
                <div class="p-5 hover:bg-slate-50/50 transition-colors group">
                    <div class="flex flex-col md:flex-row gap-4 justify-between md:items-center">
                        
                        <!-- Left Info -->
                        <div class="flex-1 flex items-start gap-4">
                            <!-- Icon Type -->
                            <div class="hidden sm:flex h-12 w-12 rounded-xl bg-indigo-50 text-indigo-600 items-center justify-center flex-shrink-0">
                                <i class="fas fa-file-alt text-xl"></i>
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                                        {{ \Carbon\Carbon::parse($ajuan->tanggal_ajuan)->format('d M Y') }}
                                    </span>
                                    <span class="text-slate-300">•</span>
                                    <span class="text-xs text-slate-400">
                                        {{ \Carbon\Carbon::parse($ajuan->tanggal_ajuan)->format('H:i') }} WITA
                                    </span>
                                </div>
                                <h3 class="text-base font-bold text-slate-800 leading-snug">
                                    {{ $ajuan->jenisSurat->nama_surat ?? 'Jenis Surat Dihapus' }}
                                </h3>
                                <div class="flex items-center gap-2 mt-1 text-sm text-slate-600">
                                    <i class="fas fa-user text-xs text-slate-400"></i>
                                    <span class="font-medium">{{ $ajuan->warga->nama_lengkap }}</span>
                                    <span class="text-slate-300">|</span>
                                    <span class="font-mono text-xs text-slate-400">NIK: {{ $ajuan->warga->nik }}</span>
                                </div>
                                <p class="text-sm text-slate-500 mt-2 line-clamp-1 italic">
                                    "{{ Str::limit($ajuan->keperluan, 60) }}"
                                </p>
                            </div>
                        </div>

                        <!-- Right Status -->
                        <div class="md:text-right flex-shrink-0">
                            @if($ajuan->status == 'BARU')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Proses Admin
                                </span>
                            @elseif($ajuan->status == 'MENUNGGU_TTD')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                    <i class="fas fa-pen-nib"></i> Menunggu TTD
                                </span>
                            @elseif($ajuan->status == 'SELESAI')
                                <div>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                        <i class="fas fa-check-circle"></i> Selesai
                                    </span>
                                    <p class="text-[10px] text-slate-400 font-mono mt-1.5">
                                        No: {{ $ajuan->nomor_surat }}
                                    </p>
                                </div>
                            @elseif($ajuan->status == 'DITOLAK')
                                <div>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                        <i class="fas fa-times-circle"></i> Ditolak
                                    </span>
                                    <p class="text-[10px] text-red-400 mt-1.5 max-w-[150px] md:ml-auto leading-tight">
                                        {{ Str::limit($ajuan->catatan_penolakan, 30) }}
                                    </p>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-slate-400 flex flex-col items-center">
                    <div class="bg-slate-50 p-4 rounded-full mb-4">
                        <i class="fas fa-inbox text-3xl text-slate-300"></i>
                    </div>
                    <h3 class="text-slate-900 font-medium">Belum ada pengajuan</h3>
                    <p class="text-sm mt-1">Belum ada surat masuk dari warga di wilayah ini.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $ajuanList->links('pagination::tailwind') }}
        </div>
    </div>

</div>
@endsection