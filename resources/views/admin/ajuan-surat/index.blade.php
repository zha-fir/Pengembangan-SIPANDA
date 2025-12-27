@extends('layouts.modern')

@section('title', 'Pengajuan Surat Masuk')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Pengajuan Masuk</h1>
            <p class="text-slate-500 text-sm mt-1">Daftar permohonan surat yang perlu ditindaklanjuti.</p>
        </div>
         <div>
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl text-sm font-bold border border-indigo-100">
                <i class="fas fa-inbox"></i> {{ $ajuanList->count() }} Permohonan Baru
            </span>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-3">
             <i class="fas fa-check-circle text-xl"></i>
             <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3">
             <i class="fas fa-exclamation-circle text-xl"></i>
             <p class="font-medium">{{ session('error') }}</p>
        </div>
    @endif
     @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
             <p class="font-bold mb-1">Gagal memproses ajuan:</p>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <!-- Table Content -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                 <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-xs border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-bold">Tanggal</th>
                        <th class="px-6 py-4 font-bold">Pemohon</th>
                        <th class="px-6 py-4 font-bold">Jenis Surat</th>
                        <th class="px-6 py-4 font-bold">Keperluan</th>
                        <th class="px-6 py-4 font-bold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($ajuanList as $ajuan)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-slate-500 font-mono">
                            <div class="flex items-center gap-2">
                                <i class="far fa-calendar-alt"></i> {{ $ajuan->tanggal_ajuan }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 border border-indigo-100">
                                    <i class="fas fa-user text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">{{ optional($ajuan->warga)->nama_lengkap ?? 'N/A' }}</p>
                                    <p class="text-xs text-slate-500 font-mono">{{ optional($ajuan->warga)->nik ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-indigo-700">{{ optional($ajuan->jenisSurat)->nama_surat ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4">
                             <p class="truncate max-w-[200px]" title="{{ $ajuan->keperluan }}">{{ $ajuan->keperluan }}</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" 
                                    class="open-confirm-modal p-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 rounded-lg transition-colors"
                                    data-id="{{ $ajuan->id_ajuan }}"
                                    data-nama="{{ optional($ajuan->warga)->nama_lengkap ?? '' }}"
                                    data-nik="{{ optional($ajuan->warga)->nik ?? '' }}"
                                    data-jenis-surat="{{ optional($ajuan->jenisSurat)->nama_surat ?? '' }}"
                                    data-keperluan="{{ $ajuan->keperluan }}"
                                    data-tambahan="{{ $ajuan->data_tambahan }}"
                                    title="Setujui">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button type="button" 
                                    class="open-reject-modal p-2 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg transition-colors"
                                    data-id="{{ $ajuan->id_ajuan }}"
                                    title="Tolak">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                             <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-inbox text-4xl mb-3 opacity-20"></i>
                                <p>Tidak ada pengajuan surat baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View -->
        <div class="md:hidden divide-y divide-slate-100">
             @forelse ($ajuanList as $ajuan)
             <div class="p-4 space-y-3">
                <div class="flex justify-between items-start">
                     <div class="flex items-center gap-3">
                         <div class="h-10 w-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 border border-indigo-100">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm">{{ optional($ajuan->warga)->nama_lengkap ?? 'N/A' }}</h3>
                            <p class="text-xs text-slate-500 font-mono">{{ optional($ajuan->warga)->nik ?? 'N/A' }}</p>
                        </div>
                    </div>
                     <span class="text-xs font-mono text-slate-400">{{ $ajuan->tanggal_ajuan }}</span>
                </div>
                
                 <div class="bg-indigo-50 p-3 rounded-lg text-sm space-y-2 border border-indigo-100">
                     <div class="flex flex-col">
                        <span class="text-xs text-indigo-400 font-bold uppercase">Jenis Surat</span>
                        <span class="text-indigo-800 font-medium">{{ optional($ajuan->jenisSurat)->nama_surat ?? 'N/A' }}</span>
                    </div>
                     <div class="flex flex-col pt-2 border-t border-indigo-100">
                        <span class="text-xs text-indigo-400 font-bold uppercase">Keperluan</span>
                        <span class="text-indigo-800">{{ $ajuan->keperluan }}</span>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-50">
                     <button type="button" 
                        class="open-reject-modal flex-1 py-2 bg-rose-50 text-rose-700 text-center rounded-lg text-sm font-medium hover:bg-rose-100"
                        data-id="{{ $ajuan->id_ajuan }}">
                        Tolak
                    </button>
                    <button type="button" 
                        class="open-confirm-modal flex-1 py-2 bg-emerald-50 text-emerald-700 text-center rounded-lg text-sm font-medium hover:bg-emerald-100"
                        data-id="{{ $ajuan->id_ajuan }}"
                        data-nama="{{ optional($ajuan->warga)->nama_lengkap ?? '' }}"
                        data-nik="{{ optional($ajuan->warga)->nik ?? '' }}"
                        data-jenis-surat="{{ optional($ajuan->jenisSurat)->nama_surat ?? '' }}"
                        data-keperluan="{{ $ajuan->keperluan }}"
                        data-tambahan="{{ $ajuan->data_tambahan }}">
                        Setujui
                    </button>
                </div>
             </div>
             @empty
             <div class="p-8 text-center text-slate-400">
                 <p>Tidak ada pengajuan surat baru.</p>
             </div>
             @endforelse
        </div>
    </div>
</div>

<!-- Modal Konfirmasi (Approval) -->
<div id="konfirmasiModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal('konfirmasiModal')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <form id="formKonfirmasi" action="" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                     <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-check text-emerald-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-slate-900" id="modal-title">Konfirmasi Surat</h3>
                            
                            <div class="mt-4 bg-slate-50 rounded-xl p-4 text-sm text-slate-600 space-y-1">
                                <p><span class="font-bold w-24 inline-block">Nama:</span> <span id="modalNama"></span></p>
                                <p><span class="font-bold w-24 inline-block">NIK:</span> <span id="modalNik"></span></p>
                                <p><span class="font-bold w-24 inline-block">Jenis:</span> <span id="modalJenisSurat"></span></p>
                            </div>

                             <!-- Data Tambahan -->
                            <div id="areaDataTambahan" class="hidden mt-3 bg-amber-50 border border-amber-100 rounded-xl p-3 text-sm">
                                <h6 class="font-bold text-amber-800 mb-2 flex items-center gap-1"><i class="fas fa-info-circle"></i> Input Tambahan Warga:</h6>
                                <ul id="listDataTambahan" class="list-disc list-inside text-amber-900 pl-1 space-y-1"></ul>
                            </div>

                            <div class="mt-6 space-y-4">
                                <div>
                                    <label for="nomor_surat" class="block text-sm font-bold text-slate-700 mb-1">No. Surat (Resmi)</label>
                                    <input type="text" name="nomor_surat" id="nomor_surat" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="Contoh: PLB/2025/XI/123" required>
                                </div>
                                <div>
                                    <label for="id_pejabat_desa" class="block text-sm font-bold text-slate-700 mb-1">Pejabat Penandatangan 1</label>
                                    <select name="id_pejabat_desa" id="id_pejabat_desa" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" required>
                                        <option value="">-- Pilih Pejabat --</option>
                                        @foreach ($pejabatList as $pejabat)
                                            <option value="{{ $pejabat->id_pejabat_desa }}">
                                                {{ $pejabat->nama_pejabat }} ({{ $pejabat->jabatan }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="id_pejabat_desa_2" class="block text-sm font-bold text-slate-700 mb-1">Pejabat Penandatangan 2 (Opsional)</label>
                                    <select name="id_pejabat_desa_2" id="id_pejabat_desa_2" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                                        <option value="">-- Kosongkan jika tidak perlu --</option>
                                        @foreach ($pejabatList as $pejabat)
                                            <option value="{{ $pejabat->id_pejabat_desa }}">
                                                {{ $pejabat->nama_pejabat }} ({{ $pejabat->jabatan }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Konfirmasi & Simpan
                    </button>
                    <button type="button" onclick="closeModal('konfirmasiModal')" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tolak (Reject) -->
<div id="tolakModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal('tolakModal')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <form id="formTolak" action="" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                     <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle text-rose-600"></i>
                        </div>
                         <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-slate-900" id="modal-title">Tolak Pengajuan</h3>
                            <div class="mt-2">
                                <p class="text-sm text-slate-500">
                                    Apakah Anda yakin ingin menolak pengajuan ini? Mohon berikan alasan penolakan agar warga dapat memperbaikinya.
                                </p>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-bold text-slate-700 mb-1">Alasan Penolakan</label>
                                <textarea name="catatan_penolakan" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none" required placeholder="Contoh: Data kurang lengkap..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-rose-600 text-base font-medium text-white hover:bg-rose-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Tolak Pengajuan
                    </button>
                    <button type="button" onclick="closeModal('tolakModal')" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Handle Open Confirm Modal
        const confirmButtons = document.querySelectorAll('.open-confirm-modal');
        confirmButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const nama = this.dataset.nama;
                const nik = this.dataset.nik;
                const jenisSurat = this.dataset.jenisSurat;
                const dataTambahan = JSON.parse(this.dataset.tambahan || '{}');

                // Set Action URL
                document.getElementById('formKonfirmasi').action = "{{ url('admin/ajuan-surat') }}/" + id + "/konfirmasi";

                // Set modal data
                document.getElementById('modalNama').textContent = nama;
                document.getElementById('modalNik').textContent = nik;
                document.getElementById('modalJenisSurat').textContent = jenisSurat;

                // Handle Data Tambahan
                const areaTambahan = document.getElementById('areaDataTambahan');
                const listTambahan = document.getElementById('listDataTambahan');
                listTambahan.innerHTML = '';

                if (Object.keys(dataTambahan).length > 0) {
                    areaTambahan.classList.remove('hidden');
                    for (const [key, value] of Object.entries(dataTambahan)) {
                        // Format key text (e.g. bidang_usaha -> Bidang Usaha)
                        const label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                        const li = document.createElement('li');
                        li.innerHTML = `<strong>${label}:</strong> ${value}`;
                        listTambahan.appendChild(li);
                    }
                } else {
                    areaTambahan.classList.add('hidden');
                }

                openModal('konfirmasiModal');
            });
        });

        // Handle Open Reject Modal
        const rejectButtons = document.querySelectorAll('.open-reject-modal');
        rejectButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                document.getElementById('formTolak').action = "{{ url('admin/ajuan-surat') }}/" + id + "/tolak";
                openModal('tolakModal');
            });
        });
    });
</script>
@endsection