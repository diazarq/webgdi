<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use App\Helper;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Tampilkan halaman pengaturan tema website (Check / Uncheck fitur elemen).
     */
    public function index()
    {
        $meta = Meta::where('var', 'THEME_SETTINGS')->first();
        $settings = ($meta && $meta->value) ? json_decode($meta->value, true) : [];

        // Nilai default semua elemen aktif (true)
        $defaultSettings = [
            'show_topbar'      => true, // Topbar info kontak di atas navbar
            'show_slider'      => true, // Slider utama carousel di homepage
            'show_page_header' => true, // Banner hijau latar di halaman sub-page
            'show_ads'         => true, // Slot iklan / ajakan zakat di homepage
            'sticky_navbar'    => true, // Navbar menempel saat scroll
            'show_navbar_cta'  => true, // Tombol Zakat Sekarang di navbar
        ];

        $currentSettings = array_merge($defaultSettings, $settings);

        return view('theme.index-theme', [
            'pageTitle' => 'Pengaturan: Kelola Tema',
            'active'    => ['ThemeActive' => 'active'],
            'settings'  => $currentSettings,
        ]);
    }

    /**
     * Simpan pengaturan tema dari checkbox admin.
     */
    public function save(Request $request)
    {
        // Checkbox yang dicentang bernilai 1, yang di-uncheck (tidak dikirim browser) bernilai 0
        $settings = [
            'show_topbar'      => $request->has('show_topbar') ? true : false,
            'show_slider'      => $request->has('show_slider') ? true : false,
            'show_page_header' => $request->has('show_page_header') ? true : false,
            'show_ads'         => $request->has('show_ads') ? true : false,
            'sticky_navbar'    => $request->has('sticky_navbar') ? true : false,
            'show_navbar_cta'  => $request->has('show_navbar_cta') ? true : false,
        ];

        $meta = Meta::where('var', 'THEME_SETTINGS')->first();
        if ($meta) {
            $meta->value = json_encode($settings);
            $meta->status = 'A';
            $meta->save();
        } else {
            $newMeta = new Meta();
            $newMeta->var = 'THEME_SETTINGS';
            $newMeta->value = json_encode($settings);
            $newMeta->status = 'A';
            $newMeta->save();
        }

        return redirect()->back()->with('success', 'Pengaturan tema berhasil disimpan!');
    }
}
