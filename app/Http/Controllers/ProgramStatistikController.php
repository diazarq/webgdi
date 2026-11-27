<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\ProgramDokumentasi;
use App\Models\ProgramImplementasi;
use App\Models\ProgramStatistik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProgramStatistikController extends Controller
{
    /* konteks program + kegiatan (dokumentasi) yang sedang dikelola */
    private function context(Request $req, $detail = null)
    {
        $programs     = ProgramImplementasi::options();
        $programSlug  = ProgramImplementasi::resolveSlug($detail ? $detail->program : $req->get('program'));
        $dokumentasiId = $detail ? $detail->program_dokumentasi_id : $req->get('dokumentasi');

        $dokumentasi = null;
        if ($dokumentasiId) {
            $dokumentasi = ProgramDokumentasi::where('program', $programSlug)->find($dokumentasiId);
        }

        return [
            'programs'     => $programs,
            'programSlug'  => $programSlug,
            'programLabel' => $programs[$programSlug],
            'dokumentasi'  => $dokumentasi,
        ];
    }

    public function index(Request $req)
    {
        $context = $this->context($req);

        return view('program_statistik.list', [
            'pageTitle'    => 'Statistik ' . ($context['dokumentasi'] ? 'Kegiatan ' . $context['dokumentasi']->judul_kegiatan : 'Program ' . $context['programLabel']),
            'active'       => ['ProgActive' => 'active', 'ProgStatActive' => 'active'],
            'programs'     => $context['programs'],
            'programSlug'  => $context['programSlug'],
            'programLabel' => $context['programLabel'],
            'dokumentasiId'    => $context['dokumentasi'] ? $context['dokumentasi']->id : null,
            'dokumentasiLabel' => $context['dokumentasi'] ? $context['dokumentasi']->judul_kegiatan : null,
        ]);
    }

    public function table(Request $req)
    {
        $query = ProgramStatistik::with('dokumentasi')->orderBy('urutan')->orderBy('id');
        if ($req->filled('program')) {
            $query->where('program', $req->program);
        }
        if ($req->filled('dokumentasi')) {
            $query->where('program_dokumentasi_id', $req->dokumentasi);
        }

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('icon_preview', function (ProgramStatistik $row) {
                $icon = $row->icon ?? '';
                if ($icon !== '' && strpos($icon, '/') !== false) {
                    if (file_exists(public_path($icon))) {
                        return '<img src="' . asset($icon) . '" alt="' . e($row->label_judul) . '" style="height:36px;width:auto;"/>';
                    }
                    return '<span class="text-muted">file tidak ditemukan</span>';
                }
                return '<span style="font-size:28px;line-height:1;">' . e($icon) . '</span>';
            })
            ->addColumn('kegiatan', function (ProgramStatistik $row) {
                $judul = optional($row->dokumentasi)->judul_kegiatan;
                if (!$judul) {
                    return '<span class="text-muted">Umum (program)</span>';
                }
                return '<span class="badge bg-light text-dark border fw-normal">' . e($judul) . '</span>';
            })
            ->addColumn('action', function (ProgramStatistik $row) {
                $params = '?program=' . urlencode($row->program);
                if ($row->program_dokumentasi_id) {
                    $params .= '&dokumentasi=' . $row->program_dokumentasi_id;
                }
                return '<a href="/admin/program/statistik/' . $row->id . '/edit' . $params . '" class="btn btn-sm btn-primary"><i class="bi-pencil-square"></i></a>
                    <button type="button" class="btn btn-sm btn-danger btn-del" data-id="' . $row->id . '"><i class="bi-trash"></i></button>';
            })
            ->rawColumns(['icon_preview', 'kegiatan', 'action'])
            ->make();
    }

    public function form($id = null)
    {
        $detail = null;
        if ($id) {
            $mode   = 'Ubah';
            $detail = ProgramStatistik::findOrFail($id);
        } else {
            $mode = 'Tambah';
        }

        $context   = $this->context(request(), $detail);
        $kegiatan  = $context['dokumentasi'];

        return view('program_statistik.form', [
            'pageTitle'    => $mode . ' Statistik ' . ($kegiatan ? 'Kegiatan ' . $kegiatan->judul_kegiatan : 'Program ' . $context['programLabel']),
            'active'       => ['ProgActive' => 'active', 'ProgStatActive' => 'active'],
            'mode'         => $mode,
            'detail'       => $detail,
            'programs'     => $context['programs'],
            'programSlug'  => $context['programSlug'],
            'programLabel' => $context['programLabel'],
            'dokumentasiId'    => $kegiatan ? $kegiatan->id : null,
            'dokumentasiLabel' => $kegiatan ? $kegiatan->judul_kegiatan : null,
        ]);
    }

    public function store(Request $req)
    {
        $programSlug = ProgramImplementasi::resolveSlug($req->program);

        $dokumentasi = null;
        if ($req->filled('program_dokumentasi_id')) {
            $dokumentasi = ProgramDokumentasi::where('program', $programSlug)->find($req->program_dokumentasi_id);
        }

        $req->validate([
            'icon'        => ['nullable', 'string', 'max:255'],
            'icon_file'   => ['nullable', 'image', 'mimes:jpg,png,jpeg,gif,svg,webp', 'max:2048'],
            'angka_nilai' => ['required', 'string', 'max:100'],
            'label_judul' => ['required', 'string', 'max:150'],
            'urutan'      => ['nullable', 'integer', 'min:0'],
        ]);

        $dataInput = [
            'program'                 => $programSlug,
            'program_implementasi_id' => ProgramImplementasi::idForProgram($programSlug),
            'program_dokumentasi_id'  => $dokumentasi ? $dokumentasi->id : null,
            'angka_nilai'             => trim($req->angka_nilai),
            'label_judul'             => trim($req->label_judul),
            'urutan'                  => (int) $req->urutan,
        ];

        if ($req->file('icon_file')) {
            $dir      = public_path('images/program-statistik');
            $file     = $req->file('icon_file');
            $filename = time() . '_icon_' . preg_replace('/[^A-Za-z0-9\-\._]/', '', $file->getClientOriginalName());
            $file->move($dir, $filename);
            $dataInput['icon'] = 'images/program-statistik/' . $filename;
        } else {
            $dataInput['icon'] = trim($req->icon) ?: '⭐';
        }

        if ($req->id) {
            $detail = ProgramStatistik::findOrFail($req->id);
            if ($detail->icon && strpos($detail->icon, '/') !== false && !$req->file('icon_file')) {
                if (file_exists(public_path($detail->icon))) {
                    File::delete(public_path($detail->icon));
                }
            }
            $detail->update($dataInput);
        } else {
            ProgramStatistik::create($dataInput);
        }

        $redirect = '/admin/program/statistik?program=' . urlencode($programSlug);
        if ($dokumentasi) {
            $redirect .= '&dokumentasi=' . $dokumentasi->id;
        }

        return redirect($redirect);
    }

    public function delete($id)
    {
        $detail = ProgramStatistik::findOrFail($id);
        if ($detail->icon && strpos($detail->icon, '/') !== false) {
            if (file_exists(public_path($detail->icon))) {
                File::delete(public_path($detail->icon));
            }
        }
        $detail->delete();
    }
}
