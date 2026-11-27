<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\ProgramDokumentasi;
use App\Models\ProgramImplementasi;
use App\Models\ProgramFaq;
use Illuminate\Http\Request;

class ProgramFaqController extends Controller
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

        return view('program_faq.list', [
            'pageTitle'    => 'FAQ ' . ($context['dokumentasi'] ? 'Kegiatan ' . $context['dokumentasi']->judul_kegiatan : 'Program ' . $context['programLabel']),
            'active'       => ['ProgActive' => 'active', 'ProgFaqActive' => 'active'],
            'programs'     => $context['programs'],
            'programSlug'  => $context['programSlug'],
            'programLabel' => $context['programLabel'],
            'dokumentasiId'    => $context['dokumentasi'] ? $context['dokumentasi']->id : null,
            'dokumentasiLabel' => $context['dokumentasi'] ? $context['dokumentasi']->judul_kegiatan : null,
        ]);
    }

    public function table(Request $req)
    {
        $query = ProgramFaq::with('dokumentasi')->orderBy('urutan')->orderBy('id');
        if ($req->filled('program')) {
            $query->where('program', $req->program);
        }
        if ($req->filled('dokumentasi')) {
            $query->where('program_dokumentasi_id', $req->dokumentasi);
        }

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('kegiatan', function (ProgramFaq $row) {
                $judul = optional($row->dokumentasi)->judul_kegiatan;
                if (!$judul) {
                    return '<span class="text-muted">Umum (program)</span>';
                }
                return '<span class="badge bg-light text-dark border fw-normal">' . e($judul) . '</span>';
            })
            ->addColumn('action', function (ProgramFaq $row) {
                $params = '?program=' . urlencode($row->program);
                if ($row->program_dokumentasi_id) {
                    $params .= '&dokumentasi=' . $row->program_dokumentasi_id;
                }
                return '<a href="/admin/program/faq/' . $row->id . '/edit' . $params . '" class="btn btn-sm btn-primary"><i class="bi-pencil-square"></i></a>
                    <button type="button" class="btn btn-sm btn-danger btn-del" data-id="' . $row->id . '"><i class="bi-trash"></i></button>';
            })
            ->rawColumns(['kegiatan', 'action'])
            ->make();
    }

    public function form($id = null)
    {
        $detail = null;
        if ($id) {
            $mode   = 'Ubah';
            $detail = ProgramFaq::findOrFail($id);
        } else {
            $mode = 'Tambah';
        }

        $context  = $this->context(request(), $detail);
        $kegiatan = $context['dokumentasi'];

        return view('program_faq.form', [
            'pageTitle'    => $mode . ' FAQ ' . ($kegiatan ? 'Kegiatan ' . $kegiatan->judul_kegiatan : 'Program ' . $context['programLabel']),
            'active'       => ['ProgActive' => 'active', 'ProgFaqActive' => 'active'],
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
            'pertanyaan' => ['required', 'string', 'max:255'],
            'jawaban'    => ['required', 'string'],
            'urutan'     => ['nullable', 'integer', 'min:0'],
        ]);

        $dataInput = [
            'program'                 => $programSlug,
            'program_implementasi_id' => ProgramImplementasi::idForProgram($programSlug),
            'program_dokumentasi_id'  => $dokumentasi ? $dokumentasi->id : null,
            'pertanyaan'             => trim($req->pertanyaan),
            'jawaban'                => trim($req->jawaban),
            'urutan'                 => (int) $req->urutan,
        ];

        if ($req->id) {
            ProgramFaq::where('id', $req->id)->update($dataInput);
        } else {
            ProgramFaq::create($dataInput);
        }

        $redirect = '/admin/program/faq?program=' . urlencode($programSlug);
        if ($dokumentasi) {
            $redirect .= '&dokumentasi=' . $dokumentasi->id;
        }

        return redirect($redirect);
    }

    public function delete($id)
    {
        ProgramFaq::findOrFail($id)->delete();
    }
}
