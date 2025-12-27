@extends('layouts.modern')

@section('title', 'Edit Pejabat Desa')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

     <!-- Header -->
    <div>
        <a href="{{ route('pejabat-desa.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 mb-2 transition-colors">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Data Pejabat</h1>
        <p class="text-slate-500 text-sm mt-1">Perbarui informasi pejabat desa.</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">

         <form action="{{ route('pejabat-desa.update', $pejabat->id_pejabat_desa) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                     <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_pejabat" value="{{ old('nama_pejabat', $pejabat->nama_pejabat) }}" required
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all">
                </div>

                <!-- Jabatan -->
                <div>
                     <label class="block text-sm font-semibold text-slate-700 mb-2">Jabatan</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan', $pejabat->jabatan) }}" required
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all">
                </div>

                <!-- NIP -->
                <div>
                     <label class="block text-sm font-semibold text-slate-700 mb-2">NIP</label>
                    <input type="text" name="nip" value="{{ old('nip', $pejabat->nip) }}"
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all">
                </div>

                <!-- Tanggal Lahir -->
                <div>
                     <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pejabat->tanggal_lahir) }}"
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all text-slate-600">
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100">
                <label class="block text-sm font-semibold text-slate-700 mb-4">Tanda Tangan Digital</label>
                
                <div class="flex flex-col md:flex-row gap-6 items-start">
                    <!-- Current Image -->
                    <div class="flex-shrink-0">
                         @if($pejabat->ttd_path)
                            <div class="p-2 border border-slate-200 rounded-xl bg-slate-50 inline-block">
                                <img src="{{ Storage::url($pejabat->ttd_path) }}" alt="TTD Saat Ini" class="h-24 w-auto object-contain">
                            </div>
                            <p class="text-xs text-emerald-600 font-medium mt-2 flex items-center gap-1"><i class="fas fa-check-circle"></i> Tanda tangan aktif</p>
                        @else
                            <div class="h-24 w-48 bg-slate-100 rounded-xl border border-slate-200 border-dashed flex items-center justify-center text-slate-400 text-sm">
                                Tidak ada TTD
                            </div>
                        @endif
                    </div>

                    <!-- Upload New -->
                    <div class="flex-1 w-full">
                        <input type="file" name="ttd_image" accept="image/*"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all border border-slate-300 rounded-xl">
                        <p class="mt-2 text-xs text-slate-400">Upload gambar baru jika ingin mengganti tanda tangan yang sudah ada. Biarkan kosong jika tidak ingin mengubah.</p>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4">
                 <a href="{{ route('pejabat-desa.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
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