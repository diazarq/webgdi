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

    public function table(){
        return DataTables::eloquent(Blog::query()->orderBy('created_at', 'desc'))
            ->addIndexColumn()
            ->addColumn('action', function(Blog $table){
                $button = '<a href="/admin/blog/'.$table->id.'/edit" class="btn btn-sm btn-primary"><i class="bi-pencil-square"></i></a> 
                    <button type="button" class="btn btn-sm btn-danger btn-del" data-id="'.$table->id.'"><i class="bi-trash"></i></button>';
                return $button;
            })
            ->make();
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
        /* nanti dilengkapi */
        $dataCheck = $req->validate([
            'title' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'featured_img' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $dataInput = [
            'title' => $req->title,
            'author' => $req->author,
            'slug' => Str::of($req->title)->slug('-'), //$req->slug,
            'kategori' => $req->kategori_baru ? $req->kategori_baru : $req->kategori,
            'url' => $req->url,
            'content' => $req->content, 
            'page_type' => $req->page_type,
            'date_publish' => $req->status == 'publish' ? date('Y-m-d H:i:s') : null,
            'status' => $req->status,
            'jenis' => $req->jenis,
        ];

        if($req->file('featured_img')){
            $filename = $req->file('featured_img')->getClientOriginalName();
            $path = $req->file('featured_img')->move('images/blog', $filename);
            $dataInput['featured_img'] = $path;
        }
        
        if($req->id){
            Blog::where('id', $req->id)->update($dataInput);
        }else{
            Blog::create($dataInput);
        }
        
        return redirect('/admin/blog');
    }
}

