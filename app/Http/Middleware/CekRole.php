<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login?
        // Jika belum, tendang ke halaman login
        if (!Auth::check()) {
            return redirect()->route('warga.login.form');
        }

        // 2. Ambil data user yang sedang login
        $user = Auth::user();

        // 3. Cek apakah role user ada di dalam daftar yang diizinkan?
        // $roles dikirim dari route (contoh: 'admin', 'kades')
        if (in_array($user->role, $roles)) {
            return $next($request); // Silakan masuk
        }

        // 4. Jika Role SALAH (Misal: Warga coba akses halaman Admin),
        // Kembalikan mereka ke dashboard masing-masing yang benar.
        
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } 
        elseif ($user->role == 'kades') {
            return redirect()->route('kades.dashboard');
        }
        elseif ($user->role == 'kadus') {
            return redirect()->route('kadus.dashboard');
        }
        elseif ($user->role == 'warga') {
            return redirect()->route('warga.dashboard');
        }

        // Default fallback
        return abort(403, 'Unauthorized action.');
    }
}