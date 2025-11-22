@extends('layouts.kadus')

@section('title', 'Dashboard Wilayah')

@section('content')

    <div class="alert alert-info shadow-sm mb-4">
        <i class="fas fa-map-marker-alt me-2"></i>
        Selamat datang! Anda sedang melihat data wilayah
        <strong>{{ Auth::user()->dusun->nama_dusun ?? 'Dusun Tidak Diketahui' }}</strong>.
    </div>

    <div class="row">

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Warga (Wilayah Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalWarga }} Jiwa</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Kepala Keluarga</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKK }} KK</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-home fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Permintaan Surat Baru</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $suratMasuk }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope-open-text fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection