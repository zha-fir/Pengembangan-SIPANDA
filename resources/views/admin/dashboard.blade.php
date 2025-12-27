@extends('layouts.modern')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">

    <!-- Welcome Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Dashboard Administrator</h1>
            <p class="text-slate-500 text-sm mt-1">
                Selamat datang kembali, <strong>{{ Auth::user()->nama_lengkap ?? 'Admin' }}</strong>.
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('warga.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm shadow-indigo-200">
                <i class="fas fa-plus"></i> Tambah Penduduk
            </a>
            <a href="{{ route('kk.create') }}" class="inline-flex items-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                <i class="fas fa-plus"></i> KK Baru
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Penduduk -->
        <a href="{{ route('warga.index') }}" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-2">Total Penduduk</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">{{ number_format($jumlahWarga) }}</span>
                    <span class="text-slate-400 text-sm">Jiwa</span>
                </div>
            </div>
            <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i class="fas fa-users text-6xl text-indigo-600 transform translate-x-2 -translate-y-2"></i>
            </div>
        </a>

        <!-- Total KK -->
        <a href="{{ route('kk.index') }}" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group relative overflow-hidden">
             <div class="relative z-10">
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-2">Kartu Keluarga</p>
                <div class="flex items-baseline gap-2">
                     <span class="text-3xl font-bold text-slate-800 group-hover:text-emerald-600 transition-colors">{{ number_format($jumlahKK) }}</span>
                    <span class="text-slate-400 text-sm">KK</span>
                </div>
            </div>
             <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i class="fas fa-home text-6xl text-emerald-600 transform translate-x-2 -translate-y-2"></i>
            </div>
        </a>

        <!-- Surat Baru -->
        <a href="{{ route('ajuan-surat.index') }}" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group relative overflow-hidden">
             <div class="relative z-10">
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-2">Surat Baru</p>
                 <div class="flex items-baseline gap-2">
                     <span class="text-3xl font-bold text-slate-800 group-hover:text-amber-500 transition-colors">{{ number_format($ajuanBaru) }}</span>
                    <span class="text-slate-400 text-sm">Permintaan</span>
                </div>
            </div>
            <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i class="fas fa-inbox text-6xl text-amber-500 transform translate-x-2 -translate-y-2"></i>
            </div>
        </a>

        <!-- Surat Selesai -->
        <a href="{{ route('ajuan-surat.arsip') }}" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group relative overflow-hidden">
             <div class="relative z-10">
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-2">Surat Selesai</p>
                <div class="flex items-baseline gap-2">
                     <span class="text-3xl font-bold text-slate-800 group-hover:text-cyan-600 transition-colors">{{ number_format($suratSelesai) }}</span>
                    <span class="text-slate-400 text-sm">Arsip</span>
                </div>
            </div>
             <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i class="fas fa-archive text-6xl text-cyan-600 transform translate-x-2 -translate-y-2"></i>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Activity Table -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 border-b border-slate-50 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Ajuan Masuk Terakhir</h3>
                <a href="{{ route('ajuan-surat.index') }}" class="text-sm text-indigo-600 font-medium hover:underline">Lihat Semua</a>
            </div>
            
            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-xs border-b border-slate-100">
                        <tr>
                            <th class="px-5 py-3 font-semibold">Warga</th>
                            <th class="px-5 py-3 font-semibold">Jenis Surat</th>
                            <th class="px-5 py-3 font-semibold text-center">Status</th>
                            <th class="px-5 py-3 font-semibold text-right">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($latestAjuan as $ajuan)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-3">
                                <span class="font-bold text-slate-900 block">{{ $ajuan->warga->nama_lengkap ?? 'Tanpa Nama' }}</span>
                            </td>
                            <td class="px-5 py-3 text-slate-500">
                                {{ $ajuan->jenisSurat->nama_surat ?? '-' }}
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if($ajuan->status == 'BARU')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700">Baru</span>
                                @elseif($ajuan->status == 'MENUNGGU_TTD')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700">Ttd</span>
                                @elseif($ajuan->status == 'SELESAI')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Selesai</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right text-slate-400 text-xs whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($ajuan->tanggal_ajuan)->diffForHumans() }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-slate-400">
                                Belum ada pengajuan surat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Demographics Card -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 border-b border-slate-50 flex items-center justify-between">
                <div>
                     <h3 class="font-bold text-slate-800">Demografi</h3>
                     <p class="text-xs text-slate-500 mt-0.5">Filter berdasarkan tahun kelahiran</p>
                </div>
            </div>
            
            <div class="p-5 border-b border-slate-50 bg-slate-50/50">
                 <form action="{{ route('admin.dashboard') }}" method="GET">
                    <select name="filter_tahun" class="w-full bg-white border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 outline-none transition-shadow" onchange="this.form.submit()">
                        <option value="">- Semua Umur -</option>
                        @foreach($tahunLahirList as $tahun)
                            <option value="{{ $tahun }}" {{ request('filter_tahun') == $tahun ? 'selected' : '' }}>
                                Lahir Tahun {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="p-6 flex-1 flex flex-col justify-center space-y-6">
                @if($totalFilter > 0)
                    <!-- Male -->
                    <div>
                        <div class="flex justify-between items-end mb-1">
                            <span class="text-sm font-bold text-slate-600 flex items-center gap-2">
                                <i class="fas fa-mars text-blue-500"></i> Laki-laki
                            </span>
                             <span class="text-xs font-mono text-slate-400">{{ $demografiLaki }} ({{ round(($demografiLaki / $totalFilter) * 100) }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5">
                            <div class="bg-blue-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ ($demografiLaki / $totalFilter) * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Female -->
                    <div>
                        <div class="flex justify-between items-end mb-1">
                             <span class="text-sm font-bold text-slate-600 flex items-center gap-2">
                                <i class="fas fa-venus text-pink-500"></i> Perempuan
                            </span>
                             <span class="text-xs font-mono text-slate-400">{{ $demografiPerempuan }} ({{ round(($demografiPerempuan / $totalFilter) * 100) }}%)</span>
                        </div>
                         <div class="w-full bg-slate-100 rounded-full h-2.5">
                            <div class="bg-pink-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ ($demografiPerempuan / $totalFilter) * 100 }}%"></div>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-slate-100 text-center">
                        <span class="inline-block bg-slate-100 text-slate-500 text-xs px-3 py-1 rounded-full font-medium">
                            Total: {{ number_format($totalFilter) }} Jiwa
                        </span>
                    </div>
                @else
                    <div class="text-center py-4 text-slate-400">
                        <i class="fas fa-filter text-4xl mb-3 opacity-20"></i>
                        <p class="text-sm">Tidak ada data untuk tahun {{ request('filter_tahun') }}</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <!-- Quick Info -->
    <div class="bg-indigo-900 rounded-2xl p-6 text-white relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-start gap-4">
                 <div class="h-12 w-12 rounded-xl bg-white/10 flex items-center justify-center text-2xl flex-shrink-0 border border-white/20">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div>
                   <h3 class="font-bold text-lg mb-1">Informasi Sistem</h3>
                   <p class="text-indigo-200 text-sm max-w-xl leading-relaxed">
                       Sistem Pelayanan Administrasi Desa (SIPANDA) Desa Panggulo.
                       Pastikan untuk selalu meninjau data sebelum melakukan konfirmasi persetujuan surat.
                   </p>
                </div>
            </div>
             <div class="text-xs text-indigo-300 font-mono bg-black/20 px-3 py-2 rounded-lg">
                <i class="fas fa-server mr-2"></i>v1.0.0 Stable
            </div>
        </div>
        <!-- Decorative bg -->
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-indigo-500 rounded-full blur-3xl opacity-20"></div>
    </div>

</div>
@endsection