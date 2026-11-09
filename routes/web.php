<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Controllers\RedactorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\WidgetController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\MetaController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProgramImplementasiController;
use App\Http\Controllers\ProgramUtamaController;
use App\Http\Controllers\ProgramLandingController;
use App\Http\Controllers\ProgramDokumentasiController;
use App\Http\Controllers\ProgramStatistikController;
use App\Http\Controllers\ProgramFaqController;
use App\Http\Controllers\ProgramManfaatController;
use App\Http\Controllers\ProgramGaleriController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\PaymentController;
use App\Http\Kernel;
use App\Http\Controllers\Widget\ProgramLazController;
use App\Http\Controllers\Website\BlogFrontController;
use App\Http\Controllers\DonasiCampaignController;
use App\Http\Controllers\AdminDonasiCampaignController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* front website */
Route::get('/', [WebsiteController::class, 'index']);

/* ROUTE BLOG FRONT — HARUS SEBELUM /{slug} (catch-all), agar /blog tidak tertelan 404 */
Route::get('/blog', [BlogFrontController::class, 'index'])->name('website.blog');
Route::get('/blog/category/{kategori}', [BlogFrontController::class, 'index'])->name('website.blog.category');
Route::get('/blog/{slug}', [BlogFrontController::class, 'show'])->name('website.blog.detail');

Route::get('/budaya', [WebsiteController::class, 'index_budaya']);
Route::get('/cinta', [WebsiteController::class, 'index_cinta']);
Route::get('/senyum', [WebsiteController::class, 'index_senyum']);
Route::get('/wakaf-hibah', [WebsiteController::class, 'index_wakaf_hibah']);
Route::get('/kalkulator-zakat', [WebsiteController::class, 'index_kalkulator_zakat'])->name('website.kalkulator_zakat');

/* SIMULASI MIDTRANS PAYMENT GATEWAY (SANDBOX / SNAP) - HARUS SEBELUM /{slug} */
Route::get('/simulasi-midtrans', [MidtransController::class, 'index'])->name('midtrans.index');
Route::post('/simulasi-midtrans/token', [MidtransController::class, 'createSnapToken'])->name('midtrans.token');
Route::get('/simulasi-midtrans/finish', [MidtransController::class, 'finish'])->name('midtrans.finish');
Route::get('/simulasi-midtrans/invoice/{transcode}', [MidtransController::class, 'invoice'])->name('midtrans.invoice');
Route::post('/midtrans/notification', [MidtransController::class, 'notification'])->name('midtrans.notification');

/* SISTEM DONASI CAMPAIGN & BENCANA ALAM (KITABISA STYLE + MIDTRANS SNAP) */
Route::get('/donasi', [DonasiCampaignController::class, 'index'])->name('donasi.index');
Route::post('/donasi/snap-token', [DonasiCampaignController::class, 'createSnapToken'])->name('donasi.snap-token');
Route::get('/donasi-selesai', [DonasiCampaignController::class, 'finish'])->name('donasi.finish');
Route::get('/donasi/check-status/{transcode}', [DonasiCampaignController::class, 'checkStatus'])->name('donasi.check-status');
Route::get('/donasi/invoice/{transcode}', [DonasiCampaignController::class, 'invoice'])->name('donasi.invoice');
Route::get('/donasi/{slug}/form', [DonasiCampaignController::class, 'form'])->name('donasi.form');
Route::get('/donasi/{slug}', [DonasiCampaignController::class, 'detail'])->name('donasi.detail');

Route::get('/{slug}', [WebsiteController::class, 'index']);
Route::get('/program/{slug}', [WebsiteController::class, 'index_program']);
Route::get('/program/{slug}/{detailSlug}', [WebsiteController::class, 'index_program']);



Route::post('/message/send', [WebsiteController::class, 'store_message']);

Route::get('/app/zakat', [WebsiteController::class, 'index_form_zakat']);
Route::get('/app/zakat/tunaikan', [WebsiteController::class, 'index_form_zakat']);
Route::get('/app/zakat/iq/{code}', [WebsiteController::class, 'index_inv_zakat']);
Route::get('/app/zakat/detail/{code}', [WebsiteController::class, 'index_status_zakat']);
Route::get('/app/zakat/kalkulator', [WebsiteController::class, 'index_calc_zakat']);
Route::get('/app/zakat/informasi', [WebsiteController::class, 'index_about_zakat']);

Route::post('/q/login', [AuthController::class, 'authenticate']);
Route::get('/q/logout', [AuthController::class, 'logout']);
Route::get('/q/login', function(){
    return view('auth.login');
})->name('login');

/*
Route::get('/dashboard', function(){
    return view('sample');
});
Route::get('/', function () {
    return view('welcome');
});
*/

Route::group(['prefix'=>'admin', 'middleware'=>['auth']], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    /* PLUGINS: REDACTORX */
    Route::post('/redactor/upload', [RedactorController::class, 'upload']);

    /* BAGIAN OCHA */
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/table', [UserController::class, 'table']);
    Route::get('/user/{id}/delete', [UserController::class, 'delete']);
    Route::get('/user/add', [UserController::class, 'form']);
    Route::get('/user/{id}/edit', [UserController::class, 'form']);
    Route::get('/user/detail', [UserController::class, 'detail']);
    Route::post('/user/add', [UserController::class, 'store']);

    /* KELOLA TEMA (ON/OFF ELEMEN & CHECK/UNCHECK) */
    Route::get('/theme', [ThemeController::class, 'index'])->name('admin.theme.index');
    Route::post('/theme/save', [ThemeController::class, 'save'])->name('admin.theme.save');

    /* BLOG */
    Route::get('/blog', [BlogController::class, 'index']);
    Route::get('/blog/table', [BlogController::class, 'table']);
    Route::get('/blog/{id}/delete', [BlogController::class, 'delete']);
    Route::get('/blog/add', [BlogController::class, 'form']);
    Route::get('/blog/{id}/edit', [BlogController::class, 'form']);
    Route::post('/blog/add', [BlogController::class, 'store']);

    /* GALERI */
    Route::get('/gallery', [GalleryController::class, 'index']);
    Route::post('/gallery/save', [GalleryController::class, 'store']);
    Route::post('/gallery/delete', [GalleryController::class, 'delete']);

    /* PROGRAM */
    Route::get('/program', [ProgramController::class, 'index']);
    Route::get('/program/table', [ProgramController::class, 'table']);
    Route::get('/program/add', [ProgramController::class, 'form']);
    Route::get('/program/{id}/delete', [ProgramController::class, 'delete']);
    Route::get('/program/{id}/edit', [ProgramController::class, 'form']);
    Route::get('/program/{id}/detail', [ProgramController::class, 'detail']);
    Route::post('/program/add', [ProgramController::class, 'store']);

    Route::get('/program/realisasi/{id}/table', [ProgramController::class, 'table_realisasi']);
    Route::get('/program/realisasi/{program}/add', [ProgramController::class, 'form_realisasi']);
    Route::get('/program/realisasi/{program}/{id}/edit', [ProgramController::class, 'form_realisasi']);
    Route::get('/program/realisasi/{id}/delete', [ProgramController::class, 'delete_realisasi']);
    Route::post('/program/realisasi/add', [ProgramController::class, 'store_realisasi']);

    /* PROGRAM: IMPLEMENTASI */
    Route::get('/program/implementasi', [ProgramImplementasiController::class, 'index']);
    Route::get('/program/implementasi/table', [ProgramImplementasiController::class, 'table']);
    Route::get('/program/implementasi/add', [ProgramImplementasiController::class, 'form']);
    Route::get('/program/implementasi/{id}/edit', [ProgramImplementasiController::class, 'form']);
    Route::get('/program/implementasi/{id}/delete', [ProgramImplementasiController::class, 'delete']);
    Route::post('/program/implementasi/add', [ProgramImplementasiController::class, 'store']);

    /* PROGRAM: UTAMA */
    Route::get('/program/utama', [ProgramUtamaController::class, 'index']);
    Route::get('/program/utama/table', [ProgramUtamaController::class, 'table']);
    Route::get('/program/utama/add', [ProgramUtamaController::class, 'form']);
    Route::get('/program/utama/{id}/edit', [ProgramUtamaController::class, 'form']);
    Route::get('/program/utama/{id}/delete', [ProgramUtamaController::class, 'delete']);
    Route::post('/program/utama/add', [ProgramUtamaController::class, 'store']);

    /* PROGRAM: HERO LANDING */
    Route::get('/program/landing', [ProgramLandingController::class, 'index']);
    Route::get('/program/landing/table', [ProgramLandingController::class, 'table']);
    Route::get('/program/landing/urutan', [ProgramLandingController::class, 'urutan']);
    Route::post('/program/landing/move', [ProgramLandingController::class, 'move']);
    Route::get('/program/landing/add', [ProgramLandingController::class, 'form']);
    Route::get('/program/landing/{id}/edit', [ProgramLandingController::class, 'form']);
    Route::get('/program/landing/{id}/delete', [ProgramLandingController::class, 'delete']);
    Route::post('/program/landing/add', [ProgramLandingController::class, 'store']);

    /* PROGRAM: DOKUMENTASI */
    Route::get('/program/dokumentasi', [ProgramDokumentasiController::class, 'index']);
    Route::get('/program/dokumentasi/table', [ProgramDokumentasiController::class, 'table']);
    Route::get('/program/dokumentasi/add', [ProgramDokumentasiController::class, 'form']);
    Route::get('/program/dokumentasi/{id}/edit', [ProgramDokumentasiController::class, 'form']);
    Route::get('/program/dokumentasi/{id}/delete', [ProgramDokumentasiController::class, 'delete']);
    Route::post('/program/dokumentasi/add', [ProgramDokumentasiController::class, 'store']);

    /* PROGRAM: STATISTIK (4 KOTAK) */
    Route::get('/program/statistik', [ProgramStatistikController::class, 'index']);
    Route::get('/program/statistik/table', [ProgramStatistikController::class, 'table']);
    Route::get('/program/statistik/add', [ProgramStatistikController::class, 'form']);
    Route::get('/program/statistik/{id}/edit', [ProgramStatistikController::class, 'form']);
    Route::get('/program/statistik/{id}/delete', [ProgramStatistikController::class, 'delete']);
    Route::post('/program/statistik/add', [ProgramStatistikController::class, 'store']);

    /* PROGRAM: FAQ */
    Route::get('/program/faq', [ProgramFaqController::class, 'index']);
    Route::get('/program/faq/table', [ProgramFaqController::class, 'table']);
    Route::get('/program/faq/add', [ProgramFaqController::class, 'form']);
    Route::get('/program/faq/{id}/edit', [ProgramFaqController::class, 'form']);
    Route::get('/program/faq/{id}/delete', [ProgramFaqController::class, 'delete']);
    Route::post('/program/faq/add', [ProgramFaqController::class, 'store']);

    /* PROGRAM: MANFAAT */
    Route::get('/program/manfaat', [ProgramManfaatController::class, 'index']);
    Route::get('/program/manfaat/table', [ProgramManfaatController::class, 'table']);
    Route::get('/program/manfaat/add', [ProgramManfaatController::class, 'form']);
    Route::get('/program/manfaat/{id}/edit', [ProgramManfaatController::class, 'form']);
    Route::get('/program/manfaat/{id}/delete', [ProgramManfaatController::class, 'delete']);
    Route::post('/program/manfaat/add', [ProgramManfaatController::class, 'store']);

    /* PROGRAM: GALERI */
    Route::get('/program/galeri', [ProgramGaleriController::class, 'index']);
    Route::post('/program/galeri/upload', [ProgramGaleriController::class, 'upload']);
    Route::post('/program/galeri/{id}/update', [ProgramGaleriController::class, 'update']);
    Route::get('/program/galeri/{id}/delete', [ProgramGaleriController::class, 'delete']);

    Route::get('/program/rekapitulasi', [ProgramController::class, 'index_recap']);
    Route::get('/program/rekapitulasi/donatur', [ProgramController::class, 'index_recap_donatur']);
    Route::post('/program/rekapitulasi/chart', [ProgramController::class, 'getDataChart']);
    Route::post('/program/rekapitulasi/table', [ProgramController::class, 'table_recap']);
    Route::post('/program/rekapitulasi/donatur/table', [ProgramController::class, 'table_recap_donatur']);
    Route::get('/program/rekapitulasi/donatur/export/excel/{program}/{dateStart}/{dateEnd}', [ProgramController::class, 'exportExcel']);
    Route::get('/program/rekapitulasi/donatur/export/excel', [ProgramController::class, 'exportExcel']);

    /* PAYMENT/MUZAKI */
    Route::get('/zakat', [PaymentController::class, 'index']);
    Route::post('/zakat/table', [PaymentController::class, 'table']);
    Route::get('/zakat/{id}/update', [PaymentController::class, 'update_status']);

    /* MONITORING DONASI MASUK (MIDTRANS / KITABISA) */
    Route::get('/donasi-masuk', [PaymentController::class, 'index_donasi'])->name('admin.donasi.index');
    Route::post('/donasi-masuk/table', [PaymentController::class, 'table_donasi'])->name('admin.donasi.table');
    Route::get('/donasi-masuk/{id}/update', [PaymentController::class, 'update_status_donasi'])->name('admin.donasi.update');
    Route::get('/donasi-masuk/{id}/delete', [PaymentController::class, 'delete_donasi'])->name('admin.donasi.delete');
    
    /* KELOLA PILIHAN DONASI / CAMPAIGN (ADMIN) */
    Route::get('/campaign-donasi', [AdminDonasiCampaignController::class, 'index'])->name('admin.campaign.index');
    Route::get('/campaign-donasi/add', [AdminDonasiCampaignController::class, 'form'])->name('admin.campaign.add');
    Route::get('/campaign-donasi/{id}/edit', [AdminDonasiCampaignController::class, 'form'])->name('admin.campaign.edit');
    Route::post('/campaign-donasi/store', [AdminDonasiCampaignController::class, 'store'])->name('admin.campaign.store');
    Route::get('/campaign-donasi/{id}/takedown', [AdminDonasiCampaignController::class, 'toggleTakedown'])->name('admin.campaign.takedown');
    Route::get('/campaign-donasi/{id}/delete', [AdminDonasiCampaignController::class, 'delete'])->name('admin.campaign.delete');
    /* ---- */

    /* BAGIAN PA ANDRI */
    /* MENU */
    Route::get('/menu', [MenuController::class, 'index']);
    Route::get('/menu/table', [MenuController::class, 'table']);
    Route::get('/menu/add', [MenuController::class, 'form']);
    Route::get('/menu/{id}/edit', [MenuController::class, 'form']);
    Route::get('/menu/{id}/delete', [MenuController::class, 'delete']);
    Route::post('/menu/add', [MenuController::class, 'store']);

    /* WIDGET: SLIDER */
    Route::get('/widget/slider', [WidgetController::class, 'index_slider']);
    Route::get('/widget/slider/table', [WidgetController::class, 'table_slider']);
    Route::get('/widget/slider/add', [WidgetController::class, 'form_slider']);
    Route::get('/widget/slider/{id}/edit', [WidgetController::class, 'form_slider']);
    Route::get('/widget/slider/{id}/delete', [WidgetController::class, 'delete_slider']);
    Route::post('/widget/slider/add', [WidgetController::class, 'store_slider']);

    /* WIDGET: ADS */
    Route::get('/widget/ads', [WidgetController::class, 'index_ads']);
    Route::post('/widget/ads/add', [WidgetController::class, 'store_ads']);

    /* WIDGET: SELAYANG PANDANG */
    Route::get('/widget/about', [WidgetController::class, 'index_about']);
    Route::post('/widget/about/add', [WidgetController::class, 'store_about']);

    /* WIDGET: SHORT DESC/DESKRIPSI SINGKAT */
    Route::get('/widget/desc', [WidgetController::class, 'index_desc']);
    Route::post('/widget/desc/add', [WidgetController::class, 'store_desc']);

    /* META: MEDIA SOSIAL */
    Route::get('/meta/social-media', [SocialMediaController::class, 'index']);
    Route::get('/meta/social-media/{id}/detail', [SocialMediaController::class, 'detail']);
    Route::post('/meta/social-media', [SocialMediaController::class, 'update']);

    /* META: IDENTITAS INSTANSI */
    Route::get('/meta/identitas-instansi', [MetaController::class, 'index']);
    Route::post('/meta/identitas-instansi/add', [MetaController::class, 'store']);
    Route::get('/meta/bank', [MetaController::class, 'index_bank']);
    Route::get('/meta/bank/table', [MetaController::class, 'table_bank']);
    Route::get('/meta/bank/add', [MetaController::class, 'form_bank']);
    Route::get('/meta/bank/{id}/edit', [MetaController::class, 'form_bank']);
    Route::get('/meta/bank/{id}/delete', [MetaController::class, 'delete_bank']);
    Route::post('/meta/bank/add', [MetaController::class, 'store_bank']);

    /* MESSAGE */
    Route::get('/message', [MessageController::class, 'index']);
    Route::get('/message/table', [MessageController::class, 'table']);
    Route::get('/message/{id}/delete', [MessageController::class, 'delete']);
    Route::get('/message/{id}/detail', [MessageController::class, 'detail']);


     




 /* WIDGET: PROGRAM LAZ */
    Route::prefix('widget')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/programlaz', [ProgramLazController::class, 'index'])->name('admin.widget.programlaz.index');
        Route::get('/programlaz/create', [ProgramLazController::class, 'create'])->name('admin.widget.programlaz.create');
        Route::post('/programlaz', [ProgramLazController::class, 'store'])->name('admin.widget.programlaz.store');
        Route::get('/programlaz/{id}/edit', [ProgramLazController::class, 'edit'])->name('admin.widget.programlaz.edit');
        Route::put('/programlaz/{id}', [ProgramLazController::class, 'update'])->name('admin.widget.programlaz.update');
        Route::delete('/programlaz/{id}', [ProgramLazController::class, 'destroy'])->name('admin.widget.programlaz.delete');
    });
    /* ---- */


});







