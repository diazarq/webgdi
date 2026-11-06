<ul class="metismenu">
    <li class="text">Navigasi</li>
  <li>
    <a href="/admin/dashboard" class="{{ @$DashActive }}">
        <i class="cs-menu-icon bi bi-speedometer2"></i> Dashboard
    </a>
</li>

    <li><a href="#" class="cs-menu-dropdown has-arrow {{ @$WidgetActive }}" aria-expanded="true"><i class="cs-menu-icon bi-puzzle-fill"></i> Widget</a>
        <ul class="cs-menu-dropdown-item {{ @$WidgetActive ? 'mm-collapse mm-show' : ''}}">
            <li><a href="/admin/widget/slider" class="{{ @$WidSliderActive }}">Slider</a></li>
            <li><a href="/admin/widget/ads" class="{{ @$WidAdsActive }}">Slot Iklan</a></li>
            <li><a href="/admin/widget/about" class="{{ @$WidAboutActive }}">Selayang Pandang</a></li>
            <li><a href="/admin/widget/desc" class="{{ @$WidDescActive }}">Deskripsi Singkat</a></li>
            <li><a href="{{ route('admin.widget.programlaz.index') }}" class="{{ @$WidDescActive }}">Program LAZ</a></li>

        </ul>
    </li>
    <li><a href="#" class="cs-menu-dropdown has-arrow {{ @$MetaActive }}" aria-expanded="true"><i class="cs-menu-icon bi-gear-fill"></i> Meta</a>
        <ul class="cs-menu-dropdown-item {{ @$MetaActive ? 'mm-collapse mm-show' : ''}}">
            <li><a href="/admin/meta/social-media" class="{{ @$MetaSMActive }}">Media Sosial</a></li>
            <li><a href="/admin/meta/identitas-instansi" class="{{ @$MetaIDActive }}">Identitas Instansi</a></li>
            <li><a href="/admin/meta/bank" class="{{ @$MetaBankActive }}">Rekening Bank</a></li>
        </ul>
    </li>
    <li><a href="/admin/message" class="{{ @$MsgActive }}"><i class="cs-menu-icon bi-envelope"></i> Pesan</a></li>
    <li><a href="/admin/blog" class="{{ @$BlogActive }}"><i class="cs-menu-icon bi-info-circle"></i> Blog</a></li>
    <li><a href="/admin/gallery" class="{{ @$GalleryActive }}"><i class="cs-menu-icon bi-image-fill"></i> Galeri</a></li>
    <li><a href="#" class="cs-menu-dropdown has-arrow {{ @$ProgActive }}" aria-expanded="true"><i class="cs-menu-icon bi-cash-coin"></i> Program</a>
        <ul class="cs-menu-dropdown-item {{ @$ProgActive ? 'mm-collapse mm-show' : ''}}">
            <li><a href="/admin/program" class="{{ @$ProgMngActive }}">Kelola Program</a></li>
            <li><a href="/admin/program/implementasi" class="{{ @$ProgImplActive }}">Program Implementasi</a></li>
            <li><a href="/admin/program/landing" class="{{ @$ProgLandingActive }}">Hero Landing</a></li>
            <li><a href="/admin/program/dokumentasi" class="{{ @$ProgDokActive }}">Kelola Dokumentasi Program</a></li>
            <li><a href="/admin/program/rekapitulasi" class="{{ @$ProgRecapActive }}">Rekapitulasi</a></li>
        </ul>
    </li>

    <li class="text">Transaksi</li>
    <li><a href="/admin/zakat" class="{{ @$PayActive }}"><i class="cs-menu-icon bi-grid"></i> Zakat</a></li>

    <li class="text">Pengaturan</li>
    <li><a href="/admin/user" class="{{ @$UserActive }}"><i class="cs-menu-icon bi-file-person-fill"></i> Kelola User</a></li>
      <li><a href="/admin/menu" class="{{ @$MenuActive }}"><i class="cs-menu-icon bi-menu-app"></i> Menu</a></li>
    <li><a href="/admin/theme" class="{{ @$ThemeActive }}"><i class="cs-menu-icon bi-palette-fill"></i> Kelola Tema</a></li>

    <li class="text">Lain-lain</li>
    <li><a href="/admin/user/detail" class="{{ @$ProfileActive }}"><i class="cs-menu-icon bi-person-badge"></i> Profil Anda</a></li>
    <li><a href="#"><i class="cs-menu-icon bi-pencil-square"></i> Ubah Password</a></li>
    <li><a href="/q/logout"><i class="cs-menu-icon bi-door-open-fill"></i> Logout</a></li>

</ul>
