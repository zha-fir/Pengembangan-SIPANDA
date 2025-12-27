@extends('layouts.modern')

@section('title', 'Anggota Keluarga')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col gap-4">
        <a href="{{ route('kk.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 w-fit transition-colors">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar KK
        </a>
        
        <div class="bg-gradient-to-br from-indigo-900 to-indigo-700 rounded-2xl p-6 md:p-8 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row md:items-start justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight mb-2 font-mono">{{ $kk->no_kk }}</h1>
                    <div class="flex flex-wrap gap-4 text-indigo-200 text-sm">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt"></i> {{ $kk->alamat_kk }} (RT {{ $kk->rt }}/RW {{ $kk->rw }})
                        </span>
                         <span class="flex items-center gap-2">
                            <i class="fas fa-map-signs"></i> {{ $kk->dusun->nama_dusun ?? 'Belum ada Dusun' }}
                        </span>
                    </div>
                </div>
                
                 <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20 min-w-[200px]">
                    <p class="text-xs text-indigo-300 uppercase tracking-wider font-semibold mb-1">Kepala Keluarga</p>
                    @if($kk->kepalaKeluarga)
                        <p class="font-bold text-lg leading-tight">{{ $kk->kepalaKeluarga->nama_lengkap }}</p>
                        <p class="text-xs font-mono opacity-80 mt-1">{{ $kk->kepalaKeluarga->nik }}</p>
                    @else
                        <div class="flex items-center gap-2 text-amber-300">
                             <i class="fas fa-exclamation-triangle"></i>
                             <span class="font-bold">Belum ditentukan</span>
                        </div>
                        <p class="text-xs text-white/60 mt-1 leading-snug">
                            Silakan edit warga lalu set statusnya menjadi "Kepala Keluarga".
                        </p>
                    @endif
                </div>
            </div>

             <!-- Decoration -->
             <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>
        </div>
    </div>

    <!-- Members List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <i class="fas fa-users text-indigo-500"></i> Daftar Anggota Keluarga
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                 <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-xs border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-bold">NIK & Nama</th>
                        <th class="px-6 py-4 font-bold text-center">L/P</th>
                        <th class="px-6 py-4 font-bold">Tempat, Tgl Lahir</th>
                        <th class="px-6 py-4 font-bold">Pekerjaan</th>
                        <th class="px-6 py-4 font-bold">Status Hubungan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                     @forelse ($kk->warga as $warga)
                     <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-start gap-3">
                                 <div class="mt-1 h-2 w-2 rounded-full {{ $warga->status_dalam_keluarga == 'KEPALA KELUARGA' ? 'bg-indigo-500' : 'bg-slate-300' }}"></div>
                                 <div class="flex-1">
                                    <p class="font-bold text-slate-800">{{ $warga->nama_lengkap }}</p>
                                    <p class="text-xs text-slate-500 font-mono">{{ $warga->nik }}</p>
                                 </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($warga->jenis_kelamin == 'LAKI-LAKI')
                                <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-blue-50 text-blue-600 text-xs" title="Laki-laki"><i class="fas fa-mars"></i></span>
                            @else
                                <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-pink-50 text-pink-600 text-xs" title="Perempuan"><i class="fas fa-venus"></i></span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-slate-700">{{ $warga->tempat_lahir }}</p>
                            <p class="text-xs text-slate-500">
                                {{ $warga->tanggal_lahir ? \Carbon\Carbon::parse($warga->tanggal_lahir)->isoFormat('D MMMM Y') : '-' }}
                            </p>
                        </td>
                        <td class="px-6 py-4">
                            {{ $warga->pekerjaan }}
                        </td>
                        <td class="px-6 py-4">
                             @if($warga->status_dalam_keluarga == 'KEPALA KELUARGA')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700 border border-indigo-200">
                                    <i class="fas fa-crown text-[10px]"></i> Kepala Keluarga
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                    {{ $warga->status_dalam_keluarga }}
                                </span>
                            @endif
                        </td>
                     </tr>
                     @empty
                     <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            <p>Belum ada anggota keluarga terdaftar di KK ini.</p>
                            <p class="text-xs mt-2">Tambahkan warga baru dan pilih Nomor KK ini saat mengisi data.</p>
                        </td>
                     </tr>
                     @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection