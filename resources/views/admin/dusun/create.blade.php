@extends('layouts.admin')

@section('title', 'Tambah Data Dusun')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Dusun</h6>
    </div>
    <div class="card-body">
        
        {{-- Menampilkan error validasi (jika ada) --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form akan dikirim ke 'dusun.store' (fungsi store() di Controller) --}}
        <form action="{{ route('dusun.store') }}" method="POST">
            @csrf <div class="form-group">
                <label for="nama_dusun">Nama Dusun</label>
                <input type="text" 
                       class="form-control" 
                       id="nama_dusun" 
                       name="nama_dusun" 
                       placeholder="Contoh: Dusun Melati"
                       value="{{ old('nama_dusun') }}">
            </div>
            
            <a href="{{ route('dusun.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection