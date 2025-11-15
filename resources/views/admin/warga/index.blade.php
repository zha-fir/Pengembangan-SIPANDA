@extends('layouts.admin')

@section('title', 'Manajemen Warga (Kependudukan)')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Warga</h6>
    </div>
    <div class="card-body">
        <a href="{{ route('warga.create') }}" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Tambah Data Warga
        </a>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>No. KK</th>
                        <th>Dusun</th>
                        <th>JK</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($wargaList as $warga)
                    <tr>
                        <td>{{ $warga->nik }}</td>
                        <td>{{ $warga->nama_lengkap }}</td>
                        <td>
                            {{-- Panggil relasi kk --}}
                            {{ $warga->kk->no_kk ?? 'Tidak ada KK' }}
                        </td>
                        <td>
                            {{-- Panggil relasi dusun melalui kk --}}
                            {{ $warga->kk->dusun->nama_dusun ?? 'N/A' }}
                        </td>
                        <td>{{ $warga->jenis_kelamin }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="#" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Data masih kosong.</td>
                    </tr>
                    {{-- INI PERBAIKANNYA --}}
                    @endforelse 
                </tbody>
            </table>
        </div>
    </div>
</div> {{-- PERBAIKAN KEDUA: '}' yang error sudah dihapus dari sini --}}
@endsection