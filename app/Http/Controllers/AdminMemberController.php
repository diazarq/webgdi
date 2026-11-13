<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMemberController extends Controller
{
    /**
     * Tampilkan data relawan (Sahabat Baik) & mitra (Affiliate)
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending'); // Default tab ke pending agar mudah review
        $role = $request->query('role', 'all');

        $query = User::whereIn('role_type', ['volunteer', 'affiliate']);

        if ($status !== 'all') {
            $query->where('status_approval', $status);
        }

        if ($role !== 'all') {
            $query->where('role_type', $role);
        }

        $members = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistik Counter
        $countPending = User::whereIn('role_type', ['volunteer', 'affiliate'])->where('status_approval', 'pending')->count();
        $countApproved = User::whereIn('role_type', ['volunteer', 'affiliate'])->where('status_approval', 'approved')->count();
        $countRejected = User::whereIn('role_type', ['volunteer', 'affiliate'])->where('status_approval', 'rejected')->count();
        $countVolunteer = User::where('role_type', 'volunteer')->count();
        $countAffiliate = User::where('role_type', 'affiliate')->count();

        return view('admin.members.index', [
            'pageTitle' => 'Persetujuan Relawan & Mitra (Amil Zakat)',
            'active' => ['MemberActive' => 'active'],
            'members' => $members,
            'currentStatus' => $status,
            'currentRole' => $role,
            'countPending' => $countPending,
            'countApproved' => $countApproved,
            'countRejected' => $countRejected,
            'countVolunteer' => $countVolunteer,
            'countAffiliate' => $countAffiliate,
        ]);
    }

    /**
     * Setujui / ACC Pendaftaran Relawan / Mitra
     */
    public function approve($id)
    {
        $user = User::whereIn('role_type', ['volunteer', 'affiliate'])->findOrFail($id);

        $user->status_approval = 'approved';
        $user->status = 'A'; // Aktifkan akun
        $user->approved_at = now();
        $user->rejection_note = null;
        $user->save();

        return back()->with('success', 'Akun ' . $user->name . ' (' . ucfirst($user->role_type) . ') BERHASIL DISETUJUI / DI-ACC. Pengguna sekarang dapat login di /z/login.');
    }

    /**
     * Tolak Pendaftaran Relawan / Mitra
     */
    public function reject(Request $request, $id)
    {
        $user = User::whereIn('role_type', ['volunteer', 'affiliate'])->findOrFail($id);

        $user->status_approval = 'rejected';
        $user->status = 'NA';
        $user->rejection_note = $request->input('rejection_note', 'Belum memenuhi kriteria.');
        $user->save();

        return back()->with('warning', 'Pendaftaran akun ' . $user->name . ' telah DITOLAK.');
    }

    /**
     * Hapus Pendaftaran (jika spam)
     */
    public function delete($id)
    {
        $user = User::whereIn('role_type', ['volunteer', 'affiliate'])->findOrFail($id);
        $user->delete();

        return back()->with('info', 'Data pendaftar berhasil dihapus.');
    }
}

