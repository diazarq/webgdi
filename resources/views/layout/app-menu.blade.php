<ul class="metismenu">
    @php
        $user = Auth::user();
    @endphp

    @if($user)
        <li class="text">Navigasi</li>

        {{-- 1. Dashboard --}}
        @if($user->canAccess('dashboard'))
            <li>
                <a href="/admin/dashboard" class="{{ @$DashActive }}">
                    <i class="cs-menu-icon bi-speedometer2"></i> Dashboard
                </a>
            </li>
        @endif

        {{-- 2. Widget --}}
        @if($user->canAccess('widget'))
            <li><a href="#" class="cs-menu-dropdown has-arrow {{ @$WidgetActive }}" aria-expanded="true"><i class="cs-menu-icon bi-puzzle-fill"></i> Widget</a>
                <ul class="cs-menu-dropdown-item {{ @$WidgetActive ? 'mm-collapse mm-show' : ''}}">
                    <li><a href="/admin/widget/slider" class="{{ @$WidSliderActive }}">Slider</a></li>
                    <li><a href="/admin/widget/ads" class="{{ @$WidAdsActive }}">Slot Iklan</a></li>
                    <li><a href="/admin/widget/about" class="{{ @$WidAboutActive }}">Selayang Pandang</a></li>
                    <li><a href="/admin/widget/desc" class="{{ @$WidDescActive }}">Deskripsi Singkat</a></li>
                    <li><a href="{{ route('admin.widget.programlaz.index') }}" class="{{ @$WidDescActive }}">Program LAZ</a></li>
                </ul>
            </li>
        @endif

        {{-- 3. Meta --}}
        @if($user->canAccess('meta'))
            <li><a href="#" class="cs-menu-dropdown has-arrow {{ @$MetaActive }}" aria-expanded="true"><i class="cs-menu-icon bi-gear-fill"></i> Meta</a>
                <ul class="cs-menu-dropdown-item {{ @$MetaActive ? 'mm-collapse mm-show' : ''}}">
                    <li><a href="/admin/meta/social-media" class="{{ @$MetaSMActive }}">Media Sosial</a></li>
                    <li><a href="/admin/meta/identitas-instansi" class="{{ @$MetaIDActive }}">Identitas Instansi</a></li>
                    <li><a href="/admin/meta/bank" class="{{ @$MetaBankActive }}">Rekening Bank</a></li>
                </ul>
            </li>
        @endif

        {{-- 4. Pesan --}}
        @if($user->canAccess('pesan'))
            <li><a href="/admin/message" class="{{ @$MsgActive }}"><i class="cs-menu-icon bi-envelope"></i> Pesan</a></li>
        @endif

        {{-- 5. Blog --}}
        @if($user->canAccess('blog'))
            <li><a href="/admin/blog" class="{{ @$BlogActive }}"><i class="cs-menu-icon bi-info-circle"></i> Blog</a></li>
        @endif

        {{-- 6. Galeri --}}
        @if($user->canAccess('galeri'))
            <li><a href="/admin/gallery" class="{{ @$GalleryActive }}"><i class="cs-menu-icon bi-image-fill"></i> Galeri</a></li>
        @endif

        {{-- 7. Program --}}
        @if($user->canAccess('program'))
            <li><a href="#" class="cs-menu-dropdown has-arrow {{ @$ProgActive }}" aria-expanded="true"><i class="cs-menu-icon bi-cash-coin"></i> Program</a>
                <ul class="cs-menu-dropdown-item {{ @$ProgActive ? 'mm-collapse mm-show' : ''}}">
                    <li><a href="/admin/program" class="{{ @$ProgMngActive }}">Kelola Program</a></li>
                    <li><a href="/admin/program/implementasi" class="{{ @$ProgImplActive }}">Program Implementasi</a></li>
                    <li><a href="/admin/program/landing" class="{{ @$ProgLandingActive }}">Hero Landing</a></li>
                    <li><a href="/admin/program/dokumentasi" class="{{ @$ProgDokActive }}">Kelola Dokumentasi Program</a></li>
                    <li><a href="/admin/program/rekapitulasi" class="{{ @$ProgRecapActive }}">Rekapitulasi</a></li>
                </ul>
            </li>
        @endif

        {{-- 8. Donasi Campaign --}}
        @if($user->canAccess('donasi'))
            <li><a href="{{ route('admin.campaign.index') }}" class="{{ @$CampaignDonasiActive }}"><i class="cs-menu-icon bi-megaphone-fill"></i> Donasi</a></li>
        @endif

        {{-- KELOMPOK TRANSAKSI --}}
        @if($user->canAccess('zakat') || $user->canAccess('donasi_masuk'))
            <li class="text">Transaksi</li>
            @if($user->canAccess('zakat'))
                <li><a href="/admin/zakat" class="{{ @$PayActive }}"><i class="cs-menu-icon bi-grid"></i> Zakat</a></li>
            @endif
            @if($user->canAccess('donasi_masuk'))
                <li><a href="/admin/donasi-masuk" class="{{ @$DonasiActive }}"><i class="cs-menu-icon bi-heart-fill"></i> Donasi Masuk</a></li>
            @endif
        @endif

        {{-- KELOMPOK PENGATURAN --}}
        @if($user->canAccess('relawan_mitra') || $user->canAccess('menu_dinamis') || $user->canAccess('kelola_user') || $user->canAccess('kelola_role') || $user->canAccess('kelola_tema'))
            <li class="text">Pengaturan</li>
            @if($user->canAccess('relawan_mitra'))
                <li><a href="{{ route('admin.members.index') }}" class="{{ @$MemberActive }}"><i class="cs-menu-icon bi-people-fill"></i> Relawan & Mitra</a></li>
            @endif
            @if($user->canAccess('menu_dinamis'))
                <li><a href="/admin/menu" class="{{ @$MenuActive }}"><i class="cs-menu-icon bi-menu-app"></i> Menu Website</a></li>
            @endif
            @if($user->canAccess('kelola_user'))
                <li><a href="/admin/user" class="{{ @$UserActive }}"><i class="cs-menu-icon bi-file-person-fill"></i> Kelola User</a></li>
            @endif
            @if($user->canAccess('kelola_role'))
                <li><a href="/admin/role" class="{{ @$RoleActive }}"><i class="cs-menu-icon bi-shield-lock-fill"></i> Role</a></li>
                <li><a href="/admin/user-privilege" class="{{ @$PrivilegeActive }}"><i class="cs-menu-icon bi-key-fill"></i> User Privilege</a></li>
            @endif
            @if($user->canAccess('kelola_tema'))
                <li><a href="/admin/theme" class="{{ @$ThemeActive }}"><i class="cs-menu-icon bi-palette-fill"></i> Kelola Tema</a></li>
            @endif
        @endif

        <li class="text">Lain-lain</li>
        <li><a href="/admin/user/detail" class="{{ @$ProfileActive }}"><i class="cs-menu-icon bi-person-badge"></i> Profil Anda</a></li>
        <li><a href="/q/logout"><i class="cs-menu-icon bi-door-open-fill"></i> Logout</a></li>
    @endif
</ul>
