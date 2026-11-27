<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\ProgramDokumentasi;
use App\Models\ProgramImplementasi;
use Illuminate\Http\Request;

class ProgramDokumentasiController extends Controller
{
    /* daftar program implementasi yang memiliki bagian dokumentasi */
    public static function programs()
    {
        return ProgramImplementasi::options();
    }

    public function index()
    {
        $counts = ProgramDokumentasi::selectRaw('program, COUNT(*) as total')
            ->groupBy('program')
            ->pluck('total', 'program');

        return view('program_dokumentasi.list', [
            'pageTitle' => 'Program: Dokumentasi Program',
            'active' => ['ProgActive' => 'active', 'ProgDokActive' => 'active'],
            'programs' => self::programs(),
            'programLogos' => ProgramImplementasi::logoMap(),
            'counts' => $counts,
        ]);
    }

    public function table(Request $req)
    {
        $query = ProgramDokumentasi::query()->orderBy('urutan')->orderBy('id');
        if ($req->filled('program')) {
            $query->where('program', $req->program);
        }

        $programs = self::programs();

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('program', function (ProgramDokumentasi $row) use ($programs) {
                $label = $programs[$row->program] ?? ucfirst($row->program);
                return '<span class="badge bg-light text-dark border fw-normal">' . e($label) . '</span>';
            })
            ->addColumn('judul', function (ProgramDokumentasi $row) {
                $html = '<div class="fw-semibold">' . e($row->judul_kegiatan) . '</div>';
                if ($row->kategori_badge) {
                    $html .= '<small class="text-muted">' . e($row->kategori_badge) . '</small>';
                }
                return $html;
            })
            ->addColumn('gambar', function (ProgramDokumentasi $row) {
                $fallback = in_array($row->program, ['budaya', 'cinta', 'senyum']) ? $row->program : 'budaya';
                $src = ($row->gambar_url && file_exists(public_path($row->gambar_url)))
                    ? asset($row->gambar_url)
                    : asset('website/assets/images/custom/' . $fallback . '.png');
                return '<img src="' . $src . '" class="dokumentasi-thumb" alt="' . e($row->judul_kegiatan) . '"/>';
            })
            ->addColumn('tautan', function (ProgramDokumentasi $row) {
                $links = [];
                if ($row->link_detail) {
                    $links[] = '<a href="' . e($row->link_detail) . '" target="_blank" rel="noopener" class="text-success" title="Buka link detail"><i class="bi-box-arrow-up-right"></i></a>';
                }
                if ($row->youtube_url) {
                    $links[] = '<a href="' . e($row->youtube_url) . '" target="_blank" rel="noopener" class="text-danger" title="Tonton di YouTube"><i class="bi-youtube"></i></a>';
                }
                return $links
                    ? '<div class="d-inline-flex gap-2 align-items-center">' . implode('', $links) . '</div>'
                    : '<span class="text-muted">-</span>';
            })
            /* kolom terpisah untuk tiap aksi kelola khusus kegiatan pada baris ini */
            ->addColumn('kelola_statistik', function (ProgramDokumentasi $row) {
                $url = '/admin/program/statistik?program=' . urlencode($row->program) . '&dokumentasi=' . $row->id;

                return '<a href="' . $url . '" class="text-warning" title="Kelola Statistik kegiatan ini"><i class="bi-gem"></i></a>';
            })
            ->addColumn('kelola_faq', function (ProgramDokumentasi $row) {
                $url = '/admin/program/faq?program=' . urlencode($row->program) . '&dokumentasi=' . $row->id;

                return '<a href="' . $url . '" class="text-primary" title="Kelola FAQ kegiatan ini"><i class="bi-question-circle"></i></a>';
            })
            ->addColumn('kelola_manfaat', function (ProgramDokumentasi $row) {
                $url = '/admin/program/manfaat?program=' . urlencode($row->program) . '&dokumentasi=' . $row->id;

                return '<a href="' . $url . '" class="text-info" title="Kelola Manfaat kegiatan ini"><i class="bi-stars"></i></a>';
            })
            ->addColumn('kelola_galeri', function (ProgramDokumentasi $row) {
                $url = '/admin/program/galeri?program=' . urlencode($row->program) . '&dokumentasi=' . $row->id;

                return '<a href="' . $url . '" class="text-success" title="Kelola Galeri kegiatan ini"><i class="bi-images"></i></a>';
            })
            /* kolom "Aksi" standar: hanya ubah dan hapus */
            ->addColumn('action', function (ProgramDokumentasi $row) {
                $program = urlencode($row->program);

                return '<div class="d-inline-flex gap-2 align-items-center">'
                    . '<a href="/admin/program/dokumentasi/' . $row->id . '/edit?program=' . $program . '" class="text-primary" title="Ubah"><i class="bi-pencil-square"></i></a>'
                    . '<button type="button" class="btn btn-link p-0 text-danger btn-del" data-id="' . $row->id . '" title="Hapus"><i class="bi-trash"></i></button>'
                    . '</div>';
            })
            ->rawColumns(['program', 'judul', 'gambar', 'tautan', 'kelola_statistik', 'kelola_faq', 'kelola_manfaat', 'kelola_galeri', 'action'])
            ->make();
    }

    public function form($id = null)
    {
        $detail = null;
        if ($id) {
            $mode = 'Ubah';
            $detail = ProgramDokumentasi::findOrFail($id);
        } else {
            $mode = 'Tambah';
        }

        $programs = self::programs();
        $programSlug = $detail ? $detail->program : request('program', 'budaya');
        if (!$programSlug || !isset($programs[$programSlug])) {
            $programSlug = array_key_exists('budaya', $programs) ? 'budaya' : array_key_first($programs);
        }
        $programLabel = $programs[$programSlug] ?? ucfirst($programSlug);

        return view('program_dokumentasi.form', [
            'pageTitle' => 'Program Implementasi ' . $programLabel,
            'active' => ['ProgActive' => 'active', 'ProgDokActive' => 'active'],
            'mode' => $mode,
            'detail' => $detail,
            'programs' => $programs,
            'programSlug' => $programSlug,
            'programLabel' => $programLabel,
        ]);
    }

    public function store(Request $req)
    {
        $req->validate([
            'program'        => ['required', 'in:' . implode(',', array_keys(self::programs()))],
            'kategori_badge' => ['nullable', 'string', 'max:100'],
            'judul_kegiatan' => ['required', 'string', 'max:255'],
            'link_detail'    => ['nullable', 'string', 'url', 'max:255'],
            'youtube_url'    => ['nullable', 'string', 'url', 'max:255'],
            'deskripsi_video'=> ['nullable', 'string'],
            'tujuan'         => ['nullable', 'string'],
            'sasaran'        => ['nullable', 'string'],
            'ashnaf'         => ['nullable', 'string'],
            'gambar_url'     => [($req->id ? 'nullable' : 'required'), 'image', 'mimes:jpg,png,jpeg,gif,svg,webp', 'max:4096'],
        ]);

        $dataInput = [
            'program'                 => $req->program,
            'program_implementasi_id' => ProgramImplementasi::idForProgram($req->program),
            'kategori_badge'          => $req->kategori_badge,
            'judul_kegiatan' => $req->judul_kegiatan,
            'link_detail'    => $req->link_detail ? trim($req->link_detail) : null,
            'youtube_url'    => $req->youtube_url ? trim($req->youtube_url) : null,
            'deskripsi_video'=> $req->deskripsi_video ? trim($req->deskripsi_video) : null,
            'tujuan'         => $req->tujuan ? trim($req->tujuan) : null,
            'sasaran'        => $req->sasaran ? trim($req->sasaran) : null,
            'ashnaf'         => $req->ashnaf ? trim($req->ashnaf) : null,
            'urutan'         => $req->id ? (int) $req->urutan : (int) ((ProgramDokumentasi::max('urutan') ?? 0) + 1),
        ];

        /* upload foto: hanya menimpa kalau admin upload file baru */
        if ($req->file('gambar_url')) {
            $file     = $req->file('gambar_url');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\._]/', '', $file->getClientOriginalName());
            $file->move(public_path('images/program-dokumentasi'), $filename);
            $dataInput['gambar_url'] = 'images/program-dokumentasi/' . $filename;
        }

        if ($req->id) {
            ProgramDokumentasi::where('id', $req->id)->update($dataInput);
        } else {
            ProgramDokumentasi::create($dataInput);
        }

        return redirect('/admin/program/dokumentasi?program=' . urlencode($req->program));
    }

    public function delete($id)
    {
        ProgramDokumentasi::findOrFail($id)->delete();
    }
}
