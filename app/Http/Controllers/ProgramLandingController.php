<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\ProgramImplementasi;
use App\Models\ProgramLanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramLandingController extends Controller
{
    /* Daftar program diambil langsung secara dinamis dari ProgramImplementasi */
    public static function pages()
    {
        $pages = ProgramImplementasi::options();
        if (!isset($pages['wakaf-hibah'])) {
            $pages['wakaf-hibah'] = 'Wakaf & Hibah';
        }
        return $pages;
    }

    /* Sinkronkan agar setiap ProgramImplementasi otomatis punya baris Hero Landing */
    public static function syncFromImplementasi()
    {
        $maxOrder = (int) (ProgramLanding::max('order') ?? 0);
        foreach (ProgramImplementasi::orderBy('id')->get() as $impl) {
            $slug = $impl->slug ?: \Illuminate\Support\Str::slug($impl->nama_program);
            if ($slug === '') continue;

            $landing = ProgramLanding::where('program_implementasi_id', $impl->id)
                ->orWhere('slug', $slug)
                ->first();

            if (!$landing) {
                $maxOrder++;
                ProgramLanding::create([
                    'slug'                    => $slug,
                    'program_implementasi_id' => $impl->id,
                    'title'                   => $impl->nama_program,
                    'logo_image'              => $impl->logo_image,
                    'order'                   => $maxOrder,
                    'status'                  => 'A',
                    'create_user'             => $impl->create_user ?: 'Administrator',
                    'create_date'             => now(),
                ]);
            } else {
                $updates = [];
                if (!$landing->program_implementasi_id) {
                    $updates['program_implementasi_id'] = $impl->id;
                }
                if (!$landing->logo_image && $impl->logo_image) {
                    $updates['logo_image'] = $impl->logo_image;
                }
                if (!empty($updates)) {
                    $landing->update($updates);
                }
            }
        }
    }

    /* pilihan ikon untuk kartu tambahan (key => path SVG bootstrap-icons) */
    public static $icons = [
        'gift'        => 'bi-gift',
        'heart'       => 'bi-heart-fill',
        'people'      => 'bi-people-fill',
        'star'        => 'bi-star-fill',
        'mosque'      => 'bi-building',
        'book'        => 'bi-book-fill',
        'cash'        => 'bi-cash-coin',
        'shield'      => 'bi-shield-check',
        'hands'       => 'bi-hand-thumbs-up-fill',
        'arrow-up'    => 'bi-graph-up-arrow',
        'check'       => 'bi-check-circle-fill',
        'megaphone'   => 'bi-megaphone-fill',
        'home'        => 'bi-house-heart-fill',
        'moon'        => 'bi-moon-stars-fill',
    ];

    public function index()
    {
        self::syncFromImplementasi();

        return view('program_landing.list', [
            'pageTitle' => 'Program: Hero Landing',
            'active' => ['ProgActive' => 'active', 'ProgLandingActive' => 'active'],
        ]);
    }

    public function table()
    {
        self::syncFromImplementasi();
        $pages = self::pages();

        return DataTables::eloquent(ProgramLanding::with('programImplementasi')->orderBy('order')->orderBy('id'))
            ->addIndexColumn()
            ->addColumn('logo', function (ProgramLanding $row) {
                $logo = $row->logo_image ?: ($row->programImplementasi ? $row->programImplementasi->logo_image : null);
                if ($logo && file_exists(public_path($logo))) {
                    return '<img src="' . asset($logo) . '" width="60" style="border-radius:50%"/>';
                }
                return '<img src="' . asset('admin/assets/img/setting/_img.jpg') . '" width="60" style="border-radius:50%"/>';
            })
            ->addColumn('program_name', function (ProgramLanding $row) use ($pages) {
                if ($row->programImplementasi) {
                    return '<span class="badge bg-light text-dark border">' . e($row->programImplementasi->nama_program) . ' (/' . e($row->slug) . ')</span>';
                }
                $label = $pages[$row->slug] ?? $row->slug;
                return '<span class="badge bg-light text-dark border">' . e($label) . ' (/' . e($row->slug) . ')</span>';
            })
            ->addColumn('status', function (ProgramLanding $row) {
                return $row->status == 'A'
                    ? '<span class="badge bg-success">Aktif</span>'
                    : '<span class="badge bg-secondary">Nonaktif</span>';
            })
            ->addColumn('drag_handle', function (ProgramLanding $row) {
                /* tombol ikon garis tiga: buka halaman atur urutan */
                return '<a href="/admin/program/landing/urutan" class="drag-handle text-secondary" title="Atur urutan tampil" style="font-size: 18px;"><i class="bi-list"></i></a>';
            })
            ->addColumn('action', function (ProgramLanding $row) {
                $button = '<a href="/admin/program/landing/' . $row->id . '/edit" class="btn btn-sm btn-primary"><i class="bi-pencil-square"></i></a> 
                    <button type="button" class="btn btn-sm btn-danger btn-del" data-id="' . $row->id . '"><i class="bi-trash"></i></button>';
                return $button;
            })
            ->rawColumns(['logo', 'program_name', 'status', 'drag_handle', 'action'])
            ->make();
    }

    /* Halaman atur urutan: daftar program berurutan dengan tombol naik/turun */
    public function urutan()
    {
        $items = ProgramLanding::orderBy('order')->orderBy('id')->get();

        return view('program_landing.urutan', [
            'pageTitle' => 'Program: Atur Urutan Hero Landing',
            'active' => ['ProgActive' => 'active', 'ProgLandingActive' => 'active'],
            'items' => $items,
            'icons' => self::$icons,
        ]);
    }

    /* pindahkan posisi program (arah: up / down) */
    public function move(Request $req)
    {
        $req->validate([
            'id'   => ['required', 'integer'],
            'arah' => ['required', 'in:up,down'],
        ]);

        $items = ProgramLanding::orderBy('order')->orderBy('id')->get()->values();
        $pos   = $items->search(function ($item) use ($req) {
            return $item->id == $req->id;
        });

        if ($pos === false) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        $swapPos = $req->arah == 'up' ? $pos - 1 : $pos + 1;
        if ($swapPos < 0 || $swapPos >= $items->count()) {
            return response()->json(['status' => 'error', 'message' => 'Sudah di posisi ujung'], 422);
        }

        /* tukar posisi kedua item, lalu normalisasi urutan seluruh list */
        $swapped = $items->all();
        $tmp            = $swapped[$pos];
        $swapped[$pos]  = $swapped[$swapPos];
        $swapped[$swapPos] = $tmp;

        foreach ($swapped as $i => $item) {
            ProgramLanding::where('id', $item->id)->update(['order' => $i + 1]);
        }

        return response()->json(['status' => 'ok']);
    }

    public function form($id = null)
    {
        self::syncFromImplementasi();
        $detail = null;
        if ($id) {
            $mode = 'Ubah';
            $detail = ProgramLanding::findOrFail($id);
        } elseif (request()->get('program')) {
            $slug = trim(request()->get('program'));
            $detail = ProgramLanding::where('slug', $slug)->first();
            $mode = $detail ? 'Ubah' : 'Tambah';
        } else {
            $mode = 'Tambah';
        }

        /* halaman yang sudah punya hero landing (tidak boleh dipilih lagi) */
        $usedSlugs = ProgramLanding::where('id', '!=', optional($detail)->id)->pluck('slug')->toArray();

        return view('program_landing.form', [
            'pageTitle' => $mode . ' Hero Landing Program',
            'active' => ['ProgActive' => 'active', 'ProgLandingActive' => 'active'],
            'mode' => $mode,
            'detail' => $detail,
            'pages' => self::pages(),
            'usedSlugs' => $usedSlugs,
            'icons' => self::$icons,
        ]);
    }

    public function store(Request $req)
    {
        $req->validate([
            'slug'            => ['required', 'string', 'max:100', 'unique:program_landing,slug,' . ($req->id ? $req->id : 'NULL') . ',id'],
            'badge_text'      => ['nullable', 'string', 'max:100'],
            'title'           => ['required', 'string', 'max:255'],
            'tagline'         => ['nullable', 'string', 'max:255'],
            'description'     => ['nullable', 'string'],
            'status'          => ['required', 'in:A,N'],
            'logo_image'      => ['image', 'mimes:jpg,png,jpeg,gif,svg,webp', 'max:2048'],
            'background_image'=> ['image', 'mimes:jpg,png,jpeg,webp', 'max:4096'],
        ]);

        $user = Auth::user();

        /* item kartu tambahan: array {icon, title, desc} → JSON */
        $infoItems = [];
        if (is_array($req->input('info_items'))) {
            foreach ($req->input('info_items') as $item) {
                $title = trim($item['title'] ?? '');
                $desc  = trim($item['desc'] ?? '');
                if ($title === '' && $desc === '') {
                    continue; /* lewati baris kosong */
                }
                $icon        = $item['icon'] ?? '';
                $infoItems[] = [
                    'icon'  => array_key_exists($icon, self::$icons) ? $icon : 'check',
                    'title' => $title,
                    'desc'  => $desc,
                ];
            }
        }

        $dataInput = [
            'slug'                    => trim($req->slug),
            'program_implementasi_id' => ProgramImplementasi::idForProgram($req->slug),
            'badge_text'              => $req->badge_text,
            'title'       => $req->title,
            'tagline'     => $req->tagline,
            'description' => $req->description,
            'info_text'   => $req->info_text,
            'info_items'  => $infoItems ?: null, /* cast 'array' di model yang serialize ke JSON */
            'order'       => $req->id ? (int) $req->order : (int) ((ProgramLanding::max('order') ?? 0) + 1),
            'status'      => $req->status,
        ];

        /* upload logo: hanya menimpa kalau admin upload file baru */
        if ($req->file('logo_image')) {
            $file     = $req->file('logo_image');
            $filename = time() . '_logo_' . preg_replace('/[^A-Za-z0-9\-\._]/', '', $file->getClientOriginalName());
            $file->move(public_path('images/program-landing'), $filename);
            $dataInput['logo_image'] = 'images/program-landing/' . $filename;
        }

        /* upload background hero */
        if ($req->file('background_image')) {
            $file     = $req->file('background_image');
            $filename = time() . '_bg_' . preg_replace('/[^A-Za-z0-9\-\._]/', '', $file->getClientOriginalName());
            $file->move(public_path('images/program-landing'), $filename);
            $dataInput['background_image'] = 'images/program-landing/' . $filename;
        }

        if ($req->id) {
            /* UPDATE */
            $dataInput['update_user'] = $user ? $user->name : null;
            $dataInput['update_date'] = now();
            ProgramLanding::where('id', $req->id)->update($dataInput);
        } else {
            /* CREATE */
            $dataInput['create_user'] = $user ? $user->name : null;
            $dataInput['create_date'] = now();
            ProgramLanding::create($dataInput);
        }

        /* Sinkronkan kembali ke ProgramImplementasi (nama & logo jika diupdate) */
        if ($dataInput['program_implementasi_id']) {
            $implUpdate = ['nama_program' => $req->title];
            if (isset($dataInput['logo_image'])) {
                $implUpdate['logo_image'] = $dataInput['logo_image'];
            }
            ProgramImplementasi::where('id', $dataInput['program_implementasi_id'])->update($implUpdate);
        }

        return redirect('/admin/program/landing');
    }

    public function delete($id)
    {
        ProgramLanding::findOrFail($id)->delete();
    }
}
