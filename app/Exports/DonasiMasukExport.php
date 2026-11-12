<?php

namespace App\Exports;

use App\Models\Payment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class DonasiMasukExport implements FromView, WithColumnWidths, WithTitle, WithEvents
{
    protected $dates;
    protected $transcode;

    public function __construct($dates = null, $transcode = null)
    {
        $this->dates = $dates;
        $this->transcode = $transcode;
    }

    public function title(): string
    {
        return 'Rekap Donasi Masuk';
    }

    /**
     * Tentukan lebar kolom eksplisit dan lega agar teks tidak terpotong & angka tidak menjadi ###
     */
    public function columnWidths(): array
    {
        return [
            'A' => 6,   // No.
            'B' => 20,  // Tanggal Transaksi
            'C' => 22,  // Nomor Order ID
            'D' => 45,  // Program Donasi
            'E' => 28,  // Nama Donatur
            'F' => 18,  // No. WhatsApp / HP
            'G' => 30,  // Email Donatur
            'H' => 16,  // Sifat Donasi
            'I' => 24,  // Metode Pembayaran
            'J' => 22,  // Nominal (Rp)
            'K' => 14,  // Status
        ];
    }

    public function view(): View
    {
        $query = Payment::query()->where(function($q) {
            $q->where('bank_type', 'midtrans')
              ->orWhere('payment_method', 'like', '%Midtrans%')
              ->orWhere('transcode', 'like', 'MID-%')
              ->orWhere('type', 'like', '%donasi%');
        })
        ->where('status', 'complete')
        ->orderBy('created_at', 'desc');

        $periodeText = 'Semua Periode';

        if (!empty($this->dates)) {
            $dateArr = explode(' s/d ', $this->dates);
            if (count($dateArr) === 2) {
                $start = date('Y-m-d', strtotime(str_replace('/', '-', $dateArr[0])));
                $end   = date('Y-m-d', strtotime(str_replace('/', '-', $dateArr[1])));
                $query->whereRaw('DATE(created_at) >= ?', [$start]);
                $query->whereRaw('DATE(created_at) <= ?', [$end]);
                $periodeText = $dateArr[0] . ' s/d ' . $dateArr[1];
            }
        }

        if (!empty($this->transcode)) {
            $query->where('transcode', 'like', '%' . $this->transcode . '%');
        }

        $donations = $query->get();
        $totalNominal = $donations->sum('nominal');
        $totalDonatur = $donations->count();

        return view('payment.exports.donasi-masuk', [
            'donations'    => $donations,
            'totalNominal' => $totalNominal,
            'totalDonatur' => $totalDonatur,
            'periodeText'  => $periodeText,
        ]);
    }

    /**
     * Event AfterSheet untuk styling langsung PhpSpreadsheet
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                // 1. Tinggi Baris
                $sheet->getRowDimension(1)->setRowHeight(26);
                $sheet->getRowDimension(2)->setRowHeight(22);
                $sheet->getRowDimension(3)->setRowHeight(18);
                $sheet->getRowDimension(5)->setRowHeight(28); // Header tabel

                for ($row = 6; $row <= $highestRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(22);
                }

                // 2. Styling Header Tabel (Baris 5)
                $sheet->getStyle('A5:K5')->applyFromArray([
                    'font' => [
                        'bold'  => true,
                        'color' => ['rgb' => 'FFFFFF'],
                        'size'  => 11,
                    ],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '00885A'],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // 3. Border untuk seluruh tabel (Baris 5 s/d highestRow)
                $sheet->getStyle('A5:K' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // 4. Format Angka Nominal (Kolom J) sebagai Currency/Angka Ribuan: #,##0
                $sheet->getStyle('J6:J' . $highestRow)->getNumberFormat()->setFormatCode('#,##0');

                // 5. Format Nomor Telepon (Kolom F) dan Order ID (Kolom C) sebagai Text agar 0 di depan tidak hilang
                $sheet->getStyle('C6:C' . $highestRow)->getNumberFormat()->setFormatCode('@');
                $sheet->getStyle('F6:F' . $highestRow)->getNumberFormat()->setFormatCode('@');

                // 6. Alignment Kolom
                $sheet->getStyle('A6:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B6:B' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('C6:C' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F6:F' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('H6:H' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('I6:I' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('J6:J' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('K6:K' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // 7. Styling Baris Total Terakhir
                $sheet->getStyle('A' . $highestRow . ':K' . $highestRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                    ],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E8F5E9'],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
            },
        ];
    }
}
