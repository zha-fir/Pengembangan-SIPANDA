@extends('layouts.modern')

@section('title', 'Manajemen Kartu Keluarga')

@section('content')
<div class="space-y-6">

    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Data Kartu Keluarga</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data kepala keluarga dan anggota.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <a href="{{ route('admin.kk.import.form') }}" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm shadow-emerald-200">
                <i class="fas fa-file-excel"></i> Import Excel
            </a>
            <a href="{{ route('kk.create') }}" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm shadow-indigo-200">
                <i class="fas fa-plus"></i> Tambah KK
            </a>
        </div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-3">
             <i class="fas fa-check-circle text-xl"></i>
             <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Search & Filters -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
        <form action="{{ route('kk.index') }}" method="GET" class="relative">
            <div class="flex items-center gap-2">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl leading-5 bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm" 
                           placeholder="Cari Nomor KK atau Nama Kepala Keluarga...">
                </div>
                <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-semibold transition-colors">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('kk.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Content -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                 <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-xs border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-bold">Data KK</th>
                        <th class="px-6 py-4 font-bold">Kepala Keluarga</th>
                        <th class="px-6 py-4 font-bold">Wilayah</th>
                        <th class="px-6 py-4 font-bold text-center">Anggota</th>
                        <th class="px-6 py-4 font-bold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($kkList as $kk)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="block font-mono font-bold text-slate-700 text-base mb-1">{{ $kk->no_kk }}</span>
                            @if(!$kk->kepalaKeluarga)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                    Belum Link Kepala
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                             @if($kk->kepalaKeluarga)
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xs font-bold">
                                        {{ substr($kk->kepalaKeluarga->nama_lengkap, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $kk->kepalaKeluarga->nama_lengkap }}</p>
                                        <p class="text-xs text-slate-500 font-mono">NIK: {{ $kk->kepalaKeluarga->nik }}</p>
                                    </div>
                                </div>
                            @else
                                <span class="text-slate-400 italic text-xs">Belum ditentukan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-slate-700 font-medium">{{ $kk->dusun->nama_dusun ?? '-' }}</p>
                            <p class="text-xs text-slate-500">RT {{ $kk->rt }} / RW {{ $kk->rw }}</p>
                        </td>
                         <td class="px-6 py-4 text-center">
                            <a href="{{ route('kk.members', $kk->id_kk) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition-colors text-xs font-bold" title="Lihat Anggota Keluarga">
                                <i class="fas fa-users"></i> Lihat
                            </a>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('kk.edit', $kk->id_kk) }}" class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('kk.destroy', $kk->id_kk) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data KK ini? SEMUA warga yang terhubung juga akan terpengaruh.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                             <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-folder-open text-4xl mb-3 opacity-20"></i>
                                <p>Belum ada data Kartu Keluarga.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View -->
        <div class="md:hidden divide-y divide-slate-100">
             @forelse ($kkList as $kk)
             <div class="p-4 space-y-3">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="font-mono font-bold text-slate-800 text-lg block">{{ $kk->no_kk }}</span>
                         <span class="text-xs text-slate-500">
                            <i class="fas fa-map-marker-alt mr-1"></i> {{ $kk->dusun->nama_dusun ?? '-' }} (RT {{ $kk->rt }}/RW {{ $kk->rw }})
                        </span>
                    </div>
                    <a href="{{ route('kk.members', $kk->id_kk) }}" class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold">
                        <i class="fas fa-users mr-1"></i> Anggota
                    </a>
                </div>

                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 flex items-center gap-3">
                     @if($kk->kepalaKeluarga)
                        <div class="h-8 w-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-600 text-xs font-bold shadow-sm">
                            {{ substr($kk->kepalaKeluarga->nama_lengkap, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 text-sm">{{ $kk->kepalaKeluarga->nama_lengkap }}</p>
                            <p class="text-xs text-slate-500 font-mono">{{ $kk->kepalaKeluarga->nik }}</p>
                        </div>
                    @else
                        <div class="text-red-500 text-xs italic flex items-center gap-2">
                            <i class="fas fa-exclamation-circle"></i> Kepala Keluarga belum diset
                        </div>
                    @endif
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <a href="{{ route('kk.edit', $kk->id_kk) }}" class="flex-1 py-2 bg-amber-50 text-amber-700 text-center rounded-lg text-sm font-medium hover:bg-amber-100">
                        Edit
                    </a>
                    <form action="{{ route('kk.destroy', $kk->id_kk) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus KK ini beserta warganya?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-2 bg-red-50 text-red-700 text-center rounded-lg text-sm font-medium hover:bg-red-100">
                            Hapus
                        </button>
                    </form>
                </div>
             </div>
             @empty
             <div class="p-8 text-center text-slate-400">
                 <p>Tidak ditemukan data.</p>
             </div>
             @endforelse
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $kkList->links() }}
        </div>
    </div>
</div>
@endsection