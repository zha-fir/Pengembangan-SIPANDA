@extends('layouts.admin')

@section('title', 'Manajemen Data Penduduk')

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
            <h6 class="m-0 font-weight-bold text-primary">Data Penduduk</h6>
        </div>
        <div class="card-body">

            {{-- BARIS TOMBOL & PENCARIAN --}}
            <div class="d-flex justify-content-between align-items-center mb-3">

                {{-- Kiri: Tombol Aksi --}}
                <div>
                    <a href="{{ route('warga.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Penduduk
                    </a>
                    <a href="{{ route('admin.warga.import.form') }}" class="btn btn-success ml-2">
                        <i class="fas fa-file-excel"></i> Import Excel
                    </a>
                </div>

                {{-- Kanan: Form Pencarian --}}
                <form action="{{ route('warga.index') }}" method="GET" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control bg-light border-0 small"
                            placeholder="Cari NIK atau Nama..." aria-label="Search" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" onclick="this.form.submit()">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                            @if(request('search'))
                                <a href="{{ route('warga.index') }}" class="btn btn-secondary" title="Reset">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">

                    {{-- HEADER HARUS DI LUAR LOOP --}}
                    <thead class="thead-light">
                        <tr>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>No. KK</th>
                            <th class="text-center">Status Hubungan</th>
                            <th class="text-center">Akun Login</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>

                    {{-- BODY (ISI DATA) --}}
                    <tbody>
                        @forelse ($wargaList as $warga)
                            <tr>
                                <td class="align-middle font-weight-bold">{{ $warga->nik }}</td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-2">
                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="font-weight-bold text-dark">{{ $warga->nama_lengkap }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    {{ $warga->kk->no_kk ?? '-' }}
                                </td>
                                {{-- DATA STATUS HUBUNGAN (BARU) --}}
                                <td class="align-middle text-center">
                                    @if($warga->status_dalam_keluarga == 'KEPALA KELUARGA')
                                        <span class="badge badge-primary" style="font-size: 0.9em;">KEPALA KELUARGA</span>
                                    @elseif($warga->status_dalam_keluarga == 'ISTRI')
                                        <span class="badge badge-info">ISTRI</span>
                                    @elseif($warga->status_dalam_keluarga == 'ANAK')
                                        <span class="badge badge-secondary">ANAK</span>
                                    @else
                                        <span class="badge badge-light text-dark border">{{ $warga->status_dalam_keluarga }}</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    @if($warga->user)
                                        <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i>Ada</span>
                                    @else
                                        <span class="badge badge-secondary px-2 py-1">Belum Ada</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center">
                                        {{-- TOMBOL DETAIL (BARU) --}}
                                        <a href="{{ route('warga.show', $warga->id_warga) }}" class="btn btn-info btn-circle btn-sm mr-1"
                                            title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('warga.edit', $warga->id_warga) }}" class="btn btn-warning btn-circle btn-sm mr-1" title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('warga.destroy', $warga->id_warga) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga ini? Akun login yang terhubung (jika ada) juga akan dihapus permanen.');">
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
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-gray-500">Data Penduduk belum tersedia.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
                <div class="mt-3">
                    {{ $wargaList->links() }}
                </div>
            </div>
        </div>
    </div> {{-- PERBAIKAN KEDUA: '}' yang error sudah dihapus dari sini --}}
@endsection