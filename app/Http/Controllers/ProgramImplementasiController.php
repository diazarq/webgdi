<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\ProgramImplementasi;
use App\Models\ProgramLanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProgramImplementasiController extends Controller
{
    public function index()
    {
        return view('program_implementasi.list', [
            'pageTitle' => 'Program: Program Implementasi',
            'active' => ['ProgActive' => 'active', 'ProgImplActive' => 'active'],
        ]);
    }

    public function table()
    {
        return DataTables::eloquent(ProgramImplementasi::query()->orderBy('id'))
            ->addIndexColumn()
            ->addColumn('logo', function (ProgramImplementasi $row) {
                if ($row->logo_image && file_exists(public_path($row->logo_image))) {
                    return '<img src="' . asset($row->logo_image) . '" width="60"/>';
                }
                return '<img src="' . asset('admin/assets/img/setting/_img.jpg') . '" width="60"/>';
            })
            ->addColumn('status_badge', function (ProgramImplementasi $row) {
                return ($row->status ?? 'A') === 'A'
                    ? '<span class="badge bg-success">Tampil di Homepage</span>'
                    : '<span class="badge bg-secondary">Disembunyikan</span>';
            })
            ->addColumn('dokumentasi', function (ProgramImplementasi $row) {
                $slug   = $row->slug ?: Str::slug($row->nama_program);
                $docUrl = url('/admin/program/dokumentasi') . '?program=' . urlencode($slug);

                return '<a href="' . $docUrl . '" class="btn btn-sm btn-outline-success btn-docs" title="Kelola Dokumentasi"><i class="bi-list-ul"></i> Dokumentasi</a>';
            })
            ->addColumn('action', function (ProgramImplementasi $row) {
                return '<div class="d-inline-flex gap-1">'
                    . '<a href="/admin/program/implementasi/' . $row->id . '/edit" class="btn btn-sm btn-primary" title="Edit Program & Hero"><i class="bi-pencil-square"></i></a>'
                    . '<button type="button" class="btn btn-sm btn-danger btn-del" data-id="' . $row->id . '" title="Hapus"><i class="bi-trash"></i></button>'
                    . '</div>';
            })
            ->rawColumns(['logo', 'status_badge', 'dokumentasi', 'action'])
            ->make();
    }

    public function form($id = null)
    {
        $detail  = null;
        $landing = null;
        if ($id) {
            $mode   = 'Ubah Data';
            $detail = ProgramImplementasi::findOrFail($id);
            $slug   = $detail->slug ?: Str::slug($detail->nama_program);
            $landing = ProgramLanding::where('program_implementasi_id', $detail->id)
                ->orWhere('slug', $slug)
                ->first();
        } else {
            $mode = 'Tambah';
        }

        return view('program_implementasi.form', [
            'pageTitle' => $mode . ' Program Implementasi',
            'active'    => ['ProgActive' => 'active', 'ProgImplActive' => 'active'],
            'mode'      => $mode,
            'detail'    => $detail,
            'landing'   => $landing,
        ]);
    }

    public function store(Request $req)
    {
        $req->validate([
            'nama_program'     => ['required', 'string', 'max:255'],
            'url_program'      => ['nullable', 'string', 'max:255'],
            'status'           => ['nullable', 'in:A,N'],
            'logo_image'       => ['nullable', 'image', 'mimes:jpg,png,jpeg,gif,svg,webp', 'max:2048'],
            'badge_text'       => ['nullable', 'string', 'max:100'],
            'tagline'          => ['nullable', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'background_image' => ['nullable', 'image', 'mimes:jpg,png,jpeg,webp', 'max:4096'],
        ]);

        $user   = Auth::user();
        $status = $req->status ?: 'A';

        $dataInput = [
            'nama_program' => trim($req->nama_program),
            'url_program'  => $req->url_program ? trim($req->url_program) : null,
            'status'       => $status,
        ];

        /* upload logo */
        if ($req->file('logo_image')) {
            $file     = $req->file('logo_image');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\._]/', '', $file->getClientOriginalName());
            $file->move(public_path('images/program-implementasi'), $filename);
            $dataInput['logo_image'] = 'images/program-implementasi/' . $filename;
        }

        if ($req->id) {
            /* UPDATE */
            $impl = ProgramImplementasi::findOrFail($req->id);
            $slug = $impl->slug ?: Str::slug($req->nama_program);
            if (!$impl->slug) {
                $dataInput['slug'] = $slug;
            }
            $dataInput['update_user'] = $user ? $user->name : null;
            $dataInput['update_date'] = now();
            $impl->update($dataInput);
            $implId = $impl->id;
        } else {
            /* CREATE */
            $base = Str::slug($req->nama_program);
            $slug = $base;
            $i = 2;
            while (ProgramImplementasi::where('slug', $slug)->exists()) {
                $slug = $base . '-' . $i++;
            }
            $dataInput['slug']        = $slug;
            $dataInput['url_program'] = $dataInput['url_program'] ?: ('/' . $slug);
            $dataInput['create_user'] = $user ? $user->name : null;
            $dataInput['create_date'] = now();
            $impl   = ProgramImplementasi::create($dataInput);
            $implId = $impl->id;
        }

        /* Sinkronkan otomatis ke tabel program_landing (Hero halaman program) */
        $landing = ProgramLanding::where('program_implementasi_id', $implId)
            ->orWhere('slug', $slug)
            ->first();

        $landingData = [
            'slug'                    => $slug,
            'program_implementasi_id' => $implId,
            'title'                   => trim($req->nama_program),
            'badge_text'              => $req->badge_text,
            'tagline'                 => $req->tagline,
            'description'             => $req->description,
            'status'                  => $status,
        ];

        if (isset($dataInput['logo_image'])) {
            $landingData['logo_image'] = $dataInput['logo_image'];
        } elseif (!$landing && $impl->logo_image) {
            $landingData['logo_image'] = $impl->logo_image;
        }

        if ($req->file('background_image')) {
            $bgFile     = $req->file('background_image');
            $bgFilename = time() . '_bg_' . preg_replace('/[^A-Za-z0-9\-\._]/', '', $bgFile->getClientOriginalName());
            $bgFile->move(public_path('images/program-landing'), $bgFilename);
            $landingData['background_image'] = 'images/program-landing/' . $bgFilename;
        }

        if ($landing) {
            $landingData['update_user'] = $user ? $user->name : null;
            $landingData['update_date'] = now();
            $landing->update($landingData);
        } else {
            $landingData['order']       = (int) ((ProgramLanding::max('order') ?? 0) + 1);
            $landingData['create_user'] = $user ? $user->name : null;
            $landingData['create_date'] = now();
            ProgramLanding::create($landingData);
        }

        return redirect('/admin/program/implementasi');
    }

    public function delete($id)
    {
        $impl = ProgramImplementasi::findOrFail($id);
        ProgramLanding::where('program_implementasi_id', $impl->id)
            ->orWhere('slug', $impl->slug)
            ->delete();
        $impl->delete();
    }
}
