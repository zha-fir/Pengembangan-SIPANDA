<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Impor Fasad Auth
use Illuminate\Support\Facades\Redirect; // <-- Impor Redirect
use App\Models\Warga;
use App\Models\AjuanSurat;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login warga.
     */
    public function showLoginForm()
{
    // Cek apakah user SUDAH login
    if (Auth::check()) {
        // Jika sudah login, JANGAN tampilkan form login lagi.
        // Lempar mereka ke dashboard yang sesuai peran mereka.
        
        if (Auth::user()->role == 'warga') {
            return Redirect::route('warga.dashboard');
        } elseif (Auth::user()->role == 'admin') {
            return Redirect::route('admin.dashboard');
        }
    }

    // Jika BELUM login, baru tampilkan form
    return view('citizen.auth.login');
}

    /**
     * Memproses data login yang dikirim dari form.
     */
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Coba lakukan login
        if (Auth::attempt($credentials)) {

            // 3. Login berhasil, cek rolenya
            $user = Auth::user();

            // Regenerate session
            $request->session()->regenerate();

            // --- INI LOGIKA PINTARNYA ---
            if ($user->role == 'warga') {
                return Redirect::route('warga.dashboard');

            } elseif ($user->role == 'admin') {
                return redirect()->route('admin.dashboard');

            } elseif ($user->role == 'kades') { // <--- TAMBAHKAN INI
                return redirect()->route('kades.dashboard');
                
            } elseif ($user->role == 'kadus') { // <--- TAMBAHKAN INI
                return redirect()->route('kadus.dashboard');
                
            } else {
                // Jika rolenya tidak jelas, tolak
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Role akun Anda tidak valid.',
                ])->onlyInput('username');
            }
        }

        // 4. Login gagal (username atau password salah)
        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    /**
     * Logout warga.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan ke halaman login warga
        return Redirect::route('warga.login.form');
    }

    /**
     * Menampilkan dashboard warga (setelah login).
     */
   public function dashboard()
    {
        $id_user_login = Auth::id();

        $warga = Warga::with('kk.dusun')
                      ->where('id_user', $id_user_login)
                      ->first();

        if (!$warga) {
            Auth::logout();
            return Redirect::route('warga.login.form')->withErrors(['username' => 'Akun belum terhubung data warga.']);
        }

        // --- TAMBAHAN BARU: AMBIL RIWAYAT AJUAN ---
        // Ambil semua ajuan milik warga ini, urutkan dari yang terbaru
        $riwayatAjuan = AjuanSurat::with('jenisSurat')
                                  ->where('id_warga', $warga->id_warga)
                                  ->orderBy('tanggal_ajuan', 'desc')
                                  ->take(3)
                                  ->get();

        // Kirim $riwayatAjuan ke view
        return view('citizen.dashboard', [
            'warga' => $warga,
            'riwayatAjuan' => $riwayatAjuan 
        ]);
    }
}