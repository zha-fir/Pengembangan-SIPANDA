@extends('layouts.guest')

@section('title', 'Login Warga')

@section('content')

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
        
        <!-- Header -->
        <div class="bg-indigo-600 px-8 py-6 text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-white/20 mb-3 text-white backdrop-blur-sm">
                <i class="fas fa-university text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-tight">SIPANDA</h1>
            <p class="text-indigo-100 text-sm mt-1 opacity-90">Sistem Pelayanan Administrasi Desa</p>
        </div>

        <!-- Body -->
        <div class="p-8">
            
            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-100 text-rose-600 px-4 py-3 rounded-xl text-sm mb-6 flex items-start gap-3">
                    <i class="fas fa-exclamation-circle mt-0.5"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('warga.login.submit') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label for="username" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">NIK / Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-id-card text-slate-400"></i>
                        </div>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" 
                               class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder-slate-400 font-medium"
                               placeholder="Masukkan NIK Anda" required>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-slate-400"></i>
                        </div>
                        <input type="password" id="password" name="password" 
                               class="w-full pl-10 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder-slate-400 font-medium"
                               placeholder="Masukkan password..." required>
                        <button type="button" onclick="togglePassword('password', 'toggle-icon')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-indigo-600 transition-colors">
                            <i id="toggle-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transform transition-all active:scale-[0.98] flex items-center justify-center gap-2 mt-2">
                    <span>Masuk Aplikasi</span>
                    <i class="fas fa-arrow-right text-sm"></i>
                </button>

            </form>
        </div>
        
        <div class="bg-slate-50 px-8 py-4 text-center border-t border-slate-100">
            <p class="text-xs text-slate-500">Belum punya akun? <br>Silakan hubungi <strong class="text-slate-700">Kantor Desa</strong> untuk pendaftaran.</p>
        </div>

    </div>

@endsection