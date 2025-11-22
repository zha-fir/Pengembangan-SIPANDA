@extends('layouts.kades')

@section('title', 'Monitoring Surat Masuk & Keluar')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-filter me-1"></i> Filter Data</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('kades.monitoring.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label>Pilih Dusun</label>
                        <select name="id_dusun" class="form-control">
                            <option value="">- Semua Dusun -</option>
                            @foreach($dusunList as $dusun)
                                <option value="{{ $dusun->id_dusun }}" {{ request('id_dusun') == $dusun->id_dusun ? 'selected' : '' }}>
                                    {{ $dusun->nama_dusun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Jenis Surat</label>
                        <select name="id_jenis_surat" class="form-control">
                            <option value="">- Semua Jenis -</option>
                            @foreach($jenisSuratList as $surat)
                                <option value="{{ $surat->id_jenis_surat }}" {{ request('id_jenis_surat') == $surat->id_jenis_surat ? 'selected' : '' }}>
                                    {{ $surat->nama_surat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">- Semua Status -</option>
                            <option value="BARU" {{ request('status') == 'BARU' ? 'selected' : '' }}>Baru (Proses)</option>
                            <option value="SELESAI" {{ request('status') == 'SELESAI' ? 'selected' : '' }}>Selesai</option>
                            <option value="DITOLAK" {{ request('status') == 'DITOLAK' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan</button>
                <a href="{{ route('kades.monitoring.index') }}" class="btn btn-secondary">Reset</a>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th>Tgl</th>
                            <th>Pemohon (Warga)</th>
                            <th>Dusun</th>
                            <th>Jenis Surat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ajuanList as $ajuan)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($ajuan->tanggal_ajuan)->isoFormat('D MMM Y') }}</td>
                                <td>
                                    <strong>{{ $ajuan->warga->nama_lengkap }}</strong><br>
                                    <small class="text-muted">{{ $ajuan->warga->nik }}</small>
                                </td>
                                <td>{{ $ajuan->warga->kk->dusun->nama_dusun ?? '-' }}</td>
                                <td>{{ $ajuan->jenisSurat->nama_surat ?? '-' }}</td>
                                <td>
                                    @if($ajuan->status == 'BARU')
                                        <span class="badge badge-warning">Proses</span>
                                    @elseif($ajuan->status == 'SELESAI')
                                        <span class="badge badge-success">Selesai</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- HANYA TOMBOL DETAIL --}}
                                    <a href="{{ route('kades.monitoring.show', $ajuan->id_ajuan) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $ajuanList->links() }}
            </div>
        </div>
    </div>
@endsection