<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogFrontController extends Controller
{
    public function index(Request $request, $kategori = null, $jenis = null)
    {
        $query = Blog::where('status', 'publish');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        // Filter kategori
        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $jenisFilter = $jenis ?: ($request->query('jenis') ?: $request->route('jenis'));
        $jenisLabel = null;

        if ($jenisFilter) {
            $jenisLower = strtolower(trim($jenisFilter));
            if (in_array($jenisLower, ['laznews', 'kegiatan', 'news', 'berita'])) {
                $query->where(function($q) {
                    $q->whereIn('jenis', ['laznews', 'kegiatan', 'news', 'berita'])
                      ->orWhere('kategori', 'like', '%news%')
                      ->orWhere('kategori', 'like', '%kegiatan%');
                });
                $jenisLabel = 'LAZNews';
            } elseif (in_array($jenisLower, ['lazjourney', 'journey'])) {
                $query->where(function($q) {
                    $q->whereIn('jenis', ['lazjourney', 'journey'])
                      ->orWhere('kategori', 'like', '%journey%');
                });
                $jenisLabel = 'LAZJourney';
            } elseif (in_array($jenisLower, ['lazsalam', 'salam', 'edukasi'])) {
                $query->where(function($q) {
                    $q->whereIn('jenis', ['lazsalam', 'salam', 'edukasi'])
                      ->orWhere('kategori', 'like', '%salam%');
                });
                $jenisLabel = 'LAZSalam';
            } else {
                $query->where('jenis', $jenisFilter);
                $jenisLabel = ucfirst($jenisFilter);
            }
        }

        // Ambil data blog dengan pagination
        $blog = $query->orderBy('date_publish', 'desc')->paginate(9);

        // Featured Hero Blogs for magazine showcase slider (ambil 4 berita terbaru berstatus publish)
        $heroBlogs = Blog::where('status', 'publish')
            ->orderBy('date_publish', 'desc')
            ->take(4)
            ->get();

        // Sidebar data
        $blogRealisasi = Blog::where('status', 'publish')
            ->where('kategori', 'Berita Realisasi')
            ->orderBy('date_publish', 'desc')
            ->take(5)
            ->get();

        $blogDewanSyariah = Blog::where('status', 'publish')
            ->where('kategori', 'Salam Dewan Syariah')
            ->orderBy('date_publish', 'desc')
            ->take(5)
            ->get();

        $blogLatest = Blog::where('status', 'publish')
            ->orderBy('date_publish', 'desc')
            ->take(5)
            ->get();

        $category = Blog::select('kategori')
            ->selectRaw('COUNT(*) as total')
            ->where('status', 'publish')
            ->groupBy('kategori')
            ->get();

        $totalAllPosts = Blog::where('status', 'publish')->count();

        // Untuk LAZNews, LAZJourney, LAZSalam gunakan tampilan page-blog-lazjourney (gaya editorial Folkative)
        if ($jenisFilter) {
            $pageTitle = $jenisLabel ?: 'Blog & Berita';
            $viewName = in_array($jenisLabel, ['LAZNews', 'LAZJourney', 'LAZSalam'])
                ? 'website.page-blog-lazjourney'
                : 'website.page-blog';

            return view($viewName, [
                'pageTitle' => $pageTitle,
                'blog' => $blog,
                'heroBlogs' => $heroBlogs,
                'blogRealisasi' => $blogRealisasi,
                'blogDewanSyariah' => $blogDewanSyariah,
                'blogLatest' => $blogLatest,
                'category' => $category,
                'totalAllPosts' => $totalAllPosts,
                'categoryKey' => $kategori,
                'jenisKey' => $jenisFilter,
                'jenisLabel' => $jenisLabel,
                'parent' => 'KabarLAZ',
                'detail' => null,
            ]);
        }

        // Untuk halaman general KabarLAZ (/blog atau /blog/category/...) gunakan tampilan baru page-kabarlaz
        $featuredBlog = Blog::where('status', 'publish')->orderBy('date_publish', 'desc')->first();
        $rubricCounts = [
            'laznews' => Blog::where('status', 'publish')->where(function ($q) {
                $q->whereIn('jenis', ['laznews', 'kegiatan', 'news', 'berita'])
                  ->orWhere('kategori', 'like', '%news%')
                  ->orWhere('kategori', 'like', '%kegiatan%');
            })->count(),
            'lazjourney' => Blog::where('status', 'publish')->where(function ($q) {
                $q->whereIn('jenis', ['lazjourney', 'journey'])
                  ->orWhere('kategori', 'like', '%journey%');
            })->count(),
            'lazsalam' => Blog::where('status', 'publish')->where(function ($q) {
                $q->whereIn('jenis', ['lazsalam', 'salam', 'edukasi'])
                  ->orWhere('kategori', 'like', '%salam%');
            })->count(),
        ];

        $pageTitle = $jenisLabel ?: ($kategori ?: 'KabarLAZ');

        $viewName = 'website.page-blog';
        if (in_array($jenisLabel, ['LAZNews', 'LAZJourney', 'LAZSalam'])) {
            $viewName = 'website.page-blog-lazjourney';
        }

        return view($viewName, [
            'pageTitle' => $pageTitle,
            'blog' => $blog,
            'featuredBlog' => $featuredBlog,
            'blogLatest' => $blogLatest,
            'category' => $category,
            'totalAllPosts' => $totalAllPosts,
            'rubricCounts' => $rubricCounts,
            'categoryKey' => $kategori,
            'jenisLabel' => $jenisLabel,
            'detail' => null,
        ]);
    }

    public function byJenis(Request $request, $jenis)
    {
        return $this->index($request, null, $jenis);
    }

    public function detail($slug)
    {
        return $this->show($slug);
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 'publish')
            ->firstOrFail();

        // Sidebar Data
        $blogRealisasi = Blog::where('status', 'publish')
            ->where('kategori', 'Berita Realisasi')
            ->orderBy('date_publish', 'desc')
            ->take(5)
            ->get();

        $blogDewanSyariah = Blog::where('status', 'publish')
            ->where('kategori', 'Salam Dewan Syariah')
            ->orderBy('date_publish', 'desc')
            ->take(5)
            ->get();

        $blogLatest = Blog::where('status', 'publish')
            ->orderBy('date_publish', 'desc')
            ->take(5)
            ->get();

        $category = Blog::select('kategori')
            ->selectRaw('COUNT(*) as total')
            ->where('status', 'publish')
            ->groupBy('kategori')
            ->get();

        $totalAllPosts = Blog::where('status', 'publish')->count();

        return view('website.page-blog-detail', [
            'pageTitle' => $blog->title,
            'blog' => $blog,
            'blogRealisasi' => $blogRealisasi,
            'blogDewanSyariah' => $blogDewanSyariah,
            'blogLatest' => $blogLatest,
            'category' => $category,
            'totalAllPosts' => $totalAllPosts,
            'categoryKey' => null,
            'parent' => 'Blog',
            'detail' => $blog,
        ]);
    }
}
