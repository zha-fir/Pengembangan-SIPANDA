@extends('layouts.admin')
@section('title', 'Detail Ajuan Surat')
@section('content')

<a href="{{ route('ajuan-surat.arsip') }}" class="btn btn-secondary btn-sm mb-3">
    <i class="fas fa-arrow-left"></i> Kembali ke Arsip
</a>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Detail Ajuan #{{ $ajuan->id_ajuan }}</h6>
        @if($ajuan->status == 'SELESAI')
            <span class="badge badge-success">SELESAI</span>
        @else
            <span class="badge badge-danger">DITOLAK</span>
        @endif
    </div>
    <div class="card-body">

        {{-- Tampilkan Alasan Penolakan (jika DITOLAK) --}}
        @if($ajuan->status == 'DITOLAK')
        <div class="alert alert-danger">
            <strong>Alasan Penolakan:</strong><br>
            {{ $ajuan->catatan_penolakan }}
        </div>
        @endif

        <div class="row">
            {{-- Kolom Data Pemohon --}}
            <div class="col-md-6">
                <h5>Data Pemohon</h5>
                <table class="table table-sm table-borderless">
                    <tr>
                        <th style="width: 150px;">Nama Lengkap</th>
                        <td>: {{ optional($ajuan->warga)->nama_lengkap ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td>: {{ optional($ajuan->warga)->nik ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Tempat, Tgl Lahir</th>
                        <td>: {{ optional($ajuan->warga)->tempat_lahir ?? 'N/A' }}, {{ optional($ajuan->warga)->tanggal_lahir ? \Carbon\Carbon::parse($ajuan->warga->tanggal_lahir)->isoFormat('D MMMM Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>: {{ optional(optional($ajuan->warga)->kk)->alamat_kk ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>

            {{-- Kolom Data Surat --}}
            <div class="col-md-6">
                <h5>Data Surat</h5>
                <table class="table table-sm table-borderless">
                    <tr>
                        <th style="width: 150px;">Jenis Surat</th>
                        <td>: {{ optional($ajuan->jenisSurat)->nama_surat ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Keperluan</th>
                        <td>: {{ $ajuan->keperluan }}</td>
                    </tr>
                    <tr>
                        <th>No. Surat (Resmi)</th>
                        <td>: {{ $ajuan->nomor_surat ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Penandatangan</th>
                        <td>: {{ optional($ajuan->pejabatDesa)->nama_pejabat ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <td>: {{ optional($ajuan->pejabatDesa)->jabatan ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection