<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogFrontController extends Controller
{
    public function index(Request $request, $kategori = null)
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

        // Ambil data blog dengan pagination
        $blog = $query->orderBy('date_publish', 'desc')->paginate(9);

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

        return view('website.page-blog', [
            'pageTitle' => $kategori ? 'Blog - ' . $kategori : 'Blog',
            'blog' => $blog,
            'blogRealisasi' => $blogRealisasi,
            'blogDewanSyariah' => $blogDewanSyariah,
            'blogLatest' => $blogLatest,
            'category' => $category,
            'totalAllPosts' => $totalAllPosts,
            'categoryKey' => $kategori,
            'parent' => $kategori ? 'Blog' : null,
            'detail' => null,
        ]);
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
