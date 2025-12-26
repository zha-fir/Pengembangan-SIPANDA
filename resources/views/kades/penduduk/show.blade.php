@extends('layouts.modern')

@section('title', 'Detail Profil Warga')

@section('content')
<div class="space-y-6">

    <!-- Back Button -->
    <a href="{{ route('kades.penduduk.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-indigo-600 font-medium transition-colors">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Profile Card (Left) -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 flex flex-col items-center text-center h-fit">
            <div class="relative">
                <div class="h-32 w-32 rounded-full p-1 bg-white border-2 border-indigo-100 shadow-sm mb-4">
                    <img class="h-full w-full rounded-full object-cover" src="{{ asset('img/undraw_profile.svg') }}" alt="Profile">
                </div>
                 <div class="absolute bottom-4 right-0 bg-white rounded-full p-1.5 shadow-sm border border-slate-100">
                    @if($warga->jenis_kelamin == 'LAKI-LAKI')
                        <i class="fas fa-mars text-blue-500 text-lg"></i>
                    @else
                        <i class="fas fa-venus text-pink-500 text-lg"></i>
                    @endif
                </div>
            </div>
            
            <h2 class="text-xl font-bold text-slate-800">{{ $warga->nama_lengkap }}</h2>
            <p class="text-slate-400 text-sm font-mono mt-1">{{ $warga->nik }}</p>

            <div class="mt-4 flex gap-2">
                @if($warga->jenis_kelamin == 'LAKI-LAKI')
                    <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wide">
                        Laki-laki
                    </span>
                @else
                    <span class="px-3 py-1 rounded-full bg-pink-50 text-pink-600 text-xs font-bold uppercase tracking-wide">
                        Perempuan
                    </span>
                @endif
            </div>
        </div>

        <!-- Detail Info (Right) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-50">
                <h3 class="font-bold text-slate-800">Informasi Lengkap</h3>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    
                    <!-- Col 1 -->
                    <div class="space-y-4 text-sm">
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tempat, Tanggal Lahir</span>
                            <div class="font-medium text-slate-800">
                                {{ $warga->tempat_lahir }}, {{ \Carbon\Carbon::parse($warga->tanggal_lahir)->isoFormat('D MMMM Y') }}
                            </div>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Usia</span>
                            <div class="font-medium text-slate-800">{{ \Carbon\Carbon::parse($warga->tanggal_lahir)->age }} Tahun</div>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Agama</span>
                            <div class="font-medium text-slate-800">{{ $warga->agama }}</div>
                        </div>
                         <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Status Perkawinan</span>
                            <div class="font-medium text-slate-800">{{ $warga->status_perkawinan }}</div>
                        </div>
                    </div>

                    <!-- Col 2 -->
                    <div class="space-y-4 text-sm">
                         <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Pekerjaan</span>
                            <div class="font-medium text-slate-800">{{ $warga->pekerjaan }}</div>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Kewarganegaraan</span>
                            <div class="font-medium text-slate-800">{{ $warga->kewarganegaraan }}</div>
                        </div>
                    </div>

                </div>

                <div class="my-6 border-t border-slate-100"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 text-sm">
                    <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor Kartu Keluarga (KK)</span>
                        <div class="font-medium text-indigo-600 font-mono text-base">{{ $warga->kk->no_kk ?? '-' }}</div>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Kepala Keluarga</span>
                        <div class="font-medium text-slate-800">{{ $warga->kk->kepalaKeluarga->nama_lengkap ?? '(Belum Diset)' }}</div>
                    </div>
                    <div class="md:col-span-2">
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat Lengkap</span>
                        <div class="font-medium text-slate-800">
                            {{ $warga->kk->alamat_kk ?? '-' }}
                        </div>
                        <div class="text-slate-500 mt-1">
                            Dusun {{ $warga->kk->dusun->nama_dusun ?? '-' }} - RT {{ $warga->kk->rt }} / RW {{ $warga->kk->rw }}
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection