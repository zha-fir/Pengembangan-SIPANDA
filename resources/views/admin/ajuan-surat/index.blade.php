@extends('layouts.admin')
@section('title', 'Pengajuan Surat Masuk')
@section('content')

    {{-- Tampilkan Pesan Sukses/Error --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div> @endif

    {{-- Tampilkan Error Validasi (jika modal gagal) --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            Gagal memproses ajuan. Pastikan semua field terisi.
            <ul>
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengajuan (Status: BARU)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <th>Pemohon (NIK)</th>
                            <th>Jenis Surat</th>
                            <th>Keperluan</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ajuanList as $ajuan)
                            <tr>
                                <td class="align-middle">
                                    <i class="far fa-calendar-alt text-gray-400 mr-2"></i>
                                    {{ $ajuan->tanggal_ajuan }}
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-2">
                                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="font-weight-bold text-dark">{{ optional($ajuan->warga)->nama_lengkap ?? 'N/A' }}</span>
                                            <br>
                                            <small class="text-muted">NIK: {{ optional($ajuan->warga)->nik ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="font-weight-bold text-primary">{{ optional($ajuan->jenisSurat)->nama_surat ?? 'N/A' }}</span>
                                </td>
                                <td class="align-middle">{{ $ajuan->keperluan }}</td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center">
                                        {{-- Tombol Pemicu Modal Konfirmasi --}}
                                        <button type="button" class="btn btn-success btn-circle btn-sm mr-1" data-toggle="modal"
                                            data-target="#konfirmasiModal" data-id="{{ $ajuan->id_ajuan }}"
                                            data-nama="{{ optional($ajuan->warga)->nama_lengkap ?? '' }}"
                                            data-nik="{{ optional($ajuan->warga)->nik ?? '' }}"
                                            data-jenis-surat="{{ optional($ajuan->jenisSurat)->nama_surat ?? '' }}"
                                            data-keperluan="{{ $ajuan->keperluan }}" data-tambahan="{{ $ajuan->data_tambahan }}"
                                            title="Konfirmasi">
                                            <i class="fas fa-check"></i>
                                        </button>

                                        {{-- Tombol Pemicu Modal Tolak --}}
                                        <button type="button" class="btn btn-danger btn-circle btn-sm" data-toggle="modal"
                                            data-target="#tolakModal" data-id="{{ $ajuan->id_ajuan }}"
                                            title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-gray-500 mb-2"><i class="fas fa-inbox fa-2x"></i></div>
                                    <div>Belum ada ajuan surat baru.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="konfirmasiModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="formKonfirmasi" action="" method="POST"> {{-- Action diisi JS --}}
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Surat Keterangan</h5>
                        <button class="close" type="button" data-dismiss="modal"><span>×</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Anda akan mengonfirmasi ajuan surat untuk:</p>
                        <ul>
                            <li><strong>Nama:</strong> <span id="modalNama"></span></li>
                            <li><strong>NIK:</strong> <span id="modalNik"></span></li>
                            <li><strong>Jenis Surat:</strong> <span id="modalJenisSurat"></span></li>
                            <li><strong>Keperluan:</strong> <span id="modalKeperluan"></span></li>
                        </ul>

                        {{-- AREA BARU: DATA TAMBAHAN (Default disembunyikan) --}}
                        <div id="areaDataTambahan" class="alert alert-warning d-none">
                            <h6 class="font-weight-bold"><i class="fas fa-info-circle"></i> Data Input Warga:</h6>
                            <ul id="listDataTambahan" class="mb-0 pl-3">
                                {{-- List akan diisi otomatis oleh JavaScript --}}
                            </ul>
                        </div>

                        <hr>
                        <p>Silakan isi detail surat resmi di bawah ini:</p>
                        <div class="form-group">
                            <label for="nomor_surat">No. Surat (Resmi)</label>
                            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" required
                                placeholder="Contoh: PLB/2025/XI/123">
                        </div>
                        {{-- Dropdown Pejabat 1 (Yang sudah ada) --}}
                        <div class="form-group">
                            <label for="id_pejabat_desa">Pejabat Penandatangan 1 (Utama/Kanan)</label>
                            <select class="form-control" id="id_pejabat_desa" name="id_pejabat_desa" required>
                                <option value="">-- PILIH PEJABAT 1 --</option>
                                @foreach ($pejabatList as $pejabat)
                                    <option value="{{ $pejabat->id_pejabat_desa }}">
                                        {{ $pejabat->nama_pejabat }} ({{ $pejabat->jabatan }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Dropdown Pejabat 2 (BARU) --}}
                        <div class="form-group">
                            <label for="id_pejabat_desa_2">Pejabat Penandatangan 2 (Opsional/Kiri)</label>
                            <select class="form-control" id="id_pejabat_desa_2" name="id_pejabat_desa_2">
                                <option value="">-- KOSONGKAN JIKA TIDAK PERLU --</option>
                                @foreach ($pejabatList as $pejabat)
                                    <option value="{{ $pejabat->id_pejabat_desa }}">
                                        {{ $pejabat->nama_pejabat }} ({{ $pejabat->jabatan }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Biasanya untuk Kepala Dusun atau mengetahui Camat.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Konfirmasi & Simpan ke Arsip</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tolakModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formTolak" action="" method="POST"> {{-- Action diisi JS --}}
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tolak Ajuan Surat</h5>
                        <button class="close" type="button" data-dismiss="modal"><span>×</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Anda yakin ingin menolak ajuan ini? Berikan alasan penolakan (wajib).</p>
                        <div class="form-group">
                            <label for="catatan_penolakan">Alasan Penolakan</label>
                            <textarea class="form-control" name="catatan_penolakan" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Tolak Ajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Script untuk mengisi data-data ke Modal --}}
    <script>
        $(document).ready(function () {
            // Script untuk Modal Konfirmasi
            // Script untuk Modal Konfirmasi
            $('#konfirmasiModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var ajuanId = button.data('id');
                var nama = button.data('nama');
                var nik = button.data('nik');
                var keperluan = button.data('keperluan');
                var jenisSurat = button.data('jenis-surat');

                // AMBIL DATA TAMBAHAN (JSON)
                var dataTambahan = button.data('tambahan');

                var modal = $(this);
                var actionUrl = "{{ url('admin/ajuan-surat') }}/" + ajuanId + "/konfirmasi";

                modal.find('#formKonfirmasi').attr('action', actionUrl);
                modal.find('#modalNama').text(nama);
                modal.find('#modalNik').text(nik);
                modal.find('#modalKeperluan').text(keperluan);
                modal.find('#modalJenisSurat').text(jenisSurat);

                // --- LOGIKA MENAMPILKAN DATA TAMBAHAN ---
                var listArea = modal.find('#listDataTambahan');
                var container = modal.find('#areaDataTambahan');

                // Kosongkan list lama
                listArea.empty();

                if (dataTambahan) {
                    // Jika ada data tambahan, Munculkan kotaknya
                    container.removeClass('d-none');

                    // Loop setiap data (key: value)
                    $.each(dataTambahan, function (key, value) {
                        // Rapikan nama Key (misal: "bidang_usaha" jadi "Bidang Usaha")
                        var label = key.replace(/_/g, ' ').replace(/\b\w/g, function (l) { return l.toUpperCase() });

                        // Masukkan ke list
                        listArea.append('<li><strong>' + label + ':</strong> ' + value + '</li>');
                    });
                } else {
                    // Jika tidak ada data tambahan, sembunyikan kotaknya
                    container.addClass('d-none');
                }
            });

            // Script untuk Modal Tolak
            $('#tolakModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var ajuanId = button.data('id');
                var actionUrl = "{{ url('admin/ajuan-surat') }}/" + ajuanId + "/tolak";

                var modal = $(this);
                modal.find('#formTolak').attr('action', actionUrl);
            });
        });
    </script>
@endpush