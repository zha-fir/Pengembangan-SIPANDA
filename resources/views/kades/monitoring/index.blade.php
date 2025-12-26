@extends('layouts.modern')

@section('title', 'Monitoring Surat')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Monitoring Surat</h1>
        <p class="text-slate-500 text-sm mt-1">Pantau lalu lintas pengajuan surat dari seluruh wilayah.</p>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <form action="{{ route('kades.monitoring.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Filter Dusun -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Wilayah Dusun</label>
                    <select name="id_dusun" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                        <option value="">- Semua Dusun -</option>
                        @foreach($dusunList as $dusun)
                            <option value="{{ $dusun->id_dusun }}" {{ request('id_dusun') == $dusun->id_dusun ? 'selected' : '' }}>
                                {{ $dusun->nama_dusun }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Jenis Surat -->
                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jenis Surat</label>
                    <select name="id_jenis_surat" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                        <option value="">- Semua Jenis -</option>
                        @foreach($jenisSuratList as $surat)
                            <option value="{{ $surat->id_jenis_surat }}" {{ request('id_jenis_surat') == $surat->id_jenis_surat ? 'selected' : '' }}>
                                {{ $surat->nama_surat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Status -->
                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Status Surat</label>
                    <select name="status" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                        <option value="">- Semua Status -</option>
                        <option value="BARU" {{ request('status') == 'BARU' ? 'selected' : '' }}>Baru (Proses)</option>
                         <option value="MENUNGGU_TTD" {{ request('status') == 'MENUNGGU_TTD' ? 'selected' : '' }}>Menunggu TTD</option>
                        <option value="SELESAI" {{ request('status') == 'SELESAI' ? 'selected' : '' }}>Selesai</option>
                        <option value="DITOLAK" {{ request('status') == 'DITOLAK' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <!-- Filter Tanggal -->
                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tanggal Ajuan</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 flex gap-3">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl text-sm px-5 py-2.5 text-center inline-flex items-center gap-2 transition-colors">
                    <i class="fas fa-filter"></i> Terapkan Filter
                </button>
                <a href="{{ route('kades.monitoring.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium rounded-xl text-sm px-5 py-2.5 text-center inline-flex items-center gap-2 transition-colors">
                    <i class="fas fa-undo"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Data List -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        
        <!-- Mobile View (Card List) -->
        <div class="block md:hidden divide-y divide-slate-100">
            @forelse ($ajuanList as $ajuan)
                <div class="p-4 space-y-3">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                                {{ \Carbon\Carbon::parse($ajuan->tanggal_ajuan)->format('d M Y') }}
                            </span>
                             <h3 class="font-bold text-slate-800 mt-1">{{ $ajuan->warga->nama_lengkap }}</h3>
                            <p class="text-xs text-slate-500">{{ $ajuan->warga->kk->dusun->nama_dusun ?? 'Wilayah ?' }}</p>
                        </div>
                        <div>
                           @if($ajuan->status == 'BARU')
                                <span class="inline-flex px-2 py-1 rounded-lg text-[10px] font-bold uppercase bg-amber-100 text-amber-700">Proses</span>
                            @elseif($ajuan->status == 'MENUNGGU_TTD')
                                <span class="inline-flex px-2 py-1 rounded-lg text-[10px] font-bold uppercase bg-blue-100 text-blue-700">Ttd</span>
                            @elseif($ajuan->status == 'SELESAI')
                                <span class="inline-flex px-2 py-1 rounded-lg text-[10px] font-bold uppercase bg-emerald-100 text-emerald-700">Selesai</span>
                            @else
                                <span class="inline-flex px-2 py-1 rounded-lg text-[10px] font-bold uppercase bg-red-100 text-red-700">Ditolak</span>
                            @endif
                        </div>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <p class="text-sm font-medium text-slate-700">{{ $ajuan->jenisSurat->nama_surat ?? '-' }}</p>
                    </div>
                    <div class="flex justify-end">
                         <a href="{{ route('kades.monitoring.show', $ajuan->id_ajuan) }}" class="text-sm text-indigo-600 font-medium hover:underline">
                            Detail Surat &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-slate-400">
                    <p>Data tidak ditemukan.</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop View (Table) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-xs border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold">Pemohon</th>
                        <th class="px-6 py-4 font-semibold">Wilayah</th>
                        <th class="px-6 py-4 font-semibold">Jenis Surat</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($ajuanList as $ajuan)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($ajuan->tanggal_ajuan)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">{{ $ajuan->warga->nama_lengkap }}</div>
                                <div class="text-xs text-slate-400 font-mono">{{ $ajuan->warga->nik }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs font-medium">
                                    {{ $ajuan->warga->kk->dusun->nama_dusun ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 max-w-xs truncate">
                                {{ $ajuan->jenisSurat->nama_surat ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($ajuan->status == 'BARU')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Proses
                                    </span>
                                @elseif($ajuan->status == 'MENUNGGU_TTD')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-pen-nib text-[10px]"></i> Menunggu TTD
                                    </span>
                                @elseif($ajuan->status == 'SELESAI')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        <i class="fas fa-check-circle text-[10px]"></i> Selesai
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle text-[10px]"></i> Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('kades.monitoring.show', $ajuan->id_ajuan) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-slate-50 p-4 rounded-full mb-3">
                                        <i class="fas fa-folder-open text-2xl"></i>
                                    </div>
                                    <p>Data surat tidak ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $ajuanList->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection