<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * 
     * @param  string[]  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/q/login');
        }

        $user = Auth::user();

        // Jika status akun Nonaktif
        if ($user->status !== 'A') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/q/login')->withErrors([
                'error' => 'Akun Anda berstatus non-aktif. Silakan hubungi Administrator.',
            ]);
        }

        // Superadmin memiliki akses ke semua halaman admin
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Normalisasi role yang diizinkan menjadi lowercase
        $allowedRoles = array_map('strtolower', $roles);
        $userRole = strtolower($user->role_type ?? '');

        // Khusus Admin lama dengan level = 1
        if ($user->isAdmin() && in_array('admin', $allowedRoles)) {
            return $next($request);
        }

        // Cek apakah role user ada di daftar role yang diizinkan
        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
