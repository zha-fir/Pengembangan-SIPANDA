@extends('layouts.modern')

@section('title', 'Edit Data KK')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Header -->
    <div>
        <a href="{{ route('kk.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 mb-2 transition-colors">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Kartu Keluarga</h1>
        <p class="text-slate-500 text-sm mt-1">Perbarui data Nomor Kartu Keluarga dan alamat.</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
        
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 rounded-xl p-4 text-sm mb-6">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kk.update', $kk->id_kk) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- No KK -->
            <div>
                 <label for="no_kk" class="block text-sm font-semibold text-slate-700 mb-2">Nomor KK (16 Digit)</label>
                <div class="relative">
                    <input type="text" id="no_kk" name="no_kk" value="{{ old('no_kk', $kk->no_kk) }}" maxlength="16" required
                           class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all font-mono placeholder:text-slate-400">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-id-card"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Dusun -->
                <div class="md:col-span-1">
                     <label for="id_dusun" class="block text-sm font-semibold text-slate-700 mb-2">Wilayah Dusun</label>
                     <div class="relative">
                        <select name="id_dusun" id="id_dusun" required
                                class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none appearance-none transition-all text-slate-700">
                             <option value="">-- Pilih Dusun --</option>
                             @foreach ($dusunList as $dusun)
                                <option value="{{ $dusun->id_dusun }}" {{ old('id_dusun', $kk->id_dusun) == $dusun->id_dusun ? 'selected' : '' }}>
                                    {{ $dusun->nama_dusun }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500"><i class="fas fa-chevron-down text-xs"></i></div>
                     </div>
                </div>

                <!-- RT -->
                <div>
                     <label for="rt" class="block text-sm font-semibold text-slate-700 mb-2">RT</label>
                    <input type="number" id="rt" name="rt" value="{{ old('rt', $kk->rt) }}" required
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400">
                </div>

                <!-- RW -->
                <div>
                     <label for="rw" class="block text-sm font-semibold text-slate-700 mb-2">RW</label>
                    <input type="number" id="rw" name="rw" value="{{ old('rw', $kk->rw) }}" required
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400">
                </div>
            </div>

             <!-- Alamat -->
            <div>
                 <label for="alamat_kk" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap</label>
                <textarea id="alamat_kk" name="alamat_kk" rows="3" required
                          class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400">{{ old('alamat_kk', $kk->alamat_kk) }}</textarea>
            </div>

             <!-- Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                 <a href="{{ route('kk.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 shadow-sm shadow-indigo-200 transition-colors">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection