{{-- Mewarisi template admin SBAdmin2 --}}
@extends('layouts.admin')

{{-- Mengisi title --}}
@section('title', 'Manajemen Data Dusun')

{{-- Mengisi konten --}}
@section('content')

{{-- Menampilkan pesan sukses (jika ada setelah proses 'store') --}}
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
        <h6 class="m-0 font-weight-bold text-primary">Data Dusun</h6>
    </div>
    <div class="card-body">
        <a href="{{ route('dusun.create') }}" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Tambah Data Dusun
        </a>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="10%" class="text-center">ID</th>
                        <th>Nama Dusun</th>
                        <th class="text-center" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop data dusunList dari Controller --}}
                    @forelse ($dusunList as $dusun)
                    <tr>
                        <td class="align-middle text-center">{{ $dusun->id_dusun }}</td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <div class="mr-2">
                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                </div>
                                <span class="font-weight-bold text-dark">{{ $dusun->nama_dusun }}</span>
                            </div>
                        </td>

                        {{-- Tombol Aksi --}}
                        <td class="align-middle text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('dusun.edit', $dusun->id_dusun) }}" class="btn btn-warning btn-circle btn-sm mr-1" title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('dusun.destroy', $dusun->id_dusun) }}" method="POST" 
                                    class="d-inline" 
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-circle btn-sm" title="Hapus Data">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">
                            <div class="text-gray-500">Data Dusun belum tersedia.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
</div>
@endsection