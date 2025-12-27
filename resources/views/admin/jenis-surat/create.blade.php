@extends('layouts.modern')

@section('title', 'Tambah Jenis Surat')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Header -->
    <div>
        <a href="{{ route('jenis-surat.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 mb-2 transition-colors">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Template Surat</h1>
        <p class="text-slate-500 text-sm mt-1">Upload template baru untuk jenis surat ini.</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
        <form action="{{ route('jenis-surat.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            {{-- Validation Errors --}}
             @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 rounded-xl p-4 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Nama Surat -->
            <div>
                 <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Surat</label>
                <input type="text" name="nama_surat" value="{{ old('nama_surat') }}" class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400" required placeholder="Contoh: Surat Keterangan Usaha">
            </div>

            <!-- Kode Surat -->
             <div>
                 <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Surat (Opsional)</label>
                <input type="text" name="kode_surat" value="{{ old('kode_surat') }}" class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400" placeholder="Contoh: SKU">
                <p class="text-xs text-slate-500 mt-1">Digunakan untuk penomoran surat otomatis.</p>
            </div>

            <!-- File Template -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">File Template (.docx)</label>
                <div class="flex items-center justify-center w-full">
                    <label for="template_file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class="fas fa-cloud-upload-alt text-3xl text-slate-400 mb-2"></i>
                            <p class="mb-1 text-sm text-slate-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                            <p class="text-xs text-slate-500">File Microsoft Word (.docx) Maks 2MB</p>
                        </div>
                        <input id="template_file" name="template_file" type="file" class="hidden" accept=".docx" />
                    </label>
                </div>
                 <div id="file-name" class="hidden mt-2 text-sm text-emerald-600 font-medium flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> <span></span>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                 <a href="{{ route('jenis-surat.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 shadow-sm shadow-indigo-200 transition-colors">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const fileInput = document.getElementById('template_file');
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