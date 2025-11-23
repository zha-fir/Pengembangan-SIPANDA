@extends('layouts.admin')

@section('title', 'Edit Data Warga')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Warga</h6>
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

            <form action="{{ route('warga.update', $warga->id_warga) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nik">NIK (16 Digit)</label>
                            <input type="text" class="form-control" id="nik" name="nik"
                                value="{{ old('nik', $warga->nik) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                value="{{ old('nama_lengkap', $warga->nama_lengkap) }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="id_kk">Pilih Kartu Keluarga (KK)</label>
                    <select class="form-control" id="id_kk" name="id_kk">
                        <option value="">-- Pilih KK --</option>
                        @foreach ($kkList as $kk)
                            <option value="{{ $kk->id_kk }}" {{-- LOGIKA: Jika ID KK warga sama dengan ID KK di loop, pilih ini
                                --}} {{ old('id_kk', $warga->id_kk) == $kk->id_kk ? 'selected' : '' }}>

                                {{ $kk->no_kk }} -
                                @if($kk->kepalaKeluarga)
                                    {{ $kk->kepalaKeluarga->nama_lengkap }}
                                @else
                                    (Belum Ada Kepala Keluarga)
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Status Hubungan Dalam Keluarga</label>
                    <select class="form-control" name="status_dalam_keluarga">
                        <option value="KEPALA KELUARGA" {{ old('status_dalam_keluarga', $warga->status_dalam_keluarga) == 'KEPALA KELUARGA' ? 'selected' : '' }}>KEPALA KELUARGA</option>
                        <option value="ISTRI" {{ old('status_dalam_keluarga', $warga->status_dalam_keluarga) == 'ISTRI' ? 'selected' : '' }}>ISTRI</option>
                        <option value="ANAK" {{ old('status_dalam_keluarga', $warga->status_dalam_keluarga) == 'ANAK' ? 'selected' : '' }}>ANAK</option>
                        <option value="FAMILI LAIN" {{ old('status_dalam_keluarga', $warga->status_dalam_keluarga) == 'FAMILI LAIN' ? 'selected' : '' }}>FAMILI LAIN</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                value="{{ old('tempat_lahir', $warga->tempat_lahir) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $warga->tanggal_lahir) }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                <option value="">-- Pilih --</option>
                                {{-- LOGIKA SELECTED --}}
                                <option value="LAKI-LAKI" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'LAKI-LAKI' ? 'selected' : '' }}>LAKI-LAKI</option>
                                <option value="PEREMPUAN" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'PEREMPUAN' ? 'selected' : '' }}>PEREMPUAN</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="agama">Agama</label>
                            <select class="form-control" id="agama" name="agama">
                                <option value="">-- Pilih Agama --</option>
                                {{-- Kita loop array agama, dan cek satu per satu --}}
                                @foreach(['ISLAM', 'KRISTEN', 'KATOLIK', 'HINDU', 'BUDHA', 'KONGHUCU'] as $ag)
                                    <option value="{{ $ag }}" {{ old('agama', $warga->agama) == $ag ? 'selected' : '' }}>
                                        {{ $ag }}
                                    </option>
                                @endforeach
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
                                @foreach(['BELUM KAWIN', 'KAWIN', 'CERAI HIDUP', 'CERAI MATI'] as $status)
                                    <option value="{{ $status }}" {{ old('status_perkawinan', $warga->status_perkawinan) == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pekerjaan">Pekerjaan</label>
                            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                                value="{{ old('pekerjaan', $warga->pekerjaan) }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="kewarganegaraan">Kewarganegaraan</label>
                    <select class="form-control" id="kewarganegaraan" name="kewarganegaraan">
                        <option value="WNI" {{ old('kewarganegaraan', $warga->kewarganegaraan) == 'WNI' ? 'selected' : '' }}>
                            WNI</option>
                        <option value="WNA" {{ old('kewarganegaraan', $warga->kewarganegaraan) == 'WNA' ? 'selected' : '' }}>
                            WNA</option>
                    </select>
                </div>

                <hr>

                {{-- Bagian Akun (Reset Password) --}}
                @if($warga->user)
                    <h5><i class="fas fa-key"></i> Reset Password Akun</h5>
                    <p class="text-muted">
                        Username: <strong>{{ $warga->user->username }}</strong>
                    </p>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="reset_password" id="reset_password">
                        <label class="form-check-label" for="reset_password">
                            Ya, reset password warga ini
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Minimal 6 karakter">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary btn-toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <h5><i class="fas fa-key"></i> Buat Akun Login</h5>
                    <p class="text-danger small">Warga ini belum memiliki akun login.</p>
                @endif

                <a href="{{ route('warga.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection