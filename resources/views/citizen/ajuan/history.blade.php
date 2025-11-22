@extends('layouts.citizen')

@section('title', 'Riwayat Status Ajuan Surat')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Tanggal</th>
                            <th>Jenis Surat</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayatAjuan as $ajuan)
                            <tr>
                                <td class="ps-4 text-muted small">
                                    {{ \Carbon\Carbon::parse($ajuan->tanggal_ajuan)->isoFormat('D MMM Y') }}
                                </td>
                                <td class="fw-bold text-dark">
                                    {{ $ajuan->jenisSurat->nama_surat ?? 'Jenis Surat Dihapus' }}
                                </td>
                                <td>
                                    @if($ajuan->status == 'BARU')
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-clock me-1"></i> Sedang Diproses
                                        </span>
                                    @elseif($ajuan->status == 'SELESAI')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i> Selesai
                                        </span>
                                    @elseif($ajuan->status == 'DITOLAK')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle me-1"></i> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($ajuan->status == 'SELESAI')
                                        <small class="text-success">
                                            <i class="fas fa-info-circle"></i> Silakan ambil di Kantor Desa.
                                        </small>
                                    @elseif($ajuan->status == 'DITOLAK')
                                        <small class="text-danger fw-bold">
                                            Alasan: {{ $ajuan->catatan_penolakan }}
                                        </small>
                                    @else
                                        <small class="text-muted">-</small>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block text-gray-300"></i>
                                    Belum ada riwayat pengajuan surat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection