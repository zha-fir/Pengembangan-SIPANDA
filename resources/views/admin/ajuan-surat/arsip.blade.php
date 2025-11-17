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
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>No. Surat</th>
                        <th>Pemohon (NIK)</th>
                        <th>Jenis Surat</th>
                        <th>Penandatangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($arsipList as $arsip)
                    <tr>
                        <td>{{ $arsip->nomor_surat ?? 'N/A' }}</td>
                        <td>
                            {{ $arsip->warga->nama_lengkap ?? 'N/A' }}
                            <br><small>NIK: {{ $arsip->warga->nik ?? 'N/A' }}</small>
                        </td>
                        <td>{{ $arsip->jenisSurat->nama_surat ?? 'N/A' }}</td>
                        <td>{{ $arsip->pejabatDesa->nama_pejabat ?? 'N/A' }}</td> {{-- Ganti ke pejabatDesa --}}
                        <td>
                            @if($arsip->status == 'SELESAI')
                                <span class="badge badge-success">SELESAI</span>
                            @else
                                <span class="badge badge-danger">DITOLAK</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('ajuan-surat.detail', $arsip->id_ajuan) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Detail
                            </a>

                            {{-- Hanya tampilkan tombol Cetak jika status SELESAI --}}
                            @if($arsip->status == 'SELESAI')
                                <a href="{{ route('ajuan-surat.cetak', $arsip->id_ajuan) }}" class="btn btn-sm btn-primary" target="_blank">
                                    <i class="fas fa-print"></i> Cetak Word
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Belum ada surat di arsip.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection