@extends('layouts.modern')

@section('title', 'Manajemen Data Penduduk')

@section('content')
<div class="space-y-6">

    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Data Penduduk</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data seluruh penduduk desa.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <a href="{{ route('admin.warga.import.form') }}" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm shadow-emerald-200">
                <i class="fas fa-file-excel"></i> Import Excel
            </a>
            <a href="{{ route('warga.create') }}" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm shadow-indigo-200">
                <i class="fas fa-plus"></i> Tambah Penduduk
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

    <!-- Search -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
        <form action="{{ route('warga.index') }}" method="GET" class="relative">
            <div class="flex items-center gap-2">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl leading-5 bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm"
                           placeholder="Cari NIK atau Nama Penduduk...">
                </div>
                <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-semibold transition-colors">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('warga.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition-colors">
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
                        <th class="px-6 py-4 font-bold">Identitas Penduduk</th>
                        <th class="px-6 py-4 font-bold">Keluarga</th>
                        <th class="px-6 py-4 font-bold text-center">Status Hub.</th>
                        <th class="px-6 py-4 font-bold text-center">Akun</th>
                        <th class="px-6 py-4 font-bold text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($wargaList as $warga)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-xs font-bold border border-indigo-100 uppercase">
                                    {{ substr($warga->nama_lengkap, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800">{{ $warga->nama_lengkap }}</p>
                                    <p class="text-xs text-slate-500 font-mono">{{ $warga->nik }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                             @if($warga->kk)
                                <span class="font-mono text-xs text-slate-600 bg-slate-100 px-2 py-1 rounded">{{ $warga->kk->no_kk }}</span>
                             @else
                                <span class="text-xs text-red-500 italic">Belum masuk KK</span>
                             @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($warga->status_dalam_keluarga == 'KEPALA KELUARGA')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700">
                                    <i class="fas fa-crown text-[10px]"></i> Kepala
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                    {{ ucwords(strtolower($warga->status_dalam_keluarga)) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($warga->user)
                                <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-emerald-100 text-emerald-600 text-xs" title="Memiliki Akun Login">
                                    <i class="fas fa-check"></i>
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-slate-100 text-slate-300 text-xs" title="Tidak Ada Akun">
                                    <i class="fas fa-times"></i>
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('warga.show', $warga->id_warga) }}" class="p-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-lg transition-colors" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('warga.edit', $warga->id_warga) }}" class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('warga.destroy', $warga->id_warga) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga ini?');">
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
                                <i class="fas fa-users text-4xl mb-3 opacity-20"></i>
                                <p>Belum ada data penduduk.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View -->
        <div class="md:hidden divide-y divide-slate-100">
             @forelse ($wargaList as $warga)
             <div class="p-4 space-y-3">
                <div class="flex items-start justify-between gap-3">
                     <div class="flex items-start gap-3">
                        <div class="mt-1 h-9 w-9 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-xs font-bold border border-indigo-100 uppercase flex-shrink-0">
                            {{ substr($warga->nama_lengkap, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 leading-snug">{{ $warga->nama_lengkap }}</h3>
                            <p class="text-xs text-slate-500 font-mono mt-0.5">{{ $warga->nik }}</p>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span class="text-[10px] px-2 py-0.5 bg-slate-100 text-slate-600 rounded border border-slate-200 font-medium">
                                    {{ ucwords(strtolower($warga->status_dalam_keluarga)) }}
                                </span>
                                @if($warga->user)
                                    <span class="text-[10px] px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded border border-emerald-100 font-medium">
                                        <i class="fas fa-user-lock mr-1"></i> Akun Aktif
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-50">
                     <a href="{{ route('warga.show', $warga->id_warga) }}" class="flex-1 py-2 bg-indigo-50 text-indigo-700 text-center rounded-lg text-sm font-medium hover:bg-indigo-100">
                        <i class="fas fa-eye mr-1"></i> Detail
                    </a>
                    <a href="{{ route('warga.edit', $warga->id_warga) }}" class="flex-1 py-2 bg-amber-50 text-amber-700 text-center rounded-lg text-sm font-medium hover:bg-amber-100">
                        Edit
                    </a>
                    <form action="{{ route('warga.destroy', $warga->id_warga) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus data warga ini?');">
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
            {{ $wargaList->links() }}
        </div>
    </div>
</div>
@endsection