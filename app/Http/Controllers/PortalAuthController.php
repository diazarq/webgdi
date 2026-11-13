<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PortalAuthController extends Controller
{
    /**
     * Tampilkan form login portal relawan & mitra (/z/login)
     */
    public function showLogin()
    {
        // Tampilkan halaman z/login tanpa auto-redirect paksa ke admin dashboard
        return view('portal.login', [
            'pageTitle' => 'Login Portal Sahabat Baik & Mitra'
        ]);
    }

    /**
     * Proses autentikasi portal (/z/login)
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Username atau Email wajib diisi.',
            'password.required' => 'Password wajib diisi.'
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Cek jika akun adalah Administrator: DILARANG login di /z/login!
            if ($user->isAdmin()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withInput()->withErrors([
                    'login' => 'Akun Administrator tidak dapat login di Portal Relawan & Mitra. Silakan login admin melalui /q/login'
                ]);
            }

            // Cek jika akun masih pending verifikasi admin
            if ($user->status_approval === 'pending') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withInput()->with('pending_notice', [
                    'title' => 'Akun Sedang Diverifikasi',
                    'message' => 'Pendaftaran akun Anda atas nama <strong>' . e($user->name) . '</strong> masih dalam proses review oleh Admin Graha Dhuafa Indonesia. Anda akan dihubungi melalui WhatsApp setelah akun disetujui.'
                ]);
            }

            // Cek jika akun ditolak
            if ($user->status_approval === 'rejected') {
                $note = $user->rejection_note ?: 'Data pendaftaran belum memenuhi kriteria kualifikasi relawan/mitra.';
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withInput()->withErrors([
                    'login' => 'Pendaftaran akun Anda ditolak oleh Admin. Catatan: ' . $note
                ]);
            }

            // Cek jika akun nonaktif
            if ($user->status === 'NA') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withInput()->withErrors([
                    'login' => 'Akun Anda saat ini sedang dinonaktifkan. Silakan hubungi admin GDI.'
                ]);
            }

            // Sukses Login
            $request->session()->regenerate();
            $user->last_login = now();
            $user->save();

            return redirect()->route('portal.dashboard');
        }

        return back()->withInput()->withErrors([
            'login' => 'Kombinasi Username/Email dan Password tidak cocok.'
        ]);
    }

    /**
     * Tampilkan form pendaftaran relawan "Sahabat Baik"
     */
    public function showRegisterVolunteer()
    {
        return view('portal.register-volunteer', [
            'pageTitle' => 'Pendaftaran Relawan Sahabat Baik GDI'
        ]);
    }

    /**
     * Proses simpan pendaftaran relawan "Sahabat Baik"
     */
    public function storeRegisterVolunteer(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username'],
            'phone' => ['required', 'string', 'max:30'],
            'volunteer_type' => ['required', 'string'],
            'organisasi' => ['required', 'string'],
            'domisili' => ['required', 'string', 'max:150'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar. Silakan gunakan email lain atau login.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan, pilih username lain.',
            'username.alpha_dash' => 'Username hanya boleh huruf, angka, dash (-) dan underscore (_).',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'volunteer_type.required' => 'Pilih bidang relawan yang diminati.',
            'organisasi.required' => 'Pengalaman organisasi / keahlian wajib diceritakan.',
            'domisili.required' => 'Kota domisili wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'level' => 2,
            'role_type' => 'volunteer',
            'volunteer_type' => $request->volunteer_type,
            'organisasi' => $request->organisasi,
            'domisili' => $request->domisili,
            'status' => 'NA', // Belum aktif sebelum di-ACC
            'status_approval' => 'pending',
        ]);

        return redirect()->route('portal.login')->with('registered_success', [
            'name' => $request->name,
            'type' => 'Relawan Sahabat Baik',
            'message' => 'Pendaftaran relawan berhasil! Data Anda telah dikirim ke Admin Graha Dhuafa Indonesia untuk tahap verifikasi. Setelah disetujui, Anda dapat login di halaman ini.'
        ]);
    }

    /**
     * Tampilkan form pendaftaran mitra / affiliate / amil zakat
     */
    public function showRegisterAffiliate()
    {
        return view('portal.register-affiliate', [
            'pageTitle' => 'Pendaftaran Kemitraan & Amil Zakat GDI'
        ]);
    }

    /**
     * Proses simpan pendaftaran mitra / affiliate / amil zakat
     */
    public function storeRegisterAffiliate(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'instansi' => ['required', 'string', 'max:200'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username'],
            'phone' => ['required', 'string', 'max:30'],
            'domisili' => ['required', 'string', 'max:150'],
            'organisasi' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap / PIC wajib diisi.',
            'instansi.required' => 'Nama lembaga / instansi / komunitas wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan, pilih username lain.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'domisili.required' => 'Kota domisili wajib diisi.',
            'organisasi.required' => 'Rencana kegiatan kemitraan / profil ringkas wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $request->name,
            'instansi' => $request->instansi,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'level' => 3,
            'role_type' => 'affiliate',
            'organisasi' => $request->organisasi,
            'domisili' => $request->domisili,
            'status' => 'NA',
            'status_approval' => 'pending',
        ]);

        return redirect()->route('portal.login')->with('registered_success', [
            'name' => $request->name,
            'type' => 'Mitra / Affiliate (Amil Zakat)',
            'message' => 'Pendaftaran mitra berhasil! Tim GDI akan meninjau pengajuan kemitraan Anda. Anda akan menerima konfirmasi via WhatsApp/Email setelah akun disetujui.'
        ]);
    }

    /**
     * Logout portal
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('portal.login');
    }
}

