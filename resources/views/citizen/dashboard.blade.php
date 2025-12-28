@extends('layouts.citizen')

@section('title', 'Dashboard')

@section('content')

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-start gap-3 animate__animated animate__fadeInDown">
            <i class="fas fa-check-circle mt-0.5"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="space-y-6">
        
        <!-- Welcome Card -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-600 to-indigo-600 text-white shadow-xl shadow-brand-200">
            <!-- Deco Circle -->
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 rounded-full bg-white/10 blur-2xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-32 h-32 rounded-full bg-white/10 blur-xl"></div>
            
            <div class="relative p-6 md:p-8">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold mb-2">Halo, {{ $warga->nama_lengkap }}! 👋</h2>
                        <p class="text-brand-100 max-w-xl text-sm md:text-base leading-relaxed">
                            Selamat datang di SIPANDA. Akses pelayanan administrasi desa dengan mudah, cepat, dan transparan dari mana saja.
                        </p>
                    </div>
                    <a href="{{ route('warga.ajuan.create') }}" 
                       class="w-full md:w-auto px-6 py-3 bg-white text-brand-600 font-bold rounded-xl shadow-lg hover:shadow-xl hover:bg-brand-50 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        <i class="fas fa-plus-circle"></i>
                        <span>Buat Pengajuan</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- LEFT COLUMN: History (Span 2) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-history text-brand-500"></i> Pengajuan Terakhir
                        </h3>
                        <a href="{{ route('warga.ajuan.history') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 hover:underline">
                            Lihat Semua
                        </a>
                    </div>
                    
                    <div class="p-0">
                        @if($riwayatAjuan->count() > 0)
                            <!-- Desktop Table -->
                            <div class="hidden md:block overflow-x-auto">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold text-xs">
                                        <tr>
                                            <th class="px-6 py-4">Jenis Surat</th>
                                            <th class="px-6 py-4">Tanggal</th>
                                            <th class="px-6 py-4">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($riwayatAjuan as $ajuan)
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <span class="block font-bold text-slate-800">{{ $ajuan->jenisSurat->nama_surat ?? 'Deleted' }}</span>
                                                <span class="text-xs text-slate-400">{{ Str::limit($ajuan->keperluan, 40) }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2 text-slate-500">
                                                    <i class="far fa-calendar text-slate-400"></i>
                                                    {{ \Carbon\Carbon::parse($ajuan->tanggal_ajuan)->isoFormat('D MMM Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($ajuan->status == 'BARU')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-100">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Proses
                                                    </span>
                                                @elseif($ajuan->status == 'SELESAI')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                        <i class="fas fa-check text-[10px]"></i> Selesai
                                                    </span>
                                                @elseif($ajuan->status == 'DITOLAK')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100">
                                                        <i class="fas fa-times text-[10px]"></i> Ditolak
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile Cards -->
                            <div class="md:hidden divide-y divide-slate-100">
                                @foreach($riwayatAjuan as $ajuan)
                                <div class="p-4 space-y-3">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-bold text-slate-800 text-sm">{{ $ajuan->jenisSurat->nama_surat ?? 'Deleted' }}</h4>
                                            <p class="text-xs text-slate-500 mt-0.5">{{ \Carbon\Carbon::parse($ajuan->tanggal_ajuan)->isoFormat('dddd, D MMMM Y') }}</p>
                                        </div>
                                        @if($ajuan->status == 'BARU')
                                            <span class="shrink-0 px-2 py-1 rounded-lg text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-100">
                                                Proses
                                            </span>
                                        @elseif($ajuan->status == 'SELESAI')
                                            <span class="shrink-0 px-2 py-1 rounded-lg text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                Selesai
                                            </span>
                                        @elseif($ajuan->status == 'DITOLAK')
                                            <span class="shrink-0 px-2 py-1 rounded-lg text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-100">
                                                Ditolak
                                            </span>
                                        @endif
                                    </div>
                                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                        <p class="text-xs text-slate-500 line-clamp-2">
                                            <span class="font-medium text-slate-700">Keperluan:</span> {{ $ajuan->keperluan }}
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        @else
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300">
                                    <i class="fas fa-inbox text-3xl"></i>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada pengajuan surat.</p>
                                <p class="text-slate-400 text-sm mt-1">Silakan buat pengajuan baru.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Profile (Span 1) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-brand-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                    
                    <div class="relative flex flex-col items-center text-center">
                        <div class="w-20 h-20 rounded-full bg-slate-100 p-1 mb-4 shadow-sm">
                            <div class="w-full h-full rounded-full bg-brand-600 text-white flex items-center justify-center text-2xl font-bold">
                                {{ substr($warga->nama_lengkap, 0, 1) }}
                            </div>
                        </div>
                        
                        <h3 class="text-lg font-bold text-slate-800">{{ $warga->nama_lengkap }}</h3>
                        <p class="text-sm text-slate-500 font-mono mt-1 bg-slate-100 px-2 py-1 rounded">{{ $warga->nik }}</p>
                        
                        <div class="w-full h-px bg-slate-100 my-6"></div>
                        
                        <div class="w-full space-y-4">
                            <div class="flex items-center gap-4 text-left p-3 rounded-xl hover:bg-slate-50 transition-colors cursor-default">
                                <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase">Dusun</p>
                                    <p class="text-sm font-semibold text-slate-700">{{ $warga->kk->dusun->nama_dusun ?? '-' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 text-left p-3 rounded-xl hover:bg-slate-50 transition-colors cursor-default">
                                <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase">Pekerjaan</p>
                                    <p class="text-sm font-semibold text-slate-700">{{ $warga->pekerjaan }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection