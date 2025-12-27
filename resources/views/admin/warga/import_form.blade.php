@extends('layouts.modern')

@section('title', 'Import Data Warga')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Header -->
    <div>
        <a href="{{ route('warga.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 mb-2 transition-colors">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Import Data Warga dari Excel</h1>
        <p class="text-slate-500 text-sm mt-1">Upload file Excel untuk menambahkan banyak Data Penduduk sekaligus.</p>
    </div>

    <!-- Important Notice -->
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6">
        <div class="flex items-start gap-4">
            <div class="p-2 bg-amber-100 rounded-lg text-amber-600">
                <i class="fas fa-exclamation-triangle text-xl"></i>
            </div>
            <div>
                 <h3 class="font-bold text-amber-900 mb-1">Prasyarat Penting</h3>
                 <p class="text-sm text-amber-800 leading-relaxed">
                    Import Data Warga membutuhkan <strong>Nomor KK</strong> yang sudah terdaftar. 
                    <br>Pastikan Anda <strong>SUDAH</strong> menginput atau mengimport Data KK terlebih dahulu sebelum melakukan import warga ini.
                    Jika Nomor KK tidak ditemukan di sistem, data warga tersebut akan gagal diimport.
                 </p>
            </div>
        </div>
    </div>

    <!-- Instructions -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <i class="fas fa-file-excel text-emerald-600"></i> Format Kolom Excel
            </h3>
        </div>
        <div class="p-6">
             <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm text-slate-600">
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <span class="font-mono font-bold text-indigo-600">nik</span>
                        <span class="text-xs bg-slate-100 px-2 py-0.5 rounded">Wajib (16 Digit)</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <span class="font-mono font-bold text-indigo-600">nama_lengkap</span>
                        <span class="text-xs bg-slate-100 px-2 py-0.5 rounded">Wajib</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <span class="font-mono font-bold text-indigo-600">no_kk</span>
                        <span class="text-xs bg-slate-100 px-2 py-0.5 rounded">Wajib (Harus Ada)</span>
                    </div>
                     <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <span class="font-mono font-bold text-indigo-600">status_hubungan</span>
                        <span class="text-xs bg-slate-100 px-2 py-0.5 rounded">KEPALA KELUARGA/ISTRI...</span>
                    </div>
                </div>
                <div class="space-y-4">
                     <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <span class="font-mono font-bold text-indigo-600">jenis_kelamin</span>
                        <span class="text-xs bg-slate-100 px-2 py-0.5 rounded">LAKI-LAKI / PEREMPUAN</span>
                    </div>
                     <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <span class="font-mono font-bold text-indigo-600">tanggal_lahir</span>
                        <span class="text-xs bg-slate-100 px-2 py-0.5 rounded">Format: YYYY-MM-DD</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <span class="font-mono font-bold text-indigo-600">pekerjaan</span>
                        <span class="text-xs bg-slate-100 px-2 py-0.5 rounded">Opsional</span>
                    </div>
                </div>
             </div>
             <div class="mt-6 p-4 bg-emerald-50 rounded-xl border border-emerald-100 text-sm text-emerald-800 flex items-center gap-3">
                 <i class="fas fa-magic text-lg"></i>
                 <p>Akun login akan dibuat <strong>otomatis</strong> (Username: NIK, Pass: 123456).</p>
             </div>
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
         @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
                <i class="fas fa-check-circle text-xl"></i>
                <p>{{ session('success') }}</p>
            </div>
        @endif


        <form action="{{ route('admin.warga.import.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                 <a href="{{ route('warga.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
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