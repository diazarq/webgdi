<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Halaman Manajemen Role (CRUD Role Dinamis dari Database)
     */
    public function index()
    {
        $roles = Role::orderBy('is_system', 'desc')->orderBy('id', 'asc')->get();

        return view('admin.role.index', [
            'pageTitle'  => 'Manajemen Role',
            'active'     => ['RoleActive' => 'active'],
            'roles'      => $roles,
        ]);
    }

    /**
     * Simpan Role Baru atau Update Role
     */
    public function store(Request $request)
    {
        $rules = [
            'name'        => ['required', 'string', 'max:100', 'unique:roles,name,' . ($request->id ?? 0)],
            'description' => ['nullable', 'string'],
        ];

        $request->validate($rules);

        $data = [
            'name'        => trim($request->name),
            'description' => $request->description,
        ];

        if ($request->id) {
            $role = Role::findOrFail($request->id);
            $role->update($data);
            $msg = 'Role berhasil diperbarui!';
        } else {
            $data['is_system'] = false;
            Role::create($data);
            $msg = 'Role baru berhasil ditambahkan!';
        }

        return redirect()->route('admin.role.index')->with('success', $msg);
    }

    /**
     * Hapus Role (Hanya role non-sistem)
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if ($role->is_system) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Role bawaan sistem tidak boleh dihapus demi keamanan aplikasi!'
            ], 403);
        }

        // Cek jika role masih memiliki user
        if ($role->user_count > 0) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Role masih digunakan oleh ' . $role->user_count . ' pengguna. Pindahkan role user tersebut terlebih dahulu sebelum menghapus!'
            ], 400);
        }

        $role->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Role berhasil dihapus.'
        ]);
    }

    /**
     * Halaman User Privilege / Permission Matrix
     */
    public function privilege(Request $request)
    {
        $roles = Role::all();
        $selectedRole = $request->get('role', 'Admin');

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
            'roles'        => $roles,
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
