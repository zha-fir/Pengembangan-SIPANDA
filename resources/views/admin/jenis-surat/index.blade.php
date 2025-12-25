@extends('layouts.admin')

@section('title', 'Manajemen Data Surat')

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
        <h6 class="m-0 font-weight-bold text-primary">Data Surat</h6>
    </div>
    <div class="card-body">
        <a href="{{ route('jenis-surat.create') }}" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Tambah Data Surat
        </a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>Nama Surat</th>
                        <th class="text-center" width="15%">Kode Surat</th>
                        <th>File Template</th>
                        <th class="text-center" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suratList as $surat)
                    <tr>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <div class="mr-2">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                </div>
                                <span class="font-weight-bold text-dark">{{ $surat->nama_surat }}</span>
                            </div>
                        </td>
                        <td class="align-middle text-center">
                            <span class="badge badge-secondary px-2 py-1">{{ $surat->kode_surat }}</span>
                        </td>
                        <td class="align-middle">
                            @if($surat->template_file)
                                <div class="text-muted small">
                                    <i class="fas fa-paperclip mr-1"></i> {{ $surat->template_file }}
                                </div>
                            @else
                                <span class="text-danger small">Tidak ada file</span>
                            @endif
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('jenis-surat.edit', $surat->id_jenis_surat) }}" class="btn btn-warning btn-circle btn-sm mr-1" title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('jenis-surat.destroy', $surat->id_jenis_surat) }}" method="POST" 
                                    class="d-inline" 
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus template surat ini?');">
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
                        <td colspan="4" class="text-center py-4">
                            <div class="text-gray-500">Data Jenis Surat belum tersedia.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection