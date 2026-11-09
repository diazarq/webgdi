<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Payment;
use App\Models\Bank;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    private function _dateFormat($date){
        $d = explode('-', $date);
        return $d[2].'-'.$d[1].'-'.$d[0];
    }
    private function _rangeReFormat($dates){
        $date = explode(' s/d ', $dates);
        return array(
            'date_start' => $this->_dateFormat($date[0]),
            'date_end'   => $this->_dateFormat($date[1])
        );
    }

    public function index(){
        $bank = Bank::where('status', 'A')->get();
        return view('payment.list-payment',[
            'pageTitle' => 'Daftar Muzaki',
            'active' => ['PayActive'=>'active'],
            'bank' => $bank
        ]);
    }

    public function table(Request $request){
        $payment = Payment::selectRaw('payments.*, banks.bank_name')
            ->leftJoin('banks', 'banks.id', '=', 'payments.bank_id');

        if($request->dates){
            $dates = $this->_rangeReFormat($request->dates);
            $payment->whereRaw('DATE(payments.created_at) >= "' . $dates['date_start'] . '"');
            $payment->whereRaw('DATE(payments.created_at) <= "'. $dates['date_end'] . '"');
        }else{
            $payment->whereRaw('MONTH(payments.created_at) = "'. date('m') . '" AND YEAR(payments.created_at) = "'. date('Y') .'"');
        }

        if($request->type){
            $payment->where('payments.type', $request->type);
        }

        if($request->status){
            $payment->where('payments.status', $request->status);
        }

        if($request->transcode){
            $payment->where('payments.transcode', $request->transcode);
        }

        if($request->bank_id){
            $payment->where('payments.bank_id', $request->bank_id);
        }

        return DataTables::eloquent($payment)
            ->addIndexColumn()
            ->addColumn('action', function(Payment $table){
                $button = '<a href="/admin/program/'.$table->id.'/detail" class="btn btn-sm btn-warning disabled" title="Detail Program"><i class="bi-list"></i></a> 
                    <button type="button" class="btn btn-sm btn-primary btn-update" data-id="'.$table->id.'" title="Complete Payment"><i class="bi-bookmark-check"></i></button>';
                return $button;
            })
            ->make();
    }

    public function update_status($id){
        Payment::where('id', $id)->update([
            'status' => 'complete'
        ]);
    }

    /**
     * Halaman Monitoring Donasi Masuk (Kitabisa & Midtrans) di Admin
     */
    public function index_donasi()
    {
        // Hanya menghitung transaksi donasi yang sudah berhasil/lunas masuk
        $baseQuery = Payment::where(function($q) {
            $q->where('bank_type', 'midtrans')
              ->orWhere('payment_method', 'like', '%Midtrans%')
              ->orWhere('transcode', 'like', 'MID-%')
              ->orWhere('type', 'like', '%donasi%');
        })->where('status', 'complete');

        $totalNominal  = (clone $baseQuery)->sum('nominal');
        $totalSukses   = (clone $baseQuery)->count();
        $donasiHariIni = (clone $baseQuery)->whereDate('created_at', Carbon::today())->sum('nominal');

        return view('payment.list-donasi', [
            'pageTitle'     => 'Monitoring Donasi Masuk',
            'active'        => ['DonasiActive' => 'active'],
            'totalNominal'  => $totalNominal,
            'totalSukses'   => $totalSukses,
            'donasiHariIni' => $donasiHariIni,
        ]);
    }

    /**
     * DataTables Server-Side untuk Donasi Masuk (Hanya transaksi yang sudah lunas/berhasil)
     */
    public function table_donasi(Request $request)
    {
        $query = Payment::query()->where(function($q) {
            $q->where('bank_type', 'midtrans')
              ->orWhere('payment_method', 'like', '%Midtrans%')
              ->orWhere('transcode', 'like', 'MID-%')
              ->orWhere('type', 'like', '%donasi%');
        })
        ->where('status', 'complete') // Hanya donasi yang sudah masuk / berhasil
        ->orderBy('created_at', 'desc');

        if ($request->dates) {
            $dates = $this->_rangeReFormat($request->dates);
            $query->whereRaw('DATE(created_at) >= "' . $dates['date_start'] . '"');
            $query->whereRaw('DATE(created_at) <= "' . $dates['date_end'] . '"');
        }

        if ($request->transcode) {
            $query->where('transcode', 'like', '%' . $request->transcode . '%');
        }

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->editColumn('payment_method', function(Payment $table) {
                $m = $table->payment_method;
                if (empty($m) || stripos($m, 'snap') !== false || strtolower($m) === 'midtrans') {
                    return 'VA BCA';
                }
                return $m;
            })
            ->addColumn('action', function(Payment $table) {
                $invoiceUrl = route('midtrans.invoice', ['transcode' => $table->transcode]);
                return '<div class="btn-group btn-group-sm" role="group">
                    <a href="' . $invoiceUrl . '" target="_blank" class="btn btn-outline-primary" title="Lihat Bukti Invoice">
                        <i class="bi bi-receipt me-1"></i>
                    </a>
                    <button type="button" class="btn btn-outline-danger btn-delete-donasi" data-id="' . $table->id . '" title="Hapus Donasi">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>';
            })
            ->make();
    }

    public function update_status_donasi($id)
    {
        Payment::where('id', $id)->update([
            'status' => 'complete'
        ]);

        return response()->json(['status' => 'success', 'message' => 'Status donasi berhasil diubah menjadi selesai.']);
    }

    /**
     * Hapus / Drop Data Transaksi Donasi
     */
    public function delete_donasi($id)
    {
        $payment = Payment::find($id);
        if ($payment) {
            $payment->delete();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Data transaksi donasi berhasil dihapus.'
                ]);
            }

            return redirect()->back()->with('success', 'Data transaksi donasi berhasil dihapus.');
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data donasi tidak ditemukan.'
            ], 404);
        }

        return redirect()->back()->with('error', 'Data donasi tidak ditemukan.');
    }
}
