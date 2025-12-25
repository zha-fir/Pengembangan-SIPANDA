@extends('layouts.admin')
@section('title', 'Manajemen Pejabat Desa')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pejabat Desa</h6>
    </div>
    <div class="card-body">
        <a href="{{ route('pejabat-desa.create') }}" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Tambah Pejabat</a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="5%" class="text-center">ID</th>
                        <th>Nama Pejabat</th>
                        <th>Jabatan</th>
                        <th class="text-center" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pejabatList as $item)
                    <tr>
                        <td class="align-middle text-center">{{ $item->id_pejabat_desa }}</td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <div class="mr-2">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                </div>
                                <span class="font-weight-bold text-dark">{{ $item->nama_pejabat }}</span>
                            </div>
                        </td>
                        <td class="align-middle">
                            <span class="badge badge-light border text-dark p-2">{{ $item->jabatan }}</span>
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('pejabat-desa.edit', $item->id_pejabat_desa) }}" class="btn btn-warning btn-circle btn-sm mr-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pejabat-desa.destroy', $item->id_pejabat_desa) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data pejabat ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-circle btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            <div class="text-gray-500">Data Pejabat Desa belum tersedia.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection