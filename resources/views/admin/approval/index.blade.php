@extends('layouts.modern')

@section('title', 'Persetujuan Surat')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Persetujuan Surat</h1>
            <p class="text-slate-500 text-sm mt-1">Tinjau dan tandatangani surat yang masuk.</p>
        </div>
        
        <!-- Stats Card (Compact) -->
        <div class="bg-indigo-600 rounded-2xl p-4 text-white shadow-lg shadow-indigo-200 flex items-center gap-4 min-w-[200px]">
            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                <i class="fas fa-file-signature text-xl"></i>
            </div>
            <div>
                <p class="text-indigo-100 text-xs font-medium uppercase tracking-wider">Menunggu</p>
                <p class="text-2xl font-bold">{{ $pendingList->count() }} Surat</p>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-100 flex items-start gap-3 shadow-sm">
            <i class="fas fa-check-circle mt-1"></i>
            <div>
                <p class="font-bold">Berhasil!</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 text-red-700 p-4 rounded-xl border border-red-100 flex items-start gap-3 shadow-sm">
            <i class="fas fa-exclamation-triangle mt-1"></i>
            <div>
                <p class="font-bold">Terjadi Kesalahan</p>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Content Area -->
    @if($pendingList->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-3xl p-12 text-center borderBorder-slate-100 shadow-sm border border-slate-100 flex flex-col items-center">
            <div class="h-24 w-24 bg-green-50 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-check text-4xl text-green-500"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800">Semua Beres!</h3>
            <p class="text-slate-500 max-w-sm mx-auto mt-2">Tidak ada surat yang perlu persetujuan Anda saat ini. Kerja bagus!</p>
        </div>
    @else
        <!-- Responsive Grid for Mobile / List for Desktop -->
        <div class="grid grid-cols-1 gap-4">
            @foreach($pendingList as $ajuan)
                <!-- Card Item -->
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                    <!-- Status Strip -->
                    <div class="absolute top-0 left-0 bottom-0 w-1.5 bg-amber-400 group-hover:bg-amber-500 transition-colors"></div>

                    <div class="flex flex-col md:flex-row gap-5 md:items-center justify-between pl-3">
                        
                        <!-- Info Utama -->
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wide">
                                    {{ \Carbon\Carbon::parse($ajuan->tanggal_ajuan)->format('d M Y') }}
                                </span>
                                @if($ajuan->id_pejabat_desa == $pejabatSaya->id_pejabat_desa)
                                    <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-1 rounded-full uppercase">Utama</span>
                                @else
                                    <span class="bg-slate-100 text-slate-600 text-[10px] font-bold px-2 py-1 rounded-full uppercase">Mengetahui</span>
                                @endif
                            </div>
                            
                            <h3 class="text-lg font-bold text-slate-800 leading-tight mb-1">
                                {{ $ajuan->jenisSurat->nama_surat }}
                            </h3>
                            <div class="text-slate-500 text-sm flex flex-wrap gap-x-4 gap-y-1">
                                <span class="flex items-center gap-1"><i class="fas fa-user text-xs"></i> {{ $ajuan->warga->nama_lengkap }}</span>
                                <span class="flex items-center gap-1"><i class="fas fa-id-card text-xs"></i> {{ $ajuan->warga->nik }}</span>
                            </div>
                            
                            <div class="mt-3 bg-slate-50 p-3 rounded-xl text-sm text-slate-600 border border-slate-100">
                                <span class="font-semibold text-slate-800">Keperluan:</span> {{ $ajuan->keperluan }}
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="md:min-w-[180px] flex md:justify-end">
                            <form action="{{ route('approval.approve', $ajuan->id_ajuan) }}" method="POST" class="w-full md:w-auto" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui dan menandatangani surat ini?');">
                                @csrf
                                <button type="submit" class="w-full md:w-auto flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg shadow-indigo-200 transition-all active:scale-95">
                                    <i class="fas fa-pen-fancy"></i>
                                    <span>Tanda Tangani</span>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
