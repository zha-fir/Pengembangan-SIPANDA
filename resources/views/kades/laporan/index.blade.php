@extends('layouts.kades')

@section('title', 'Laporan & Rekapitulasi')

@section('content')
    <div class="row">

        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-users me-2"></i> Laporan Data Penduduk</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('kades.laporan.cetak-penduduk') }}" method="GET" target="_blank">

                        <div class="form-group">
                            <label>Filter Dusun (Opsional)</label>
                            <select name="id_dusun" class="form-control">
                                <option value="">-- Semua Dusun --</option>
                                @foreach($dusunList as $dusun)
                                    <option value="{{ $dusun->id_dusun }}">{{ $dusun->nama_dusun }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin (Opsional)</label>
                            <select name="jenis_kelamin" class="form-control">
                                <option value="">-- Semua --</option>
                                <option value="LAKI-LAKI">Laki-laki</option>
                                <option value="PEREMPUAN">Perempuan</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-print me-2"></i> Cetak PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-file-alt me-2"></i> Laporan Arsip Surat</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('kades.laporan.cetak-surat') }}" method="GET" target="_blank">

                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label>Bulan</label>
                                <select name="bulan" class="form-control" required>
                                    @for($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ date('m') == $m ? 'selected' : '' }}>
                                            {{ date("F", mktime(0, 0, 0, $m, 10)) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Tahun</label>
                                <select name="tahun" class="form-control" required>
                                    @for($y = date('Y'); $y >= 2020; $y--)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Jenis Surat (Opsional)</label>
                            <select name="id_jenis_surat" class="form-control">
                                <option value="">-- Semua Jenis --</option>
                                @foreach($jenisSuratList as $surat)
                                    <option value="{{ $surat->id_jenis_surat }}">{{ $surat->nama_surat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-print me-2"></i> Cetak PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection