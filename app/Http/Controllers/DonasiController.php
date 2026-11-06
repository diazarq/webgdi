<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Payment; // Sesuaikan dengan model transaksi Anda jika ada

class DonasiController extends Controller
{
    // 1. Tampilkan form donasi sederhana
    public function index()
    {
        return view('donasi-sederhana');
    }

    // 2. Buat Invoice ke Xendit
    public function bayar(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email',
            'nominal' => 'required|numeric|min:10000',
        ]);

        $externalId = 'DONASI-' . time(); // ID unik transaksi
        $secretKey = config('services.xendit.secret_key') ?: env('XENDIT_SECRET_KEY');

        if (empty($secretKey)) {
            return back()->with('error', 'XENDIT_SECRET_KEY belum diisi di file .env');
        }

        // Payload data pesanan ke Xendit
        $payload = [
            'external_id' => $externalId,
            'amount' => (int) $request->nominal,
            'description' => 'Donasi atas nama ' . $request->nama,
            'payer_email' => $request->email,
            'customer' => [
                'given_names' => $request->nama,
                'email' => $request->email,
            ],
            // URL setelah user selesai bayar
            'success_redirect_url' => url('/donasi/sukses'),
        ];

        try {
            // Request ke API Xendit menggunakan Basic Auth bawaan Laravel Http
            $response = Http::withoutVerifying()
                ->withBasicAuth($secretKey, '')
                ->post('https://api.xendit.co/v2/invoices', $payload);

            if ($response->successful()) {
                $result = $response->json();

                if (!empty($result['invoice_url'])) {
                    // Redirect donatur ke URL pembayaran Xendit
                    return redirect($result['invoice_url']);
                }

                return back()->with('error', 'Respon Xendit tidak memiliki invoice_url: ' . json_encode($result));
            }

            return back()->with('error', 'Gagal dari Xendit (' . $response->status() . '): ' . $response->body());
        } catch (\Throwable $e) {
            return back()->with('error', 'Koneksi error: ' . $e->getMessage());
        }
    }

    // 3. Menerima laporan webhook dari Xendit saat donatur sudah bayar
    public function callback(Request $request)
    {
        $data = $request->all();

        $externalId = $data['external_id'] ?? null;
        $status = $data['status'] ?? null; // 'PAID', 'EXPIRED', dll.

        if ($status === 'PAID') {
            // Update database transaksi menjadi sukses/lunas
            // Payment::where('transcode', $externalId)->update(['status' => 'success']);
        }

        return response()->json(['message' => 'Callback received'], 200);
    }
}