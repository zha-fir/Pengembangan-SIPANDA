@extends('layouts.modern')

@section('title', 'Edit Data Warga')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div>
        <a href="{{ route('warga.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 mb-2 transition-colors">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Data Penduduk</h1>
        <p class="text-slate-500 text-sm mt-1">Perbarui informasi data diri penduduk.</p>
    </div>

    <form action="{{ route('warga.update', $warga->id_warga) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

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

        <!-- Card: Identitas Utama -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-sm">
             <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2 pb-2 border-b border-slate-100">
                <i class="fas fa-id-card text-indigo-500"></i> Identitas Utama
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NIK -->
                <div>
                     <label for="nik" class="block text-sm font-semibold text-slate-700 mb-2">NIK (16 Digit)</label>
                    <input type="text" id="nik" name="nik" value="{{ old('nik', $warga->nik) }}" maxlength="16" required
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all font-mono placeholder:text-slate-400">
                </div>

                <!-- Nama -->
                <div>
                     <label for="nama_lengkap" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $warga->nama_lengkap) }}" required
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400">
                </div>

                <!-- KK -->
                <div class="md:col-span-2">
                     <label for="id_kk" class="block text-sm font-semibold text-slate-700 mb-2">Nomor Kartu Keluarga</label>
                     <div class="relative">
                        <select name="id_kk" id="id_kk" class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none appearance-none transition-all text-slate-700">
                            <option value="">-- Pilih Kartu Keluarga --</option>
                            @foreach ($kkList as $kk)
                                <option value="{{ $kk->id_kk }}" {{ old('id_kk', $warga->id_kk) == $kk->id_kk ? 'selected' : '' }}>
                                    {{ $kk->no_kk }} - {{ $kk->kepalaKeluarga->nama_lengkap ?? '(Belum Ada Kepala Keluarga)' }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500"><i class="fas fa-chevron-down text-xs"></i></div>
                     </div>
                </div>

                <!-- Status Keluarga -->
                <div>
                     <label for="status_dalam_keluarga" class="block text-sm font-semibold text-slate-700 mb-2">Status Hubungan</label>
                     <div class="relative">
                        <select name="status_dalam_keluarga" id="status_dalam_keluarga" class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none appearance-none transition-all text-slate-700">
                             <option value="FAMILI LAIN" {{ old('status_dalam_keluarga', $warga->status_dalam_keluarga) == 'FAMILI LAIN' ? 'selected' : '' }}>FAMILI LAIN</option>
                             <option value="KEPALA KELUARGA" {{ old('status_dalam_keluarga', $warga->status_dalam_keluarga) == 'KEPALA KELUARGA' ? 'selected' : '' }}>KEPALA KELUARGA</option>
                             <option value="ISTRI" {{ old('status_dalam_keluarga', $warga->status_dalam_keluarga) == 'ISTRI' ? 'selected' : '' }}>ISTRI</option>
                             <option value="ANAK" {{ old('status_dalam_keluarga', $warga->status_dalam_keluarga) == 'ANAK' ? 'selected' : '' }}>ANAK</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500"><i class="fas fa-chevron-down text-xs"></i></div>
                     </div>
                </div>
            </div>
        </div>

        <!-- Card: Data Pribadi -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-sm">
             <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2 pb-2 border-b border-slate-100">
                <i class="fas fa-user text-indigo-500"></i> Data Pribadi
            </h2>

             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- TTL -->
                <div>
                     <label for="tempat_lahir" class="block text-sm font-semibold text-slate-700 mb-2">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $warga->tempat_lahir) }}"
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all">
                </div>
                <div>
                     <label for="tanggal_lahir" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $warga->tanggal_lahir) }}"
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all text-slate-600">
                </div>

                <!-- JK -->
                 <div>
                     <label for="jenis_kelamin" class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin</label>
                     <div class="relative">
                        <select name="jenis_kelamin" id="jenis_kelamin" class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none appearance-none transition-all text-slate-700">
                             <option value="">-- Pilih --</option>
                             <option value="LAKI-LAKI" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'LAKI-LAKI' ? 'selected' : '' }}>LAKI-LAKI</option>
                             <option value="PEREMPUAN" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'PEREMPUAN' ? 'selected' : '' }}>PEREMPUAN</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500"><i class="fas fa-chevron-down text-xs"></i></div>
                     </div>
                </div>

                <!-- Agama -->
                 <div>
                     <label for="agama" class="block text-sm font-semibold text-slate-700 mb-2">Agama</label>
                     <div class="relative">
                        <select name="agama" id="agama" class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none appearance-none transition-all text-slate-700">
                             <option value="">-- Pilih Agama --</option>
                             @foreach(['ISLAM', 'KRISTEN', 'KATOLIK', 'HINDU', 'BUDHA', 'KONGHUCU'] as $agm)
                                <option value="{{ $agm }}" {{ old('agama', $warga->agama) == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                             @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500"><i class="fas fa-chevron-down text-xs"></i></div>
                     </div>
                </div>

                <!-- Status Kawin -->
                 <div>
                     <label for="status_perkawinan" class="block text-sm font-semibold text-slate-700 mb-2">Status Perkawinan</label>
                     <div class="relative">
                        <select name="status_perkawinan" id="status_perkawinan" class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none appearance-none transition-all text-slate-700">
                             <option value="">-- Pilih Status --</option>
                             @foreach(['BELUM KAWIN', 'KAWIN', 'CERAI HIDUP', 'CERAI MATI'] as $stts)
                                <option value="{{ $stts }}" {{ old('status_perkawinan', $warga->status_perkawinan) == $stts ? 'selected' : '' }}>{{ $stts }}</option>
                             @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500"><i class="fas fa-chevron-down text-xs"></i></div>
                     </div>
                </div>

                <!-- Pekerjaan -->
                <div>
                     <label for="pekerjaan" class="block text-sm font-semibold text-slate-700 mb-2">Pekerjaan</label>
                    <input type="text" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $warga->pekerjaan) }}"
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all">
                </div>

                 <!-- WN -->
                 <div>
                     <label for="kewarganegaraan" class="block text-sm font-semibold text-slate-700 mb-2">Kewarganegaraan</label>
                     <div class="relative">
                        <select name="kewarganegaraan" id="kewarganegaraan" class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none appearance-none transition-all text-slate-700">
                             <option value="WNI" {{ old('kewarganegaraan', $warga->kewarganegaraan) == 'WNI' ? 'selected' : '' }}>WNI (Warga Negara Indonesia)</option>
                             <option value="WNA" {{ old('kewarganegaraan', $warga->kewarganegaraan) == 'WNA' ? 'selected' : '' }}>WNA (Warga Negara Asing)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500"><i class="fas fa-chevron-down text-xs"></i></div>
                     </div>
                </div>
            </div>
        </div>

         <!-- Account Login Check -->
        <div class="bg-indigo-50 rounded-2xl border border-indigo-100 p-6 shadow-sm">
             @if($warga->user)
                 <div class="flex items-start gap-4">
                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-indigo-900 mb-1">Pengaturan Akun</h3>
                        <p class="text-sm text-indigo-700 mb-3">
                             User ini sudah memiliki akun dengan username: <span class="font-mono bg-white/50 px-1 rounded font-bold">{{ $warga->user->username }}</span>
                        </p>
                        
                         <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="reset_password" id="reset_password" class="w-4 h-4 text-indigo-600 rounded focus:ring-indigo-500 border-indigo-300">
                            <span class="text-sm font-semibold text-indigo-800">Reset Password (kembali ke "123456")</span>
                        </label>
                    </div>
                 </div>
            @else
                 <div class="flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-indigo-400"></i>
                    <p class="text-sm text-indigo-500 italic">User ini belum memiliki akun login. Sistem akan otomatis membuakan akun baru jika data ini disimpan (jika belum ada).</p>
                 </div>
            @endif
        </div>

        <!-- Buttons -->
        <div class="flex items-center justify-end gap-3 pt-4">
             <a href="{{ route('warga.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 shadow-sm shadow-indigo-200 transition-colors">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>

    </form>
</div>
@endsection