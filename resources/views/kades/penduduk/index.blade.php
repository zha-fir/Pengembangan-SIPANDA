@extends('layouts.modern')

@section('title', 'Data Penduduk Desa')

@section('content')
<div class="space-y-6">

    <!-- Header & Search -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Data Penduduk</h1>
            <p class="text-slate-500 text-sm mt-1">
                Database seluruh penduduk desa.
            </p>
        </div>

        <form action="{{ route('kades.penduduk.index') }}" method="GET" class="w-full md:w-auto">
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="block w-full md:w-80 pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all shadow-sm"
                       placeholder="Cari NIK atau Nama...">
            </div>
        </form>
    </div>

    <!-- Data Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        
        <!-- Mobile View (Card List) -->
        <div class="block md:hidden divide-y divide-slate-100">
            @forelse ($wargaList as $warga)
                <div class="p-4 space-y-3">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-slate-900">{{ $warga->nama_lengkap }}</h3>
                            <p class="text-xs text-slate-500 font-mono mt-0.5">{{ $warga->nik }}</p>
                        </div>
                         <a href="{{ route('kades.penduduk.show', $warga->id_warga) }}" class="text-slate-400 hover:text-indigo-600">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                         <div class="bg-slate-50 p-2 rounded-lg">
                            <span class="block text-[10px] text-slate-400 uppercase font-bold">Gender</span>
                            <span class="{{ $warga->jenis_kelamin == 'LAKI-LAKI' ? 'text-blue-600' : 'text-pink-600' }} font-bold">
                                {{ $warga->jenis_kelamin == 'LAKI-LAKI' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </div>
                        <div class="bg-slate-50 p-2 rounded-lg">
                            <span class="block text-[10px] text-slate-400 uppercase font-bold">Dusun</span>
                            <span class="text-slate-700 font-bold truncate">{{ $warga->kk->dusun->nama_dusun ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            @empty
                 <div class="p-8 text-center text-slate-400">
                    <p>Penduduk tidak ditemukan.</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop View (Table) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-xs border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Profil Warga</th>
                        <th class="px-6 py-4 font-semibold">Jenis Kelamin</th>
                        <th class="px-6 py-4 font-semibold">Wilayah Dusun</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($wargaList as $warga)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div>
                                    <div class="font-bold text-slate-900">{{ $warga->nama_lengkap }}</div>
                                    <div class="text-xs text-slate-400 font-mono mt-0.5">{{ $warga->nik }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($warga->jenis_kelamin == 'LAKI-LAKI')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                        <i class="fas fa-mars"></i> Laki-laki
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-pink-50 text-pink-700">
                                        <i class="fas fa-venus"></i> Perempuan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs font-medium">
                                    {{ $warga->kk->dusun->nama_dusun ?? 'Dusun ?' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('kades.penduduk.show', $warga->id_warga) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm border border-indigo-100 hover:bg-indigo-50 px-3 py-1.5 rounded-lg transition-colors">
                                    <i class="fas fa-id-card mr-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-slate-50 p-4 rounded-full mb-3">
                                        <i class="fas fa-user-slash text-2xl"></i>
                                    </div>
                                    <p>Data penduduk tidak ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $wargaList->links('pagination::tailwind') }}
        </div>
    </div>

</div>
@endsection