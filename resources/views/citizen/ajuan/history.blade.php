@extends('layouts.citizen')

@section('title', 'Riwayat Pengajuan')

@section('content')

    <div class="max-w-6xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <p class="text-slate-500 text-sm">
                Daftar seluruh surat yang pernah Anda ajukan dan status terkininya.
            </p>
            <a href="{{ route('warga.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-600 font-bold text-sm shadow-sm hover:bg-slate-50 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 uppercase tracking-wider font-bold text-xs">
                        <tr>
                            <th class="px-6 py-4 w-16">#</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Jenis Surat & Keperluan</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Keterangan / Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($riwayatAjuan as $index => $ajuan)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-slate-400 font-mono">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center shrink-0">
                                            <i class="far fa-calendar-alt"></i>
                                        </div>
                                        <div>
                                            <span class="block font-bold text-slate-800">{{ \Carbon\Carbon::parse($ajuan->tanggal_ajuan)->isoFormat('D MMM Y') }}</span>
                                            <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($ajuan->tanggal_ajuan)->format('H:i') }} WITA</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="block font-bold text-slate-800 text-base mb-1">{{ $ajuan->jenisSurat->nama_surat ?? 'Judul Dihapus' }}</span>
                                    <p class="text-xs text-slate-500 flex items-start gap-1.5">
                                        <i class="fas fa-info-circle mt-0.5 text-brand-400"></i>
                                        {{ Str::limit($ajuan->keperluan, 50) }}
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    @if($ajuan->status == 'BARU')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-100">
                                            <span class="relative flex h-2 w-2">
                                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                              <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                                            </span>
                                            Proses Verifikasi
                                        </span>
                                    @elseif($ajuan->status == 'MENUNGGU_TTD')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">
                                            <i class="fas fa-file-signature text-[10px]"></i> Menunggu TTD
                                        </span>
                                    @elseif($ajuan->status == 'SELESAI')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                            <i class="fas fa-check-circle text-[10px]"></i> Selesai
                                        </span>
                                    @elseif($ajuan->status == 'DITOLAK')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100">
                                            <i class="fas fa-times-circle text-[10px]"></i> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($ajuan->status == 'SELESAI')
                                        <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-100">
                                            <p class="text-xs font-bold text-emerald-700 mb-2 flex items-center gap-1">
                                                <i class="fas fa-check"></i> Surat Terbit
                                            </p>
                                            <p class="text-[10px] text-emerald-600 mb-2 font-mono">No: {{ $ajuan->nomor_surat }}</p>
                                            
                                            <!-- Assuming route exists or will be added. Using # for now if not sure, but code showed 'warga.ajuan.download' -->
                                            <!-- Warning: user code showed route('warga.ajuan.download'). I should keep it. -->
                                            @if(Route::has('warga.ajuan.download'))
                                                <a href="{{ route('warga.ajuan.download', $ajuan->id_ajuan) }}" target="_blank" class="w-full flex items-center justify-center gap-2 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition-colors shadow-sm shadow-emerald-200">
                                                    <i class="fas fa-download"></i> Unduh
                                                </a>
                                            @else
                                                <button disabled class="w-full flex items-center justify-center gap-2 px-3 py-1.5 bg-emerald-200 text-emerald-700 text-xs font-bold rounded-lg cursor-not-allowed">
                                                    <i class="fas fa-download"></i> Unduh
                                                </button>
                                            @endif
                                        </div>
                                    @elseif($ajuan->status == 'DITOLAK')
                                        <div class="p-3 bg-rose-50 rounded-xl border border-rose-100">
                                            <p class="text-xs font-bold text-rose-700 mb-1 flex items-center gap-1">
                                                <i class="fas fa-exclamation-circle"></i> Ditolak
                                            </p>
                                            <p class="text-xs text-rose-600 leading-snug">
                                                {{ $ajuan->catatan_penolakan ?? 'Tidak ada catatan.' }}
                                            </p>
                                        </div>
                                    @else
                                        <p class="text-xs text-slate-400 italic">Menunggu proses...</p>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="far fa-folder-open text-3xl text-slate-300"></i>
                                    </div>
                                    <p class="font-medium">Belum ada riwayat pengajuan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards (Stacked) -->
            <div class="md:hidden divide-y divide-slate-100">
                @forelse ($riwayatAjuan as $ajuan)
                    <div class="p-5 space-y-4">
                        <!-- Top: Date & Status -->
                        <div class="flex justify-between items-start">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center shrink-0">
                                    <i class="far fa-calendar-alt"></i>
                                </div>
                                <div>
                                    <span class="block font-bold text-slate-800 text-sm">{{ \Carbon\Carbon::parse($ajuan->tanggal_ajuan)->isoFormat('D MMM Y') }}</span>
                                    <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($ajuan->tanggal_ajuan)->format('H:i') }} WITA</span>
                                </div>
                            </div>
                            
                            @if($ajuan->status == 'BARU')
                                <span class="px-2 py-1 rounded-lg text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-100">
                                    Proses
                                </span>
                            @elseif($ajuan->status == 'MENUNGGU_TTD')
                                <span class="px-2 py-1 rounded-lg text-[10px] font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">
                                    TTD
                                </span>
                            @elseif($ajuan->status == 'SELESAI')
                                <span class="px-2 py-1 rounded-lg text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                    Selesai
                                </span>
                            @elseif($ajuan->status == 'DITOLAK')
                                <span class="px-2 py-1 rounded-lg text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-100">
                                    Ditolak
                                </span>
                            @endif
                        </div>

                        <!-- Content -->
                        <div>
                            <h4 class="font-bold text-slate-800 text-base mb-1">{{ $ajuan->jenisSurat->nama_surat ?? 'Deleted' }}</h4>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-xs text-slate-500">
                                <span class="font-bold text-slate-700 block mb-0.5">Keperluan:</span>
                                {{ $ajuan->keperluan }}
                            </div>
                        </div>

                        <!-- Action/Info -->
                        @if($ajuan->status == 'SELESAI')
                            <div class="pt-3 border-t border-slate-50">
                                @if(Route::has('warga.ajuan.download'))
                                    <a href="{{ route('warga.ajuan.download', $ajuan->id_ajuan) }}" target="_blank" class="flex w-full items-center justify-center gap-2 px-4 py-3 bg-emerald-600 active:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-emerald-200 transition-transform active:scale-95">
                                        <i class="fas fa-download"></i> Unduh Surat
                                    </a>
                                @endif
                            </div>
                        @elseif($ajuan->status == 'DITOLAK')
                            <div class="pt-3 border-t border-slate-50">
                                <div class="p-3 bg-rose-50 text-rose-700 rounded-xl text-xs border border-rose-100">
                                    <span class="font-bold block mb-1"><i class="fas fa-info-circle"></i> Alasan Penolakan:</span>
                                    {{ $ajuan->catatan_penolakan }}
                                </div>
                            </div>
                        @endif
                        
                    </div>
                @empty
                    <div class="text-center py-12 px-6">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-inbox text-3xl text-slate-300"></i>
                        </div>
                        <p class="text-slate-500 font-medium">Belum ada riwayat pengajuan.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

@endsection