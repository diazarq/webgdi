<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use App\Models\VolunteerProgram;
use App\Models\VolunteerRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PortalDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check()) {
                return redirect()->route('portal.login');
            }
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            if ($user->status_approval !== 'approved') {
                Auth::logout();
                return redirect()->route('portal.login')->withErrors([
                    'login' => 'Akun Anda belum disetujui oleh Admin.'
                ]);
            }
            return $next($request);
        });
    }

    /**
     * Dashboard Utama Portal (Daftar Program Relawan & Riwayat Aktivitas)
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedCategory = $request->query('category', 'all');
        $activeTab = $request->query('tab', session('active_tab', 'programs'));

        // Ambil daftar program aksi yang tersedia
        $programsQuery = VolunteerProgram::whereIn('status', ['open', 'active']);
        if ($selectedCategory && $selectedCategory !== 'all') {
            $programsQuery->where('category', $selectedCategory);
        }
        $programs = $programsQuery->withCount('registrations')->orderBy('created_at', 'desc')->get();

        // Ambil riwayat aktivitas relawan (program yang pernah/sedang diikuti user)
        $myRegistrations = VolunteerRegistration::where('user_id', $user->id)
            ->with('program')
            ->orderBy('created_at', 'desc')
            ->get();

        $registeredProgramIds = $myRegistrations->pluck('volunteer_program_id')->toArray();

        return view('portal.dashboard', [
            'pageTitle' => 'Dashboard Relawan Sahabat Baik',
            'user' => $user,
            'programs' => $programs,
            'myRegistrations' => $myRegistrations,
            'registeredProgramIds' => $registeredProgramIds,
            'selectedCategory' => $selectedCategory,
            'activeTab' => $activeTab,
            'totalJoined' => $myRegistrations->count(),
            'totalAvailable' => VolunteerProgram::whereIn('status', ['open', 'active'])->count(),
        ]);
    }

    /**
     * Halaman Detail Program Aksi Relawan (Persis Flow Donasi: /donasi/{slug})
     */
    public function programDetail($slug)
    {
        $user = Auth::user();
        $program = VolunteerProgram::where('slug', $slug)->withCount('registrations')->firstOrFail();

        $myRegistration = VolunteerRegistration::where('user_id', $user->id)
            ->where('volunteer_program_id', $program->id)
            ->first();

        $percent = min(100, round(($program->registrations_count / max(1, $program->quota)) * 100));

        return view('portal.program-detail', [
            'pageTitle' => $program->title . ' - Detail Program Relawan GDI',
            'user' => $user,
            'program' => $program,
            'myRegistration' => $myRegistration,
            'isRegistered' => (bool)$myRegistration,
            'percent' => $percent,
        ]);
    }

    /**
     * Halaman Formulir Pendaftaran Relawan (Persis Flow Donasi: /donasi/{slug}/form)
     */
    public function programForm($slug)
    {
        $user = Auth::user();
        $program = VolunteerProgram::where('slug', $slug)->withCount('registrations')->firstOrFail();

        $myRegistration = VolunteerRegistration::where('user_id', $user->id)
            ->where('volunteer_program_id', $program->id)
            ->first();

        if ($myRegistration) {
            return redirect()->route('portal.dashboard', ['tab' => 'riwayat'])
                ->with('info', 'Anda sudah terdaftar di program aksi "' . $program->title . '".');
        }

        $percent = min(100, round(($program->registrations_count / max(1, $program->quota)) * 100));

        return view('portal.program-form', [
            'pageTitle' => 'Formulir Pendaftaran Relawan - ' . $program->title,
            'user' => $user,
            'program' => $program,
            'percent' => $percent,
        ]);
    }

    /**
     * Proses Simpan Pendaftaran Relawan via Form (Persis Flow Donasi)
     */
    public function registerProgramBySlug(Request $request, $slug)
    {
        $user = Auth::user();
        $program = VolunteerProgram::where('slug', $slug)->firstOrFail();

        // Cek apakah relawan sudah pernah mendaftar di program ini
        $existing = VolunteerRegistration::where('user_id', $user->id)
            ->where('volunteer_program_id', $program->id)
            ->first();

        if ($existing) {
            return redirect()->route('portal.dashboard', ['tab' => 'riwayat'])
                ->with('warning', 'Anda sudah pernah terdaftar pada program aksi "' . $program->title . '".');
        }

        $request->validate([
            'skills' => ['required', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:500'],
            'phone' => ['required', 'string', 'max:30'],
            'domisili' => ['required', 'string', 'max:150'],
        ], [
            'skills.required' => 'Pilih salah satu peran / bidang keahlian yang Anda kontribusikan.',
            'phone.required' => 'Nomor WhatsApp aktif wajib diisi.',
            'domisili.required' => 'Kota domisili wajib diisi.',
        ]);

        $registration = VolunteerRegistration::create([
            'user_id' => $user->id,
            'volunteer_program_id' => $program->id,
            'name' => $user->name,
            'phone' => $request->phone,
            'domisili' => $request->domisili,
            'skills' => $request->skills,
            'notes' => $request->notes,
            'status' => 'terdaftar',
        ]);

        return redirect()->route('portal.dashboard', ['tab' => 'riwayat'])->with('pendaftaran_sukses', [
            'registration_id' => $registration->id,
            'program_title' => $program->title,
            'coordinator_name' => $program->coordinator_name,
            'message' => 'Alhamdulillah, pendaftaran Anda pada aksi "' . $program->title . '" berhasil! Silakan langsung bergabung ke Grup WhatsApp Koordinasi di bawah ini.',
        ]);
    }

    /**
     * Teruskan data & arahkan ke WhatsApp grup koordinasi koordinator
     */
    public function joinCoordinationGroup($id)
    {
        $user = Auth::user();
        $registration = VolunteerRegistration::where('user_id', $user->id)
            ->where('id', $id)
            ->with('program')
            ->firstOrFail();

        $registration->update([
            'status' => 'bergabung_grup',
            'joined_group_at' => now(),
        ]);

        $program = $registration->program;

        // Jika ada link grup WhatsApp resmi, utamakan link grup
        if ($program && !empty($program->whatsapp_group_link)) {
            return redirect()->away($program->whatsapp_group_link);
        }

        // Fallback: kirim pesan pembuka langsung ke WhatsApp koordinator lapangan
        $phone = $program->coordinator_phone ?? '6282119998877';
        $message = "Halo {$program->coordinator_name}, saya {$registration->name} ({$registration->phone}) dari domisili {$registration->domisili}.\n\nSaya telah mendaftar sebagai relawan pada program: *{$program->title}* (Bidang: {$registration->skills}).\nMohon izin bergabung ke dalam grup koordinasi relawan. Terima kasih!";

        return redirect()->away("https://wa.me/{$phone}?text=" . urlencode($message));
    }

    /**
     * Halaman daftar berita milik relawan / mitra
     */
    public function beritaIndex(Request $request)
    {
        $user = Auth::user();
        $status = $request->query('status', 'all');

        $query = Blog::where('user_id', $user->id);

        if ($status === 'draft') {
            $query->where('status', 'draft');
        } elseif ($status === 'publish') {
            $query->where('status', 'publish');
        } elseif ($status === 'bin') {
            $query = Blog::onlyTrashed()->where('user_id', $user->id);
        }

        $blogs = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('portal.berita-index', [
            'pageTitle' => 'Kelola Berita & Liputan Kegiatan',
            'blogs' => $blogs,
            'currentStatus' => $status,
            'countDraft' => Blog::where('user_id', $user->id)->where('status', 'draft')->count(),
            'countPublish' => Blog::where('user_id', $user->id)->where('status', 'publish')->count(),
            'countBin' => Blog::onlyTrashed()->where('user_id', $user->id)->count(),
        ]);
    }

    /**
     * Form tambah berita / liputan baru
     */
    public function beritaCreate()
    {
        $kategoriList = Blog::select('kategori')->whereNotNull('kategori')->distinct()->pluck('kategori');

        return view('portal.berita-form', [
            'pageTitle' => 'Tulis Berita / Liputan Kegiatan Baru',
            'mode' => 'tambah',
            'detail' => null,
            'kategoriList' => $kategoriList
        ]);
    }

    /**
     * Simpan berita baru (otomatis status draft)
     */
    public function beritaStore(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string'],
            'content' => ['required', 'string'],
            'featured_img' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'title.required' => 'Judul berita / liputan wajib diisi.',
            'kategori.required' => 'Pilih atau isi kategori berita.',
            'content.required' => 'Isi berita / liputan kegiatan tidak boleh kosong.',
            'featured_img.required' => 'Foto kegiatan / featured image wajib diunggah.',
            'featured_img.image' => 'File harus berupa gambar.',
            'featured_img.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        $user = Auth::user();

        // Handle Image Upload
        $pathImg = null;
        if ($request->hasFile('featured_img')) {
            $file = $request->file('featured_img');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $pathImg = $file->move('images/blog', $filename)->getPathname();
            $pathImg = str_replace('\\', '/', $pathImg);
        }

        // Generate clean unique slug
        $baseSlug = Str::slug($request->title);
        $slug = $baseSlug;
        $counter = 1;
        while (Blog::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $kategori = $request->kategori_baru ? trim($request->kategori_baru) : $request->kategori;

        Blog::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'slug' => $slug,
            'page_type' => 'page',
            'kategori' => $kategori,
            'featured_img' => $pathImg,
            'content' => $request->content,
            'status' => 'draft', // Selalu draft! Wajib di-review Admin
            'author' => $user->name . ' (' . ($user->isVolunteer() ? 'Sahabat Baik' : 'Mitra GDI') . ')',
            'hashtag' => $request->hashtag,
        ]);

        return redirect()->route('portal.berita.index')->with('success', 'Berita berhasil disimpan sebagai DRAFT. Admin Graha Dhuafa Indonesia akan mengevaluasi liputan ini sebelum dipublikasikan ke website publik.');
    }

    /**
     * Form edit berita (hanya jika masih draft)
     */
    public function beritaEdit($id)
    {
        $user = Auth::user();
        $detail = Blog::where('user_id', $user->id)->where('id', $id)->firstOrFail();

        if ($detail->status === 'publish') {
            return redirect()->route('portal.berita.index')->with('warning', 'Berita yang sudah dipublikasikan tidak dapat diubah langsung. Hubungi admin jika membutuhkan revisi.');
        }

        $kategoriList = Blog::select('kategori')->whereNotNull('kategori')->distinct()->pluck('kategori');

        return view('portal.berita-form', [
            'pageTitle' => 'Edit Berita / Liputan Kegiatan',
            'mode' => 'edit',
            'detail' => $detail,
            'kategoriList' => $kategoriList
        ]);
    }

    /**
     * Update berita
     */
    public function beritaUpdate(Request $request, $id)
    {
        $user = Auth::user();
        $blog = Blog::where('user_id', $user->id)->where('id', $id)->firstOrFail();

        if ($blog->status === 'publish') {
            return redirect()->route('portal.berita.index')->with('warning', 'Berita yang sudah publish tidak dapat diubah.');
        }

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string'],
            'content' => ['required', 'string'],
            'featured_img' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $dataInput = [
            'title' => $request->title,
            'kategori' => $request->kategori_baru ? trim($request->kategori_baru) : $request->kategori,
            'content' => $request->content,
            'hashtag' => $request->hashtag,
            'status' => 'draft', // Tetap draft setelah diupdate
        ];

        if ($request->hasFile('featured_img')) {
            $file = $request->file('featured_img');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $pathImg = $file->move('images/blog', $filename)->getPathname();
            $dataInput['featured_img'] = str_replace('\\', '/', $pathImg);
        }

        $blog->update($dataInput);

        return redirect()->route('portal.berita.index')->with('success', 'Berita draft berhasil diperbarui dan menunggu evaluasi Admin.');
    }

    /**
     * Profil User
     */
    public function profile()
    {
        return view('portal.profile', [
            'pageTitle' => 'Profil Sahabat Baik & Mitra',
            'user' => Auth::user()
        ]);
    }

    /**
     * Update Profil & Password
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'domisili' => ['required', 'string', 'max:150'],
            'organisasi' => ['nullable', 'string'],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'min:6', 'confirmed'];
        }

        $request->validate($rules);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->domisili = $request->domisili;
        if ($request->has('organisasi')) {
            $user->organisasi = $request->organisasi;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil dan informasi akun berhasil diperbarui!');
    }
}

