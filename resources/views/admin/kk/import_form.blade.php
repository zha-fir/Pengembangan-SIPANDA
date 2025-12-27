@extends('layouts.modern')

@section('title', 'Import Data KK')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Header -->
    <div>
        <a href="{{ route('kk.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 mb-2 transition-colors">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Import Data KK dari Excel</h1>
        <p class="text-slate-500 text-sm mt-1">Upload file Excel untuk menambahkan banyak Kartu Keluarga sekaligus.</p>
    </div>

    <!-- Alert / Instructions -->
    <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-6">
        <h3 class="font-bold text-indigo-900 flex items-center gap-2 mb-3">
            <i class="fas fa-info-circle text-indigo-500"></i> Petunjuk & Format Excel
        </h3>
        <div class="text-sm text-indigo-800 space-y-3">
             <p>Pastikan file Excel Anda memiliki <strong>Header</strong> (baris pertama) dengan nama kolom berikut (huruf kecil semua):</p>
             <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 font-mono text-xs font-bold text-indigo-600">
                <span class="bg-white px-2 py-1 rounded border border-indigo-200">no_kk</span>
                <span class="bg-white px-2 py-1 rounded border border-indigo-200">nama_dusun</span>
                <span class="bg-white px-2 py-1 rounded border border-indigo-200">alamat</span>
                <span class="bg-white px-2 py-1 rounded border border-indigo-200">rt</span>
                <span class="bg-white px-2 py-1 rounded border border-indigo-200">rw</span>
             </div>
             <p class="mt-2 text-indigo-700 leading-relaxed">
                <strong>Catatan Penting:</strong> <br>
                1. <strong>nama_dusun</strong> harus SAMA PERSIS dengan data di sistem.<br>
                2. Tidak perlu kolom "Kepala Keluarga". Sistem akan mendeteksi otomatis nanti setelah Data Warga diimport.
             </p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
        
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-xl"></i>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <form action="{{ route('admin.kk.import.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih File Excel (.xlsx, .xls)</label>
                <div class="flex items-center justify-center w-full">
                    <label for="file_excel" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class="fas fa-file-excel text-3xl text-emerald-500 mb-2"></i>
                            <p class="mb-1 text-sm text-slate-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                            <p class="text-xs text-slate-500">Maksimal 2MB</p>
                        </div>
                        <input id="file_excel" name="file_excel" type="file" class="hidden" accept=".xlsx, .xls" required />
                    </label>
                </div>
                 <div id="file-name" class="hidden mt-2 text-sm text-emerald-600 font-medium flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> <span></span>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                 <a href="{{ route('kk.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 shadow-sm shadow-emerald-200 transition-colors">
                    <i class="fas fa-upload mr-2"></i> Upload & Import
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const fileInput = document.getElementById('file_excel');
    const fileNameDisplay = document.getElementById('file-name');
    const fileNameText = fileNameDisplay.querySelector('span');

    fileInput.addEventListener('change', function() {
        if(this.files && this.files[0]) {
            fileNameText.textContent = "File terpilih: " + this.files[0].name;
            fileNameDisplay.classList.remove('hidden');
        } else {
            fileNameDisplay.classList.add('hidden');
        }
    });
</script>
@endsection