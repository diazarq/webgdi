<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Program;
use App\Models\ProgramImplementasi;
use App\Models\ProgramLanding;
use App\Models\ProgramDokumentasi;
use App\Models\ProgramStatistik;
use App\Models\ProgramFaq;
use App\Models\ProgramManfaat;
use App\Models\ProgramGaleri;
use App\Models\ProgramRealisasi;
use App\Models\Blog;
use App\Models\Message;
use App\Models\Widget;
use App\Models\Bank;
use App\Models\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Arr;
use Illuminate\Http\Request;


class WebsiteController extends Controller
{
    protected $bulan = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];

    public function __construct(){
        
    }

    public function index($slug=null){
        $detail = [];
        if($slug){
            if($slug == 'kalkulator-zakat'){
                return $this->index_kalkulator_zakat();
            }
            if($slug != 'donasi'){
                $detail = Menu::where('slug', $slug)->first();
                $parentID = $detail ? ($detail->parent_id == 0 ? $detail->id : $detail->parent_id) : null;
            }
            if($detail){
                switch($detail->page_type){
                    case 'general':
                        return view('website.page-general', [
                            'pageTitle' => $detail->title,
                            'detail' => $detail,
                            'active' => ['menu'.$parentID => 'current']
                        ]);
                        break;
    
                    case 'blog_list':
                        $kategori = Blog::selectRaw('DISTINCT(kategori) as kategori')->get();
                        $blog = Blog::where('status', 'publish')->orderBy('date_publish', 'desc')->paginate(9);
                        return view('website.page-blog', [
                            'pageTitle' => $detail->title,
                            'detail' => $detail,
                            'blog' => $blog,
                            'category' => $kategori,
                            'active' => ['menu'.$parentID => 'current']
                        ]);
                        break;
                    
                    case 'program_list':
                        $program = Program::selectRaw('*, (SELECT SUM(nominal) FROM program_donasis WHERE program_id = programs.id) as donasi')->where([
                            'status' => 'publish',
                            'program_type' => 'donation'
                        ])->get();
                        return view('website.page-program', [
                            'pageTitle' => $detail->title,
                            'detail' => $detail,
                            'active' => ['menu'.$parentID => 'current'],
                            'program' => $program,
                        ]);
                        break;
    
                    case 'gallery':
                        $files = File::files(public_path('images/gallery/'));
                        return view('website.page-gallery', [
                            'pageTitle' => $detail->title,
                            'detail' => $detail,
                            'active' => ['menu'.$parentID => 'current'],
                            'files' => $files
                        ]);
                        break;
    
                    case 'contact':
                        return view('website.page-contact', [
                            'pageTitle' => $detail->title,
                            'detail' => $detail,
                            'active' => ['menu'.$parentID => 'current'],
                            'slug' => $slug
                        ]);
                        break;
                }
            }else{
                return view('404');
                /* return 404 */
            }
            
        }else{
            $slider = Widget::where([
                'type' => 'slider',
                'status' => 'A'
            ])->get();
            $program = Program::selectRaw('*, (SELECT SUM(nominal) FROM program_donasis WHERE program_id = programs.id) as donasi')->where([
                'status' => 'publish',
                'program_type' => 'donation'
            ])->limit(3)->get();
            $blog = Blog::where('status', 'publish')->orderBy('date_publish', 'desc')->limit(3)->get();
            $blogHome = Blog::where('status', 'publish')->orderBy('date_publish', 'desc')->limit(6)->get();
            $blogHomeCategory = Blog::select('kategori')
                ->selectRaw('COUNT(*) as total')
                ->where('status', 'publish')
                ->groupBy('kategori')
                ->orderByDesc('total')
                ->get();
            $blogHomePopular = Blog::where('status', 'publish')->orderBy('date_publish', 'desc')->limit(5)->get();
            $ads = Widget::where([
                'type' => 'ads',
                'status' => 'A'
            ])->first();
            $info = Widget::where([
                'type' => 'general',
                'status' => 'A'
            ])->first();
            $about = Widget::where([
                'type' => 'about',
                'status' => 'A'
            ])->first();
            $programImplementasi = ProgramImplementasi::orderBy('id')->get();
            return view('website.homepage', [
                'pageTitle' => 'Yayasan Graha Dhuafa Indonesia',
                'slider' => $slider,
                'program' => $program,
                'blog' => $blog,
                'blogHome' => $blogHome,
                'blogHomeCategory' => $blogHomeCategory,
                'blogHomePopular' => $blogHomePopular,
                'ads' => $ads,
                'info' => $info,
                'about' => $about,
                'programImplementasi' => $programImplementasi
            ]);
        }
        
    }

    public function index_program($slug, $detailSlug=null){
        $detail = Menu::where('slug', 'program')->first();
        if($slug == 'donasi'){
            if($detailSlug){
                /* detail program donasi */
                $programDetail = Program::selectRaw('*, (SELECT SUM(nominal) FROM program_donasis WHERE program_id = programs.id) as donasi, (SELECT COUNT(donatur) FROM program_donasis WHERE program_id = programs.id) as donatur')
                                    ->where('slug', $detailSlug)->first();
                $programService = Program::where([
                    'status' => 'publish',
                    'program_type' => 'non-donation'
                ])->get();
                $programService = count($programService) > 0 ? $programService->random(1) : []; 

                $programRealisasi = ProgramRealisasi::where('program_id', $programDetail->id)->get();

                $programSuggest = Program::selectRaw('*, (SELECT SUM(nominal) FROM program_donasis WHERE program_id = programs.id) as donasi, (SELECT COUNT(donatur) FROM program_donasis WHERE program_id = programs.id) as donatur')
                            ->where('id', '<>', $programDetail->id)
                            ->where('program_type', 'donation')->get();
                $programSuggest = count($programSuggest) >= 3 ? $programSuggest->random(3): $programSuggest;

                return view('website.page-program-detail', [
                    'pageTitle' => $programDetail->title,
                    'active' => ['menu'.$detail->id => 'current'],
                    'parent' => 'Program',
                    'detail' => $programDetail,
                    'programService' => $programService,
                    'programRealisasi' => $programRealisasi,
                    'programSuggest' => $programSuggest
                ]);
            }else{
                $program = Program::selectRaw('*, (SELECT SUM(nominal) FROM program_donasis WHERE program_id = programs.id) as donasi')->where([
                    'status' => 'publish',
                    'program_type' => 'donation'
                ])->get();
                return view('website.page-program', [
                    'pageTitle' => 'Program Donasi',
                    'active' => ['menu'.$detail->id => 'current'],
                    'parent' => 'Program',
                    'program' => $program
                ]);
            }
            
        }else{
            /* detail program non donasi */
            $programDetail = Program::selectRaw('*, (SELECT SUM(nominal) FROM program_donasis WHERE program_id = programs.id) as donasi, (SELECT COUNT(donatur) FROM program_donasis WHERE program_id = programs.id) as donatur')
                                    ->where('slug', $slug)->first();
            $programService = Program::where([
                'status' => 'publish',
                'program_type' => 'non-donation'
            ])->get();
            $programService = count($programService) > 0 ? $programService->random(1) : []; 

            $programSuggest = Program::selectRaw('*, (SELECT SUM(nominal) FROM program_donasis WHERE program_id = programs.id) as donasi, (SELECT COUNT(donatur) FROM program_donasis WHERE program_id = programs.id) as donatur')
                        ->where('program_type', 'donation')->get();
            $programSuggest = count($programSuggest) >= 3 ? $programSuggest->random(3): $programSuggest;
            return view('website.page-program-detail', [
                'pageTitle' => $programDetail->title,
                'active' => ['menu'.$detail->id => 'current'],
                'parent' => 'Program',
                'detail' => $programDetail,
                'programService' => $programService,
                'programSuggest' => $programSuggest
            ]);
        }
    }

    /* ===== Konfigurasi halaman pilar program: Budaya, Cinta, Senyum ===== */
    protected function pilarConfig()
    {
        return [
            'budaya' => [
                'title'         => 'Budaya',
                'badge'         => '3 Program Unggulan',
                'tagline'       => 'Bangun Peradaban, Berakhlak & Berkarya',
                'description'   => "Merupakan program yang berkonsentrasi pada pembangunan lingkungan\nuntuk memunculkan generasi yang kreatif, penuh karya dan Qur'ani.",
                'logo'          => 'website/assets/images/custom/budaya.png',
                'background'    => 'website/assets/images/backgrounds/page-header-bg-3.jpeg',
                'section_title' => 'Momen Kegiatan Program Budaya',
                'galeri'        => [
                    [
                        'src'     => asset('images/blog/8a0b575bfeb8b0ea7a2cf1fc2eecec38.jpg'),
                        'alt'     => 'Penyaluran manfaat wakaf untuk masyarakat',
                        'caption' => 'Wakaf & Hibah',
                        'tag'     => 'Wakaf',
                        'url'     => url('/wakaf-hibah'),
                    ],
                    [
                        'src'     => asset('images/blog/wow.jpeg'),
                        'alt'     => 'Penyaluran daging qurban Peace Qurban',
                        'caption' => 'Peace Qurban',
                        'tag'     => 'Qurban',
                        'url'     => url('/budaya'),
                    ],
                    [
                        'src'     => asset('images/blog/qiyamullail.jpg'),
                        'alt'     => 'Kajian dan zikir bersama generasi muda',
                        'caption' => 'Bandung Berzikir',
                        'tag'     => 'Dakwah',
                        'url'     => url('/budaya'),
                    ],
                ],
            ],
            'cinta' => [
                'title'         => 'Cinta',
                'badge'         => '3 Program Unggulan',
                'tagline'       => "Cinta Yatim, Cinta Al-Qur'an, Cinta Negeri",
                'description'   => "Program yang berfokus pada pembinaan anak yatim, dhuafa, dan tahfidz melalui beasiswa, pendidikan Al-Qur'an, serta kegiatan penuh kasih sayang untuk menumbuhkan generasi Qur'ani.",
                'logo'          => 'website/assets/images/custom/cinta.png',
                'background'    => 'website/assets/images/backgrounds/page-header-bg-3.jpeg',
                'section_title' => 'Momen Kegiatan Program Cinta',
                'galeri'        => [
                    [
                        'src'     => asset('images/blog/2e10e7a278d7e5b7b0bf939a2399f97a.jpg'),
                        'alt'     => 'Kegiatan Zooerney Cinta Yatim bersama anak yatim dan dhuafa',
                        'caption' => 'Zooerney Cinta Yatim',
                        'tag'     => 'Pendidikan',
                        'url'     => url('/cinta'),
                    ],
                    [
                        'src'     => asset('images/blog/qiyamullail.jpg'),
                        'alt'     => 'Pembinaan tahfidz Al-Qur\'an generasi muda',
                        'caption' => 'Graha Tahfidz',
                        'tag'     => 'Tahfidz',
                        'url'     => url('/cinta'),
                    ],
                    [
                        'src'     => asset('images/blog/8a0b575bfeb8b0ea7a2cf1fc2eecec38.jpg'),
                        'alt'     => 'Penyaluran beasiswa dan santunan anak yatim',
                        'caption' => 'Beasiswa & Santunan Yatim',
                        'tag'     => 'Beasiswa',
                        'url'     => url('/cinta'),
                    ],
                ],
            ],
            'senyum' => [
                'title'         => 'Senyum',
                'badge'         => '3 Program Unggulan',
                'tagline'       => 'Berbagi Kebahagiaan, Menghadirkan Harapan',
                'description'   => 'Program kepedulian sosial dan kemanusiaan yang menghadirkan senyum bagi masyarakat dhuafa melalui santunan, paket sembako, Jumat berbagi, serta respons cepat terhadap kebutuhan darurat.',
                'logo'          => 'website/assets/images/custom/senyum.png',
                'background'    => 'website/assets/images/backgrounds/page-header-bg-3.jpeg',
                'section_title' => 'Momen Kegiatan Program Senyum',
                'galeri'        => [
                    [
                        'src'     => asset('images/blog/rice-learnreliggions-com.jpg'),
                        'alt'     => 'Kegiatan Jumat Berbagi bersama masyarakat dhuafa',
                        'caption' => 'Jumat Berbagi',
                        'tag'     => 'Sosial',
                        'url'     => url('/senyum'),
                    ],
                    [
                        'src'     => asset('images/blog/8a0b575bfeb8b0ea7a2cf1fc2eecec38.jpg'),
                        'alt'     => 'Santunan untuk anak yatim dan dhuafa',
                        'caption' => 'Santunan Anak Yatim & Dhuafa',
                        'tag'     => 'Santunan',
                        'url'     => url('/senyum'),
                    ],
                    [
                        'src'     => asset('images/blog/sedekah-ramadhan.jpg'),
                        'alt'     => 'Penyaluran paket sembako untuk keluarga dhuafa',
                        'caption' => 'Paket Sembako Dhuafa',
                        'tag'     => 'Kemanusiaan',
                        'url'     => url('/senyum'),
                    ],
                ],
            ],
        ];
    }

    public function index_budaya()
    {
        return $this->index_pilar('budaya');
    }

    public function index_cinta()
    {
        return $this->index_pilar('cinta');
    }

    public function index_senyum()
    {
        return $this->index_pilar('senyum');
    }

    public function index_kalkulator_zakat()
    {
        $detail = Menu::where('slug', 'kalkulator-zakat')->first();
        $parentID = $detail ? ($detail->parent_id == 0 ? $detail->id : $detail->parent_id) : 10;
        return view('website.page-kalkulator-zakat', [
            'pageTitle' => $detail ? $detail->title : 'Kalkulator Zakat',
            'detail' => $detail,
            'active' => ['menu'.$parentID => 'current']
        ]);
    }

    /**
     * Render halaman pilar program dengan tampilan yang sama.
     * Hero dan dokumentasi diambil dari database sesuai slug program.
     */
    protected function index_pilar($slug)
    {
        $configs = $this->pilarConfig();
        if (!isset($configs[$slug])) {
            abort(404);
        }
        $config = $configs[$slug];

        /* hero landing dari database (dikelola di menu admin: Program > Hero Landing) */
        $landing = ProgramLanding::where('slug', $slug)->where('status', 'A')->first();

        /* statistik, manfaat, dan FAQ khusus program ini (data level program) */
        $statistik = ProgramStatistik::where('program', $slug)
            ->whereNull('program_dokumentasi_id')
            ->orderBy('urutan')->orderBy('id')->get();

        $manfaat = ProgramManfaat::where('program', $slug)
            ->whereNull('program_dokumentasi_id')
            ->orderBy('urutan')->orderBy('id')->get()
            ->map(function ($m) {
                return ['title' => $m->judul, 'desc' => $m->deskripsi];
            })->all();

        $faq = ProgramFaq::where('program', $slug)
            ->whereNull('program_dokumentasi_id')
            ->orderBy('urutan')->orderBy('id')->get()
            ->map(function ($q) {
                return ['question' => $q->pertanyaan, 'answer' => $q->jawaban];
            })->all();

        /* dokumentasi kegiatan dari database (dikelola di menu admin: Program > Kelola Dokumentasi Program) */
        $dokumentasi = ProgramDokumentasi::where(function ($query) use ($slug) {
            $query->where('program', $slug);
            /* kompatibilitas data lama yang belum punya penanda program */
            if ($slug === 'budaya') {
                $query->orWhereNull('program');
            }
        })->orderBy('urutan')->orderBy('id')->get()
            ->map(function ($d) use ($config) {
                $img = $d->gambar_url && file_exists(public_path($d->gambar_url))
                    ? asset($d->gambar_url)
                    : asset($config['logo']);
                /* bangun URL dari path agar selalu benar (root maupun subfolder) */
                $path = $d->link_detail ? (parse_url($d->link_detail, PHP_URL_PATH) ?: null) : null;
                return [
                    'src'     => $img,
                    'alt'     => $d->judul_kegiatan ?: 'Dokumentasi Kegiatan',
                    'caption' => $d->judul_kegiatan ?: 'Dokumentasi Kegiatan',
                    'tag'     => $d->kategori_badge ?: 'PROGRAM',
                    'url'     => $path ? url($path) : null,
                ];
            })->all();

        /* fallback ke data contoh bila belum ada dokumentasi di database */
        if (empty($dokumentasi)) {
            $dokumentasi = $config['galeri'];
        }

        return view('website.page-budaya', [
            'pageTitle'   => $config['title'] . ' — Graha Dhuafa Indonesia',
            'pilar'       => $config,
            'dokumentasi' => $dokumentasi,
            'landing'     => $landing,
            'statistik'   => $statistik,
            'manfaat'     => $manfaat,
            'faq'         => $faq,
        ]);
    }

    public function index_wakaf_hibah()
    {
        $programSlug = 'budaya';

        /* Kegiatan Wakaf & Hibah dikelola di admin: Program > Dokumentasi Program */
        $dokumentasi = ProgramDokumentasi::where('program', $programSlug)
            ->where(function ($query) {
                $query->where('link_detail', 'like', '%wakaf-hibah%')
                    ->orWhere('judul_kegiatan', 'like', '%Wakaf%');
            })
            ->orderBy('urutan')->orderBy('id')->first();

        $dokumentasiId = $dokumentasi ? $dokumentasi->id : null;

        /* statistik & FAQ: data kegiatan dulu, lalu data level program */
        $statistik = $this->wakafProgramData(ProgramStatistik::class, $programSlug, $dokumentasiId);

        $faq = $this->wakafProgramData(ProgramFaq::class, $programSlug, $dokumentasiId)
            ->map(function ($row) {
                return ['question' => $row->pertanyaan, 'answer' => $row->jawaban];
            })->all();

        /* manfaat: data kegiatan, level program, lalu teks bawaan halaman */
        $manfaat = $this->wakafProgramData(ProgramManfaat::class, $programSlug, $dokumentasiId)
            ->map(function ($row) {
                return ['title' => $row->judul, 'desc' => $row->deskripsi];
            })->all();
        if (empty($manfaat)) {
            $manfaat = $this->wakafManfaatDefault();
        }

        /* galeri: data kegiatan, level program, lalu foto bawaan halaman */
        $galeri = $this->wakafProgramData(ProgramGaleri::class, $programSlug, $dokumentasiId)
            ->map(function ($row) {
                /* kolom `keterangan` = judul foto, kolom `alt_text` = keterangan foto */
                return $this->wakafGaleriItem($row->gambar_url, $row->keterangan, $row->alt_text);
            })->all();
        if (empty($galeri)) {
            $galeri = $this->wakafGaleriDefault();
        }

        /* video kegiatan: dokumentasi program yang punya Link YouTube di admin */
        $videoSlides = $this->wakafVideoSlides($programSlug);

        /* hero landing dari database (dikelola di menu admin: Program > Hero Landing) */
        $landing = ProgramLanding::where('slug', 'wakaf-hibah')->where('status', 'A')->first();

        return view('website.page-wakaf-hibah', [
            'pageTitle'    => 'Wakaf & Hibah — Graha Dhuafa Indonesia',
            'manfaat'      => $manfaat,
            'galeri'       => $galeri,
            'videoSlides'  => $videoSlides,
            'landing'      => $landing,
            'statistik'    => $statistik,
            'faq'          => $faq,
            'dokumentasi'  => $dokumentasi,
        ]);
    }

    /* Ambil data program: khusus kegiatan (dokumentasi) dulu, lalu level program. */
    protected function wakafProgramData($model, $programSlug, $dokumentasiId)
    {
        if ($dokumentasiId) {
            $rows = $model::where('program', $programSlug)
                ->where('program_dokumentasi_id', $dokumentasiId)
                ->orderBy('urutan')->orderBy('id')->get();

            if ($rows->isNotEmpty()) {
                return $rows;
            }
        }

        return $model::where('program', $programSlug)
            ->whereNull('program_dokumentasi_id')
            ->orderBy('urutan')->orderBy('id')->get();
    }

    /* Satu item galeri untuk halaman Wakaf & Hibah. */
    protected function wakafGaleriItem($gambarUrl, $judul, $keterangan)
    {
        $src = $gambarUrl && file_exists(public_path($gambarUrl))
            ? asset($gambarUrl)
            : asset('images/blog/8a0b575bfeb8b0ea7a2cf1fc2eecec38.jpg');

        return [
            'src'     => $src,
            'alt'     => $keterangan ?: ($judul ?: 'Foto galeri Wakaf & Hibah'),
            'judul'   => $judul ?: '',
            'caption' => $keterangan ?: $judul,
        ];
    }

    /* Teks manfaat bawaan halaman bila belum ada data di admin. */
    protected function wakafManfaatDefault()
    {
        return [
            [
                'title' => 'Pahala Jariyah Berkelanjutan',
                'desc'  => 'Manfaat wakaf terus mengalir selama fasilitasnya digunakan masyarakat, pahalanya pun terus berjalan meski pemberi wakaf telah tiada.',
            ],
            [
                'title' => 'Menopang Dakwah & Sosial',
                'desc'  => 'Wakaf dan hibah Anda menopang operasional serta pengembangan program dakwah dan sosial Graha Dhuafa Indonesia.',
            ],
            [
                'title' => 'Tepat Sasaran & Amanah',
                'desc'  => 'Pengelolaan dilakukan secara profesional dan transparan, diprioritaskan untuk masyarakat dhuafa yang paling membutuhkan.',
            ],
        ];
    }

    /* Foto galeri bawaan halaman bila belum ada data di admin. */
    protected function wakafGaleriDefault()
    {
        return [
            $this->wakafGaleriItem('images/blog/8a0b575bfeb8b0ea7a2cf1fc2eecec38.jpg', 'Penyaluran manfaat wakaf', 'Penyaluran manfaat wakaf untuk masyarakat'),
            $this->wakafGaleriItem('images/blog/sedekah-ramadhan.jpg', 'Santunan & sedekah Ramadhan', 'Penyaluran sedekah dan wakaf di bulan Ramadhan'),
            $this->wakafGaleriItem('images/blog/rice-learnreliggions-com.jpg', 'Bantuan bahan pokok dhuafa', 'Penyaluran bahan pokok untuk masyarakat dhuafa'),
        ];
    }

    /* Slide video kegiatan dari field Link YouTube + Deskripsi Video di admin. */
    protected function wakafVideoSlides($programSlug)
    {
        $rows = ProgramDokumentasi::where('program', $programSlug)
            ->whereNotNull('youtube_url')
            ->where('youtube_url', '<>', '')
            ->orderBy('urutan')->orderBy('id')->get();

        $slides = $rows->map(function ($row) {
            $points = preg_split('/\r\n|\r|\n/', (string) $row->deskripsi_video);
            $points = array_values(array_filter(array_map('trim', $points), function ($line) {
                return $line !== '';
            }));

            if (empty($points)) {
                $points = ['Dokumentasi kegiatan ' . ($row->judul_kegiatan ?: 'Wakaf & Hibah') . '.'];
            }

            return [
                'title'     => $row->judul_kegiatan ?: 'Kegiatan Wakaf & Hibah',
                'points'    => $points,
                'embed_url' => $this->youtubeEmbedUrl($row->youtube_url),
            ];
        })->all();

        if (empty($slides)) {
            $slides = $this->wakafVideoDefault();
        }

        return $slides;
    }

    /* Video bawaan halaman bila belum ada Link YouTube di admin. */
    protected function wakafVideoDefault()
    {
        return [
            [
                'title'     => 'Zoorney With Anak Yatim & Dhuafa',
                'points'    => [
                    'Rekreasi dan edukasi seru bersama adik-adik yatim & dhuafa di Kebun Binatang Bandung.',
                    'Momen kebersamaan yang membangun rasa percaya diri dan kebahagiaan adik-adik.',
                    'Wujud nyata kepedulian wakif & donatur yang menyalurkan kebahagiaan.',
                ],
                'embed_url' => 'https://www.youtube.com/embed/sLf7wPMENnc',
            ],
            [
                'title'     => 'Penyaluran Wakaf & Hibah',
                'points'    => [
                    'Wakaf dan hibah wakif disalurkan secara amanah dan transparan.',
                    'Diprioritaskan untuk masyarakat dhuafa yang paling membutuhkan.',
                    'Laporan penyaluran terbuka untuk seluruh wakif dan donatur.',
                ],
                'embed_url' => 'https://www.youtube.com/embed/sLf7wPMENnc',
            ],
            [
                'title'     => 'Bandung Berzikir',
                'points'    => [
                    'Event zikir & kajian massal bagi generasi muda Bandung.',
                    'Wahana silaturahmi, pengajian, dan pembinaan spiritual.',
                    'Didukung penuh oleh dana wakaf & hibah para dermawan.',
                ],
                'embed_url' => 'https://www.youtube.com/embed/sLf7wPMENnc',
            ],
        ];
    }

    /* Ubah link YouTube biasa menjadi URL embed (aman untuk iframe). */
    protected function youtubeEmbedUrl($url)
    {
        if (!$url) {
            return '';
        }

        if (strpos($url, 'youtube.com/embed/') !== false) {
            return $url;
        }

        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|shorts/|embed/))([A-Za-z0-9_-]{6,})~i', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        return $url;
    }

    public function index_blog($slug){
        $menu = Menu::where([
            'page_type' => 'blog_list',
        ])->first();
        $parentID = $menu->parent_id ? $menu->parent_id : $menu->id;

        $detail = Blog::where('slug', $slug)->first();
        $blog = Blog::where('id', '<>', $detail->id)->where('status', 'publish')->orderBy('date_publish', 'desc')->get();
        $kategori = Blog::selectRaw('DISTINCT(kategori) as kategori')->get();
        return view('website.page-blog-detail', [
            'pageTitle' => $detail->title,
            'parent' => $menu->title,
            'detail' => $detail,
            'category' => $kategori,
            'active' => ['menu'.$parentID => 'current'],
            'blog' => $blog
        ]);
    }

    public function index_blog_category($category){
        $menu = Menu::where([
            'page_type' => 'blog_list',
        ])->first();
        $parentID = $menu->parent_id ? $menu->parent_id : $menu->id;

        $blog = Blog::where([
            'status' => 'publish',
            'kategori' => $category
        ])->get();
        $blogLatest = Blog::where('status', 'publish')->orderBy('date_publish', 'desc')->get();
        $kategori = Blog::selectRaw('DISTINCT(kategori) as kategori')->get();
        return view('website.page-blog', [
            'pageTitle' => $menu->title,
            'category' => $kategori,
            'active' => ['menu'.$parentID => 'current'],
            'blog' => $blog,
            'blogLatest' => $blogLatest,
            'categoryKey' => $category
        ]);
    }

    public function store_message(Request $req){
        $dataInput = [
            'sender' => $req->name,
            'email' => $req->email,
            'phone' => $req->phone,
            'subject' => $req->subject,
            'content' => $req->message,
            'date_send' => date('Y-m-d H:i:s'),
            'status' => 'new'
        ];

        Message::create($dataInput);
        return redirect('/'.$req->slug)->with('success', true);
    }

    public function index_form_zakat(Request $request){
        $nominal = $request->nominal;
        $jenis = $request->jenis;
        
        $bank = Bank::where([
            'status' => 'A'
        ])->get();
        return view('website.page-form-zakat', [
            'bank' => $bank,
            'jenis' => $jenis,
            'nominal' => $nominal
        ]);
    }
    public function index_inv_zakat($code){
        $detail = Payment::where('transcode', $code)->first();
        $bank = Bank::find($detail->bank_id);
        $exp_date = date('d', strtotime($detail->exp_at)).' '.Arr::get($this->bulan, date('m', strtotime($detail->exp_at))).' '.date('Y', strtotime($detail->exp_at)).' Pukul '.date('H:i', strtotime($detail->exp_at));
        $created_date = date('d', strtotime($detail->created_at)).' '.Arr::get($this->bulan, date('m', strtotime($detail->created_at))).' '.date('Y', strtotime($detail->created_at)).' Pukul '.date('H:i', strtotime($detail->created_at));
        return view('website.page-invoice-zakat', [
            'detail' => $detail,
            'bank' => $bank,
            'expire' => $exp_date,
            'created' => $created_date
        ]);
    }
    public function index_status_zakat($code){
        $check = Payment::where('transcode', $code)->first();
        if($check->status == 'pending'){
            $dataInput = [
                'status' => 'on_confirm'
            ];
            Payment::where('transcode', $code)->update($dataInput);
        }
        
        $detail = Payment::where('transcode', $code)->first();
        $bank = Bank::find($detail->bank_id);
        $exp_date = date('d', strtotime($detail->exp_at)).' '.Arr::get($this->bulan, date('m', strtotime($detail->exp_at))).' '.date('Y', strtotime($detail->exp_at)).' Pukul '.date('H:i', strtotime($detail->exp_at));
        $created_date = date('d', strtotime($detail->created_at)).' '.Arr::get($this->bulan, date('m', strtotime($detail->created_at))).' '.date('Y', strtotime($detail->created_at)).' Pukul '.date('H:i', strtotime($detail->created_at));
        return view('website.page-status-zakat', [
            'detail' => $detail,
            'bank' => $bank,
            'expire' => $exp_date,
            'created' => $created_date
        ]);
    }
    public function index_about_zakat(){
        return view('website.page-about-zakat');
    }
    public function index_calc_zakat(){
        return view('website.page-calc-zakat');
    }
}
