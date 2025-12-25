@extends('layouts.admin')
@section('title', 'Manajemen Akun Pengguna')
@section('content')

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna Sistem</h6>
        </div>
        <div class="card-body">
            <a href="{{ route('users.create') }}" class="btn btn-primary mb-3 shadow-sm"><i class="fas fa-user-plus mr-1"></i> Tambah Akun</a>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th class="text-center">Role</th>
                            <th>Wilayah (Khusus Kadus)</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-2">
                                            @php
                                                $bgClass = 'bg-secondary';
                                                $icon = 'fas fa-user';
                                                if($user->role == 'admin') { $bgClass = 'bg-danger'; $icon = 'fas fa-user-cog'; }
                                                elseif($user->role == 'kades') { $bgClass = 'bg-primary'; $icon = 'fas fa-user-tie'; }
                                                elseif($user->role == 'kadus') { $bgClass = 'bg-success'; $icon = 'fas fa-user-tag'; }
                                            @endphp
                                            <div class="{{ $bgClass }} text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                <i class="{{ $icon }}"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="font-weight-bold text-dark">{{ $user->nama_lengkap }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">{{ $user->username }}</td>
                                <td class="align-middle text-center">
                                    @if($user->role == 'admin') 
                                        <span class="badge badge-danger px-2 py-1"><i class="fas fa-user-cog mr-1"></i>ADMIN</span>
                                    @elseif($user->role == 'kades') 
                                        <span class="badge badge-primary px-2 py-1"><i class="fas fa-user-tie mr-1"></i>KEPALA DESA</span>
                                    @elseif($user->role == 'kadus') 
                                        <span class="badge badge-success px-2 py-1"><i class="fas fa-map-marked-alt mr-1"></i>KEPALA DUSUN</span>
                                    @else 
                                        <span class="badge badge-secondary px-2 py-1"><i class="fas fa-user mr-1"></i>WARGA</span> 
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($user->dusun)
                                        <i class="fas fa-map-marker-alt text-danger mr-1"></i> {{ $user->dusun->nama_dusun }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('users.edit', $user->id_user) }}" class="btn btn-warning btn-circle btn-sm mr-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($user->id_user != Auth::id())
                                            <form action="{{ route('users.destroy', $user->id_user) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin hapus user ini?');">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-circle btn-sm" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-gray-500 mb-2"><i class="fas fa-users-slash fa-2x"></i></div>
                                    <div>Belum ada data pengguna.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection