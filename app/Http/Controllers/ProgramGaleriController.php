<?php

namespace App\Http\Controllers;

use App\Models\ProgramDokumentasi;
use App\Models\ProgramGaleri;
use App\Models\ProgramImplementasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProgramGaleriController extends Controller
{
    /* konteks program + kegiatan (dokumentasi) yang sedang dikelola */
    private function context(Request $req)
    {
        $programs     = ProgramImplementasi::options();
        $programSlug  = ProgramImplementasi::resolveSlug($req->get('program'));
        $dokumentasiId = $req->get('dokumentasi');

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

        $query = ProgramGaleri::where('program', $context['programSlug']);
        if ($context['dokumentasi']) {
            $query->where('program_dokumentasi_id', $context['dokumentasi']->id);
        } else {
            $query->whereNull('program_dokumentasi_id');
        }
        $galeri = $query->orderBy('urutan')->orderBy('id')->get();

        /* total ukuran file foto yang tersimpan, dipakai untuk statistik di halaman */
        $totalSize = 0;
        foreach ($galeri as $item) {
            $path = $item->gambar_url ? public_path($item->gambar_url) : null;
            if ($path && is_file($path)) {
                $totalSize += (int) filesize($path);
            }
        }

        return view('program_galeri.list', [
            'pageTitle'    => 'Galeri ' . ($context['dokumentasi'] ? 'Kegiatan ' . $context['dokumentasi']->judul_kegiatan : 'Program ' . $context['programLabel']),
            'active'       => ['ProgActive' => 'active', 'ProgGaleriActive' => 'active'],
            'programs'     => $context['programs'],
            'programSlug'  => $context['programSlug'],
            'programLabel' => $context['programLabel'],
            'dokumentasiId'    => $context['dokumentasi'] ? $context['dokumentasi']->id : null,
            'dokumentasiLabel' => $context['dokumentasi'] ? $context['dokumentasi']->judul_kegiatan : null,
            'galeri'       => $galeri,
            'totalSize'    => $totalSize,
        ]);
    }

    /* unggah banyak foto sekaligus (drag & drop / browse) */
    public function upload(Request $req)
    {
        $req->validate([
            'files'   => ['required', 'array', 'min:1'],
            'files.*' => ['image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120', 'dimensions:min_width=150,min_height=150'],
        ], [
            'files.*.dimensions' => 'Ukuran gambar minimal 150 x 150 px.',
            'files.*.max'        => 'Ukuran file maksimal 5MB.',
            'files.*.image'      => 'File harus berupa gambar.',
        ]);

        $programSlug = ProgramImplementasi::resolveSlug($req->program);

        $dokumentasi = null;
        if ($req->filled('program_dokumentasi_id')) {
            $dokumentasi = ProgramDokumentasi::where('program', $programSlug)->find($req->program_dokumentasi_id);
            if (!$dokumentasi) {
                return response()->json(['message' => 'Kegiatan tidak ditemukan untuk program ini.'], 422);
            }
        }

        $dir = public_path('images/program-galeri');
        if (!file_exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $urutan = (int) ProgramGaleri::where('program', $programSlug)
            ->when($dokumentasi, function ($query) use ($dokumentasi) {
                $query->where('program_dokumentasi_id', $dokumentasi->id);
            }, function ($query) {
                $query->whereNull('program_dokumentasi_id');
            })
            ->max('urutan');

        $count = 0;
        foreach ($req->file('files') as $file) {
            $filename = time() . '_' . uniqid() . '_' . preg_replace('/[^A-Za-z0-9\-\._]/', '', $file->getClientOriginalName());
            $file->move($dir, $filename);

            ProgramGaleri::create([
                'program'                 => $programSlug,
                'program_implementasi_id' => ProgramImplementasi::idForProgram($programSlug),
                'program_dokumentasi_id'  => $dokumentasi ? $dokumentasi->id : null,
                'gambar_url'             => 'images/program-galeri/' . $filename,
                'urutan'                 => ++$urutan,
            ]);

            $count++;
        }

        return response()->json(['status' => true, 'count' => $count]);
    }

    /* simpan judul & keterangan satu foto
       (kolom `keterangan` menyimpan judul, kolom `alt_text` menyimpan keterangan) */
    public function update(Request $req, $id)
    {
        $req->validate([
            'keterangan' => ['nullable', 'string', 'max:255'],
            'alt_text'   => ['nullable', 'string', 'max:255'],
        ], [
            'keterangan.max' => 'Judul maksimal 255 karakter.',
            'alt_text.max'   => 'Keterangan maksimal 255 karakter.',
        ]);

        $foto = ProgramGaleri::findOrFail($id);

        $programSlug   = ProgramImplementasi::resolveSlug($req->program);
        $dokumentasiId = $req->filled('program_dokumentasi_id') ? (int) $req->program_dokumentasi_id : null;

        if ($foto->program !== $programSlug || (int) $foto->program_dokumentasi_id !== (int) $dokumentasiId) {
            return response()->json(['message' => 'Foto tidak ditemukan pada galeri ini.'], 404);
        }

        $foto->keterangan = $req->filled('keterangan') ? trim($req->keterangan) : null;
        $foto->alt_text   = $req->filled('alt_text') ? trim($req->alt_text) : null;
        $foto->save();

        return response()->json([
            'status'     => true,
            'keterangan' => $foto->keterangan,
            'alt_text'   => $foto->alt_text,
        ]);
    }

    public function delete($id)
    {
        $detail = ProgramGaleri::findOrFail($id);

        if ($detail->gambar_url && strpos($detail->gambar_url, 'images/program-galeri/') === 0) {
            if (file_exists(public_path($detail->gambar_url))) {
                File::delete(public_path($detail->gambar_url));
            }
        }

        $detail->delete();

        return response()->json(['status' => true]);
    }
}
