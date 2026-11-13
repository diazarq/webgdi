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
     * Menggabungkan data dari penyimpanan JSON (dapat dikelola Admin) & sinkronisasi real-time donasi masuk.
     */
    public function getCampaigns()
    {
        $filePath = storage_path('app/donasi_campaigns.json');
        $data = null;
        if (File::exists($filePath)) {
            $json = File::get($filePath);
            $data = json_decode($json, true);
        }

        if (!is_array($data) || count($data) === 0) {
            $data = $this->getDefaultCampaigns();
            File::ensureDirectoryExists(dirname($filePath));
            File::put($filePath, json_encode(array_values($data), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }

        // Sinkronisasi data real-time dari donasi yang sudah berstatus 'complete' di database
        try {
            $completedPayments = Payment::where('status', 'complete')->get(['id', 'type', 'nominal', 'bank_id', 'created_at']);

            foreach ($data as &$c) {
                if (!isset($c['status'])) {
                    $c['status'] = 'active';
                }
                if (!isset($c['base_collected'])) {
                    $c['base_collected'] = (int) ($c['collected'] ?? 0);
                }
                if (!isset($c['base_donatur_count'])) {
                    $c['base_donatur_count'] = (int) ($c['donatur_count'] ?? 0);
                }

                $matchingPayments = $completedPayments->filter(function($p) use ($c) {
                    $pType = trim($p->type ?? '');
                    $cTitle = trim($c['title'] ?? '');
                    $cSlug = trim($c['slug'] ?? '');

                    // 1. Jika bank_id cocok DAN judul/slug cocok (mencegah ID bank lama mencocokkan program baru)
                    if (!empty($p->bank_id) && (int)$p->bank_id === (int)$c['id']) {
                        if ($cTitle && strcasecmp($pType, $cTitle) === 0) return true;
                        if ($cSlug && strcasecmp($pType, $cSlug) === 0) return true;
                        if ($cTitle && str_starts_with(strtolower($pType), strtolower($cTitle))) return true;
                    }

                    // 2. Jika exact match judul atau slug (fallback transaksi lama)
                    if ($cTitle && strcasecmp($pType, $cTitle) === 0) return true;
                    if ($cSlug && strcasecmp($pType, $cSlug) === 0) return true;

                    return false;
                });

                $sumNominal = $matchingPayments->sum('nominal');
                $countDonatur = $matchingPayments->count();

                $c['collected'] = (int) $c['base_collected'] + (int) $sumNominal;
                $c['donatur_count'] = (int) $c['base_donatur_count'] + (int) $countDonatur;
            }
        } catch (\Throwable $e) {
            // Failover aman jika ada kendala pembacaan database
        }

        return $data;
    }

    /**
     * Master Data Awal (Default) Campaign
     */
    public function getDefaultCampaigns()
    {
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
                'base_collected'=> 48500000,
                'donatur_count' => 312,
                'base_donatur_count' => 312,
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
                'base_collected'=> 32700000,
                'donatur_count' => 198,
                'base_donatur_count' => 198,
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
                'base_collected'=> 38250000,
                'donatur_count' => 450,
                'base_donatur_count' => 450,
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
                'base_collected'=> 29400000,
                'donatur_count' => 165,
                'base_donatur_count' => 165,
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
                'base_collected'=> 17800000,
                'donatur_count' => 110,
                'base_donatur_count' => 110,
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
        if ($request->filled('ref')) {
            session(['affiliate_ref' => $request->query('ref')]);
        }

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
    public function detail($slug, Request $request)
    {
        if ($request->filled('ref')) {
            session(['affiliate_ref' => $request->query('ref')]);
        }

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
            'isProduction'   => $this->isProduction(),
        ]);
    }

    /**
     * 2b. Halaman Khusus Formulir Donasi (Redirect ke Page Baru)
     */
    public function form($slug)
    {
        $campaigns = collect($this->getCampaigns());
        $campaign = $campaigns->firstWhere('slug', $slug);

        if (!$campaign) {
            abort(404, 'Program donasi tidak ditemukan');
        }

        // Cek jika status takedown atau target donasi sudah penuh 100%
        $isFull = ($campaign['collected'] >= $campaign['target']);
        $isTakedown = (($campaign['status'] ?? 'active') === 'takedown');

        if ($isFull || $isTakedown) {
            return redirect()->route('donasi.detail', ['slug' => $slug])
                ->with('warning', 'Penggalangan dana untuk program ini telah ditutup karena target telah terpenuhi.');
        }

        return view('website.page-form-donasi', [
            'pageTitle'    => 'Formulir Donasi - ' . $campaign['title'],
            'campaign'     => $campaign,
            'clientKey'    => $this->getClientKey(),
            'isProduction' => $this->isProduction(),
        ]);
    }

    /**
     * 3. Request Pembuatan Snap Token ke Midtrans (AJAX)
     */
    public function createSnapToken(Request $request)
    {
        // Pastikan nilai anonim berupa integer (1 atau 0) sesuai tipe boolean MySQL
        $isAnonim  = $request->has('anonim') && in_array($request->anonim, ['Y', '1', 1, true, 'on'], true);
        $anonim    = $isAnonim ? 1 : 0;

        $request->validate([
            'nominal' => 'required|numeric|min:10000',
            'name'    => $isAnonim ? 'nullable|string|max:100' : 'required|string|max:100',
            'notelp'  => 'required|string|max:20',
        ]);

        $nominal   = (int) $request->nominal;

        // Cek jika campaign berstatus takedown atau target donasi sudah penuh (100%)
        if ($request->has('campaign_slug')) {
            $campaigns = collect($this->getCampaigns());
            $found = $campaigns->firstWhere('slug', $request->campaign_slug);
            if ($found) {
                if (($found['status'] ?? 'active') === 'takedown') {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Penggalangan dana untuk program ini telah ditutup oleh admin.',
                    ], 400);
                }
                if ($found['target'] > 0 && $found['collected'] >= $found['target']) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Alhamdulillah, target donasi untuk program ini telah terpenuhi 100%. Donasi telah ditutup.',
                    ], 400);
                }
            }
        }

        $orderId   = 'MID-' . date('ymd') . rand(10000, 99999);
        $name      = $isAnonim ? 'Hamba Allah' : (trim($request->name) ?: 'Hamba Allah');
        $email     = $request->email ?: 'donatur@gdi.org';
        $notelp    = $request->notelp;
        $campaign  = $request->campaign_title ?? 'Donasi Bencana & Kebaikan';

        // Cari ID campaign untuk relasi donasi masuk
        $campaignId = $request->campaign_id;
        if (!$campaignId && $request->has('campaign_slug')) {
            $campaigns = collect($this->getCampaigns());
            $found = $campaigns->firstWhere('slug', $request->campaign_slug);
            if ($found) {
                $campaignId = $found['id'];
            }
        }

        $paymentMethod = $request->payment_method ?: 'VA BCA';

        // Simpan transaksi di database lokal status pending
        $paymentData = [
            'type'           => substr($campaign, 0, 95),
            'transcode'      => $orderId,
            'name'           => $name,
            'pronoun'        => $request->pronoun ?? 'Bapak/Ibu',
            'anonim'         => $anonim,
            'notelp'         => $notelp,
            'email'          => $email,
            'nominal'        => $nominal,
            'payment_method' => $paymentMethod,
            'bank_type'      => 'midtrans',
            'bank_id'        => $campaignId ? (int) $campaignId : 1,
            'digit'          => '0',
            'status'         => 'pending',
            'exp_at'         => date('Y-m-d H:i:s', strtotime('+24 hours')),
        ];

        try {
            $payment = Payment::create($paymentData);
        } catch (\Throwable $e) {
            // Auto heal jika ada kendala tipe kolom nominal pada MySQL
            if (str_contains($e->getMessage(), '22003') || str_contains($e->getMessage(), 'nominal')) {
                try {
                    \Illuminate\Support\Facades\DB::statement("ALTER TABLE payments MODIFY nominal DECIMAL(20, 2) NULL");
                } catch (\Throwable $ex) {}
            }
            // Coba simpan kembali
            $payment = Payment::create($paymentData);
        }

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
                    'id'       => (string) ($campaignId ?: 'donasi-gdi'),
                    'price'    => $nominal,
                    'quantity' => 1,
                    'name'     => substr($campaign, 0, 45),
                ]
            ],
            'callbacks' => [
                'finish' => route('donasi.finish'),
            ]
        ];

        // Filter otomatis channel Midtrans sesuai metode pilihan donatur (sesuai simulator Midtrans)
        if (stripos($paymentMethod, 'BCA') !== false) {
            $params['enabled_payments'] = ['bca_va'];
        } elseif (stripos($paymentMethod, 'BRI') !== false) {
            $params['enabled_payments'] = ['bri_va'];
        } elseif (stripos($paymentMethod, 'BNI') !== false) {
            $params['enabled_payments'] = ['bni_va'];
        } elseif (stripos($paymentMethod, 'Permata') !== false) {
            $params['enabled_payments'] = ['permata_va'];
        } elseif (stripos($paymentMethod, 'CIMB') !== false) {
            $params['enabled_payments'] = ['cimb_va'];
        } elseif (stripos($paymentMethod, 'Mandiri') !== false) {
            $params['enabled_payments'] = ['echannel', 'mandiri_va'];
        } elseif (stripos($paymentMethod, 'Danamon') !== false) {
            $params['enabled_payments'] = ['danamon_va', 'other_va'];
        } elseif (stripos($paymentMethod, 'BSI') !== false) {
            $params['enabled_payments'] = ['other_va'];
        } elseif (stripos($paymentMethod, 'SeaBank') !== false) {
            $params['enabled_payments'] = ['other_va'];
        } elseif (stripos($paymentMethod, 'Saqu') !== false) {
            $params['enabled_payments'] = ['other_va'];
        } elseif (stripos($paymentMethod, 'ShopeePay') !== false) {
            $params['enabled_payments'] = ['shopeepay', 'qris'];
        } elseif (stripos($paymentMethod, 'Dana') !== false) {
            $params['enabled_payments'] = ['qris'];
        } elseif (stripos($paymentMethod, 'OVO') !== false) {
            $params['enabled_payments'] = ['qris'];
        } elseif (stripos($paymentMethod, 'LinkAja') !== false) {
            $params['enabled_payments'] = ['qris'];
        } elseif (stripos($paymentMethod, 'QRIS') !== false) {
            $params['enabled_payments'] = ['qris', 'gopay', 'shopeepay'];
        } elseif (stripos($paymentMethod, 'GoPay') !== false) {
            $params['enabled_payments'] = ['gopay', 'qris'];
        }

        try {
            // Panggil API Midtrans menggunakan HTTP Client (withoutVerifying untuk lingkungan local/Windows)
            $auth = base64_encode($this->getServerKey() . ':');
            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'Authorization' => 'Basic ' . $auth,
            ])->post($this->getSnapUrl(), $params);

            if ($response->successful()) {
                $data = $response->json();
                $snapToken = $data['token'] ?? null;

                // Simpan snap_token ke database agar bisa dibuka kembali jika donatur menutup popup
                if ($snapToken) {
                    try {
                        $payment->snap_token = $snapToken;
                        $payment->save();
                    } catch (\Throwable $e) {
                        \Illuminate\Support\Facades\Log::warning('Gagal menyimpan snap_token ke database: ' . $e->getMessage());
                    }
                }

                return response()->json([
                    'status'      => 'success',
                    'snap_token'  => $snapToken,
                    'order_id'    => $orderId,
                    'invoice_url' => route('donasi.invoice', ['transcode' => $orderId]),
                    'message'     => 'Snap token Midtrans berhasil dibuat.',
                ]);
            } else {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Gagal menghubungi server Midtrans: ' . $response->body(),
                ], 500);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Exception Midtrans: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * 4. Redirect Callback Selesai dari Midtrans
     */
    public function finish(Request $request)
    {
        $orderId = $request->order_id ?? $request->orderId;
        $transactionStatus = $request->transaction_status ?? $request->status;

        if ($orderId) {
            $payment = Payment::where('transcode', $orderId)->first();
            if ($payment) {
                try {
                    if (in_array($transactionStatus, ['settlement', 'capture']) || $request->status_code == '200') {
                        $payment->status = 'complete';
                        $payment->save();
                    } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire']) || in_array($request->status_code, ['202', '407', '408'])) {
                        $payment->status = 'failed';
                        $payment->save();
                    }
                } catch (\Throwable $e) {
                    \Log::error('Gagal update status transaksi finish: ' . $e->getMessage());
                }

                return redirect()->route('donasi.invoice', ['transcode' => $orderId]);
            }
        }

        return redirect()->route('donasi.index')->with('info', 'Transaksi donasi Anda telah diproses.');
    }

    /**
     * 5. Webhook Notifikasi Otomatis dari Server Midtrans
     */
    public function notification(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $paymentType = $payload['payment_type'] ?? null;

        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $this->getServerKey());

        if ($signatureKey === $expectedSignature) {
            $payment = Payment::where('transcode', $orderId)->first();
            if ($payment) {
                if (in_array($transactionStatus, ['capture', 'settlement'])) {
                    $payment->status = 'complete';
                    $payment->payment_method = 'Midtrans (' . ($paymentType ?? 'Online') . ')';
                    $payment->save();
                } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                    $payment->status = 'failed';
                    $payment->save();
                }
            }
            return response()->json(['status' => 'success'], 200);
        }

        return response()->json(['status' => 'invalid signature'], 400);
    }

    /**
     * 6. Halaman Kuitansi / Bukti Donasi
     */
    public function invoice($transcode)
    {
        $payment = Payment::where('transcode', $transcode)->firstOrFail();

        // Cari data campaign donasi terkait
        $campaigns = collect($this->getCampaigns());
        $campaign = null;

        if (!empty($payment->bank_id)) {
            $campaign = $campaigns->firstWhere('id', (int) $payment->bank_id);
        }
        if (!$campaign && !empty($payment->type)) {
            $campaign = $campaigns->firstWhere('title', $payment->type);
        }
        if (!$campaign && !empty($payment->type)) {
            $campaign = $campaigns->firstWhere('slug', $payment->type);
        }
        if (!$campaign && !empty($payment->type)) {
            $campaign = $campaigns->first(function($c) use ($payment) {
                return stripos($c['title'], substr($payment->type, 0, 30)) !== false ||
                       stripos($payment->type, substr($c['title'], 0, 30)) !== false;
            });
        }

        $campaignSlug = $campaign ? ($campaign['slug'] ?? null) : null;

        return view('midtrans.invoice', [
            'payment'      => $payment,
            'campaign'     => $campaign,
            'campaignSlug' => $campaignSlug,
            'pageTitle'    => 'Bukti Pembayaran Donasi - Graha Dhuafa Indonesia'
        ]);
    }

    /**
     * 7. Cek Status Pembayaran Realtime ke Server Midtrans
     */
    public function checkStatus($transcode)
    {
        $payment = Payment::where('transcode', $transcode)->firstOrFail();

        try {
            $auth = base64_encode($this->getServerKey() . ':');
            $baseUrl = $this->isProduction() ? 'https://api.midtrans.com' : 'https://api.sandbox.midtrans.com';
            $response = Http::withoutVerifying()->withHeaders([
                'Accept'        => 'application/json',
                'Authorization' => 'Basic ' . $auth,
            ])->get($baseUrl . '/v2/' . $transcode . '/status');

            if ($response->successful()) {
                $data = $response->json();
                $transactionStatus = $data['transaction_status'] ?? null;
                $paymentType = $data['payment_type'] ?? null;

                if (in_array($transactionStatus, ['capture', 'settlement'])) {
                    $payment->status = 'complete';
                    if ($paymentType) {
                        $payment->payment_method = 'Midtrans (' . strtoupper($paymentType) . ')';
                    }
                    $payment->save();
                    return redirect()->route('donasi.invoice', ['transcode' => $transcode])
                        ->with('status_msg', [
                            'type' => 'success',
                            'text' => 'Alhamdulillah! Pembayaran donasi Anda telah terverifikasi LUNAS.'
                        ]);
                } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                    $payment->status = 'failed';
                    $payment->save();
                    return redirect()->route('donasi.invoice', ['transcode' => $transcode])
                        ->with('status_msg', [
                            'type' => 'error',
                            'text' => 'Transaksi donasi telah dibatalkan atau melewati batas waktu pembayaran.'
                        ]);
                } else {
                    return redirect()->route('donasi.invoice', ['transcode' => $transcode])
                        ->with('status_msg', [
                            'type' => 'info',
                            'text' => 'Status transaksi saat ini masih Menunggu Pembayaran. Silakan selesaikan pembayaran donasi Anda.'
                        ]);
                }
            }
        } catch (\Throwable $e) {
            // Silently redirect if connection issue
        }

        return redirect()->route('donasi.invoice', ['transcode' => $transcode])
            ->with('status_msg', [
                'type' => 'info',
                'text' => 'Status transaksi belum berubah. Jika Anda sudah transfer, mohon tunggu 1-2 menit lalu cek kembali.'
            ]);
    }
}

