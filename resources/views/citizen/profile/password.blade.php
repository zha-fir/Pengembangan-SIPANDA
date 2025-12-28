@extends('layouts.citizen')

@section('title', 'Ubah Password')

@section('content')

    <div class="max-w-xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 md:p-8">

                 @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-600 text-sm flex items-start gap-3">
                        <i class="fas fa-exclamation-circle mt-0.5"></i>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('warga.password.update') }}" method="POST">
                    @csrf

                    {{-- 1. Password Lama --}}
                    <div class="mb-6">
                        <label for="current_password" class="block text-sm font-bold text-slate-700 mb-2">Password Lama</label>
                        <div class="relative">
                            <input type="password" id="current_password" name="current_password" required
                                class="w-full pl-4 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all placeholder-slate-400">
                            <button type="button" onclick="togglePassword('current_password', 'icon_current')" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-brand-600 transition-colors">
                                <i id="icon_current" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="h-px bg-slate-100 my-6"></div>

                    {{-- 2. Password Baru --}}
                    <div class="mb-5">
                        <label for="new_password" class="block text-sm font-bold text-slate-700 mb-2">Password Baru</label>
                        <div class="relative">
                            <input type="password" id="new_password" name="new_password" required
                                placeholder="Minimal 6 karakter"
                                class="w-full pl-4 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all placeholder-slate-400">
                             <button type="button" onclick="togglePassword('new_password', 'icon_new')" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-brand-600 transition-colors">
                                <i id="icon_new" class="fas fa-eye"></i>
                            </button>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1 italic">Gunakan kombinasi huruf dan angka agar lebih aman.</p>
                    </div>

                    {{-- 3. Konfirmasi Password Baru --}}
                    <div class="mb-8">
                        <label for="new_password_confirmation" class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
                                placeholder="Ulangi password baru"
                                class="w-full pl-4 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all placeholder-slate-400">
                             <button type="button" onclick="togglePassword('new_password_confirmation', 'icon_confirm')" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-brand-600 transition-colors">
                                <i id="icon_confirm" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('warga.dashboard') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl shadow-lg shadow-brand-200 hover:shadow-brand-300 transform transition-all active:scale-95 flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
    @endpush

@endsection