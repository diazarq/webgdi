<style>
 
    .site-footer {
        background-color: #faf8f1 !important;
        border-top: 2px solid #d8cdae; /* garis pembatas antara konten halaman & footer */
    }

    .site-footer__top {
        padding: 56px 0 8px;
    }

    .site-footer__bottom {
        padding: 22px 0 26px;
        background-color: transparent !important;
        box-shadow: none !important;
    }

    .site-footer__shape-1 {
        display: none; /* shape dekoratif tema disembunyikan */
    }

    /* ---- Logo program ---- */
    .wfh-footer__logo {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .wfh-footer__logo img {
        width: auto;
        max-width: 120px;
        max-height: 110px;
        object-fit: contain;
    }

    /* ---- Baris info: lokasi | sosmed | website ---- */
    .wfh-footer__info {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 8px 0;
        margin-bottom: 30px;
    }

    .wfh-footer__info-item {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 14.5px;
        font-weight: 700;
        color: #33413a;
        text-decoration: none !important;
        padding: 0 14px;
    }

    .wfh-footer__info-item:hover {
        color: #1a8b4c;
    }

    .wfh-footer__info-item i {
        color: #1a8b4c;
        font-size: 15px;
    }

    .wfh-footer__info-item + .wfh-footer__info-item::before {
        content: "";
        display: inline-block;
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #b9c6bf;
        margin-right: 21px;
    }

    /* ---- Ikon aksi bulat: website, share, email ---- */
    .wfh-footer__actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        margin-bottom: 30px;
    }

    .wfh-footer__actions a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #e4f0e0;
        border: 1px solid #d3e5cd;
        color: #2f7d3b;
        font-size: 17px;
        text-decoration: none !important;
        transition: background 0.25s ease, color 0.25s ease, transform 0.25s ease, border-color 0.25s ease;
    }

    .wfh-footer__actions a:hover {
        background: #1a8b4c;
        border-color: #1a8b4c;
        color: #ffffff;
        transform: translateY(-3px);
    }

    .wfh-footer__actions a i {
        line-height: 1;
    }

    /* ---- Copyright ---- */
    .site-footer__bottom-inner {
        text-align: center !important;
    }

    .site-footer__bottom-text {
        font-size: 13.5px;
        color: #8a8272;
    }

    .site-footer__bottom-text a {
        color: #2f7d3b;
        font-weight: 700;
        text-decoration: none;
    }

    @media (max-width: 575px) {
        .wfh-footer__info {
            flex-direction: column;
            gap: 10px;
        }

        .wfh-footer__info-item + .wfh-footer__info-item::before {
            display: none;
        }

        .wfh-footer__info-item {
            padding: 0;
        }
    }
</style>
<div class="site-footer__top">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 wow fadeInUp" data-wow-delay="100ms">
                {{-- Logo program (versi ikon agar terbaca jelas di latar krem & center) --}}
                <div class="wfh-footer__logo">
                    <img src="{{ asset('website/assets/images/custom/logo_gdi.png') }}"
                         alt="Graha Dhuafa Indonesia"/>
                </div>

                {{-- Baris info: lokasi | sosmed | website --}}
                <div class="wfh-footer__info">
                    <span class="wfh-footer__info-item">
                        <i class="fas fa-mosque" aria-hidden="true"></i>
                        Bandung, Jawa Barat
                    </span>
                    <a class="wfh-footer__info-item" href="https://instagram.com/grahadhuafaorg" target="_blank" rel="noopener">
                        <i class="fab fa-instagram" aria-hidden="true"></i>
                        @event.grahadhuafa &amp; @grahadhuafaorg
                    </a>
                    <a class="wfh-footer__info-item" href="https://grahadhuafa.org" target="_blank" rel="noopener">
                        <i class="fas fa-globe" aria-hidden="true"></i>
                        grahadhuafa.org
                    </a>
                </div>

                {{-- Ikon aksi: website, share, email --}}
                <div class="wfh-footer__actions">
                    <a href="https://grahadhuafa.org" target="_blank" rel="noopener" aria-label="Website">
                        <i class="fas fa-globe"></i>
                    </a>
                    <a href="#" aria-label="Bagikan halaman">
                        <i class="fas fa-share-alt"></i>
                    </a>
                    <a href="mailto:info@grahadhuafa.org" aria-label="Email">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="site-footer__bottom">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="site-footer__bottom-inner">
                    <p class="site-footer__bottom-text">© 2026 LAZ Graha Dhuafa Indonesia. Hak Cipta Dilindungi Undang–Undang.</p>
                </div>
            </div>
        </div>
    </div>
</div>
