@extends('layouts.kades')

@section('title', 'Detail Surat')

@section('content')
<a href="{{ route('kades.monitoring.index') }}" class="btn btn-secondary btn-sm mb-3">
    <i class="fas fa-arrow-left"></i> Kembali
</a>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Detail Ajuan #{{ $ajuan->id_ajuan }}</h6>
        @if($ajuan->status == 'SELESAI')
            <span class="badge badge-success p-2">STATUS: SELESAI</span>
        @elseif($ajuan->status == 'DITOLAK')
            <span class="badge badge-danger p-2">STATUS: DITOLAK</span>
        @else
            <span class="badge badge-warning p-2">STATUS: BARU (BELUM DIPROSES)</span>
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 border-right">
                <h5 class="font-weight-bold mb-3">Data Pemohon</h5>
                <table class="table table-borderless table-sm">
                    <tr><td width="130">Nama</td><td>: {{ $ajuan->warga->nama_lengkap }}</td></tr>
                    <tr><td>NIK</td><td>: {{ $ajuan->warga->nik }}</td></tr>
                    <tr><td>TTL</td><td>: {{ $ajuan->warga->tempat_lahir }}, {{ $ajuan->warga->tanggal_lahir }}</td></tr>
                    <tr><td>Alamat</td><td>: {{ $ajuan->warga->kk->alamat_kk ?? '-' }}</td></tr>
                    <tr><td>Dusun</td><td>: {{ $ajuan->warga->kk->dusun->nama_dusun ?? '-' }}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <h5 class="font-weight-bold mb-3">Data Surat</h5>
                <table class="table table-borderless table-sm">
                    <tr><td width="130">Jenis Surat</td><td>: {{ $ajuan->jenisSurat->nama_surat }}</td></tr>
                    <tr><td>Keperluan</td><td>: {{ $ajuan->keperluan }}</td></tr>
                    <tr><td>Tgl Ajuan</td><td>: {{ $ajuan->tanggal_ajuan }}</td></tr>

                    @if($ajuan->status == 'SELESAI')
                        <tr><td class="text-success font-weight-bold">No. Surat</td><td class="text-success font-weight-bold">: {{ $ajuan->nomor_surat }}</td></tr>
                        <tr><td>TTD 1</td><td>: {{ $ajuan->pejabatDesa->nama_pejabat ?? '-' }}</td></tr>
                        <tr><td>TTD 2</td><td>: {{ $ajuan->pejabatDesa2->nama_pejabat ?? '-' }}</td></tr>
                    @endif

                    @if($ajuan->status == 'DITOLAK')
                        <tr><td class="text-danger font-weight-bold">Alasan Tolak</td><td class="text-danger font-weight-bold">: {{ $ajuan->catatan_penolakan }}</td></tr>
                    @endif
                </table>

                {{-- Tampilkan Data Tambahan (JSON) jika ada --}}
                @if($ajuan->data_tambahan)
                    <hr>
                    <h6 class="font-weight-bold">Data Tambahan:</h6>
                    <ul>
                    @foreach(json_decode($ajuan->data_tambahan, true) as $key => $value)
                        <li><strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</li>
                    @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection