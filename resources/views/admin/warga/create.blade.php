@extends('layouts.admin')

@section('title', 'Tambah Data Warga')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Warga</h6>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('warga.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nik">NIK (16 Digit)</label>
                            <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                value="{{ old('nama_lengkap') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="id_kk">Pilih Kartu Keluarga (KK)</label>
                    <select class="form-control" id="id_kk" name="id_kk">
                        <option value="">-- Pilih KK --</option>
                        @foreach ($kkList as $kk)
                            <option value="{{ $kk->id_kk }}">
                                {{ $kk->no_kk }}

                                {{-- Tampilkan nama jika sudah ada, atau tulisan Kosong jika belum --}}
                                @if($kk->kepalaKeluarga)
                                    - {{ $kk->kepalaKeluarga->nama_lengkap }}
                                @else
                                    - (Belum Ada Kepala Keluarga)
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="status_dalam_keluarga">Status Hubungan Dalam Keluarga</label>
                    <select class="form-control" id="status_dalam_keluarga" name="status_dalam_keluarga">
                        <option value="KEPALA KELUARGA">KEPALA KELUARGA</option>
                        <option value="ISTRI">ISTRI</option>
                        <option value="ANAK">ANAK</option>
                        <option value="FAMILI LAIN" selected>FAMILI LAIN</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                value="{{ old('tempat_lahir') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                <option value="">-- Pilih --</option>
                                <option value="LAKI-LAKI" {{ old('jenis_kelamin') == 'LAKI-LAKI' ? 'selected' : '' }}>
                                    LAKI-LAKI</option>
                                <option value="PEREMPUAN" {{ old('jenis_kelamin') == 'PEREMPUAN' ? 'selected' : '' }}>
                                    PEREMPUAN</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="agama">Agama</label>
                            <select class="form-control" id="agama" name="agama">
                                <option value="">-- Pilih Agama --</option>
                                <option value="ISLAM" {{ old('agama') == 'ISLAM' ? 'selected' : '' }}>ISLAM</option>
                                <option value="KRISTEN" {{ old('agama') == 'KRISTEN' ? 'selected' : '' }}>KRISTEN</option>
                                <option value="KATOLIK" {{ old('agama') == 'KATOLIK' ? 'selected' : '' }}>KATOLIK</option>
                                <option value="HINDU" {{ old('agama') == 'HINDU' ? 'selected' : '' }}>HINDU</option>
                                <option value="BUDHA" {{ old('agama') == 'BUDHA' ? 'selected' : '' }}>BUDHA</option>
                                <option value="KONGHUCU" {{ old('agama') == 'KONGHUCU' ? 'selected' : '' }}>KONGHUCU</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status_perkawinan">Status Perkawinan</label>
                            <select class="form-control" id="status_perkawinan" name="status_perkawinan">
                                <option value="">-- Pilih Status --</option>
                                <option value="BELUM KAWIN" {{ old('status_perkawinan') == 'BELUM KAWIN' ? 'selected' : '' }}>
                                    BELUM KAWIN</option>
                                <option value="KAWIN" {{ old('status_perkawinan') == 'KAWIN' ? 'selected' : '' }}>KAWIN
                                </option>
                                <option value="CERAI HIDUP" {{ old('status_perkawinan') == 'CERAI HIDUP' ? 'selected' : '' }}>
                                    CERAI HIDUP</option>
                                <option value="CERAI MATI" {{ old('status_perkawinan') == 'CERAI MATI' ? 'selected' : '' }}>
                                    CERAI MATI</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pekerjaan">Pekerjaan</label>
                            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                                value="{{ old('pekerjaan') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="kewarganegaraan">Kewarganegaraan</label>
                    <select class="form-control" id="kewarganegaraan" name="kewarganegaraan">
                        <option value="WNI" {{ old('kewarganegaraan', 'WNI') == 'WNI' ? 'selected' : '' }}>WNI (Warga Negara
                            Indonesia)</option>
                        <option value="WNA" {{ old('kewarganegaraan') == 'WNA' ? 'selected' : '' }}>WNA (Warga Negara Asing)
                        </option>
                    </select>
                </div>
                {{-- TAMBAHKAN INFO INI --}}
                <hr>
                <div class="alert alert-info small">
                    <i class="fas fa-info-circle"></i>
                    <strong>Catatan:</strong> Akun login akan dibuat secara otomatis.
                    <ul>
                        <li><strong>Username:</strong> Akan diisi sesuai NIK</li>
                        <li><strong>Password Default:</strong> 123456</li>
                    </ul>
                </div>

                <a href="{{ route('warga.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection