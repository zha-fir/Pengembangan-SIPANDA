@extends('layouts.admin')
@section('title', 'Tambah Pengguna Baru')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Username (Untuk Login)</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Password</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" required>
                            <div class="input-group-append"> {{-- SBAdmin2 menggunakan input-group-append --}}
                                <button class="btn btn-outline-secondary btn-toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Role / Jabatan</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Administrator / Operator</option>
                            <option value="kades">Kepala Desa</option>
                            <option value="kadus">Kepala Dusun</option>
                        </select>
                    </div>
                </div>

                {{-- Dropdown Dusun (Hanya muncul jika Kadus) --}}
                <div class="form-group d-none" id="area_dusun">
                    <label class="font-weight-bold text-success">Pilih Wilayah Dusun (Wajib untuk Kadus)</label>
                    <select name="id_dusun" class="form-control">
                        <option value="">-- Pilih Dusun --</option>
                        @foreach($dusunList as $dusun)
                            <option value="{{ $dusun->id_dusun }}">{{ $dusun->nama_dusun }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
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