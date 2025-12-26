@extends('layouts.modern')

@section('title', 'Dashboard Kades')

@section('content')
<div class="space-y-6">

    <!-- Welcome Banner with Stats (Special Layout) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Banner Column -->
        <div class="lg:col-span-2 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-3xl p-6 text-white relative overflow-hidden shadow-xl shadow-indigo-200 flex flex-col justify-center min-h-[160px]">
            <!-- Decorative Patterns -->
            <div class="absolute top-0 right-0 -mt-8 -mr-8 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row gap-6 md:items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Dashboard Kepala Desa</h1>
                    <p class="text-indigo-100 max-w-md text-sm md:text-base opacity-90 leading-relaxed">
                        Selamat Datang, <strong>{{ Auth::user()->nama_lengkap }}</strong>. 
                        Ini adalah pusat kontrol data kependudukan dan layanan surat desa Anda.
                    </p>
                </div>
                <!-- Quick Date Widget -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-2xl text-center min-w-[120px]">
                    <p class="text-xs uppercase tracking-widest text-indigo-200 mb-1">{{ \Carbon\Carbon::now()->translatedFormat('F') }}</p>
                    <p class="text-3xl font-bold text-white leading-none">{{ \Carbon\Carbon::now()->format('d') }}</p>
                    <p class="text-xs text-indigo-200 mt-1">{{ \Carbon\Carbon::now()->format('Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Primary Stat Card (Penduduk) -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 flex flex-col justify-center relative overflow-hidden">
             <div class="absolute top-0 right-0 p-4 opacity-10">
                <i class="fas fa-users text-8xl text-indigo-600 transform rotate-12 translate-x-4 -translate-y-4"></i>
            </div>
            <div>
                <p class="text-slate-500 text-sm font-bold uppercase tracking-wider mb-2">Total Penduduk</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-slate-800">{{ number_format($totalWarga) }}</span>
                    <span class="text-slate-400 font-medium">Jiwa</span>
                </div>
                <div class="mt-4 flex items-center gap-2 text-sm text-indigo-600 bg-indigo-50 w-fit px-3 py-1 rounded-full">
                    <i class="fas fa-home"></i>
                    <span class="font-semibold">{{ $totalKK }} Keluarga (KK)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Surat Masuk -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    <i class="fas fa-inbox"></i>
                </div>
                <div>
                    <p class="text-slate-500 text-xs uppercase font-bold tracking-wider">Surat Masuk (Bulan Ini)</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $suratMasuk }}</p>
                </div>
            </div>
            <!-- Trend Indicator (Fake data for visual) -->
            <div class="text-right hidden sm:block">
                 <span class="text-xs text-slate-400">Total Permintaan</span>
            </div>
        </div>

        <!-- Surat Selesai -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fas fa-check-double"></i>
                </div>
                <div>
                    <p class="text-slate-500 text-xs uppercase font-bold tracking-wider">Selesai (Bulan Ini)</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $suratSelesai }}</p>
                </div>
            </div>
             <div class="text-right hidden sm:block">
                 <span class="text-xs text-slate-400">Siap Diambil</span>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Bar Chart (Sebaran Dusun) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
             <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-slate-800">Sebaran Penduduk per Dusun</h3>
                <button class="text-slate-400 hover:text-indigo-600"><i class="fas fa-ellipsis-h"></i></button>
            </div>
            <div class="relative h-72 w-full">
                <canvas id="myBarChart"></canvas>
            </div>
        </div>

        <!-- Pie Chart (Profesi) -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="font-bold text-slate-800 mb-6">Top 5 Profesi Warga</h3>
            <div class="relative h-64 w-full">
                <canvas id="myPieChart"></canvas>
            </div>
             <div class="mt-4 text-center">
                <p class="text-xs text-slate-400 italic">*Data dari 5 pekerjaan terbanyak</p>
            </div>
        </div>
    </div>

    <!-- Recent Activity Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-50 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">Aktivitas Surat Terbaru</h3>
            <a href="{{ route('kades.monitoring.index') }}" class="text-sm text-indigo-600 font-medium hover:underline">Lihat Semua</a>
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
                            <div class="font-medium text-slate-900">{{ $surat->warga->nama_lengkap }}</div>
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
                            <p>Belum ada aktivitas surat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

<script>
    // --- 1. KONFIGURASI GRAFIK BATANG (DUSUN) ---
    var ctxBar = document.getElementById("myBarChart");
    var myBarChart = new Chart(ctxBar, {
      type: 'bar',
      data: {
        labels: {!! json_encode($chartDusunLabels) !!},
        datasets: [{
          label: "Jumlah Warga",
          backgroundColor: "#4f46e5", // Indigo-600
          hoverBackgroundColor: "#4338ca", // Indigo-700
          borderColor: "#4f46e5",
          data: {!! json_encode($chartDusunData) !!},
          barPercentage: 0.6,
          categoryPercentage: 0.8
        }],
      },
      options: {
        maintainAspectRatio: false,
        layout: { padding: { left: 0, right: 0, top: 0, bottom: 0 } },
        scales: {
            xAxes: [{
                gridLines: { display: false, drawBorder: false },
                ticks: {
                    fontColor: "#64748b", // Slate-500
                    fontFamily: "'Plus Jakarta Sans', sans-serif"
                }
            }],
            yAxes: [{
                gridLines: {
                    color: "rgba(226, 232, 240, 0.6)", // Slate-200
                    zeroLineColor: "rgba(226, 232, 240, 0.6)",
                    borderDash: [5, 5],
                    drawBorder: false
                },
                ticks: {
                     fontColor: "#64748b",
                     padding: 10,
                     min: 0
                }
            }],
        },
        legend: { display: false },
        tooltips: {
            backgroundColor: "#1e293b", // Slate-800
            titleFontColor: "#fff",
            bodyFontColor: "#fff",
            cornerRadius: 8,
            xPadding: 12,
            yPadding: 12
        }
      }
    });

    // --- 2. KONFIGURASI GRAFIK DONAT (PEKERJAAN) ---
    var ctxPie = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctxPie, {
      type: 'doughnut',
      data: {
        labels: {!! json_encode($chartPekerjaanLabels) !!},
        datasets: [{
          data: {!! json_encode($chartPekerjaanData) !!},
          backgroundColor: ['#4f46e5', '#8b5cf6', '#ec4899', '#f59e0b', '#10b981'], // Modern Palette
          hoverBackgroundColor: ['#4338ca', '#7c3aed', '#db2777', '#d97706', '#059669'],
          hoverBorderColor: "#ffffff",
          borderWidth: 2
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "#1e293b",
          bodyFontColor: "#fff",
          cornerRadius: 8,
          xPadding: 12,
          yPadding: 12
        },
        legend: { 
            display: true, 
            position: 'bottom',
            labels: {
                usePointStyle: true,
                fontColor: "#64748b",
                fontFamily: "'Plus Jakarta Sans', sans-serif",
                padding: 20
            }
        },
        cutoutPercentage: 75,
      },
    });
</script>
@endpush