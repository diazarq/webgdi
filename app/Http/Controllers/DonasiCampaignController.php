<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use App\Models\Payment;
use App\Models\Program;

class DonasiCampaignController extends Controller
{
    /**
     * Konfigurasi Kunci Midtrans
     */
    protected function getServerKey()
    {
        return env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-Ne-uxZxJDtyRjFH1X6JSNy2O');
    }

    protected function getClientKey()
    {
        return env('MIDTRANS_CLIENT_KEY', 'Mid-client-41OdYqyH2hOuH_Qj');
    }

    protected function isProduction()
    {
        return env('MIDTRANS_IS_PRODUCTION', false);
    }

    protected function getSnapUrl()
    {
        return $this->isProduction()
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
    }

    /**
     * Daftar Master Data Campaign Donasi (Kitabisa Style)
     * Menggabungkan data dari penyimpanan JSON (dapat dikelola Admin) & fallback default.
     */
    public function getCampaigns()
    {
        $filePath = storage_path('app/donasi_campaigns.json');
        if (File::exists($filePath)) {
            $json = File::get($filePath);
            $data = json_decode($json, true);
            if (is_array($data) && count($data) > 0) {
                return $data;
            }
        }

        return [
            [
                'id'            => 1,
                'slug'          => 'darurat-bencana-gempa-longsor',
                'title'         => 'Darurat Bencana Gempa & Longsor: Ribuan Korban Kehilangan Rumah',
                'category'      => 'bencana-alam',
                'category_label'=> 'Bencana Alam',
                'category_badge'=> 'bg-danger',
                'image'         => 'images/blog/sedekah-ramadhan.jpg',
                'image_banner'  => 'images/blog/sedekah-ramadhan.jpg',
                'target'        => 150000000,
                'collected'     => 48500000,
                'donatur_count' => 312,
                'days_left'     => 14,
                'location'      => 'Wilayah Terdampak Bencana Alam',
                'organizer'     => 'Yayasan Graha Dhuafa Indonesia',
                'short_desc'    => 'Gempa dahsyat dan longsor menerjang pemukiman warga. Ratusan keluarga kini terpaksa bertahan di posko pengungsian darurat tanpa pakaian dan makanan yang layak.',
                'story'         => '<p class="lead">Innalillahi wa inna ilaihi rajiun. Bencana gempa bumi dan tanah longsor melanda saudara-saudara kita secara mendadak. Puluhan rumah rata dengan tanah dan akses air bersih terputus total.</p>
                <p>Saat ini, anak-anak, lansia, dan para ibu terpaksa tidur beralaskan terpal tipis di tenda-tenda darurat di tengah cuaca dingin dan hujan lebat. Pasokan makanan siap santap, selimut, susu bayi, dan obat-obatan sangat menipis.</p>
                <h5 class="fw-bold mt-4 mb-3 text-dark">Kondisi Lapangan Terkini:</h5>
                <ul>
                    <li>Lebih dari 450 jiwa mengungsi di posko pengungsian terpadu.</li>
                    <li>Akses listrik padam dan sumber air bersih tertimbun material longsor.</li>
                    <li>Kebutuhan mendesak: Tenda terpal, makanan hangat siap santap, air mineral, popok bayi, dan obat-obatan darurat.</li>
                </ul>
                <h5 class="fw-bold mt-4 mb-3 text-dark">Rencana Penyaluran Bantuan:</h5>
                <p>Setiap donasi yang Anda titipkan akan disalurkan langsung oleh Tim Relawan Tanggap Darurat LAZ Graha Dhuafa Indonesia ke titik posko pengungsian prioritas berupa:</p>
                <ol>
                    <li>Dapur Umum Makanan Bergizi & Air Bersih</li>
                    <li>Paket Selimut, Matras Tidur, dan Pakaian Layak</li>
                    <li>Posko Layanan Medis & Obat-obatan Gratis</li>
                </ol>',
            ],
            [
                'id'            => 2,
                'slug'          => 'bantu-adik-alif-kanker-darah',
                'title'         => 'Bantu Kesembuhan Adik Alif Berjuang Melawan Kanker Darah Akut',
                'category'      => 'medis',
                'category_label'=> 'Bantuan Medis',
                'category_badge'=> 'bg-warning text-dark',
                'image'         => 'images/blog/panas.jpg',
                'image_banner'  => 'images/blog/panas.jpg',
                'target'        => 80000000,
                'collected'     => 32700000,
                'donatur_count' => 198,
                'days_left'     => 21,
                'location'      => 'Rumah Sakit Umum Daerah',
                'organizer'     => 'Yayasan Graha Dhuafa Indonesia',
                'short_desc'    => 'Di usia 4 tahun, Alif harus merasakan jarum suntik dan kemoterapi rutin. Sang ayah hanya seorang buruh harian yang tak lagi mampu menanggung biaya pengobatan.',
                'story'         => '<p class="lead">Adik Alif (4 tahun) divonis menderita Leukemia Akut sejak 6 bulan yang lalu. Tubuh kecilnya semakin kurus dan sering demam tinggi disertai mimisan parah.</p>
                <p>Dokter menyatakan Alif harus menjalani kemoterapi intensif dan terapi pendukung selama 2 tahun ke depan. Banyak obat-obatan dan susu khusus medis yang tidak ditanggung oleh jaminan kesehatan.</p>
                <h5 class="fw-bold mt-4 mb-3 text-dark">Rencana Penyaluran Bantuan:</h5>
                <ul>
                    <li>Biaya pembelian obat-obatan kemoterapi khusus non-BPJS.</li>
                    <li>Susu nutrisi medis tinggi kalori untuk menaikkan berat badan Alif.</li>
                    <li>Akomodasi & transportasi ambulans bolak-balik desa ke rumah sakit rujukan.</li>
                </ul>',
            ],
            [
                'id'            => 3,
                'slug'          => 'sedekah-beras-penghafal-quran-yatim',
                'title'         => 'Sedekah Beras & Santunan 100 Anak Yatim Dhuafa Penghafal Al-Qur\'an',
                'category'      => 'yatim-dhuafa',
                'category_label'=> 'Yatim & Dhuafa',
                'category_badge'=> 'bg-success',
                'image'         => 'images/blog/2e10e7a278d7e5b7b0bf939a2399f97a.jpg',
                'image_banner'  => 'images/blog/2e10e7a278d7e5b7b0bf939a2399f97a.jpg',
                'target'        => 50000000,
                'collected'     => 38250000,
                'donatur_count' => 450,
                'days_left'     => 9,
                'location'      => 'Pesantren Yatim & Dhuafa',
                'organizer'     => 'Yayasan Graha Dhuafa Indonesia',
                'short_desc'    => 'Penuhi kebutuhan pangan dan biaya pendidikan ratusan anak yatim dhuafa yang sedang berjuang menghafal 30 juz Al-Qur\'an.',
                'story'         => '<p class="lead">"Barangsiapa yang memelihara anak yatim di antara umat Islam dengan memberinya makan dan minum, maka Allah pasti memasukkannya ke dalam surga." (HR. Tirmidzi)</p>
                <p>Di asrama pesantren yatim binaan kami, 100 santri yatim dan piatu dhuafa belajar dan menghafal Al-Qur\'an setiap hari. Kebutuhan beras bulanan mencapai 1,5 ton beras beserta lauk pauk bergizi.</p>
                <p>Mari jadikan beras dan makanan yang mereka santap mengalirkan pahala jariyah abadi bagi Anda di setiap lantunan ayat suci yang mereka baca.</p>',
            ],
            [
                'id'            => 4,
                'slug'          => 'wakaf-sumur-air-bersih-desa-kekeringan',
                'title'         => 'Wakaf Sumur Bor & Akses Air Bersih untuk Desa Rawan Kekeringan',
                'category'      => 'infrastruktur',
                'category_label'=> 'Wakaf & Air Bersih',
                'category_badge'=> 'bg-info text-dark',
                'image'         => 'images/blog/8a0b575bfeb8b0ea7a2cf1fc2eecec38.jpg',
                'image_banner'  => 'images/blog/8a0b575bfeb8b0ea7a2cf1fc2eecec38.jpg',
                'target'        => 65000000,
                'collected'     => 29400000,
                'donatur_count' => 165,
                'days_left'     => 18,
                'location'      => 'Dusun Terpencil Wilayah Pelosok',
                'organizer'     => 'Yayasan Graha Dhuafa Indonesia',
                'short_desc'    => 'Warga harus berjalan 3 km mendaki bukit demi satu jerigen air keruh. Pembangunan sumur bor akan mengalirkan air bersih bagi 250 kepala keluarga.',
                'story'         => '<p class="lead">Kekeringan panjang membuat sumur-sumur warga mengering total. Warga dan anak-anak sekolah harus berjalan kaki menempuh jarak 3 kilometer melintasi perbukitan setiap pagi dan sore.</p>
                <p>Air yang didapat pun sering kali keruh dan berkapur, mengakibatkan banyak warga menderita penyakit kulit dan pencernaan. Dengan sumur bor sedalam 70 meter dan bak penampungan air desa, masalah kekeringan ini dapat terselesaikan secara permanen.</p>',
            ],
            [
                'id'            => 5,
                'slug'          => 'beasiswa-sekolah-anak-pelosok',
                'title'         => 'Patungan Beasiswa Sekolah untuk Anak-anak Pelosok Negeri',
                'category'      => 'pendidikan',
                'category_label'=> 'Pendidikan',
                'category_badge'=> 'bg-primary',
                'image'         => 'images/blog/download (4).jpeg',
                'image_banner'  => 'images/blog/download (4).jpeg',
                'target'        => 40000000,
                'collected'     => 17800000,
                'donatur_count' => 110,
                'days_left'     => 30,
                'location'      => 'Sekolah Binaan Pelosok',
                'organizer'     => 'Yayasan Graha Dhuafa Indonesia',
                'short_desc'    => 'Bantu seragam, sepatu, dan alat tulis untuk puluhan anak berprestasi dari keluarga prasejahtera agar tidak putus sekolah.',
                'story'         => '<p class="lead">Pendidikan adalah jalan utama memutus rantai kemiskinan. Namun banyak anak di pelosok terancam putus sekolah hanya karena tidak mampu membeli seragam dan buku tulis.</p>
                <p>Melalui program beasiswa ini, kita bersama-sama memastikan mimpi anak-anak ini tetap hidup dan mereka dapat terus bersekolah hingga tuntas.</p>',
            ]
        ];
    }

    /**
     * 1. Halaman Katalog Pilihan Donasi (Kitabisa Style)
     */
    public function index(Request $request)
    {
        $category = $request->query('kategori');
        $campaigns = collect($this->getCampaigns());

        if ($category && $category !== 'semua') {
            $campaigns = $campaigns->where('category', $category);
        }

        return view('website.page-katalog-donasi', [
            'pageTitle'       => 'Pilih Donasi Kebaikan - Kitabisa Style',
            'campaigns'       => $campaigns,
            'currentCategory' => $category ?? 'semua',
        ]);
    }

    /**
     * 2. Halaman Detail Campaign / Musibah & Form Donasi Midtrans
     */
    public function detail($slug)
    {
        $campaigns = collect($this->getCampaigns());
        $campaign = $campaigns->firstWhere('slug', $slug);

        if (!$campaign) {
            abort(404, 'Program donasi tidak ditemukan');
        }

        // Ambil donasi lain sebagai rekomendasi
        $otherCampaigns = $campaigns->where('slug', '!=', $slug)->take(3);

        return view('website.page-detail-donasi', [
            'pageTitle'      => $campaign['title'] . ' - Graha Dhuafa Indonesia',
            'campaign'       => $campaign,
            'otherCampaigns' => $otherCampaigns,
            'clientKey'      => $this->getClientKey(),
        ]);
    }

    /**
     * 3. Request Pembuatan Snap Token Midtrans dari Form Donasi
     */
    public function createSnapToken(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:10000',
            'name'    => 'required|string|max:100',
            'notelp'  => 'required|string|max:20',
        ]);

        $nominal   = (int) $request->nominal;

        // Cek jika campaign berstatus takedown / ditutup
        if ($request->has('campaign_slug')) {
            $campaigns = collect($this->getCampaigns());
            $found = $campaigns->firstWhere('slug', $request->campaign_slug);
            if ($found && ($found['status'] ?? 'active') === 'takedown') {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Penggalangan dana untuk program ini telah ditutup oleh admin karena target donasi telah tercapai.',
                ], 400);
            }
        }

        $orderId   = 'MID-' . date('ymd') . rand(1000, 9999);
        $name      = $request->name;
        $email     = $request->email ?: 'donatur@gdi.org';
        $notelp    = $request->notelp;
        
        // Pastikan nilai anonim berupa integer (1 atau 0) sesuai tipe boolean MySQL
        $isAnonim  = $request->has('anonim') && in_array($request->anonim, ['Y', '1', 1, true, 'on'], true);
        $anonim    = $isAnonim ? 1 : 0;
        $doa       = $request->doa ?? '';
        $campaign  = $request->campaign_title ?? 'Donasi Bencana & Kebaikan';

        // Simpan transaksi di database lokal
        Payment::create([
            'type'           => substr($campaign, 0, 95),
            'transcode'      => $orderId,
            'name'           => $anonim ? 'Hamba Allah' : $name,
            'pronoun'        => $request->pronoun ?? 'Bapak/Ibu',
            'anonim'         => $anonim,
            'notelp'         => $notelp,
            'email'          => $email,
            'nominal'        => $nominal,
            'payment_method' => 'Midtrans Snap',
            'bank_type'      => 'midtrans',
            'digit'          => '0',
            'status'         => 'pending',
            'exp_at'         => date('Y-m-d H:i:s', strtotime('+24 hours')),
        ]);

        // Payload transaksi untuk Midtrans Snap
        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $nominal,
            ],
            'customer_details' => [
                'first_name' => $name,
                'email'      => $email,
                'phone'      => $notelp,
            ],
            'item_details' => [
                [
                    'id'       => substr($request->campaign_slug ?? 'donasi-gdi', 0, 45),
                    'price'    => $nominal,
                    'quantity' => 1,
                    'name'     => substr($campaign, 0, 45),
                ]
            ],
            'callbacks' => [
                'finish' => route('donasi.finish'),
            ]
        ];

        try {
            // Panggil API Midtrans (withoutVerifying untuk bypass masalah SSL cURL Windows)
            $auth = base64_encode($this->getServerKey() . ':');
            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'Authorization' => 'Basic ' . $auth,
            ])->post($this->getSnapUrl(), $params);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'status'     => 'success',
                    'snap_token' => $data['token'] ?? null,
                    'order_id'   => $orderId,
                ]);
            } else {
                return response()->json([
                    'status'  => 'error',
                    'message' => $response->body(),
                ], 500);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * 4. Redirect Callback Selesai dari Midtrans Snap
     */
    public function finish(Request $request)
    {
        $orderId = $request->order_id;
        $transactionStatus = $request->transaction_status;

        $payment = Payment::where('transcode', $orderId)->first();

        if ($payment) {
            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                $payment->status = 'complete';
                $payment->save();
            }
            return redirect()->route('midtrans.invoice', ['transcode' => $orderId]);
        }

        return redirect()->route('donasi.index')->with('info', 'Transaksi telah diproses.');
    }
}

