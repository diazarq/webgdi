<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminDonasiCampaignController extends Controller
{
    protected $filePath;

    public function __construct()
    {
        $this->filePath = storage_path('app/donasi_campaigns.json');
    }

    /**
     * Ambil data seluruh campaign dari penyimpanan JSON dengan sinkronisasi real-time
     */
    protected function getAllCampaigns()
    {
        $controller = new DonasiCampaignController();
        return $controller->getCampaigns();
    }

    /**
     * Simpan data seluruh campaign ke penyimpanan JSON
     */
    protected function saveAllCampaigns(array $campaigns)
    {
        File::ensureDirectoryExists(dirname($this->filePath));
        File::put($this->filePath, json_encode(array_values($campaigns), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * 1. Halaman Daftar Campaign Donasi (Admin)
     */
    public function index()
    {
        $campaigns = $this->getAllCampaigns();

        $totalActive = collect($campaigns)->where('status', 'active')->count();
        $totalTakedown = collect($campaigns)->where('status', 'takedown')->count();
        $totalTarget = collect($campaigns)->sum('target');
        $totalCollected = collect($campaigns)->sum('collected');

        return view('admin.donasi.index', [
            'pageTitle'      => 'Kelola Pilihan Donasi (Campaign)',
            'active'         => ['CampaignDonasiActive' => 'active'],
            'campaigns'      => $campaigns,
            'totalActive'    => $totalActive,
            'totalTakedown'  => $totalTakedown,
            'totalTarget'    => $totalTarget,
            'totalCollected' => $totalCollected,
        ]);
    }

    /**
     * 2. Form Tambah / Edit Donasi Baru
     */
    public function form($id = null)
    {
        $campaign = null;
        $mode = 'Tambah';

        if ($id) {
            $campaigns = $this->getAllCampaigns();
            foreach ($campaigns as $item) {
                if ($item['id'] == $id) {
                    $campaign = $item;
                    $mode = 'Ubah';
                    break;
                }
            }
            if (!$campaign) {
                return redirect()->route('admin.campaign.index')->with('error', 'Program donasi tidak ditemukan.');
            }
        }

        return view('admin.donasi.form', [
            'pageTitle' => $mode . ' Pilihan Donasi',
            'active'    => ['CampaignDonasiActive' => 'active'],
            'mode'      => $mode,
            'campaign'  => $campaign,
        ]);
    }

    /**
     * 3. Simpan Data Donasi Baru / Update
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'category'       => 'required|string',
            'target'         => 'required|numeric|min:100000',
            'days_left'      => 'required|integer|min:1',
            'short_desc'     => 'required|string',
            'story'          => 'required|string',
            'image_file'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $campaigns = $this->getAllCampaigns();
        $id = $request->id;

        // Kategori badge & label otomatis
        $categoryMap = [
            'bencana-alam' => ['label' => 'Bencana Alam', 'badge' => 'bg-danger'],
            'medis'        => ['label' => 'Bantuan Medis', 'badge' => 'bg-warning text-dark'],
            'yatim-dhuafa' => ['label' => 'Yatim & Dhuafa', 'badge' => 'bg-success'],
            'infrastruktur'=> ['label' => 'Wakaf & Air Bersih', 'badge' => 'bg-info text-dark'],
            'pendidikan'   => ['label' => 'Pendidikan', 'badge' => 'bg-primary'],
            'kemanusiaan'  => ['label' => 'Kemanusiaan', 'badge' => 'bg-secondary'],
        ];

        $catInfo = $categoryMap[$request->category] ?? ['label' => ucwords(str_replace('-', ' ', $request->category)), 'badge' => 'bg-success'];

        // Upload Cover jika ada
        $imagePath = $request->existing_image ?: 'images/blog/sedekah-ramadhan.jpg';
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'donasi_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/donasi'), $filename);
            $imagePath = 'images/donasi/' . $filename;
        }

        if ($id) {
            // Update
            foreach ($campaigns as &$item) {
                if ($item['id'] == $id) {
                    $item['title']          = $request->title;
                    $item['category']       = $request->category;
                    $item['category_label'] = $catInfo['label'];
                    $item['category_badge'] = $catInfo['badge'];
                    $item['target']         = (float) $request->target;
                    $item['days_left']      = (int) $request->days_left;
                    $item['location']       = $request->location ?: 'Indonesia';
                    $item['short_desc']     = $request->short_desc;
                    $item['story']          = $request->story;
                    $item['image']          = $imagePath;
                    $item['status']         = $request->status ?? $item['status'];
                    break;
                }
            }
            $pesan = 'Program donasi berhasil diperbarui!';
        } else {
            // Tambah Baru: Dana terkumpul & donatur selalu mulai dari 0 (dihitung otomatis dari donasi masuk)
            $maxId = count($campaigns) > 0 ? max(array_column($campaigns, 'id')) : 0;
            $newId = $maxId + 1;
            $slug = Str::slug($request->title) . '-' . Str::random(4);

            $newCampaign = [
                'id'                 => $newId,
                'slug'               => $slug,
                'title'              => $request->title,
                'category'           => $request->category,
                'category_label'     => $catInfo['label'],
                'category_badge'     => $catInfo['badge'],
                'image'              => $imagePath,
                'target'             => (float) $request->target,
                'base_collected'     => 0,
                'collected'          => 0,
                'base_donatur_count' => 0,
                'donatur_count'      => 0,
                'days_left'          => (int) $request->days_left,
                'location'           => $request->location ?: 'Indonesia',
                'organizer'          => 'Yayasan Graha Dhuafa Indonesia',
                'short_desc'         => $request->short_desc,
                'story'              => $request->story,
                'status'             => $request->status ?? 'active',
            ];

            $campaigns[] = $newCampaign;
            $pesan = 'Program donasi baru berhasil ditambahkan!';
        }

        $this->saveAllCampaigns($campaigns);

        return redirect()->route('admin.campaign.index')->with('success', $pesan);
    }

    /**
     * 4. Fitur Takedown / Pulihkan Donasi
     * Jika donasi sudah terkumpul semua atau ingin ditutup, admin bisa langsung Takedown
     */
    public function toggleTakedown($id)
    {
        $campaigns = $this->getAllCampaigns();
        $updated = false;
        $newStatus = 'active';

        foreach ($campaigns as &$item) {
            if ($item['id'] == $id) {
                // Toggle status
                $item['status'] = ($item['status'] === 'active') ? 'takedown' : 'active';
                $newStatus = $item['status'];
                $updated = true;
                break;
            }
        }

        if ($updated) {
            $this->saveAllCampaigns($campaigns);
            $msg = ($newStatus === 'takedown')
                ? 'Program donasi berhasil di-TAKEDOWN (tidak lagi menerima donasi di publik).'
                : 'Program donasi berhasil diaktifkan kembali (aktif di publik).';
            return redirect()->route('admin.campaign.index')->with('success', $msg);
        }

        return redirect()->route('admin.campaign.index')->with('error', 'Program tidak ditemukan.');
    }

    /**
     * 5. Hapus Program Donasi
     */
    public function delete($id)
    {
        $campaigns = $this->getAllCampaigns();
        $filtered = array_filter($campaigns, function($item) use ($id) {
            return $item['id'] != $id;
        });

        $this->saveAllCampaigns($filtered);

        return redirect()->route('admin.campaign.index')->with('success', 'Program donasi berhasil dihapus.');
    }
}

