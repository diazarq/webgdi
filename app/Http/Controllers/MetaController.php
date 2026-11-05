<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Meta;
use App\Models\Bank;
use Illuminate\Http\Request;

class MetaController extends Controller
{
    public function __construct(){}

    public function index(){
        $logo = Meta::where('var', 'INST_LOGO')->first();
        $name = Meta::where('var', 'INST_NAME')->first();
        $addr = Meta::where('var', 'INST_ADDR')->first();
        $telp = Meta::where('var', 'INST_TELP')->first();
        $email = Meta::where('var', 'INST_EMAIL')->first();
        $map = Meta::where('var', 'GOO_MAP')->first();
        $branch = Meta::where('var', 'BRANCH')->first();

        $output = [
            'instLogo' => $logo->value,
            'instName' => $name->value,
            'instAddr' => $addr->value,
            'instTelp' => $telp->value,
            'instEmail' => $email->value,
            'gooMap' => $map->value,
            'branch' => $branch?->value
        ];

        return view('meta.index-meta-setting', [
            'pageTitle' => 'Meta: Identitas Instansi',
            'active' => ['MetaActive' => 'active', 'MetaIDActive' => 'active'],
            'detail' => $output
        ]);
    }

    public function store(Request $req){
        $instLogo = $req->INST_LOGO;
        $instName = $req->INST_NAME;
        $instAddr = $req->INST_ADDR;
        $instTelp = $req->INST_TELP;
        $instEmail = $req->INST_EMAIL;
        $gooMap = $req->GOO_MAP;

        if($req->file('image_upload')){
            $filename = $req->file('image_upload')->getClientOriginalName();
            $path = $req->file('image_upload')->move('images/meta', $filename);
            $instLogo = $path;
        }
        

        Meta::where('var', 'INST_LOGO')->update(['value' => $instLogo]);
        Meta::where('var', 'INST_NAME')->update(['value' => $instName]);
        Meta::where('var', 'INST_TELP')->update(['value' => $instTelp]);
        Meta::where('var', 'INST_ADDR')->update(['value' => $instAddr]);
        Meta::where('var', 'INST_EMAIL')->update(['value' => $instEmail]);
        Meta::where('var', 'GOO_MAP')->update(['value' => $gooMap]);

        /* branch office */
        $brTotal = count($req->br_name?? []);
        if($brTotal > 0){
            $arrayBranch = [];
            foreach($req->br_name as $key=>$val){
                $arrayBranch[] = [
                    'name' => $val,
                    'address' => $req->br_addr[$key],
                    'phone' => $req->br_phone[$key]
                ];
            }

            $json = json_encode($arrayBranch);
            Meta::where('var', 'BRANCH')->update(['value' => $json]);
        }

        return redirect('/admin/meta/identitas-instansi');
    }

    /* kelola bank & emoney */
    public function index_bank(){
        return view('meta.index-bank', [
            'pageTitle' => 'Meta: Rekening Bank',
            'active' => ['MetaActive' => 'active', 'MetaBankActive' => 'active'],
        ]);
    }

    public function table_bank(){
        return DataTables::eloquent(Bank::query())
            ->addIndexColumn()
            ->addColumn('action', function(Bank $table){
                $button = '<a href="/admin/meta/bank/'.$table->id.'/edit" class="btn btn-sm btn-primary"><i class="bi-pencil-square"></i></a> 
                    <button type="button" class="btn btn-sm btn-danger btn-del" data-id="'.$table->id.'"><i class="bi-trash"></i></button>';
                return $button;
            })
            ->make();
    }

    public function delete_bank($id){
        $bank = Bank::find($id);
        $bank->delete();
    }

    public function form_bank($id=null){
        $detail = [];
        if($id){
            $mode = 'Ubah Data';
            $detail = Bank::find($id);
        }else{
            $mode = 'Tambah';
        }
        
        return view('meta.form-bank', [
            'pageTitle' => 'Meta: '.$mode.' Rekening Bank',
            'active' => ['MetaActive' => 'active', 'MetaBankActive'=>'active'],
            'mode' => $mode,
            'detail' => $detail,
        ]);
    }

    public function store_bank(Request $req){
        /* nanti dilengkapi */
        $dataCheck = $req->validate([
            'bank_name' => ['required', 'string'],
            'code_image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'bank_img' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $dataInput = [
            'type' => $req->type,
            'bank_name' => $req->bank_name,
            'bank_account' => $req->bank_account,
            'bank_user' => $req->bank_user,
            'status' => $req->status,
        ];

        if($req->file('code_image')){
            $filename = $req->file('code_image')->getClientOriginalName();
            $path = $req->file('code_image')->move('images/code', $filename);
            $dataInput['code_image'] = $path;
        }
        if($req->file('bank_img')){
            $filename = $req->file('bank_img')->getClientOriginalName();
            $path = $req->file('bank_img')->move('images/meta', $filename);
            $dataInput['bank_img'] = $path;
        }
        
        if($req->id){
            Bank::where('id', $req->id)->update($dataInput);
        }else{
            Bank::create($dataInput);
        }
        
        return redirect('/admin/meta/bank');
    }
}
