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
        ])->get();
        if($parent){
            foreach($parent as $p){
                $submenu = [];
                $child = Menu::where([
                    'parent_id' => $p->id,
                    'status_display' => 'publish'
                ])->get();
                if($child){
                    foreach($child as $c){
                        $submenu[] = [
                            'id' => $c->id,
                            'title' => $c->title,
                            'url' => $c->menu_type == 'page' ? $c->slug : $p->url,
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

    public static function displayFooterMenu(){
        $result = Menu::where('footer_display', 'A')->get();

        return $result;
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
