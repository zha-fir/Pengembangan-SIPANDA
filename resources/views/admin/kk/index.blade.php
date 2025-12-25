@extends('layouts.admin')

@section('title', 'Manajemen Kartu Keluarga (KK)')

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
            <h6 class="m-0 font-weight-bold text-primary">Data Kartu Keluarga</h6>
        </div>
        <div class="card-body">

            {{-- BARIS TOMBOL & PENCARIAN --}}
            <div class="d-flex justify-content-between align-items-center mb-3">

                {{-- Kiri: Tombol Aksi --}}
                <div>
                    <a href="{{ route('kk.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah KK
                    </a>
                    <a href="{{ route('admin.kk.import.form') }}" class="btn btn-success ml-2">
                        <i class="fas fa-file-excel"></i> Import Excel
                    </a>
                </div>

                {{-- Kanan: Form Pencarian --}}
                <form action="{{ route('kk.index') }}" method="GET" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control bg-light border-0 small"
                            placeholder="Cari No. KK / Nama Kepala..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" onclick="this.form.submit()">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                            @if(request('search'))
                                <a href="{{ route('kk.index') }}" class="btn btn-secondary" title="Reset">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nomor KK</th>
                            <th>Kepala Keluarga</th>
                            <th>Dusun</th>
                            <th class="text-center" width="10%">RT / RW</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kkList as $kk)
                            <tr>
                                <td class="align-middle font-weight-bold">{{ $kk->no_kk }}</td>
                                <td class="align-middle">
                                    @if($kk->kepalaKeluarga)
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="font-weight-bold text-dark">{{ $kk->kepalaKeluarga->nama_lengkap }}</span>
                                                <br>
                                                <small class="text-muted">NIK: {{ $kk->kepalaKeluarga->nik }}</small>
                                            </div>
                                        </div>
                                    @else
                                        {{ $kk->nama_kepala_keluarga }} <span class="badge badge-danger ml-1">Data Belum Link</span>
                                    @endif
                                </td>
                                <td class="align-middle">{{ $kk->dusun->nama_dusun ?? '-' }}</td>
                                <td class="align-middle text-center">{{ $kk->rt }} / {{ $kk->rw }}</td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('kk.members', $kk->id_kk) }}" class="btn btn-info btn-circle btn-sm mr-1" title="Lihat Anggota">
                                            <i class="fas fa-users"></i>
                                        </a>

                                        <a href="{{ route('kk.edit', $kk->id_kk) }}" class="btn btn-warning btn-circle btn-sm mr-1" title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('kk.destroy', $kk->id_kk) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data KK ini? SEMUA warga yang terhubung juga akan terpengaruh.');">
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
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-gray-500">Data Kartu Keluarga belum tersedia.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- Pagination Links --}}
                <div class="mt-3">
                    {{ $kkList->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection