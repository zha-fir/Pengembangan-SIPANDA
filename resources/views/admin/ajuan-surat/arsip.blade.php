@extends('layouts.modern')

@section('title', 'Arsip Surat')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Arsip Surat</h1>
            <p class="text-slate-500 text-sm mt-1">Riwayat surat yang telah selesai diproses atau ditolak.</p>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-3">
             <i class="fas fa-check-circle text-xl"></i>
             <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3">
             <i class="fas fa-exclamation-circle text-xl"></i>
             <p class="font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Table Content -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                 <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-xs border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-bold">No. Surat</th>
                        <th class="px-6 py-4 font-bold">Pemohon</th>
                        <th class="px-6 py-4 font-bold">Jenis Surat</th>
                        <th class="px-6 py-4 font-bold">Penandatangan</th>
                        <th class="px-6 py-4 font-bold text-center">Status</th>
                        <th class="px-6 py-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($arsipList as $arsip)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-mono font-medium text-slate-700">
                            {{ $arsip->nomor_surat ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 border border-slate-200">
                                    <i class="fas fa-user text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">{{ optional($arsip->warga)->nama_lengkap ?? 'N/A' }}</p>
                                    <p class="text-xs text-slate-500 font-mono">{{ optional($arsip->warga)->nik ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 text-slate-700 font-medium bg-blue-50 px-2.5 py-1 rounded-full text-xs text-blue-700 border border-blue-100">
                                <i class="fas fa-file-alt"></i> {{ optional($arsip->jenisSurat)->nama_surat ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ optional($arsip->pejabatDesa)->nama_pejabat ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($arsip->status == 'SELESAI')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    <i class="fas fa-check-circle mr-1"></i> SELESAI
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 border border-rose-200">
                                    <i class="fas fa-times-circle mr-1"></i> DITOLAK
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('ajuan-surat.detail', $arsip->id_ajuan) }}" class="p-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-lg transition-colors" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($arsip->status == 'SELESAI')
                                    <a href="{{ route('ajuan-surat.cetak', $arsip->id_ajuan) }}" class="p-2 bg-slate-50 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors" title="Cetak / Download Surat">
                                        <i class="fas fa-print"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                             <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-archive text-4xl mb-3 opacity-20"></i>
                                <p>Belum ada arsip surat.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View -->
        <div class="md:hidden divide-y divide-slate-100">
             @forelse ($arsipList as $arsip)
             <div class="p-4 space-y-3">
                <div class="flex justify-between items-start">
                     <div class="flex items-center gap-3">
                         <div class="h-10 w-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 border border-slate-200">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm">{{ optional($arsip->warga)->nama_lengkap ?? 'N/A' }}</h3>
                            <p class="text-xs text-slate-500 font-mono">{{ optional($arsip->warga)->nik ?? 'N/A' }}</p>
                        </div>
                    </div>
                     @if($arsip->status == 'SELESAI')
                        <span class="text-xs font-bold px-2 py-1 rounded bg-emerald-100 text-emerald-700">SELESAI</span>
                    @else
                        <span class="text-xs font-bold px-2 py-1 rounded bg-rose-100 text-rose-700">DITOLAK</span>
                    @endif
                </div>
                
                 <div class="bg-slate-50 p-3 rounded-lg text-sm space-y-2">
                    <div class="flex justify-between">
                        <span class="text-slate-500">No. Surat</span>
                        <span class="font-mono font-medium text-slate-700">{{ $arsip->nomor_surat ?? '-' }}</span>
                    </div>
                     <div class="flex justify-between items-center">
                        <span class="text-slate-500">Jenis</span>
                        <span class="text-blue-600 font-medium">{{ optional($arsip->jenisSurat)->nama_surat ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-50">
                    <a href="{{ route('ajuan-surat.detail', $arsip->id_ajuan) }}" class="flex-1 py-2 bg-indigo-50 text-indigo-700 text-center rounded-lg text-sm font-medium hover:bg-indigo-100">
                        Detail
                    </a>
                    @if($arsip->status == 'SELESAI')
                        <a href="{{ route('ajuan-surat.cetak', $arsip->id_ajuan) }}" class="flex-1 py-2 bg-slate-100 text-slate-700 text-center rounded-lg text-sm font-medium hover:bg-slate-200">
                            <i class="fas fa-print mr-1"></i> Cetak
                        </a>
                    @endif
                </div>
             </div>
             @empty
             <div class="p-8 text-center text-slate-400">
                 <p>Tidak ditemukan data.</p>
             </div>
             @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-slate-100">
            {{ $arsipList->links() }}
        </div>
    </div>
</div>
@endsection