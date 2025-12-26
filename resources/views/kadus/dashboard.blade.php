@extends('layouts.modern')

@section('title', 'Dashboard Kadus')

@section('content')
<div class="space-y-6">

    <!-- Welcome / Info Banner -->
    <div class="bg-indigo-600 rounded-3xl p-6 text-white relative overflow-hidden shadow-xl shadow-indigo-200">
        <!-- Background Pattern -->
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold mb-1">Selamat Datang, Bapak {{ Auth::user()->nama_lengkap }}!</h1>
                <p class="text-indigo-100 flex items-center gap-2">
                    <i class="fas fa-map-marker-alt"></i>
                    Mengelola Wilayah: <span class="font-semibold bg-white/20 px-2 py-0.5 rounded text-white">{{ Auth::user()->dusun->nama_dusun ?? 'Wilayah Tidak Diketahui' }}</span>
                </p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm p-3 rounded-2xl flex items-center gap-3 border border-white/10">
                <div class="text-right">
                    <p class="text-xs text-indigo-100 uppercase tracking-wider">Tanggal Hari Ini</p>
                    <p class="font-bold">{{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                </div>
                <div class="h-10 w-10 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <!-- Total Penduduk -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-slate-500 text-xs uppercase font-bold tracking-wider">Total Penduduk</p>
                <p class="text-2xl font-bold text-slate-800">{{ $totalWarga }} <span class="text-sm font-normal text-slate-400">Jiwa</span></p>
            </div>
        </div>

        <!-- Total KK -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="h-12 w-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fas fa-home"></i>
            </div>
            <div>
                <p class="text-slate-500 text-xs uppercase font-bold tracking-wider">Total KK</p>
                <p class="text-2xl font-bold text-slate-800">{{ $totalKK }} <span class="text-sm font-normal text-slate-400">Keluarga</span></p>
            </div>
        </div>

        <!-- Surat Proses -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="h-12 w-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <p class="text-slate-500 text-xs uppercase font-bold tracking-wider">Surat Proses</p>
                <p class="text-2xl font-bold text-slate-800">{{ $suratMasuk }}</p>
            </div>
        </div>

        <!-- Surat Selesai -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="h-12 w-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center text-xl">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <p class="text-slate-500 text-xs uppercase font-bold tracking-wider">Surat Selesai</p>
                <p class="text-2xl font-bold text-slate-800">{{ $suratSelesai }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity Column -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800">Aktivitas Surat Terbaru</h3>
                    <a href="{{ route('kadus.surat') }}" class="text-sm text-indigo-600 font-medium hover:underline">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-xs">
                            <tr>
                                <th class="px-5 py-3 font-semibold">Warga</th>
                                <th class="px-5 py-3 font-semibold">Jenis Surat</th>
                                <th class="px-5 py-3 font-semibold">Tanggal</th>
                                <th class="px-5 py-3 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($suratTerbaru as $surat)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3">
                                    <div class="font-medium text-slate-800">{{ $surat->warga->nama_lengkap }}</div>
                                </td>
                                <td class="px-5 py-3">
                                    {{ $surat->jenisSurat->nama_surat ?? '-' }}
                                </td>
                                <td class="px-5 py-3 text-slate-500">
                                    {{ \Carbon\Carbon::parse($surat->tanggal_ajuan)->format('d M Y') }}
                                </td>
                                <td class="px-5 py-3">
                                    @if($surat->status == 'BARU') 
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            Proses
                                        </span>
                                    @elseif($surat->status == 'SELESAI') 
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                            Selesai
                                        </span>
                                    @elseif($surat->status == 'MENUNGGU_TTD')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Menunggu TTD
                                        </span>
                                    @else 
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-slate-400">
                                    <i class="fas fa-inbox text-2xl mb-2"></i>
                                    <p>Belum ada aktivitas surat.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Demographics Chart -->
        <div>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 h-full">
                <h3 class="font-bold text-slate-800 mb-4">Demografi Gender</h3>
                <div class="relative h-64">
                    <canvas id="myPieChart"></canvas>
                </div>
                <div class="mt-4 flex justify-center gap-4 text-sm">
                    <div class="flex items-center gap-2">
                         <span class="w-3 h-3 rounded-full bg-[#4e73df]"></span>
                         <span class="text-slate-600">Laki-laki ({{ $wargaLaki }})</span>
                    </div>
                     <div class="flex items-center gap-2">
                         <span class="w-3 h-3 rounded-full bg-[#e74a3b]"></span>
                         <span class="text-slate-600">Perempuan ({{ $wargaPerempuan }})</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

<script>
    // Grafik Pie Gender
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ["Laki-laki", "Perempuan"],
        datasets: [{
          data: [{{ $wargaLaki }}, {{ $wargaPerempuan }}],
          backgroundColor: ['#4e73df', '#e74a3b'],
          hoverBackgroundColor: ['#2e59d9', '#be2617'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
          borderWidth: 0
        }],
      },
      options: {
        maintainAspectRatio: false,
        cutoutPercentage: 75,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: { display: false },
      },
    });
</script>
@endpush