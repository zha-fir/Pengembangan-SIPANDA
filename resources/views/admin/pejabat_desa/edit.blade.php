@extends('layouts.admin')
@section('title', 'Edit Pejabat Desa')
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('pejabat-desa.update', $pejabat->id_pejabat_desa) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_pejabat">Nama Lengkap (beserta gelar)</label>
                <input type="text" class="form-control" id="nama_pejabat" name="nama_pejabat" value="{{ old('nama_pejabat', $pejabat->nama_pejabat) }}">
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ old('jabatan', $pejabat->jabatan) }}">
            </div>
            <a href="{{ route('pejabat-desa.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection