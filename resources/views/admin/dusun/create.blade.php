@extends('layouts.modern')

@section('title', 'Tambah Data Dusun')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Header -->
    <div>
        <a href="{{ route('dusun.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 mb-2 transition-colors">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Dusun Baru</h1>
        <p class="text-slate-500 text-sm mt-1">Tambahkan wilayah administratif dusun baru.</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
        
        {{-- Error Validation --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 rounded-xl p-4 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dusun.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="nama_dusun" class="block text-sm font-semibold text-slate-700 mb-2">Nama Dusun</label>
                <input type="text" 
                       id="nama_dusun" 
                       name="nama_dusun" 
                       value="{{ old('nama_dusun') }}"
                       placeholder="Contoh: Dusun Melati"
                       class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all placeholder:text-slate-400"
                       required>
                <p class="mt-2 text-xs text-slate-400">Masukkan nama dusun tanpa singkatan jika memungkinkan.</p>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3">
                 <a href="{{ route('dusun.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 shadow-sm shadow-indigo-200 transition-colors">
                    <i class="fas fa-save mr-2"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection