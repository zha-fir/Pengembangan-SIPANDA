@extends('layouts.kades')

@section('title', 'Detail Profil Warga')

@section('content')

<a href="{{ route('kades.penduduk.index') }}" class="btn btn-secondary btn-sm mb-3">
    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
</a>

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 border-left-primary">
            <div class="card-body text-center">
                <img class="img-profile rounded-circle mb-3" src="{{ asset('img/undraw_profile.svg') }}" style="width: 100px;">
                <h4 class="font-weight-bold text-dark">{{ $warga->nama_lengkap }}</h4>
                <p class="text-muted mb-1">NIK: {{ $warga->nik }}</p>
                <span class="badge badge-primary px-3 py-2">{{ $warga->jenis_kelamin }}</span>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-md-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Lengkap</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="text-muted" width="140">Tempat Lahir</td>
                                <td class="font-weight-bold">: {{ $warga->tempat_lahir }}</td>
                            </div>
                            <tr>
                                <td class="text-muted">Tanggal Lahir</td>
                                <td class="font-weight-bold">: {{ \Carbon\Carbon::parse($warga->tanggal_lahir)->isoFormat('D MMMM Y') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Usia</td>
                                <td class="font-weight-bold">: {{ \Carbon\Carbon::parse($warga->tanggal_lahir)->age }} Tahun</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Agama</td>
                                <td class="font-weight-bold">: {{ $warga->agama }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Status Kawin</td>
                                <td class="font-weight-bold">: {{ $warga->status_perkawinan }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="text-muted" width="140">Pekerjaan</td>
                                <td class="font-weight-bold">: {{ $warga->pekerjaan }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Kewarganegaraan</td>
                                <td class="font-weight-bold">: {{ $warga->kewarganegaraan }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><hr></td>
                            </tr>
                            <tr>
                                <td class="text-muted">No. Kartu Keluarga</td>
                                <td class="font-weight-bold text-primary">: {{ $warga->kk->no_kk ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Kepala Keluarga</td>
                                <td class="font-weight-bold">: {{ $warga->kk->nama_kepala_keluarga ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Alamat</td>
                                <td class="font-weight-bold">: {{ $warga->kk->alamat_kk ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Wilayah</td>
                                <td class="font-weight-bold">: {{ $warga->kk->dusun->nama_dusun ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection