@extends('layouts.admin')

@section('title', 'Detail Data Penduduk')

@section('content')

    <a href="{{ route('warga.index') }}" class="btn btn-secondary btn-sm mb-3">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <img src="{{ asset('img/undraw_profile.svg') }}" alt="Foto Profil" class="img-fluid rounded-circle mb-3"
                        style="width: 150px;">
                    <h4 class="text-dark font-weight-bold">{{ $warga->nama_lengkap }}</h4>
                    <p class="text-muted">NIK: {{ $warga->nik }}</p>

                    <hr>

                    <div class="text-left">
                        <strong>Status Akun:</strong>
                        @if($warga->user)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Belum Ada Akun</span>
                        @endif
                        <br>
                        <strong>Status Keluarga:</strong> {{ $warga->status_dalam_keluarga }}
                    </div>

                    <hr>

                    {{-- Tombol Edit Cepat --}}
                    <a href="{{ route('warga.edit', $warga->id_warga) }}" class="btn btn-warning btn-block">
                        <i class="fas fa-edit"></i> Edit Data Ini
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Biodata Lengkap</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th width="30%">Nomor KK</th>
                            <td>
                                {{ $warga->kk->no_kk ?? '-' }}
                                @if($warga->kk && $warga->kk->kepalaKeluarga)
                                    <small class="text-muted">(Kepala: {{ $warga->kk->kepalaKeluarga->nama_lengkap }})</small>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tempat, Tanggal Lahir</th>
                            <td>{{ $warga->tempat_lahir }},
                                {{ \Carbon\Carbon::parse($warga->tanggal_lahir)->isoFormat('D MMMM Y') }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $warga->jenis_kelamin }}</td>
                        </tr>
                        <tr>
                            <th>Agama</th>
                            <td>{{ $warga->agama }}</td>
                        </tr>
                        <tr>
                            <th>Pekerjaan</th>
                            <td>{{ $warga->pekerjaan }}</td>
                        </tr>
                        <tr>
                            <th>Status Perkawinan</th>
                            <td>{{ $warga->status_perkawinan }}</td>
                        </tr>
                        <tr>
                            <th>Kewarganegaraan</th>
                            <td>{{ $warga->kewarganegaraan }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>
                                {{ $warga->kk->alamat_kk ?? '-' }} <br>
                                RT {{ $warga->kk->rt ?? '-' }} / RW {{ $warga->kk->rw ?? '-' }} <br>
                                Dusun: {{ $warga->kk->dusun->nama_dusun ?? '-' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection