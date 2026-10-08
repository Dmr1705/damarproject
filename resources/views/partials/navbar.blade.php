@php
    $isHome = request()->routeIs('home');
    $homeUrl = route('home');
    $sectionUrl = static fn (string $section): string => $isHome ? "#{$section}" : "{$homeUrl}#{$section}";
    $profilePhoto = auth()->user()?->profile_photo_path;
@endphp

<header class="site-header" data-site-header>
    <div class="site-header__inner">
        <a class="brand" href="{{ $homeUrl }}" aria-label="NU Sawangan, beranda">
            <img class="brand__mark" src="{{ config('images.logo') }}" alt="" width="52" height="52">
            <span class="brand__text">
                <span class="brand__name">NU Sawangan</span>
                <span class="brand__tagline">Merawat khidmah, menyambung umat</span>
            </span>
        </a>

        <nav class="desktop-nav" aria-label="Navigasi utama">
            <a class="desktop-nav__link is-active" href="{{ $sectionUrl('hero-section') }}" @if ($isHome) aria-current="page" @endif>Beranda</a>
            <a class="desktop-nav__link" href="{{ $sectionUrl('tentang-section') }}">Tentang</a>
            <a class="desktop-nav__link" href="{{ $sectionUrl('kegiatan-section') }}">Kegiatan</a>
            <a class="desktop-nav__link" href="{{ $sectionUrl('berita-section') }}">Berita</a>
            <a class="desktop-nav__link" href="{{ $sectionUrl('kontak-section') }}">Kontak</a>
        </nav>

        <div class="site-header__actions">
            <button class="search-toggle" type="button" aria-label="Buka pencarian" aria-expanded="false" aria-controls="desktop-search mobile-menu" data-search-toggle>
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.6"></circle><path d="m16 16 4.5 4.5"></path></svg>
                <span class="search-toggle__label">Cari</span>
            </button>
            <x-notification-bell
                mode="public"
                :endpoint="route('notifications.news')"
                storage-key="nu_seen_news_ids"
                :see-all-url="route('berita.index')"
            />
            @if (Illuminate\Support\Facades\Route::has('login'))
                @auth
                    <a class="login-link" href="{{ url('/dashboard') }}">
                        <span class="login-link__identity">
                            @if ($profilePhoto)
                                <img class="login-link__avatar" src="{{ asset('storage/'.$profilePhoto) }}" alt="" width="32" height="32">
                            @endif
                            <span>Akun</span>
                        </span>
                    </a>
                @else
                    <a class="login-link" href="{{ route('login') }}">Masuk</a>
                @endauth
            @endif
            <a class="header-cta" href="{{ route('berita.index') }}">Baca kabar <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></a>
            <button class="menu-toggle" type="button" aria-label="Buka menu" aria-expanded="false" aria-controls="mobile-menu" data-menu-toggle>
                <span class="menu-toggle__line"></span>
                <span class="menu-toggle__line"></span>
                <span class="menu-toggle__line"></span>
            </button>
        </div>
    </div>

    <div class="desktop-search" id="desktop-search" aria-hidden="true" inert data-desktop-search>
        <form class="search-form" role="search" action="{{ route('search') }}" method="GET" data-search-form>
            <label class="visually-hidden" for="desktop-search-input">Cari berita dan kegiatan</label>
            <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.6"></circle><path d="m16 16 4.5 4.5"></path></svg>
            <input id="desktop-search-input" name="q" type="search" value="{{ request('q') }}" placeholder="Cari berita atau kegiatan…" autocomplete="off" maxlength="100" data-search-input>
            <button class="search-submit" type="submit">Cari</button>
        </form>
    </div>
</header>

<button class="menu-backdrop" type="button" aria-label="Tutup menu" tabindex="-1" data-menu-backdrop></button>
<aside class="mobile-menu" id="mobile-menu" aria-label="Navigasi seluler" aria-hidden="true" inert data-mobile-menu>
    <div class="mobile-menu__top">
        <span class="mobile-menu__eyebrow">Jelajahi NU Sawangan</span>
        <button class="mobile-menu__close" type="button" aria-label="Tutup menu" data-menu-close>
            <span aria-hidden="true"></span>
        </button>
    </div>
    <nav class="mobile-menu__links" aria-label="Navigasi seluler">
        <a href="{{ $sectionUrl('hero-section') }}">Beranda <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></a>
        <a href="{{ $sectionUrl('tentang-section') }}">Tentang <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></a>
        <a href="{{ $sectionUrl('kegiatan-section') }}">Kegiatan <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></a>
        <a href="{{ $sectionUrl('berita-section') }}">Berita <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></a>
        <a href="{{ $sectionUrl('kontak-section') }}">Kontak <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></a>
    </nav>
    <form class="search-form mobile-menu__search" role="search" action="{{ route('search') }}" method="GET" data-search-form>
        <label class="visually-hidden" for="mobile-search-input">Cari berita dan kegiatan</label>
        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.6"></circle><path d="m16 16 4.5 4.5"></path></svg>
        <input id="mobile-search-input" name="q" type="search" value="{{ request('q') }}" placeholder="Cari berita atau kegiatan…" autocomplete="off" maxlength="100" data-search-input>
        <button class="search-submit" type="submit">Cari</button>
    </form>
    @if (Illuminate\Support\Facades\Route::has('login'))
        @auth
            <a class="mobile-menu__login" href="{{ url('/dashboard') }}">
                <span class="login-link__identity">
                    @if ($profilePhoto)
                        <img class="login-link__avatar" src="{{ asset('storage/'.$profilePhoto) }}" alt="" width="32" height="32">
                    @endif
                    <span>Buka akun</span>
                </span>
                <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg>
            </a>
        @else
            <a class="mobile-menu__login" href="{{ route('login') }}">Masuk ke akun <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></a>
        @endauth
    @endif
</aside>
