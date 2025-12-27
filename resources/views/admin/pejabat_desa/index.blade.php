@extends('layouts.modern')

@section('title', 'Manajemen Pejabat Desa')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Data Pejabat Desa</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data perangkat desa dan tanda tangan digital.</p>
        </div>
        <div>
            <a href="{{ route('pejabat-desa.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm shadow-indigo-200">
                <i class="fas fa-plus"></i> Tambah Pejabat
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                 <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-xs border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-bold w-20 text-center">ID</th>
                        <th class="px-6 py-4 font-bold">Nama Pejabat</th>
                        <th class="px-6 py-4 font-bold">Jabatan</th>
                        <th class="px-6 py-4 font-bold text-center w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pejabatList as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-center font-mono text-slate-400">#{{ $item->id_pejabat_desa }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 border border-indigo-100">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <span class="font-bold text-slate-800">{{ $item->nama_pejabat }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 border border-slate-200">
                                {{ $item->jabatan }}
                            </span>
                        </td>
                         <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('pejabat-desa.edit', $item->id_pejabat_desa) }}" class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pejabat-desa.destroy', $item->id_pejabat_desa) }}" method="POST" onsubmit="return confirm('Yakin hapus data pejabat ini?');">
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
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                             <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-user-tie text-4xl mb-3 opacity-20"></i>
                                <p>Belum ada data pejabat desa.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden divide-y divide-slate-100">
             @forelse ($pejabatList as $item)
             <div class="p-4 space-y-4">
                <div class="flex items-start gap-4">
                     <div class="h-12 w-12 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 border border-indigo-100 flex-shrink-0">
                        <i class="fas fa-user-tie text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">{{ $item->nama_pejabat }}</h3>
                        <span class="inline-block mt-1 px-2 py-0.5 bg-slate-100 text-slate-600 text-xs rounded-full border border-slate-200">
                            {{ $item->jabatan }}
                        </span>
                        <p class="text-xs text-slate-400 mt-1 font-mono">ID: #{{ $item->id_pejabat_desa }}</p>
                    </div>
                </div>
                 <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-50">
                    <a href="{{ route('pejabat-desa.edit', $item->id_pejabat_desa) }}" class="flex-1 py-2 bg-amber-50 text-amber-700 text-center rounded-lg text-sm font-medium hover:bg-amber-100">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <form action="{{ route('pejabat-desa.destroy', $item->id_pejabat_desa) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus data pejabat ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-2 bg-red-50 text-red-700 text-center rounded-lg text-sm font-medium hover:bg-red-100">
                            <i class="fas fa-trash mr-1"></i> Hapus
                        </button>
                    </form>
                </div>
             </div>
             @empty
             <div class="p-8 text-center text-slate-400">
                 <p>Belum ada data pejabat desa.</p>
             </div>
             @endforelse
        </div>
    </div>
</div>
@endsection