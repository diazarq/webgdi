<table>
    <thead>
        <tr>
            <th colspan="11" style="font-size: 15pt; font-weight: bold; text-align: center; color: #00885a;">YAYASAN GRAHA DHUAFA INDONESIA</th>
        </tr>
        <tr>
            <th colspan="11" style="font-size: 12pt; font-weight: bold; text-align: center;">REKAPITULASI DATA DONASI MASUK (MIDTRANS / ONLINE)</th>
        </tr>
        <tr>
            <th colspan="11" style="font-size: 10pt; font-style: italic; text-align: center; color: #555555;">Periode: {{ $periodeText }} | Waktu Ekspor: {{ date('d F Y, H:i') }} WIB</th>
        </tr>
        <tr>
            <th colspan="11"></th>
        </tr>
        <tr style="background-color: #00885a; color: #ffffff;">
            <th style="font-weight: bold; text-align: center; background-color: #00885a; color: #ffffff; border: 1px solid #000000;">No.</th>
            <th style="font-weight: bold; text-align: center; background-color: #00885a; color: #ffffff; border: 1px solid #000000;">Tanggal Transaksi</th>
            <th style="font-weight: bold; text-align: center; background-color: #00885a; color: #ffffff; border: 1px solid #000000;">Nomor Order ID</th>
            <th style="font-weight: bold; text-align: left; background-color: #00885a; color: #ffffff; border: 1px solid #000000;">Program Donasi</th>
            <th style="font-weight: bold; text-align: left; background-color: #00885a; color: #ffffff; border: 1px solid #000000;">Nama Donatur</th>
            <th style="font-weight: bold; text-align: center; background-color: #00885a; color: #ffffff; border: 1px solid #000000;">No. WhatsApp / HP</th>
            <th style="font-weight: bold; text-align: left; background-color: #00885a; color: #ffffff; border: 1px solid #000000;">Email Donatur</th>
            <th style="font-weight: bold; text-align: center; background-color: #00885a; color: #ffffff; border: 1px solid #000000;">Sifat Donasi</th>
            <th style="font-weight: bold; text-align: center; background-color: #00885a; color: #ffffff; border: 1px solid #000000;">Metode Pembayaran</th>
            <th style="font-weight: bold; text-align: right; background-color: #00885a; color: #ffffff; border: 1px solid #000000;">Nominal (Rp)</th>
            <th style="font-weight: bold; text-align: center; background-color: #00885a; color: #ffffff; border: 1px solid #000000;">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($donations as $index => $item)
            @php
                $method = $item->payment_method ?: 'Midtrans Online';
                if (stripos($method, 'snap') !== false || strtolower($method) === 'midtrans') {
                    $method = 'Midtrans Gateway';
                }
            @endphp
            <tr>
                <td style="border: 1px solid #cccccc; text-align: center;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #cccccc; text-align: center;">{{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}</td>
                <td style="border: 1px solid #cccccc; text-align: center;">{{ $item->transcode }}</td>
                <td style="border: 1px solid #cccccc; text-align: left;">{{ $item->type }}</td>
                <td style="border: 1px solid #cccccc; text-align: left;">{{ $item->name }}</td>
                <td style="border: 1px solid #cccccc; text-align: center;">{{ $item->notelp ?: '-' }}</td>
                <td style="border: 1px solid #cccccc; text-align: left;">{{ $item->email ?: '-' }}</td>
                <td style="border: 1px solid #cccccc; text-align: center;">{{ $item->anonim ? 'Hamba Allah' : 'Publik' }}</td>
                <td style="border: 1px solid #cccccc; text-align: center;">{{ $method }}</td>
                <td style="border: 1px solid #cccccc; text-align: right;">{{ $item->nominal }}</td>
                <td style="border: 1px solid #cccccc; text-align: center; font-weight: bold; color: #00885a;">LUNAS</td>
            </tr>
        @empty
            <tr>
                <td colspan="11" style="border: 1px solid #cccccc; text-align: center; padding: 12px;">Tidak ada data donasi masuk pada periode ini.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr style="background-color: #e8f5e9;">
            <th colspan="9" style="border: 1px solid #000000; font-weight: bold; text-align: right; background-color: #e8f5e9;">TOTAL DONASI TERKUMPUL:</th>
            <th style="border: 1px solid #000000; font-weight: bold; text-align: right; background-color: #e8f5e9; color: #00885a;">{{ $totalNominal }}</th>
            <th style="border: 1px solid #000000; font-weight: bold; text-align: center; background-color: #e8f5e9;">{{ $totalDonatur }} Transaksi</th>
        </tr>
    </tfoot>
</table>
