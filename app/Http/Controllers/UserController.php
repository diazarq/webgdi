<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class UserController extends Controller
{
    protected function getRoles()
    {
        try {
            $dbRoles = Role::pluck('name', 'name')->toArray();
            if (!empty($dbRoles)) {
                return $dbRoles;
            }
        } catch (\Exception $e) {}

        return [
            'superadmin' => 'Superadmin',
            'admin'      => 'Admin',
            'mitra'      => 'Mitra',
            'volunteer'  => 'Volunteer',
        ];
    }

    public function __construct()
    {
    }

    public function index()
    {
        return view('user.list-user', [
            'pageTitle' => 'Kelola User',
            'active'    => ['UserActive' => 'active'],
            'roles'     => $this->getRoles(),
        ]);
    }

    public function table()
    {
        return DataTables::eloquent(User::query())
            ->addIndexColumn()
            ->addColumn('role_badge', function(User $user) {
                $role = $user->role_type;
                if (!$role) {
                    $role = $user->level == 1 ? 'Admin' : ($user->level == 2 ? 'Volunteer' : 'User');
                }

                return ucfirst($role);
            })
            ->addColumn('status_badge', function(User $user) {
                if ($user->status === 'A') {
                    return '<span class="badge bg-success rounded-pill p-2">Aktif</span>';
                }
                return '<span class="badge bg-danger p-2 rounded-pill">Nonaktif</span>';
            })
            ->addColumn('created_date', function(User $user) {
                return $user->created_at ? $user->created_at->format('d M Y') : '-';
            })
            ->addColumn('action', function(User $table) {
                $button = '<a href="/admin/user/'.$table->id.'/edit" class="btn btn-sm btn-warning text-white me-1"><i class="bi-pencil-square"></i> Edit</a>';
                
                // Superadmin tidak boleh menghapus dirinya sendiri
                if (Auth::id() != $table->id) {
                    $button .= '<button type="button" class="btn btn-sm btn-danger btn-del" data-id="'.$table->id.'"><i class="bi-trash"></i> Hapus</button>';
                }
                return $button;
            })
            ->rawColumns(['role_badge', 'status_badge', 'action'])
            ->make(true);
    }

    public function delete($id)
    {
        // Proteksi: Hanya Superadmin yang boleh menghapus user
        if (!Auth::user()->isSuperAdmin()) {
            return response()->json(['status' => 'error', 'message' => 'Hanya Superadmin yang berhak menghapus user!'], 403);
        }

        if (Auth::id() == $id) {
            return response()->json(['status' => 'error', 'message' => 'Anda tidak dapat menghapus akun Anda sendiri!'], 400);
        }

        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan.'], 404);
    }

    public function form($id = null)
    {
        $detail = null;
        if ($id) {
            $mode = 'Ubah Data';
            $detail = User::find($id);
        } else {
            $mode = 'Tambah';
        }

        return view('user.form-user', [
            'pageTitle' => $mode . ' User',
            'active'    => ['UserActive' => 'active'],
            'mode'      => $mode,
            'detail'    => $detail,
            'roles'     => $this->getRoles(),
        ]);
    }

    public function store(Request $req)
    {
        $currentUser = Auth::user();

        // Validasi input
        $rules = [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:users,email,' . ($req->id ?? 0)],
            'role_type' => ['required', 'string'],
            'status'    => ['required', 'in:A,NA'],
        ];

        // Password wajib jika tambah user baru
        if (!$req->id) {
            $rules['password'] = ['required', 'min:6'];
        } else {
            if ($req->filled('password')) {
                $rules['password'] = ['min:6'];
            }
        }

        $req->validate($rules);

        // Proteksi: Hanya Superadmin yang boleh mengangkat role Admin atau Superadmin
        if (in_array(strtolower($req->role_type), ['superadmin', 'admin']) && !$currentUser->isSuperAdmin()) {
            abort(403, 'Hanya Superadmin yang memiliki wewenang untuk menetapkan role Admin / Superadmin.');
        }

        // Mapping level berdasarkan role_type
        $levelMap = [
            'superadmin' => 99,
            'admin'      => 1,
            'volunteer'  => 2,
            'mitra'      => 3,
            'affiliate'  => 3,
        ];

        $level = $levelMap[strtolower($req->role_type)] ?? 2;

        $dataInput = [
            'name'            => $req->name,
            'username'        => $req->username ?: explode('@', $req->email)[0],
            'email'           => $req->email,
            'role_type'       => strtolower($req->role_type),
            'level'           => $level,
            'status'          => $req->status,
            'status_approval' => 'approved',
        ];

        if ($req->filled('password')) {
            $dataInput['password'] = Hash::make($req->password);
        }

        if ($req->id) {
            User::where('id', $req->id)->update($dataInput);
        } else {
            User::create($dataInput);
        }

        return redirect('/admin/user')->with('success', 'Data user berhasil disimpan!');
    }

    public function detail()
    {
        return view('user.detail-user', [
            'pageTitle' => 'Profil Anda',
            'active'    => ['ProfileActive' => 'active'],
            'detail'    => Auth::user(),
        ]);
    }
}
