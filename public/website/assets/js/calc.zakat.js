$(function(){
    maskMoney = function(value){
        if (isNaN(value)) return '0';
        return new Intl.NumberFormat('id-ID').format(value);
    };

    unmaskMoney = function(value){
        if (!value) return 0;
        var clean = value.toString().replace(/\D/g, '');
        return clean ? parseFloat(clean) : 0;
    };

    nisab_emas = function(){
        var fHarga = $('#harga_emas');
        var fNisab = $('#nisab');
        var harga = unmaskMoney(fHarga.val());
        if (harga <= 0) {
            harga = 1450000;
            fHarga.val(maskMoney(harga));
        }
        var nisabTahun = 85 * harga;

        fHarga.attr('data-value', harga);
        fNisab.attr('data-value', nisabTahun);
        $('#nisab_float').val(nisabTahun);
        fNisab.val(maskMoney(nisabTahun));
    };

    hitung_zakat = function(){
        var jenis = $('[name=zakat_type]').val();
        var nisabTahun = parseFloat($('#nisab_float').val()) || (85 * 1450000);
        var zakat = 0;

        if (jenis === 'fitrah') {
            var jiwa = parseInt($('#fitrah_jiwa').val()) || 1;
            var hargaBeras = unmaskMoney($('#fitrah_harga_beras').val()) || 45000;
            zakat = jiwa * hargaBeras;
            $('#zakat-alert').html('<div class="alert alert-info">Kewajiban Zakat Fitrah untuk <strong>' + jiwa + ' jiwa</strong> (' + jiwa + ' × Rp ' + maskMoney(hargaBeras) + ').</div>');
        } else if (jenis === 'maal') {
            var gold = unmaskMoney($('[name=value_treasure_gold]').val());
            var saving = unmaskMoney($('[name=value_treasure_saving]').val());
            var other = unmaskMoney($('[name=value_treasure_other]').val());
            var debt = unmaskMoney($('[name=value_treasure_debt]').val());
            var totalHarta = (gold + saving + other) - debt;

            if (nisabTahun <= 0) {
                $('#zakat-alert').html('<div class="alert alert-danger">Harga emas harus diisi terlebih dahulu.</div>');
            } else if (totalHarta >= nisabTahun) {
                zakat = Math.round(0.025 * totalHarta);
                $('#zakat-alert').html('<div class="alert alert-success">Harta bersih (Rp ' + maskMoney(totalHarta) + ') <strong>SUDAH mencapai nishab tahunan</strong> (Rp ' + maskMoney(nisabTahun) + ') & haul 1 tahun. Dikenakan <strong>KEWAJIBAN ZAKAT 2,5%</strong>.</div>');
            } else {
                zakat = 0;
                var sisa = totalHarta > 0 ? 'Harta bersih Anda (Rp ' + maskMoney(totalHarta) + ')' : 'Harta';
                $('#zakat-alert').html('<div class="alert alert-warning">' + sisa + ' <strong>BELUM mencapai nishab</strong> (Rp ' + maskMoney(nisabTahun) + '). Belum dikenakan kewajiban zakat maal.</div>');
            }
        } else {
            // Profesi
            var income = unmaskMoney($('[name=value_income]').val());
            var bonus = unmaskMoney($('[name=value_bonus]').val());
            var debtProfesi = unmaskMoney($('[name=value_debt]').val());
            var totalBersih = (income + bonus) - debtProfesi;
            var nisabBulan = Math.round(nisabTahun / 12);

            if (nisabTahun <= 0) {
                $('#zakat-alert').html('<div class="alert alert-danger">Harga emas harus diisi terlebih dahulu.</div>');
            } else if (totalBersih >= nisabBulan) {
                zakat = Math.round(0.025 * totalBersih);
                $('#zakat-alert').html('<div class="alert alert-success">Penghasilan bersih (Rp ' + maskMoney(totalBersih) + ') <strong>SUDAH mencapai nishab bulanan</strong> (Rp ' + maskMoney(nisabBulan) + '). Dikenakan <strong>KEWAJIBAN ZAKAT 2,5%</strong>.</div>');
            } else {
                zakat = 0;
                var sisaP = totalBersih > 0 ? 'Penghasilan bersih Anda (Rp ' + maskMoney(totalBersih) + ')' : 'Penghasilan';
                $('#zakat-alert').html('<div class="alert alert-warning">' + sisaP + ' <strong>BELUM mencapai nishab bulanan</strong> (Rp ' + maskMoney(nisabBulan) + '). Belum dikenakan kewajiban zakat profesi.</div>');
            }
        }

        $('#zakat-total').html('Rp ' + maskMoney(zakat));
        $('#zakat-total').attr('data-value', zakat);
    };

    // Inisialisasi awal saat halaman dibuka
    if ($('#harga_emas').length) {
        if (!$('#harga_emas').val()) {
            $('#harga_emas').val('1.450.000');
        }
        nisab_emas();
        hitung_zakat();
    }
});
