@extends('layouts.admin')
@section('title', 'Edit Pejabat Desa')
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('pejabat-desa.update', $pejabat->id_pejabat_desa) }}" method="POST" enctype="multipart/form-data">
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
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>NIP</label>
                    <input type="text" class="form-control" name="nip" value="{{ old('nip', $pejabat->nip) }}">
                </div>
                <div class="col-md-6 form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pejabat->tanggal_lahir) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="font-weight-bold">Update Tanda Tangan</label><br>
                @if($pejabat->ttd_path)
                    <div class="mb-2">
                        <img src="{{ Storage::url($pejabat->ttd_path) }}" alt="TTD Saat Ini" style="max-height: 100px; border: 1px dashed #ccc;">
                        <small class="d-block text-success">Sudah ada tanda tangan.</small>
                    </div>
                @else
                    <small class="d-block text-danger mb-2">Belum ada tanda tangan.</small>
                @endif
                <input type="file" class="form-control-file" name="ttd_image" accept="image/*">
                <small class="text-muted">Upload baru untuk mengganti.</small>
            </div>
            <a href="{{ route('pejabat-desa.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection