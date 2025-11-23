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
            <a href="{{ route('admin.warga.import.form') }}" class="btn btn-success mb-3 ml-2">
                <i class="fas fa-file-excel"></i> Import Warga .XLS
            </a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    {{-- HEADER HARUS DI LUAR LOOP --}}
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>No. KK</th>
                            <th>Status Hubungan</th>
                            <th>Akun Login</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    {{-- BODY (ISI DATA) --}}
                    <tbody>
                        @forelse ($wargaList as $warga)
                            <tr>
                                <td>{{ $warga->nik }}</td>
                                <td>{{ $warga->nama_lengkap }}</td>
                                <td>
                                    {{ $warga->kk->no_kk ?? 'Tidak ada KK' }}
                                </td>
                                {{-- DATA STATUS HUBUNGAN (BARU) --}}
                                <td>
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
                                <td>
                                    @if($warga->user)
                                        <span class="badge badge-success">Ada</span>
                                    @else
                                        <span class="badge badge-secondary">Belum Ada</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- TOMBOL DETAIL (BARU) --}}
                                    <a href="{{ route('warga.show', $warga->id_warga) }}" class="btn btn-sm btn-info"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('warga.edit', $warga->id_warga) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('warga.destroy', $warga->id_warga) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga ini? Akun login yang terhubung (jika ada) juga akan dihapus permanen.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Data masih kosong.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div> {{-- PERBAIKAN KEDUA: '}' yang error sudah dihapus dari sini --}}
@endsection