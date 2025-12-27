@extends('layouts.modern')

@section('title', 'Manajemen Jenis Surat')

@section('content')
<div class="space-y-6">

    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Jenis Surat</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola template dan jenis surat yang tersedia.</p>
        </div>
        <div>
            <a href="{{ route('jenis-surat.create') }}" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm shadow-indigo-200">
                <i class="fas fa-plus"></i> Tambah Template
            </a>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-3">
             <i class="fas fa-check-circle text-xl"></i>
             <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Table Content -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                 <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-xs border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-bold">Nama Surat</th>
                        <th class="px-6 py-4 font-bold text-center">Kode</th>
                        <th class="px-6 py-4 font-bold">File Template</th>
                        <th class="px-6 py-4 font-bold text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($suratList as $surat)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-xs font-bold border border-indigo-100">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <span class="font-bold text-slate-800">{{ $surat->nama_surat }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($surat->kode_surat)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                    {{ $surat->kode_surat }}
                                </span>
                            @else
                                <span class="text-slate-400 text-xs italic">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                             @if($surat->template_file)
                                <div class="flex items-center gap-2 text-slate-600">
                                    <i class="fas fa-file-word text-blue-500"></i>
                                    <span class="truncate max-w-[200px]">{{ $surat->template_file }}</span>
                                </div>
                            @else
                                <span class="text-red-500 text-xs flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> Tidak ada file</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('jenis-surat.edit', $surat->id_jenis_surat) }}" class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('jenis-surat.destroy', $surat->id_jenis_surat) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus template surat ini?');">
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
                                <i class="fas fa-file-contract text-4xl mb-3 opacity-20"></i>
                                <p>Belum ada jenis surat.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View -->
        <div class="md:hidden divide-y divide-slate-100">
             @forelse ($suratList as $surat)
             <div class="p-4 space-y-3">
                <div class="flex justify-between items-start">
                     <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-sm border border-indigo-100">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 leading-snug">{{ $surat->nama_surat }}</h3>
                             @if($surat->kode_surat)
                                <p class="text-xs text-slate-500 font-mono mt-0.5">Kode: {{ $surat->kode_surat }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 p-3 rounded-lg text-sm text-slate-700 flex items-center gap-2">
                    <i class="fas fa-paperclip text-slate-400"></i>
                     @if($surat->template_file)
                        <span class="truncate">{{ $surat->template_file }}</span>
                     @else
                        <span class="text-red-500 italic">Belum ada file template</span>
                     @endif
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-50">
                    <a href="{{ route('jenis-surat.edit', $surat->id_jenis_surat) }}" class="flex-1 py-2 bg-amber-50 text-amber-700 text-center rounded-lg text-sm font-medium hover:bg-amber-100">
                        Edit
                    </a>
                    <form action="{{ route('jenis-surat.destroy', $surat->id_jenis_surat) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus template ini?');">
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
    </div>
</div>
@endsection