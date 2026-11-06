<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    /**
     * Konfigurasi Kunci Midtrans
     */
    private function getServerKey()
    {
        return env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-Ne-uxZxJDtyRjFH1X6JSNy2O');
    }

    public function getClientKey()
    {
        return env('MIDTRANS_CLIENT_KEY', 'Mid-client-41OdYqyH2hOuH_Qj');
    }

    private function isProduction()
    {
        return env('MIDTRANS_IS_PRODUCTION', false);
    }

    private function getSnapUrl()
    {
        return $this->isProduction()
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
    }

    /**
     * 1. Halaman Form Donasi Zakat (Midtrans Sandbox)
     */
    public function index()
    {
        return view('midtrans.index', [
            'pageTitle' => 'Simulasi Donasi Online - Midtrans Payment Gateway',
            'clientKey' => $this->getClientKey(),
        ]);
    }

    /**
     * 2. Request Pembuatan Snap Token ke Server Midtrans (AJAX)
     */
    public function createSnapToken(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'nominal' => 'required',
        ]);

        $nominal = (int) preg_replace('/[^0-9]/', '', $request->nominal);
        if ($nominal < 10000) {
            $nominal = 10000;
        }

        $orderId = 'MID-' . date('ymd') . rand(10000, 99999);
        $name    = $request->name;
        $email   = $request->email ?: 'donatur@gmail.com';
        $notelp  = $request->notelp ?: '081234567890';
        $program = $request->type ?: 'donasi_pendidikan_dhuafa';

        // Simpan transaksi di database lokal dengan status pending
        Payment::create([
            'transcode'      => $orderId,
            'name'           => $name,
            'pronoun'        => $request->pronoun ?: 'Bpk/Ibu',
            'email'          => $email,
            'notelp'         => $notelp,
            'nominal'        => $nominal,
            'type'           => $program,
            'payment_method' => 'Midtrans Snap',
            'bank_type'      => 'midtrans',
            'bank_id'        => 1,
            'digit'          => 0,
            'status'         => 'pending',
            'exp_at'         => Carbon::now()->addHours(24),
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
                    'id'       => $program,
                    'price'    => $nominal,
                    'quantity' => 1,
                    'name'     => ucwords(str_replace('_', ' ', $program)),
                ]
            ],
            'callbacks' => [
                'finish' => route('midtrans.finish'),
            ]
        ];

        // Panggil API Midtrans menggunakan HTTP Client bawaan Laravel
        $auth = base64_encode($this->getServerKey() . ':');
        $response = Http::withHeaders([
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
    }

    /**
     * 3. Callback Frontend saat Donatur Selesai Membayar via Popup Snap
     */
    public function finish(Request $request)
    {
        $orderId = $request->order_id;
        $transactionStatus = $request->transaction_status;

        $payment = Payment::where('transcode', $orderId)->first();

        if ($payment) {
            // Jika berhasil / settlement, update database menjadi complete
            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture' || $request->status_code == '200') {
                $payment->status = 'complete';
                $payment->save();
            }
            return redirect()->route('midtrans.invoice', ['transcode' => $orderId]);
        }

        return redirect()->route('midtrans.index')->with('info', 'Transaksi telah diproses.');
    }

    /**
     * 4. Webhook Notifikasi Resmi dari Server Midtrans (IPN)
     */
    public function notification(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;

        // Verifikasi Signature Keamanan Midtrans
        $validSignature = hash("sha512", $orderId . $statusCode . $grossAmount . $this->getServerKey());

        if ($signatureKey !== $validSignature) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $payment = Payment::where('transcode', $orderId)->first();
        if (!$payment) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transactionStatus = $payload['transaction_status'] ?? '';

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $payment->status = 'complete';
            $payment->payment_method = $payload['payment_type'] ?? 'Midtrans';
            $payment->save();
        } else if ($transactionStatus == 'pending') {
            $payment->status = 'pending';
            $payment->save();
        } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $payment->status = 'failed';
            $payment->save();
        }

        return response()->json(['status' => 'OK']);
    }

    /**
     * 5. Halaman Invoice / Bukti Setor Zakat Resmi
     */
    public function invoice($transcode)
    {
        $payment = Payment::where('transcode', $transcode)->firstOrFail();

        return view('midtrans.invoice', [
            'payment'   => $payment,
            'pageTitle' => 'Bukti Pembayaran ZIS - Graha Dhuafa Indonesia'
        ]);
    }
}

