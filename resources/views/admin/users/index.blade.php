@extends('layouts.modern')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6">

    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Manajemen Pengguna</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola akun pengguna dan hak akses sistem.</p>
        </div>
        <div>
            <a href="{{ route('users.create') }}" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm shadow-indigo-200">
                <i class="fas fa-plus"></i> Tambah Pengguna
            </a>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-3">
             <i class="fas fa-check-circle text-xl"></i>
             <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3">
             <i class="fas fa-exclamation-circle text-xl"></i>
             <p class="font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Table Content -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                 <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-xs border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-bold">Pengguna</th>
                        <th class="px-6 py-4 font-bold">Username</th>
                        <th class="px-6 py-4 font-bold text-center">Role</th>
                        <th class="px-6 py-4 font-bold">Wilayah</th>
                        <th class="px-6 py-4 font-bold text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @php
                                    $bgClass = 'bg-slate-100 text-slate-600 border-slate-200';
                                    $icon = 'fas fa-user';
                                    if($user->role == 'admin') { 
                                        $bgClass = 'bg-rose-100 text-rose-600 border-rose-200'; 
                                        $icon = 'fas fa-user-cog'; 
                                    } elseif($user->role == 'kades') { 
                                        $bgClass = 'bg-blue-100 text-blue-600 border-blue-200'; 
                                        $icon = 'fas fa-user-tie'; 
                                    } elseif($user->role == 'kadus') { 
                                        $bgClass = 'bg-emerald-100 text-emerald-600 border-emerald-200'; 
                                        $icon = 'fas fa-user-tag'; 
                                    }
                                @endphp
                                <div class="h-9 w-9 rounded-full flex items-center justify-center text-xs border {{ $bgClass }}">
                                    <i class="{{ $icon }}"></i>
                                </div>
                                <span class="font-bold text-slate-800">{{ $user->nama_lengkap }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-mono text-slate-600">
                            {{ $user->username }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($user->role == 'admin') 
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">ADMIN</span>
                            @elseif($user->role == 'kades') 
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">KADES</span>
                            @elseif($user->role == 'kadus') 
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">KADUS</span>
                            @else 
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">WARGA</span> 
                            @endif
                        </td>
                        <td class="px-6 py-4">
                             @if($user->dusun)
                                <span class="inline-flex items-center gap-1.5 text-slate-700 font-medium">
                                    <i class="fas fa-map-marker-alt text-rose-500"></i> {{ $user->dusun->nama_dusun }}
                                </span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('users.edit', $user->id_user) }}" class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id_user != Auth::id())
                                    <form action="{{ route('users.destroy', $user->id_user) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                             <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-users-slash text-4xl mb-3 opacity-20"></i>
                                <p>Belum ada data pengguna.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View -->
        <div class="md:hidden divide-y divide-slate-100">
             @forelse($users as $user)
             <div class="p-4 space-y-3">
                <div class="flex items-start justify-between">
                     <div class="flex items-center gap-3">
                        @php
                            $bgClass = 'bg-slate-100 text-slate-600 border-slate-200';
                            $icon = 'fas fa-user';
                            if($user->role == 'admin') { $bgClass = 'bg-rose-100 text-rose-600 border-rose-200'; }
                            elseif($user->role == 'kades') { $bgClass = 'bg-blue-100 text-blue-600 border-blue-200'; }
                            elseif($user->role == 'kadus') { $bgClass = 'bg-emerald-100 text-emerald-600 border-emerald-200'; }
                        @endphp
                        <div class="h-10 w-10 rounded-full flex items-center justify-center text-sm border {{ $bgClass }}">
                            <i class="{{ $icon }}"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">{{ $user->nama_lengkap }}</h3>
                            <p class="text-xs text-slate-500 font-mono">{{ $user->username }}</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold px-2 py-1 rounded bg-slate-100 text-slate-600">
                        {{ strtoupper($user->role) }}
                    </span>
                </div>

                @if($user->dusun)
                    <div class="ml-12 text-sm text-slate-700 flex items-center gap-1.5">
                        <i class="fas fa-map-marker-alt text-rose-500"></i> {{ $user->dusun->nama_dusun }}
                    </div>
                @endif

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-50 ml-12">
                    <a href="{{ route('users.edit', $user->id_user) }}" class="flex-1 py-2 bg-amber-50 text-amber-700 text-center rounded-lg text-sm font-medium hover:bg-amber-100">
                        Edit
                    </a>
                    @if($user->id_user != Auth::id())
                        <form action="{{ route('users.destroy', $user->id_user) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus user ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full py-2 bg-red-50 text-red-700 text-center rounded-lg text-sm font-medium hover:bg-red-100">
                                Hapus
                            </button>
                        </form>
                    @endif
                </div>
             </div>
             @empty
             <div class="p-8 text-center text-slate-400">
                 <p>Tidak ditemukan data.</p>
             </div>
             @endforelse
        </div>
    </div>
</div>
@endsection