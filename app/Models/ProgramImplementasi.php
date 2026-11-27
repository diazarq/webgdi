<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProgramImplementasi extends Model
{
    use HasFactory;

    protected $table = 'program_implementasi';

    protected $fillable = [
        'nama_program',
        'slug',
        'logo_image',
        'url_program',
        'status',
        'create_user',
        'update_user',
        'create_date',
        'update_date',
    ];

    public $timestamps = false;

    /* daftar program implementasi: [slug => nama_program] */
    public static function options()
    {
        $programs = [];
        foreach (static::orderBy('id')->get(['nama_program', 'slug']) as $row) {
            $slug = $row->slug ?: Str::slug((string) $row->nama_program);
            if ($slug !== '') {
                $programs[$slug] = $row->nama_program;
            }
        }

        return $programs ?: [
            'budaya' => 'Budaya',
            'cinta'  => 'Cinta',
            'senyum' => 'Senyum',
        ];
    }

    /* peta logo berdasarkan slug: [slug => logo_image] */
    public static function logoMap()
    {
        $logos = [];
        foreach (static::orderBy('id')->get(['nama_program', 'slug', 'logo_image']) as $row) {
            $slug = $row->slug ?: Str::slug((string) $row->nama_program);
            if ($slug !== '') {
                $logos[$slug] = $row->logo_image;
            }
        }

        return $logos;
    }

    /* pastikan slug program valid, jika tidak kembali ke program pertama */
    public static function resolveSlug($slug)
    {
        $programs = static::options();

        if (!$slug || !isset($programs[$slug])) {
            $slug = array_key_exists('budaya', $programs) ? 'budaya' : array_key_first($programs);
        }

        return $slug;
    }

    /* cari id program implementasi dari slug/nama program (mis. "budaya" => 1) */
    public static function idForProgram($program)
    {
        $slug = Str::slug((string) $program);
        if ($slug === '') {
            return null;
        }

        foreach (static::query()->get(['id', 'nama_program', 'slug']) as $row) {
            $rowSlug = $row->slug ?: Str::slug((string) $row->nama_program);
            if ($rowSlug === $slug) {
                return $row->id;
            }
        }

        return null;
    }

    protected $casts = [
        'create_date' => 'datetime',
        'update_date' => 'datetime',
    ];

    /* Relasi ke seluruh konten program yang memakai program_implementasi_id */
    public function dokumentasi()
    {
        return $this->hasMany(ProgramDokumentasi::class, 'program_implementasi_id');
    }

    public function statistik()
    {
        return $this->hasMany(ProgramStatistik::class, 'program_implementasi_id');
    }

    public function faq()
    {
        return $this->hasMany(ProgramFaq::class, 'program_implementasi_id');
    }

    public function manfaat()
    {
        return $this->hasMany(ProgramManfaat::class, 'program_implementasi_id');
    }

    public function galeri()
    {
        return $this->hasMany(ProgramGaleri::class, 'program_implementasi_id');
    }

    public function landing()
    {
        return $this->hasMany(ProgramLanding::class, 'program_implementasi_id');
    }
}
