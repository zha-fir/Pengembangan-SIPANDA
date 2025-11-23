@extends('layouts.citizen')

@section('title', 'Ubah Password')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('warga.password.update') }}" method="POST">
                        @csrf

                        {{-- 1. Password Lama --}}
                        <div class="mb-4">
                            <label for="current_password" class="form-label">Password Lama</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="current_password" name="current_password"
                                    required>
                                <button class="btn btn-outline-secondary btn-toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <hr>

                        {{-- 2. Password Baru --}}
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password" name="new_password" required
                                    placeholder="Minimal 6 karakter">
                                <button class="btn btn-outline-secondary btn-toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        {{-- 3. Konfirmasi Password Baru --}}
                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password_confirmation"
                                    name="new_password_confirmation" required placeholder="Ulangi password baru">
                                <button class="btn btn-outline-secondary btn-toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('warga.dashboard') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Simpan Password Baru
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection