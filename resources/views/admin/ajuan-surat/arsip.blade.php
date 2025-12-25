@extends('layouts.admin')
@section('title', 'Arsip Surat Selesai & Ditolak')
@section('content')

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
@if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Arsip Surat</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center" width="15%">No. Surat</th>
                        <th>Pemohon (NIK)</th>
                        <th>Jenis Surat</th>
                        <th>Penandatangan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($arsipList as $arsip)
                    <tr>
                        <td class="align-middle text-center font-weight-bold">{{ $arsip->nomor_surat ?? '-' }}</td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <div class="mr-2">
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <div>
                                    <span class="font-weight-bold text-dark">{{ optional($arsip->warga)->nama_lengkap ?? 'N/A' }}</span>
                                    <br>
                                    <small class="text-muted">NIK: {{ optional($arsip->warga)->nik ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <i class="fas fa-file-alt text-primary mr-1"></i>
                            {{ optional($arsip->jenisSurat)->nama_surat ?? 'N/A' }}
                        </td>
                        <td class="align-middle">{{ optional($arsip->pejabatDesa)->nama_pejabat ?? '-' }}</td>
                        <td class="align-middle text-center">
                            @if($arsip->status == 'SELESAI')
                                <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i>SELESAI</span>
                            @else
                                <span class="badge badge-danger px-2 py-1"><i class="fas fa-times-circle mr-1"></i>DITOLAK</span>
                            @endif
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('ajuan-surat.detail', $arsip->id_ajuan) }}" class="btn btn-info btn-circle btn-sm mr-1" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- Hanya tampilkan tombol Cetak jika status SELESAI --}}
                                @if($arsip->status == 'SELESAI')
                                    <a href="{{ route('ajuan-surat.cetak', $arsip->id_ajuan) }}" class="btn btn-primary btn-circle btn-sm" target="_blank" title="Cetak Surat">
                                        <i class="fas fa-print"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-gray-500 mb-2"><i class="fas fa-archive fa-2x"></i></div>
                            <div>Belum ada surat di arsip.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- Pagination Links --}}
            <div class="mt-3">
                {{ $arsipList->links() }}
            </div>
        </div>
    </div>
</div>
@endsection