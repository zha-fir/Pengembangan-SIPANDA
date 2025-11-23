<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistem Administrasi Masyarakat">
    <meta name="author" content="Roys R. Suleman (Contoh)">

    <title>@yield('title', 'Admin Dashboard')</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="{{ route('admin.dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-university"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SIM Administrasi</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item @if(Request::is('admin/dashboard*')) active @endif">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Menu Utama
            </div>

            @php
                $isDataActive = Request::is('admin/dusun*') || Request::is('admin/kk*') || Request::is('admin/warga*') || Request::is('admin/pejabat-desa*');
            @endphp
            <li class="nav-item {{ $isDataActive ? 'active' : '' }}">
                <a class="nav-link {{ $isDataActive ? '' : 'collapsed' }}" href="#" data-toggle="collapse"
                    data-target="#collapseData" aria-expanded="{{ $isDataActive ? 'true' : 'false' }}"
                    aria-controls="collapseData">
                    <i class="fas fa-fw fa-database"></i>
                    <span>Manajemen Data</span>
                </a>
                <div id="collapseData" class="collapse {{ $isDataActive ? 'show' : '' }}" aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Data Master:</h6>

                        <a class="collapse-item {{ Request::is('admin/dusun*') ? 'active' : '' }}"
                            href="{{ route('dusun.index') }}">
                            Data Dusun
                        </a>
                        <a class="collapse-item {{ Request::is('admin/kk*') ? 'active' : '' }}"
                            href="{{ route('kk.index') }}">
                            Data Kartu Keluarga
                        </a>
                        <a class="collapse-item {{ Request::is('admin/warga*') ? 'active' : '' }}"
                            href="{{ route('warga.index') }}">
                            Data Penduduk
                        </a>
                        <a class="collapse-item {{ Request::is('admin/pejabat-desa*') ? 'active' : '' }}"
                            href="{{ route('pejabat-desa.index') }}">
                            Pejabat Desa
                        </a>
                    </div>
                </div>
            </li>

            @php
                $isSuratActive = Request::is('admin/jenis-surat*') || Request::is('admin/ajuan-surat*') || Request::is('admin/arsip-surat*');
            @endphp
            <li class="nav-item {{ $isSuratActive ? 'active' : '' }}">
                <a class="nav-link {{ $isSuratActive ? '' : 'collapsed' }}" href="#" data-toggle="collapse"
                    data-target="#collapseSurat" aria-expanded="{{ $isSuratActive ? 'true' : 'false' }}"
                    aria-controls="collapseSurat">
                    <i class="fas fa-fw fa-envelope-open-text"></i>
                    <span>Layanan Surat</span>
                </a>
                <div id="collapseSurat" class="collapse {{ $isSuratActive ? 'show' : '' }}"
                    aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Persuratan:</h6>

                        <a class="collapse-item {{ Request::is('admin/jenis-surat*') ? 'active' : '' }}"
                            href="{{ route('jenis-surat.index') }}">
                            Template Surat
                        </a>
                        <a class="collapse-item {{ Request::is('admin/ajuan-surat*') && !Request::is('admin/arsip-surat*') ? 'active' : '' }}"
                            href="{{ route('ajuan-surat.index') }}">
                            Ajuan Masuk
                        </a>
                        <a class="collapse-item {{ Request::is('admin/arsip-surat*') ? 'active' : '' }}"
                            href="{{ route('ajuan-surat.arsip') }}">
                            Arsip Surat
                        </a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Pengaturan
            </div>

            <li class="nav-item @if(Request::is('admin/users*')) active @endif">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <i class="fas fa-fw fa-user-cog"></i>
                    <span>Manajemen Akun</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <div id="content-wrapper" class="d-flex flex-column min-vh-100">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{-- Tampilkan nama user yang login --}}
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->nama_lengkap ?? 'Administrator' }}</span>

                                <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}">
                            </a>

                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                {{-- INI ADALAH LINK PEMICU MODAL (BUKAN FORM) --}}
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <div class="container-fluid">

                    <h1 class="h3 mb-4 text-gray-800">@yield('title')</h1>

                    @yield('content')

                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Pemerintah Desa Panggulo 2025</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" di bawah jika Anda siap untuk mengakhiri sesi Anda saat ini.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>

                    {{-- FORM LOGOUT (Wajib pakai POST dan @csrf) --}}
                    <form action="{{ route('warga.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- HAPUS SEMUA SKRIP GANDA YANG ANDA MILIKI SEBELUMNYA --}}

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            // Fungsi Toggle Password Universal
            $(document).on('click', '.btn-toggle-password', function () {
                // Cari input yang satu grup dengan tombol ini
                let input = $(this).closest('.input-group').find('input');
                let icon = $(this).find('i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>

    {{-- @stack('scripts') harus di paling akhir --}}
    @stack('scripts')
</body>

</html>