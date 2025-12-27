@extends('layouts.modern')

@section('title', 'Tambah Pejabat Desa')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

     <!-- Header -->
    <div>
        <a href="{{ route('pejabat-desa.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 mb-2 transition-colors">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Pejabat Baru</h1>
        <p class="text-slate-500 text-sm mt-1">Isi formulir untuk menambahkan data pejabat desa.</p>
    </div>

    <form action="{{ route('pejabat-desa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Error Validation --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 rounded-xl p-4 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Identity Section -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                <i class="fas fa-user-circle text-indigo-500"></i> Identitas Pejabat
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                     <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap (dengan gelar)</label>
                    <input type="text" name="nama_pejabat" value="{{ old('nama_pejabat') }}" required
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400"
                           placeholder="Contoh: Budi Santoso, S.Kom">
                </div>

                <!-- Jabatan -->
                <div>
                     <label class="block text-sm font-semibold text-slate-700 mb-2">Jabatan</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan') }}" required
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400"
                           placeholder="Contoh: Kepala Dusun Mawar">
                </div>

                <!-- NIP -->
                <div>
                     <label class="block text-sm font-semibold text-slate-700 mb-2">NIP <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <input type="text" name="nip" id="nip" value="{{ old('nip') }}"
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400"
                           placeholder="Nomor Induk Pegawai">
                </div>

                <!-- Tanggal Lahir -->
                <div>
                     <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all text-slate-600">
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-slate-100">
                 <label class="block text-sm font-semibold text-slate-700 mb-2">Scan Tanda Tangan Digital <span class="text-red-500">*</span></label>
                 <div class="flex items-center gap-4">
                     <div class="flex-1">
                        <input type="file" name="ttd_image" accept="image/*"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all border border-slate-300 rounded-xl">
                     </div>
                 </div>
                 <p class="mt-2 text-xs text-slate-400">Format: JPG/PNG, Maks: 2MB. Usahakan background transparan untuk hasil terbaik di surat.</p>
            </div>
        </div>

        <!-- Account Section -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-sm">
             <div class="flex items-center gap-3 mb-6">
                <div class="flex items-center h-5">
                    <input id="buat_akun" name="buat_akun" type="checkbox" {{ old('buat_akun') ? 'checked' : '' }}
                           class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 transition-all">
                </div>
                 <label for="buat_akun" class="text-lg font-bold text-slate-800 cursor-pointer select-none">
                    Buat Akun Login
                </label>
            </div>

            <div id="form_akun" class="hidden space-y-6 pt-2 border-t border-slate-100 transition-all">
                 <p class="text-sm text-slate-500">Buat akun agar pejabat ini dapat login ke sistem.</p>
                
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Username -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}"
                               class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400"
                               placeholder="Contoh: kadus_mawar">
                        <p class="mt-1.5 text-xs text-slate-400">Password Default: <span class="font-mono bg-slate-100 px-1 rounded text-slate-600">123456</span></p>
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Hak Akses (Role)</label>
                        <div class="relative">
                            <select name="role_akun" id="role_akun" class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none appearance-none transition-all text-slate-700">
                                <option value="">-- Pilih Role --</option>
                                <option value="kades">Kepala Desa</option>
                                <option value="kadus">Kepala Dusun</option>
                                <option value="admin">Admin / Operator</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500"><i class="fas fa-chevron-down text-xs"></i></div>
                        </div>
                    </div>
                 </div>

                 <!-- Dusun Selection (Conditional) -->
                 <div id="area_dusun" class="hidden">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Wilayah Dusun <span class="text-red-500">(Wajib untuk Kadus)</span></label>
                    <div class="relative">
                         <select name="id_dusun_akun" class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none appearance-none transition-all text-slate-700">
                            <option value="">-- Pilih Dusun --</option>
                            @foreach($dusunList as $dusun)
                                <option value="{{ $dusun->id_dusun }}">{{ $dusun->nama_dusun }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500"><i class="fas fa-chevron-down text-xs"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 pt-4">
            <a href="{{ route('pejabat-desa.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 shadow-sm shadow-indigo-200 transition-colors">
                <i class="fas fa-save mr-2"></i> Simpan Data
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('buat_akun');
        const formAkun = document.getElementById('form_akun');
        const roleSelect = document.getElementById('role_akun');
        const areaDusun = document.getElementById('area_dusun');
        const nipInput = document.getElementById('nip');
        const usernameInput = document.getElementById('username');

        // Toggle Account Form
        function toggleAccountForm() {
            if (checkbox.checked) {
                formAkun.classList.remove('hidden');
                // Auto fill username from NIP
                if (nipInput.value && !usernameInput.value) {
                    usernameInput.value = nipInput.value;
                }
            } else {
                formAkun.classList.add('hidden');
            }
        }
        checkbox.addEventListener('change', toggleAccountForm);
        toggleAccountForm(); // Initial check

        // Toggle Dusun Dropdown
        function toggleDusun() {
            if (roleSelect.value === 'kadus') {
                areaDusun.classList.remove('hidden');
            } else {
                areaDusun.classList.add('hidden');
            }
        }
        roleSelect.addEventListener('change', toggleDusun);
        toggleDusun(); // Initial check
    });
</script>
@endpush
@endsection