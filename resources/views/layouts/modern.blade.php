<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIPANDA')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ['"Plus Jakarta Sans"', 'sans-serif'],
            }
          }
        }
      }
    </script>
    
    <!-- Font Awesome (Tetap dipakai untuk icon) -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="h-full antialiased text-slate-600 selection:bg-indigo-500 selection:text-white">

    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- DESKTOP SIDEBAR -->
        <aside id="desktopSidebar" class="hidden md:flex flex-col w-72 bg-white border-r border-slate-200 fixed inset-y-0 z-50 transition-all duration-300">
            <!-- Brand -->
            <div class="h-16 flex items-center justify-between px-6 border-b border-slate-100 overflow-hidden">
                <div class="flex items-center gap-2 text-indigo-600 font-bold text-xl whitespace-nowrap">
                    <i class="fas fa-university text-2xl"></i>
                    <span class="sidebar-text transition-opacity duration-300">SIPANDA</span>
                </div>
                <!-- Toggle Button -->
                <button onclick="toggleDesktopSidebar()" class="text-slate-400 hover:text-indigo-600 transition-colors">
                    <i id="sidebarToggleIcon" class="fas fa-chevron-left"></i>
                </button>
            </div>

            <!-- User Profile (Compact) -->
            <div class="p-4 border-b border-slate-50 bg-slate-50/50 overflow-hidden">
                <div class="flex items-center gap-3">
                    <img class="h-10 w-10 rounded-full object-cover border-2 border-white shadow-sm flex-shrink-0" 
                         src="{{ asset('img/undraw_profile.svg') }}" alt="Profile">
                    <div class="flex-1 min-w-0 sidebar-text transition-opacity duration-300">
                        <p class="text-sm font-semibold text-slate-900 truncate">
                            {{ Auth::user()->nama_lengkap ?? 'Pengguna' }}
                        </p>
                        <p class="text-xs text-slate-500 truncate capitalize">
                            {{ Auth::user()->role ?? 'Pejabat' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1 overflow-x-hidden">
                @php
                    $role = Auth::user()->role;
                    $prefix = $role == 'kades' ? 'kades' : 'kadus';
                @endphp

                <!-- Dashboard -->
                <a href="{{ route($prefix.'.dashboard') }}" 
                   title="Dashboard"
                   class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                   {{ Request::is($prefix.'/dashboard*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <div class="flex-shrink-0 w-6 text-center">
                        <i class="fas fa-th-large {{ Request::is($prefix.'/dashboard*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }}"></i>
                    </div>
                    <span class="sidebar-text whitespace-nowrap transition-opacity duration-300">Dashboard</span>
                </a>

                <!-- Approval (New) -->
                <a href="{{ route($prefix.'.approval.index') }}" 
                   title="Persetujuan Surat"
                   class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                   {{ Request::is($prefix.'/approval*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                   <div class="flex-shrink-0 w-6 text-center">
                       <i class="fas fa-file-signature {{ Request::is($prefix.'/approval*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }}"></i>
                   </div>
                    <span class="sidebar-text whitespace-nowrap transition-opacity duration-300">Persetujuan Surat</span>
                </a>

                <div class="pt-4 pb-2 sidebar-text transition-opacity duration-300">
                    <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Menu Utama</p>
                </div>

                @if($role == 'kades')
                    <a href="{{ route('kades.monitoring.index') }}" 
                       title="Monitoring Surat"
                       class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                       {{ Request::is('kades/monitoring*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <div class="flex-shrink-0 w-6 text-center"><i class="fas fa-eye text-slate-400"></i></div>
                        <span class="sidebar-text whitespace-nowrap transition-opacity duration-300">Monitoring Surat</span>
                    </a>
                    <a href="{{ route('kades.penduduk.index') }}" 
                       title="Data Penduduk"
                       class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                       {{ Request::is('kades/penduduk*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                         <div class="flex-shrink-0 w-6 text-center"><i class="fas fa-users text-slate-400"></i></div>
                        <span class="sidebar-text whitespace-nowrap transition-opacity duration-300">Data Penduduk</span>
                    </a>
                    <a href="{{ route('kades.laporan.index') }}" 
                       title="Laporan Rekap"
                       class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                       {{ Request::is('kades/laporan*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <div class="flex-shrink-0 w-6 text-center"><i class="fas fa-chart-pie text-slate-400"></i></div>
                        <span class="sidebar-text whitespace-nowrap transition-opacity duration-300">Laporan Rekap</span>
                    </a>
                @elseif($role == 'kadus')
                     <a href="{{ route('kadus.warga') }}" 
                       title="Penduduk Saya"
                       class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                       {{ Request::is('kadus/warga*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                         <div class="flex-shrink-0 w-6 text-center"><i class="fas fa-users text-slate-400"></i></div>
                        <span class="sidebar-text whitespace-nowrap transition-opacity duration-300">Penduduk Saya</span>
                    </a>
                    <a href="{{ route('kadus.surat') }}" 
                       title="Surat Wilayah"
                       class="group flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                       {{ Request::is('kadus/surat*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                         <div class="flex-shrink-0 w-6 text-center"><i class="fas fa-envelope-open-text text-slate-400"></i></div>
                        <span class="sidebar-text whitespace-nowrap transition-opacity duration-300">Surat Wilayah</span>
                    </a>
                @endif
            </nav>

            <!-- Bottom Actions -->
            <div class="p-4 border-t border-slate-200 overflow-hidden">
                <form action="{{ route('warga.logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Keluar" class="flex w-full items-center justify-center gap-2 rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-red-50 hover:text-red-600 transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="sidebar-text whitespace-nowrap transition-opacity duration-300">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT WRAPPER -->
        <main id="mainContent" class="flex-1 md:ml-72 flex flex-col min-h-screen pb-20 md:pb-0 transition-all duration-300">
            <!-- Mobile Topbar -->
            <div class="md:hidden glass-effect sticky top-0 z-40 px-4 h-16 flex items-center justify-between border-b border-slate-200">
                 <div class="flex items-center gap-2 text-indigo-600 font-bold">
                    <i class="fas fa-university text-xl"></i>
                    <span>SIPANDA</span>
                </div>
                <div class="flex items-center gap-3">
                     <img class="h-8 w-8 rounded-full object-cover border border-slate-200" 
                         src="{{ asset('img/undraw_profile.svg') }}" alt="Profile">
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-4 md:p-8 max-w-7xl mx-auto w-full">
                @yield('content')
            </div>
        </main>

        <!-- MOBILE BOTTOM NAVIGATION -->
        <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 z-50 pb-safe">
            <div class="flex justify-around items-center h-16">
                <!-- Dashboard -->
                <a href="{{ route($prefix.'.dashboard') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ Request::is($prefix.'/dashboard*') ? 'text-indigo-600' : 'text-slate-400' }}">
                    <i class="fas fa-th-large text-lg"></i>
                    <span class="text-[10px] font-medium">Beranda</span>
                </a>

                <!-- Approval (Center Prominent) -->
                 <a href="{{ route($prefix.'.approval.index') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ Request::is($prefix.'/approval*') ? 'text-indigo-600' : 'text-slate-400' }}">
                    <div class="relative">
                         <i class="fas fa-file-signature text-xl mb-1"></i>
                         <!-- Indicator dot could go here -->
                    </div>
                    <span class="text-[10px] font-medium">Setujui</span>
                </a>

                <!-- Menu (More) -->
                <button type="button" onclick="toggleMobileMenu()" class="flex flex-col items-center justify-center w-full h-full space-y-1 text-slate-400">
                    <i class="fas fa-bars text-lg"></i>
                    <span class="text-[10px] font-medium">Menu</span>
                </button>
            </div>
        </nav>

        <!-- MOBILE MENU OVERLAY (Tailwind + Vanilla JS) -->
        <div id="mobileMenuOverlay" class="fixed inset-0 bg-black/50 z-50 hidden transition-opacity opacity-0" onclick="toggleMobileMenu()"></div>
        
        <div id="mobileMenuContent" class="fixed bottom-0 left-0 right-0 bg-white rounded-t-3xl z-50 transform translate-y-full transition-transform duration-300 md:hidden shadow-2xl">
            <div class="p-5 flex flex-col gap-4">
                <!-- Header -->
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                     <img class="h-12 w-12 rounded-full border-2 border-slate-100" src="{{ asset('img/undraw_profile.svg') }}">
                     <div>
                        <p class="font-bold text-slate-800 text-lg leading-tight">{{ Auth::user()->nama_lengkap }}</p>
                        <p class="text-sm text-slate-500 capitalize">{{ Auth::user()->role }}</p>
                     </div>
                     <button onclick="toggleMobileMenu()" class="ml-auto w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500">
                        <i class="fas fa-times"></i>
                     </button>
                </div>

                <!-- Menus -->
                <div class="grid gap-2">
                    @if($role == 'kades')
                         <a href="{{ route('kades.monitoring.index') }}" class="p-3 flex items-center gap-3 hover:bg-slate-50 rounded-xl text-slate-600">
                            <i class="fas fa-eye w-6 text-center text-indigo-500"></i> <span class="font-medium">Monitoring Surat</span>
                        </a>
                        <a href="{{ route('kades.penduduk.index') }}" class="p-3 flex items-center gap-3 hover:bg-slate-50 rounded-xl text-slate-600">
                            <i class="fas fa-users w-6 text-center text-indigo-500"></i> <span class="font-medium">Data Penduduk</span>
                        </a>
                        <a href="{{ route('kades.laporan.index') }}" class="p-3 flex items-center gap-3 hover:bg-slate-50 rounded-xl text-slate-600">
                            <i class="fas fa-chart-pie w-6 text-center text-indigo-500"></i> <span class="font-medium">Laporan Rekap</span>
                        </a>
                    @elseif($role == 'kadus')
                        <a href="{{ route('kadus.warga') }}" class="p-3 flex items-center gap-3 hover:bg-slate-50 rounded-xl text-slate-600">
                            <i class="fas fa-users w-6 text-center text-indigo-500"></i> <span class="font-medium">Penduduk Saya</span>
                        </a>
                        <a href="{{ route('kadus.surat') }}" class="p-3 flex items-center gap-3 hover:bg-slate-50 rounded-xl text-slate-600">
                            <i class="fas fa-envelope-open-text w-6 text-center text-indigo-500"></i> <span class="font-medium">Surat Wilayah</span>
                        </a>
                    @endif
                    
                    <div class="h-px bg-slate-100 my-1"></div>
                    
                    <form action="{{ route('warga.logout') }}" method="POST">
                        @csrf
                        <button class="w-full p-3 flex items-center gap-3 bg-red-50 hover:bg-red-100 rounded-xl text-red-600 transition-colors">
                            <i class="fas fa-sign-out-alt w-6 text-center"></i> <span class="font-bold">Keluar Aplikasi</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <!-- Removed SB Admin scripts for this layout to ensure clean modern behavior -->
    <script>
        function toggleMobileMenu() {
            const overlay = document.getElementById('mobileMenuOverlay');
            const content = document.getElementById('mobileMenuContent');
            
            if (content.classList.contains('translate-y-full')) {
                // Open
                overlay.classList.remove('hidden');
                // timeout to allow display:block to apply before opacity transition
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                    content.classList.remove('translate-y-full');
                }, 10);
            } else {
                // Close
                overlay.classList.add('opacity-0');
                content.classList.add('translate-y-full');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300);
            }
        }

        // Sidebar Toggle Logic
        function toggleDesktopSidebar() {
            const sidebar = document.getElementById('desktopSidebar');
            const mainContent = document.getElementById('mainContent');
            const texts = document.querySelectorAll('.sidebar-text');
            const toggleIcon = document.getElementById('sidebarToggleIcon');

            // Toggle width classes
            sidebar.classList.toggle('w-72');
            sidebar.classList.toggle('w-20');

            // Toggle margin classes
            mainContent.classList.toggle('md:ml-72');
            mainContent.classList.toggle('md:ml-20');

            // Toggle text visibility
            texts.forEach(el => {
                if (sidebar.classList.contains('w-20')) {
                    el.classList.add('opacity-0', 'pointer-events-none', 'hidden'); // added hidden for better layout collapse
                } else {
                    el.classList.remove('hidden');
                    setTimeout(() => el.classList.remove('opacity-0', 'pointer-events-none'), 50); // delay for transition
                }
            });

            // Rotate Icon
            if (sidebar.classList.contains('w-20')) {
                toggleIcon.classList.remove('fa-chevron-left');
                toggleIcon.classList.add('fa-chevron-right');
            } else {
                toggleIcon.classList.remove('fa-chevron-right');
                toggleIcon.classList.add('fa-chevron-left');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
