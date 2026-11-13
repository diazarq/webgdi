<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
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
     * Dashboard Utama Portal
     */
    public function index()
    {
        $user = Auth::user();

        $totalBerita = Blog::where('user_id', $user->id)->count();
        $totalPublish = Blog::where('user_id', $user->id)->where('status', 'publish')->count();
        $totalDraft = Blog::where('user_id', $user->id)->where('status', 'draft')->count();
        $totalBin = Blog::onlyTrashed()->where('user_id', $user->id)->count();

        $recentBlogs = Blog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('portal.dashboard', [
            'pageTitle' => 'Dashboard Sahabat Baik & Mitra',
            'user' => $user,
            'totalBerita' => $totalBerita,
            'totalPublish' => $totalPublish,
            'totalDraft' => $totalDraft,
            'totalBin' => $totalBin,
            'recentBlogs' => $recentBlogs,
        ]);
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

