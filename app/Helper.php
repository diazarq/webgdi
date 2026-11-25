<?php

namespace App;

use App\Models\Menu;
use App\Models\SocialMedia;
use App\Models\Meta;
use App\Models\Program;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class Helper{
    public static function dateFormat($date){
        $month = [
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

        $d = date('d', strtotime($date));
        $m = date('m', strtotime($date));
        $y = date('Y', strtotime($date));

        return $d.' '.Arr::get($month, $m).' '.$y;
    }

    public static function totalDays($dateEnd){
        $startDate = Carbon::parse(date('Y-m-d'));
        $endDate = Carbon::parse($dateEnd);
        $interval = $startDate->diffInDays($endDate, false);
        return $interval;
    }

    public static function displayMenu(){
        $arrMenu = [
            [
                'id' => 0,
                'title' => 'Beranda',
                'url' => '',
                'submenu' => [],
                'type' => 'homepage'
            ]
        ];

        $parent = Menu::where([
            'parent_id' => 0,
            'status_display' => 'publish'
        ])->orderBy('order', 'asc')->orderBy('id', 'asc')->get();
        if($parent){
            foreach($parent as $p){
                $submenu = [];
                $child = Menu::where([
                    'parent_id' => $p->id,
                    'status_display' => 'publish'
                ])->orderBy('order', 'asc')->orderBy('id', 'asc')->get();
                if($child){
                    foreach($child as $c){
                        $submenu[] = [
                            'id' => $c->id,
                            'title' => $c->title,
                            'url' => $c->menu_type == 'page' ? $c->slug : ($c->url ?: $c->slug),
                        ];
                    }
                }

                if($p->page_type == 'program_list'){
                    /* diisi daftar program */
                    $submenu = [
                        [
                            'id' => 0,
                            'title' => 'Program Donasi/Fundraising',
                            'url' => 'program/donasi'
                        ],
                    ];

                    $program = Program::where([
                        'status' => 'publish',
                        'program_type' => 'non-donation'
                    ])->get();

                    if($program){
                        foreach($program as $prog){
                            $submenu[] = [
                                'id' => $prog->id,
                                'title' => $prog->title,
                                'url' => 'program/'.$prog->slug
                            ];
                        }
                    }

                }

                if(strtolower(trim($p->title)) === 'layanan'){
                    $submenu[] = [
                        'id' => 991,
                        'title' => 'Daftar Relawan (Sahabat Baik)',
                        'url' => 'volunteer/daftar'
                    ];
                    $submenu[] = [
                        'id' => 992,
                        'title' => 'Daftar Mitra Amil Zakat',
                        'url' => 'mitra/daftar'
                    ];
                    $submenu[] = [
                        'id' => 993,
                        'title' => 'Portal Relawan & Mitra (Login)',
                        'url' => 'z/login'
                    ];
                }

                if($p->page_type == 'blog_list' || strtolower(trim($p->title)) === 'blog'){
                    if(empty($submenu)){
                        $submenu = [
                            [
                                'id' => 801,
                                'title' => 'LAZNews',
                                'url' => 'blog/jenis/laznews'
                            ],
                            [
                                'id' => 802,
                                'title' => 'LAZJourney',
                                'url' => 'blog/jenis/lazjourney'
                            ],
                            [
                                'id' => 803,
                                'title' => 'LAZSalam',
                                'url' => 'blog/jenis/lazsalam'
                            ],
                        ];
                    }
                }
                $arrMenu[] = [
                    'id' => $p->id,
                    'title' => $p->title,
                    'url' => $p->menu_type == 'page' ? $p->slug : $p->url,
                    'submenu' => $submenu,
                    'type' => $p->page_type
                ];
            }
        }

        return $arrMenu;
    }

    public static function getFooterSettings($key = null, $default = null)
    {
        $defaultSettings = [
            'about_text' => 'Menjadi lembaga global yang profesional untuk peduli menjaga generasi mandiri dan unggul',
            'cta_text' => 'Zakat Sekarang',
            'cta_url' => '/app/zakat',
            'quick_links_title' => 'Quick Links',
            'program_title' => 'Program',
            'contact_title' => 'Kontak',
            'copyright_text' => '© copyright ' . date('Y') . ' by Yayasan Graha Dhuafa Indonesia',
        ];

        try {
            $meta = Meta::where('var', 'FOOTER_SETTINGS')->first();
            if ($meta && !empty($meta->value)) {
                $saved = json_decode($meta->value, true);
                if (is_array($saved)) {
                    $defaultSettings = array_merge($defaultSettings, $saved);
                }
            }
        } catch (\Exception $e) {
            // fallback to default
        }

        if ($key !== null) {
            return $defaultSettings[$key] ?? $default;
        }

        return $defaultSettings;
    }

    public static function displayFooterMenu($category = 'quick_link'){
        if (class_exists('App\Models\FooterMenu')) {
            $footerMenus = \App\Models\FooterMenu::where('category', $category)
                ->where('status', 'A')
                ->orderBy('order', 'asc')
                ->get();
            if ($footerMenus && $footerMenus->count() > 0) {
                return $footerMenus;
            }
        }
        return collect([]);
    }

    public static function displaySocialMedia(){
        return SocialMedia::where('status', 'A')->get();
    }

    public static function displayContact(){
        $telp = Meta::where('var', 'INST_TELP')->first();
        $addr = Meta::where('var', 'INST_ADDR')->first();
        $email = Meta::where('var', 'INST_EMAIL')->first(); 
        $gooMap = Meta::where('var', 'GOO_MAP')->first(); 
        $result = [
            'inst_telp' => $telp ? $telp->value : '',
            'inst_addr' => $addr ? $addr->value : '',
            'inst_email' => $email ? $email->value : '',
            'inst_map' => $gooMap ? $gooMap->value : ''
        ];

        return $result;
    }

    public static function displayBranch(){
        $branch = Meta::where('var', 'BRANCH')->first();

        return ($branch && $branch->value) ? json_decode($branch->value, TRUE) : [];
    }

    /**
     * Ambil pengaturan fitur elemen tema (on/off via check-uncheck).
     */
    public static function getThemeSetting($key, $default = true) {
        static $themeSettings = null;
        if ($themeSettings === null) {
            $meta = Meta::where('var', 'THEME_SETTINGS')->first();
            $themeSettings = ($meta && $meta->value) ? json_decode($meta->value, true) : [];
        }
        return isset($themeSettings[$key]) ? (bool)$themeSettings[$key] : $default;
    }
}
