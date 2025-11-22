@extends('layouts.kades')

@section('title', 'Dashboard Kepala Desa')

@section('content')
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Penduduk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalWarga }} Jiwa</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total KK</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKK }} KK</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-home fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Surat Masuk (Bulan Ini)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $suratMasuk }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-envelope-open-text fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Surat Selesai (Bulan Ini)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $suratSelesai }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Demografi Gender</h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold">Laki-laki <span class="float-right">{{ $wargaLaki }}</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-primary" role="progressbar"
                            style="width: {{ $totalWarga > 0 ? ($wargaLaki / $totalWarga) * 100 : 0 }}%"></div>
                    </div>
                    <h4 class="small font-weight-bold">Perempuan <span class="float-right">{{ $wargaPerempuan }}</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-danger" role="progressbar"
                            style="width: {{ $totalWarga > 0 ? ($wargaPerempuan / $totalWarga) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection