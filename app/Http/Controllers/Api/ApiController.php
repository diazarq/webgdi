<?php

namespace App\Http\Controllers\api;

use App\Models\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    protected $type = [
        'profesi' => '01',
        'maal' => '02',
        'fitrah' => '03'
    ];


    public function generatePaymentCode($zakatType, $digit){
        $data = Payment::whereRaw('DATE(created_at) = CURDATE()')->get()->count();
        $ztype = Arr::get($this->type, $zakatType);
        $code = date('ymd').$digit.$ztype.Str::padLeft($data+1, 4, '0');

        return $code;
    }

    public function sample(){
        $ztype = 'fitrah';
        $digit = mt_rand(000, 999);
        $code = $this->generatePaymentCode($ztype, $digit);
        $date = date('Y-m-d H:i:s');
        $exp_date = date('Y-m-d H:i:s', strtotime($date. '+1 day'));
        dd($exp_date);
    }

    public function store_payment(Request $request){
        $digit = mt_rand(100, 999);
        $transcode = $this->generatePaymentCode($request->zakat_type, $digit);
        $email = Str::of($request->email_phone)->is('*@*') == true ? $request->email_phone : null;
        $phone = $email == null ? $request->email_phone : null;

        $date = date('Y-m-d H:i:s');
        $exp_date = date('Y-m-d H:i:s', strtotime($date. '+1 day'));

        // Bersihkan nominal dari titik (.) dan koma (,) agar nilainya utuh (contoh 50.000 -> 50000)
        $cleanNominal = preg_replace('/[^0-9]/', '', (string)$request->zakat_nominal);
        $nominal = $cleanNominal ? floatval($cleanNominal) : 0;

        $isAnonim = $request->has('anonim') && ($request->anonim == '1' || $request->anonim == 1);
        $name = $isAnonim ? ($request->name ? $request->name : 'Hamba Allah') : ($request->name ?: 'Hamba Allah');
        $pronoun = $isAnonim ? ($request->sapaan ?: '-') : ($request->sapaan ?: '-');

        $dataInput = [
            'type' => $request->zakat_type,
            'transcode' => $transcode,
            'name' => $name,
            'pronoun' => $pronoun,
            'anonim' => $isAnonim ? 1 : 0,
            'notelp' => $phone,
            'email' => $email,
            'nominal' => $nominal,
            'payment_method' => $request->payment_method,
            'bank_type' => null,
            'bank_id' => $request->bank_id,
            'digit' => $digit,
            'status' => 'pending',
            'exp_at' => $exp_date
        ];
        
        Payment::create($dataInput);

        return response()->json([
            'code' => $transcode
        ], 200);
    }
}
