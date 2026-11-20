<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    protected $pageType = [
        'general' => 'General',
        'contact' => 'Contact',
        'blog_list' => 'Blog List',
        'program_list' => 'Program list',
        'gallery' => 'Gallery',
        'homepage' => 'Homepage'
    ];
    public function __construct(){}

    public function index(){
        $menu = [];
        $parentMenu = Menu::where('parent_id', 0)->orderBy('order', 'asc')->orderBy('id', 'asc')->get();
        if($parentMenu){
            foreach($parentMenu as $par){
                $child_menu = Menu::where('parent_id', $par->id)->orderBy('order', 'asc')->orderBy('id', 'asc')->get();
                $child_items = [];
                foreach($child_menu as $ch){
                    $sub_child = Menu::where('parent_id', $ch->id)->orderBy('order', 'asc')->orderBy('id', 'asc')->get();
                    $child_items[] = [
                        'id' => $ch->id,
                        'title' => $ch->title,
                        'page_type' => $this->pageType[$ch->page_type] ?? ($ch->page_type ? ucfirst($ch->page_type) : '-'),
                        'menu_type' => ucfirst($ch->menu_type),
                        'footer_display' => $ch->footer_display == 'A' ? 'Ya' : 'Tidak',
                        'status_display' => ucfirst($ch->status_display),
                        'sub_child' => $sub_child,
                    ];
                }
                $menu[] = [
                    'id' => $par->id,
                    'title' => $par->title,
                    'page_type' => $this->pageType[$par->page_type] ?? ($par->page_type ? ucfirst($par->page_type) : '-'),
                    'menu_type' => ucfirst($par->menu_type),
                    'footer_display' => $par->footer_display == 'A' ? 'Ya' : 'Tidak',
                    'status_display' => ucfirst($par->status_display),
                    'child' => json_encode($child_menu),
                    'child_items' => $child_items,
                ];
            }
        }
        return view('menu.list-menu', [
            'pageTitle' => 'Menu',
            'active' => ['MenuActive' => 'active'],
            'list_menu' => $menu,
            'pageType' => $this->pageType
        ]);
    }

    public function reorder(Request $request){
        $hierarchy = $request->input('hierarchy');
        if(is_string($hierarchy)){
            $hierarchy = json_decode($hierarchy, true);
        }

        if(!is_array($hierarchy)){
            return response()->json([
                'status' => 'error',
                'message' => 'Format data tidak valid.'
            ], 400);
        }

        $this->saveHierarchy($hierarchy, 0);

        return response()->json([
            'status' => 'success',
            'message' => 'Urutan dan hierarki menu berhasil disimpan!'
        ]);
    }

    private function saveHierarchy(array $items, $parentId = 0){
        foreach($items as $index => $item){
            if(isset($item['id']) && $item['id'] !== null){
                $id = intval($item['id']);
                Menu::where('id', $id)->update([
                    'parent_id' => intval($parentId),
                    'order' => $index + 1
                ]);

                if(!empty($item['children']) && is_array($item['children'])){
                    $this->saveHierarchy($item['children'], $id);
                }
            }
        }
    }

    public function table(){
        return DataTables::eloquent(Menu::query())
            ->addIndexColumn()
            ->addColumn('action', function(Menu $table){
                $button = '<a href="/admin/menu/'.$table->id.'/edit" class="btn btn-sm btn-primary"><i class="bi-pencil-square"></i></a> 
                    <button type="button" class="btn btn-sm btn-danger btn-del" data-id="'.$table->id.'"><i class="bi-trash"></i></button>';
                return $button;
            })
            ->make();
    }

    public function delete($id){
        $user = Menu::find($id);
        $user->delete();
    }

    public function form($id=null){
        $detail = [];
        $parent = Menu::where('parent_id', 0)->orderBy('order', 'asc')->get();
        if($id){
            $mode = 'Ubah Data';
            $detail = Menu::find($id);
        }else{
            $mode = 'Tambah';
        }
        
        return view('menu.form-menu', [
            'pageTitle' => $mode.' Menu',
            'active' => ['MenuActive' => 'active'],
            'mode' => $mode,
            'detail' => $detail,
            'pageType' => $this->pageType,
            'parent' => $parent
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
            'subtitle' => $req->subtitle,
            'parent_id' => $req->parent_id,
            'slug' => $req->slug,
            'menu_type' => $req->menu_type,
            'url' => $req->url,
            'content' => $req->content, 
            'page_type' => $req->page_type,
            'footer_display' => $req->footer_display,
            'status_display' => $req->status_display,
        ];

        if($req->file('featured_img')){
            $filename = $req->file('featured_img')->getClientOriginalName();
            $path = $req->file('featured_img')->move('images/menu', $filename);
            $dataInput['featured_img'] = $path;
        }
        
        if($req->id){
            Menu::where('id', $req->id)->update($dataInput);
        }else{
            Menu::create($dataInput);
        }
        
        return redirect('/admin/menu');
    }

    public function updateOrder(Request $request)
    {
        return $this->reorder($request);
    }
}
