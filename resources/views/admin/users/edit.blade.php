@extends('layouts.modern')

@section('title', 'Edit Data Pengguna')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Header -->
    <div>
        <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 mb-2 transition-colors">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Data Pengguna</h1>
        <p class="text-slate-500 text-sm mt-1">Perbarui informasi akun pengguna.</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
        <form action="{{ route('users.update', $user->id_user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                     <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all" required>
                </div>
                <!-- Username -->
                <div>
                     <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all font-mono" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Password (Optional) -->
                <div>
                     <label class="block text-sm font-semibold text-slate-700 mb-2">Password Baru (Opsional)</label>
                     <div class="relative">
                        <input type="password" name="password" id="password" class="w-full pl-4 pr-10 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all" placeholder="Kosongkan jika tidak diganti">
                        <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                            <i class="fas fa-eye"></i>
                        </button>
                     </div>
                     <p class="text-xs text-slate-500 mt-1">Isi hanya jika ingin mengubah password.</p>
                </div>
                <!-- Role -->
                <div>
                     <label class="block text-sm font-semibold text-slate-700 mb-2">Role / Jabatan</label>
                     <div class="relative">
                        <select name="role" id="role" class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none appearance-none transition-all text-slate-700" required>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator / Operator</option>
                            <option value="kades" {{ $user->role == 'kades' ? 'selected' : '' }}>Kepala Desa</option>
                            <option value="kadus" {{ $user->role == 'kadus' ? 'selected' : '' }}>Kepala Dusun</option>
                            <option value="warga" {{ $user->role == 'warga' ? 'selected' : '' }}>Warga</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500"><i class="fas fa-chevron-down text-xs"></i></div>
                     </div>
                </div>
            </div>

            <!-- Area Dusun (Conditional) -->
             <div id="area_dusun" class="{{ $user->role == 'kadus' ? '' : 'hidden' }}">
                 <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Wilayah Dusun</label>
                 <div class="relative">
                    <select name="id_dusun" class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none appearance-none transition-all text-slate-700">
                        <option value="">-- Pilih Dusun --</option>
                        @foreach($dusunList as $dusun)
                            <option value="{{ $dusun->id_dusun }}" {{ $user->id_dusun == $dusun->id_dusun ? 'selected' : '' }}>
                                {{ $dusun->nama_dusun }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500"><i class="fas fa-chevron-down text-xs"></i></div>
                 </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                 <a href="{{ route('users.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 shadow-sm shadow-indigo-200 transition-colors">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }
    }

    const roleSelect = document.getElementById('role');
    const areaDusun = document.getElementById('area_dusun');

    if(roleSelect) {
        roleSelect.addEventListener('change', function() {
            if(this.value === 'kadus') {
                areaDusun.classList.remove('hidden');
            } else {
                areaDusun.classList.add('hidden');
            }
        });
    }
</script>
@endsection