<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function __construct(){}

    public function index(){
        return view('blog.list-blog',[
            'pageTitle' => 'Blog',
            'active' => ['BlogActive' => 'active']
        ]);
    }

    public function table(Request $request){
        $query = Blog::query();

        if ($request->has('filter_status')) {
            if ($request->filter_status === 'draft') {
                $query->where('status', 'draft');
            } elseif ($request->filter_status === 'publish') {
                $query->where('status', 'publish');
            } elseif ($request->filter_status === 'mitra_volunteer') {
                $query->whereNotNull('user_id');
            }
        }

        return DataTables::eloquent($query->orderBy('created_at', 'desc'))
            ->addIndexColumn()
            ->addColumn('action', function(Blog $table){
                $button = '<div class="btn-group btn-group-sm" role="group">';
                
                if($table->status === 'draft'){
                    $button .= '<a href="/admin/blog/'.$table->id.'/publish" class="btn btn-sm btn-success" title="ACC / Publikasikan"><i class="bi-check2-circle"></i> ACC</a>';
                }
                
                $button .= '<a href="/admin/blog/'.$table->id.'/edit" class="btn btn-sm btn-primary" title="Edit"><i class="bi-pencil-square"></i></a> 
                    <button type="button" class="btn btn-sm btn-danger btn-del" data-id="'.$table->id.'" title="Hapus / Masukkan ke Bin"><i class="bi-trash"></i></button>';
                
                $button .= '</div>';
                return $button;
            })
            ->make();
    }

    public function publish($id){
        $blog = Blog::findOrFail($id);
        $blog->status = 'publish';
        $blog->date_publish = now();
        $blog->user_verify = auth()->user() ? auth()->user()->name : 'Admin GDI';
        $blog->save();

        return redirect('/admin/blog')->with('success', 'Berita berhasil di-ACC dan dipublikasikan!');
    }

    public function delete($id){
        $blog = Blog::find($id);
        $blog->delete();
    }

    public function form($id=null){
        $detail = [];
        $category = Blog::select('kategori')->distinct()->get();
        if($id){
            $mode = 'Ubah Data';
            $detail = Blog::find($id);
        }else{
            $mode = 'Tambah';
        }
        
        return view('blog.form-blog', [
            'pageTitle' => $mode.' Blog',
            'active' => ['BlogActive' => 'active'],
            'mode' => $mode,
            'detail' => $detail,
            'category' => $category
        ]);
    }

    public function store(Request $req){
        $req->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'featured_img' => ['nullable', 'image', 'mimes:jpg,png,jpeg,gif,svg,webp', 'max:5120'],
        ], [
            'title.required' => 'Judul blog wajib diisi.',
            'slug.required' => 'Slug wajib diisi.',
            'author.required' => 'Author wajib diisi.',
            'featured_img.image' => 'File yang diunggah harus berupa gambar.',
            'featured_img.mimes' => 'Format gambar harus jpg, jpeg, png, gif, svg, atau webp.',
            'featured_img.max' => 'Ukuran gambar maksimal 5 MB.',
        ]);

        $slug = $req->slug ? Str::slug($req->slug, '-') : Str::slug($req->title, '-');

        $dataInput = [
            'title' => $req->title,
            'author' => $req->author,
            'slug' => $slug,
            'kategori' => $req->kategori == '_newcat' && $req->kategori_baru ? $req->kategori_baru : $req->kategori,
            'url' => $req->url,
            'content' => $req->content, 
            'page_type' => $req->page_type,
            'date_publish' => $req->status == 'publish' ? date('Y-m-d H:i:s') : null,
            'status' => $req->status,
            'jenis' => $req->jenis,
        ];

        if($req->hasFile('featured_img')){
            $file = $req->file('featured_img');
            $safeName = preg_replace('/[^A-Za-z0-9.\-_]/', '_', $file->getClientOriginalName());
            $filename = time() . '_' . $safeName;
            $file->move(public_path('images/blog'), $filename);
            $dataInput['featured_img'] = 'images/blog/' . $filename;
        }
        
        if($req->id){
            Blog::where('id', $req->id)->update($dataInput);
            $msg = 'Blog berhasil diperbarui!';
        }else{
            Blog::create($dataInput);
            $msg = 'Blog baru berhasil ditambahkan!';
        }
        
        return redirect('/admin/blog')->with('success', $msg);
    }
}

