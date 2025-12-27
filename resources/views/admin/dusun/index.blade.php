@extends('layouts.modern')

@section('title', 'Manajemen Data Dusun')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Data Wilayah Dusun</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data wilayah administrasi dusun.</p>
        </div>
        <div>
            <a href="{{ route('dusun.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm shadow-indigo-200">
                <i class="fas fa-plus"></i> Tambah Dusun
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

    <!-- Content Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                 <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-xs border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-bold w-24 text-center">ID</th>
                        <th class="px-6 py-4 font-bold">Nama Dusun</th>
                        <th class="px-6 py-4 font-bold text-center w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($dusunList as $dusun)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-center font-mono text-slate-400">#{{ $dusun->id_dusun }}</td>
                        <td class="px-6 py-4">
                             <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <span class="font-bold text-slate-800">{{ $dusun->nama_dusun }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('dusun.edit', $dusun->id_dusun) }}" class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('dusun.destroy', $dusun->id_dusun) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                        <td colspan="3" class="px-6 py-12 text-center text-slate-400">
                            <i class="fas fa-map-signs text-4xl mb-3 opacity-20"></i>
                            <p>Belum ada data dusun.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden divide-y divide-slate-100">
             @forelse ($dusunList as $dusun)
             <div class="p-4 space-y-4">
                <div class="flex items-start justify-between">
                     <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 flex-shrink-0">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">{{ $dusun->nama_dusun }}</h3>
                             <span class="text-xs text-slate-400 font-mono">ID: #{{ $dusun->id_dusun }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-50">
                    <a href="{{ route('dusun.edit', $dusun->id_dusun) }}" class="flex-1 py-2 bg-amber-50 text-amber-700 text-center rounded-lg text-sm font-medium hover:bg-amber-100">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <form action="{{ route('dusun.destroy', $dusun->id_dusun) }}" method="POST" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                 <p>Belum ada data dusun.</p>
             </div>
             @endforelse
        </div>
    </div>
</div>
@endsection