@extends('layouts.admin')

@section('title', 'Tambah Data KK')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Kartu Keluarga</h6>
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

        <form action="{{ route('kk.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="no_kk">Nomor KK (16 Digit)</label>
                <input type="text" class="form-control" id="no_kk" name="no_kk" value="{{ old('no_kk') }}">
            </div>

            <div class="form-group">
                <label for="nama_kepala_keluarga">Nama Kepala Keluarga</label>
                <input type="text" class="form-control" id="nama_kepala_keluarga" name="nama_kepala_keluarga" value="{{ old('nama_kepala_keluarga') }}">
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="id_dusun">Pilih Dusun</label>
                        {{-- Ini adalah DROPDOWN --}}
                        <select class="form-control" id="id_dusun" name="id_dusun">
                            <option value="">-- Pilih Dusun --</option>
                            {{-- Loop data $dusunList yang dikirim dari Controller --}}
                            @foreach ($dusunList as $dusun)
                                <option value="{{ $dusun->id_dusun }}" 
                                    {{ old('id_dusun') == $dusun->id_dusun ? 'selected' : '' }}>
                                    {{ $dusun->nama_dusun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="rt">RT</label>
                        <input type="text" class="form-control" id="rt" name="rt" value="{{ old('rt') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="rw">RW</label>
                        <input type="text" class="form-control" id="rw" name="rw" value="{{ old('rw') }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="alamat_kk">Alamat Lengkap (Sesuai KK)</label>
                <textarea class="form-control" id="alamat_kk" name="alamat_kk" rows="3">{{ old('alamat_kk') }}</textarea>
            </div>
            
            <a href="{{ route('kk.index') }}" class="btn btn-secondary">Batal</a>
            <button typeD="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection