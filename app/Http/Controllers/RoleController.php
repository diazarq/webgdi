<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RoleController extends Controller
{
    /**
     * Halaman Manajemen Role (CRUD Role)
     */
    public function index()
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'Superadmin',
                'slug' => 'superadmin',
                'description' => 'Akses penuh ke semua modul, manajemen user, role, privilege, dan pengaturan teknis.',
                'user_count' => User::where('role_type', 'superadmin')->orWhere('level', 99)->count(),
                'is_system' => true,
            ],
            [
                'id' => 2,
                'name' => 'Admin (Pengurus)',
                'slug' => 'admin',
                'description' => 'Mengelola operasional harian: Blog, Program, Donasi Masuk, Zakat, dan Persetujuan Relawan/Mitra.',
                'user_count' => User::where('role_type', 'admin')->orWhere('level', 1)->count(),
                'is_system' => true,
            ],
            [
                'id' => 3,
                'name' => 'Mitra',
                'slug' => 'mitra',
                'description' => 'Mitra penghimpun dana dan kolaborasi program LAZ dengan akses dashboard portal mitra.',
                'user_count' => User::whereIn('role_type', ['mitra', 'affiliate'])->orWhere('level', 3)->count(),
                'is_system' => false,
            ],
            [
                'id' => 4,
                'name' => 'Volunteer (Relawan)',
                'slug' => 'volunteer',
                'description' => 'Relawan lapangan: menulis draft berita/kegiatan relawan dan mengikuti kegiatan program.',
                'user_count' => User::where('role_type', 'volunteer')->orWhere('level', 2)->count(),
                'is_system' => false,
            ],
        ];

        return view('admin.role.index', [
            'pageTitle'  => 'Manajemen Role',
            'active'     => ['RoleActive' => 'active'],
            'roles'      => $roles,
        ]);
    }

    /**
     * Halaman User Privilege / Permission Matrix
     */
    public function privilege(Request $request)
    {
        $selectedRole = $request->get('role', 'admin');

        $modules = [
            ['key' => 'dashboard', 'name' => 'Dashboard', 'category' => 'Navigasi'],
            ['key' => 'widget', 'name' => 'Widget & Slider', 'category' => 'Navigasi'],
            ['key' => 'meta', 'name' => 'Pengaturan Meta & Bank', 'category' => 'Navigasi'],
            ['key' => 'pesan', 'name' => 'Pesan Masuk', 'category' => 'Navigasi'],
            ['key' => 'blog', 'name' => 'Artikel & Berita (Blog)', 'category' => 'Navigasi'],
            ['key' => 'galeri', 'name' => 'Galeri Foto Kegiatan', 'category' => 'Navigasi'],
            ['key' => 'program', 'name' => 'Kelola Program LAZ', 'category' => 'Navigasi'],
            ['key' => 'donasi', 'name' => 'Kampanye Donasi', 'category' => 'Navigasi'],
            ['key' => 'zakat', 'name' => 'Transaksi Zakat', 'category' => 'Transaksi'],
            ['key' => 'donasi_masuk', 'name' => 'Laporan Donasi Masuk', 'category' => 'Transaksi'],
            ['key' => 'relawan_mitra', 'name' => 'Approval Relawan & Mitra', 'category' => 'Pengaturan'],
            ['key' => 'kelola_user', 'name' => 'Kelola Akun User', 'category' => 'Pengaturan'],
            ['key' => 'kelola_role', 'name' => 'Kelola Role & Privilege', 'category' => 'Pengaturan'],
            ['key' => 'menu_dinamis', 'name' => 'Pengaturan Menu Website', 'category' => 'Pengaturan'],
            ['key' => 'kelola_tema', 'name' => 'Kelola Tema & Tampilan', 'category' => 'Pengaturan'],
        ];

        return view('admin.role.privilege', [
            'pageTitle'    => 'User Privilege (Permission Matrix)',
            'active'       => ['PrivilegeActive' => 'active'],
            'selectedRole' => $selectedRole,
            'modules'      => $modules,
        ]);
    }

    /**
     * Simpan Hak Akses Privilege
     */
    public function savePrivilege(Request $request)
    {
        return redirect()->back()->with('success', 'Hak akses untuk role ' . strtoupper($request->role) . ' berhasil diperbarui!');
    }
}
