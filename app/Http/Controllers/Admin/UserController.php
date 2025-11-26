<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Dusun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Daftar semua pengguna sistem.
     */
    public function index()
    {
        // HANYA ambil user yang role-nya admin, kades, atau kadus
        // Warga TIDAK ditampilkan di sini
        $users = User::whereIn('role', ['admin', 'kades', 'kadus'])
                     ->with('dusun')
                     ->orderByRaw("FIELD(role, 'admin', 'kades', 'kadus')")
                     ->orderBy('nama_lengkap', 'asc')
                     ->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $dusunList = Dusun::all(); // Untuk dropdown jika role = kadus
        return view('admin.users.create', compact('dusunList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:tabel_users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin',
            // id_dusun wajib diisi HANYA JIKA role = kadus
            'id_dusun' => 'nullable|required_if:role,kadus|exists:tabel_dusun,id_dusun',
        ], [
            'id_dusun.required_if' => 'Untuk Role Kepala Dusun, Anda wajib memilih Wilayah Dusun.'
        ]);

        $user = new User();
        $user->nama_lengkap = $request->nama_lengkap;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        
        // Hanya simpan id_dusun jika role kadus, selain itu null
        $user->id_dusun = ($request->role == 'kadus') ? $request->id_dusun : null;
        
        $user->save();

        return redirect()->route('users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $dusunList = Dusun::all();
        return view('admin.users.edit', compact('user', 'dusunList'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'username' => ['required', Rule::unique('tabel_users')->ignore($user->id_user, 'id_user')],
            'role' => 'required|in:admin,kades,kadus',
            'id_dusun' => 'nullable|required_if:role,kadus|exists:tabel_dusun,id_dusun',
            'password' => 'nullable|string|min:6', // Password opsional saat edit
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->username = $request->username;
        $user->role = $request->role;
        $user->id_dusun = ($request->role == 'kadus') ? $request->id_dusun : null;

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id_user == auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }
        
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}