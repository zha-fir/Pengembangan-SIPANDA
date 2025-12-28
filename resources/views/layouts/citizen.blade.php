<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pelayanan Warga') - SIPANDA</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ['"Plus Jakarta Sans"', 'sans-serif'],
            },
            colors: {
              brand: {
                50: '#eff6ff',
                100: '#dbeafe',
                500: '#3b82f6',
                600: '#2563eb',
                700: '#1d4ed8',
              }
            }
          }
        }
      }
    </script>

    <!-- Third Party CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-slate-50 text-slate-600 font-sans antialiased selection:bg-brand-100 selection:text-brand-700 pb-20 md:pb-0">

    <!-- DESKTOP SIDEBAR -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 shadow-sm hidden md:flex flex-col transition-all duration-300">
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 border-b border-slate-100 bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-brand-600 text-white flex items-center justify-center shrink-0">
                    <i class="fas fa-landmark text-sm"></i>
                </div>
                <div>
                    <h1 class="font-bold text-slate-800 leading-tight">SIPANDA</h1>
                    <p class="text-[10px] text-slate-400 font-medium tracking-wide uppercase">Warga Desa</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <p class="px-3 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 mt-2">Menu Utama</p>
            
            <a href="{{ route('warga.dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ Request::routeIs('warga.dashboard') ? 'bg-brand-50 text-brand-700 shadow-sm ring-1 ring-brand-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <i class="fas fa-home w-5 text-center {{ Request::routeIs('warga.dashboard') ? 'text-brand-600' : 'text-slate-400' }}"></i>
                Dashboard
            </a>
            
            <a href="{{ route('warga.ajuan.create') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ Request::routeIs('warga.ajuan.create') ? 'bg-brand-50 text-brand-700 shadow-sm ring-1 ring-brand-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 create-link' }}">
                <i class="fas fa-file-pen w-5 text-center {{ Request::routeIs('warga.ajuan.create') ? 'text-brand-600' : 'text-slate-400' }}"></i>
                Buat Pengajuan
            </a>
            
            <a href="{{ route('warga.ajuan.history') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ Request::routeIs('warga.ajuan.history') ? 'bg-brand-50 text-brand-700 shadow-sm ring-1 ring-brand-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <i class="fas fa-clock-rotate-left w-5 text-center {{ Request::routeIs('warga.ajuan.history') ? 'text-brand-600' : 'text-slate-400' }}"></i>
                Riwayat Surat
            </a>

            <p class="px-3 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 mt-6">Akun</p>
            
            <a href="{{ route('warga.password.edit') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ Request::routeIs('warga.password.edit') ? 'bg-brand-50 text-brand-700 shadow-sm ring-1 ring-brand-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <i class="fas fa-key w-5 text-center {{ Request::routeIs('warga.password.edit') ? 'text-brand-600' : 'text-slate-400' }}"></i>
                Ubah Password
            </a>
        </div>

        <!-- User Profile (Bottom Sidebar) -->
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold text-sm border-2 border-white shadow-sm">
                    {{ substr(Auth::user()->nama_lengkap ?? 'W', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate">{{ Auth::user()->nama_lengkap ?? 'Warga' }}</p>
                    <p class="text-xs text-slate-500 truncate">NIK: {{ Auth::user()->username ?? '-' }}</p>
                </div>
            </div>
            <form action="{{ route('warga.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 transition-colors">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MOBILE HEADER (Sticky Top) -->
    <header class="fixed top-0 inset-x-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-200 px-4 h-16 flex items-center justify-between md:hidden">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-brand-600 text-white flex items-center justify-center shrink-0">
                <i class="fas fa-landmark text-sm"></i>
            </div>
            <span class="font-bold text-slate-800">SIPANDA</span>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600">
                <span class="text-xs font-bold">{{ substr(Auth::user()->nama_lengkap ?? 'W', 0, 1) }}</span>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT WRAPPER -->
    <div class="md:pl-64 flex flex-col min-h-screen pt-16 md:pt-0">
        <main class="flex-1 p-4 md:p-8 max-w-7xl mx-auto w-full">
            <header class="mb-6 md:mb-8">
                 <h2 class="text-2xl font-bold text-slate-800 tracking-tight">@yield('title')</h2>
                 @hasSection('subtitle')
                    <p class="text-slate-500 mt-1">@yield('subtitle')</p>
                 @endif
            </header>

            @yield('content')
        </main>

        <footer class="py-6 text-center text-xs text-slate-400 border-t border-slate-100 mt-auto hidden md:block">
            &copy; {{ date('Y') }} Pemerintah Desa Panggulo.
        </footer>
    </div>

    <!-- MOBILE BOTTOM NAVIGATION (Fixed) -->
    <nav class="fixed bottom-0 inset-x-0 z-50 bg-white border-t border-slate-200 pb-safe md:hidden shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
        <div class="grid grid-cols-4 h-16">
            <a href="{{ route('warga.dashboard') }}" class="flex flex-col items-center justify-center gap-1 {{ Request::routeIs('warga.dashboard') ? 'text-brand-600' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="fas fa-home text-lg {{ Request::routeIs('warga.dashboard') ? 'mb-1' : '' }}"></i>
                <span class="text-[10px] font-medium">Beranda</span>
            </a>
            
            <a href="{{ route('warga.ajuan.create') }}" class="flex flex-col items-center justify-center gap-1 {{ Request::routeIs('warga.ajuan.create') ? 'text-brand-600' : 'text-slate-400 hover:text-slate-600' }}">
                <div class="w-10 h-10 rounded-full bg-brand-50 flex items-center justify-center {{ Request::routeIs('warga.ajuan.create') ? 'bg-brand-600 text-white shadow-lg shadow-brand-200 ring-2 ring-white -mt-4' : 'text-brand-600' }}">
                    <i class="fas fa-plus text-lg"></i>
                </div>
            </a>
            
            <a href="{{ route('warga.ajuan.history') }}" class="flex flex-col items-center justify-center gap-1 {{ Request::routeIs('warga.ajuan.history') ? 'text-brand-600' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="fas fa-history text-lg {{ Request::routeIs('warga.ajuan.history') ? 'mb-1' : '' }}"></i>
                <span class="text-[10px] font-medium">Riwayat</span>
            </a>

            <!-- Mobile Menu More (Trigger Offcanvas / Dropdown logic simpler here just Profile) -->
             <a href="{{ route('warga.password.edit') }}" class="flex flex-col items-center justify-center gap-1 {{ Request::routeIs('warga.password.edit') ? 'text-brand-600' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="fas fa-user text-lg {{ Request::routeIs('warga.password.edit') ? 'mb-1' : '' }}"></i>
                <span class="text-[10px] font-medium">Profil</span>
            </a>
        </div>
    </nav>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Additional Scripts
    </script>
    @stack('scripts')
</body>
</html>