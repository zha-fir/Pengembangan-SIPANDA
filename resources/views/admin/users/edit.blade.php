@extends('layouts.admin')
@section('title', 'Edit Pengguna')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('users.update', $user->id_user) }}" method="POST">
                @csrf @method('PUT')

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ $user->nama_lengkap }}"
                            required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control"
                                placeholder="Isi hanya jika ingin mengganti password">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary btn-toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        {{-- TAMBAHKAN INI --}}
                        <small class="text-danger mt-1">
                            * Kosongkan jika tidak ingin mengubah password user ini.
                        </small>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Role</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="kades" {{ $user->role == 'kades' ? 'selected' : '' }}>Kepala Desa</option>
                            <option value="kadus" {{ $user->role == 'kadus' ? 'selected' : '' }}>Kepala Dusun</option>
                        </select>
                    </div>
                </div>

                <div class="form-group {{ $user->role == 'kadus' ? '' : 'd-none' }}" id="area_dusun">
                    <label>Pilih Wilayah Dusun</label>
                    <select name="id_dusun" class="form-control">
                        <option value="">-- Pilih Dusun --</option>
                        @foreach($dusunList as $dusun)
                            <option value="{{ $dusun->id_dusun }}" {{ $user->id_dusun == $dusun->id_dusun ? 'selected' : '' }}>
                                {{ $dusun->nama_dusun }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            $('#role').change(function () {
                if ($(this).val() == 'kadus') {
                    $('#area_dusun').removeClass('d-none');
                } else {
                    $('#area_dusun').addClass('d-none');
                }
            });
        </script>
    @endpush
@endsection