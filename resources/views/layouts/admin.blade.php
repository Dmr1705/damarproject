<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin · NU Sawangan')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-pages.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-profile-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notification-bell.css') }}">
    <script src="{{ asset('js/admin.js') }}" defer></script>
    <script src="{{ asset('js/admin-pages.js') }}" defer></script>
    <script src="{{ asset('js/notification-bell.js') }}" defer></script>
    <script src="{{ asset('js/admin-profile-menu.js') }}" defer></script>
</head>
<body class="admin-page">
    @php
        $pageTitle = match (true) {
            request()->routeIs('admin.berita.*') => 'Data Berita',
            request()->routeIs('admin.anggota.*') => 'Data Anggota',
            request()->routeIs('admin.galeri.*') => 'Data Galeri',
            request()->routeIs('admin.dashboard', 'dashboard') => 'Dashboard',
            request()->routeIs('profile.*') => 'Profil',
            default => 'Panel Pengelolaan',
        };
        $adminSearchRoute = request()->routeIs('admin.anggota.*')
            ? 'admin.anggota.index'
            : (request()->routeIs('admin.galeri.*') ? 'admin.galeri.index' : 'admin.berita.index');
    @endphp

    <div class="admin-shell" data-admin-shell>
        <button class="admin-overlay" type="button" data-admin-overlay aria-label="Tutup navigasi admin"></button>
        <aside class="admin-sidebar" id="admin-sidebar" data-admin-sidebar aria-label="Navigasi admin">
            <div class="admin-brand">
                <img src="{{ config('images.logo') }}" alt="" width="42" height="42" onerror="this.onerror=null;this.hidden=true">
                <span class="admin-brand__text">
                    <span class="admin-brand__title">Panel Admin</span>
                    <span class="admin-brand__caption">NU Sawangan</span>
                </span>
                <button class="admin-mobile-close" type="button" data-admin-close aria-label="Tutup menu admin">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"></path></svg>
                </button>
            </div>

            <nav class="admin-sidebar__nav">
                <p class="admin-nav-label">Ringkasan</p>
                <a href="{{ route('admin.dashboard') }}" @class(['admin-nav-link', 'anim-fade-up', 'delay-1']) @if (request()->routeIs('admin.dashboard', 'dashboard')) aria-current="page" @endif title="Dashboard">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1z"></path></svg>
                    <span>Dashboard</span>
                </a>

                @if (auth()->user()?->role === 'admin')
                    <p class="admin-nav-label">Kelola konten</p>
                    <a href="{{ route('admin.berita.index') }}" @class(['admin-nav-link', 'anim-fade-up', 'delay-2']) @if (request()->routeIs('admin.berita.*')) aria-current="page" @endif title="Data berita">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 4h12a2 2 0 0 1 2 2v14H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"></path><path d="M7 8h8M7 12h8M7 16h5"></path></svg>
                        <span>Data Berita</span>
                    </a>
                    <a href="{{ route('admin.anggota.index') }}" @class(['admin-nav-link', 'anim-fade-up', 'delay-3']) @if (request()->routeIs('admin.anggota.*')) aria-current="page" @endif title="Data anggota">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="9" cy="8" r="3"></circle><path d="M3 20v-1a6 6 0 0 1 12 0v1zM16 5.2a3 3 0 0 1 0 5.6M18 14a5 5 0 0 1 3 4.6V20h-3"></path></svg>
                        <span>Data Anggota</span>
                    </a>
                    <a href="{{ route('admin.galeri.index') }}" @class(['admin-nav-link', 'anim-fade-up', 'delay-4']) @if (request()->routeIs('admin.galeri.*')) aria-current="page" @endif title="Data galeri">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2"></rect><circle cx="8.5" cy="9" r="1.5"></circle><path d="m21 15-5-5L5 20"></path></svg>
                        <span>Data Galeri</span>
                    </a>
                @endif
            </nav>

            <div class="admin-sidebar__bottom">
                <a class="admin-nav-link" href="{{ route('home') }}" title="Kembali ke beranda">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M19 12H5m7 7-7-7 7-7"></path></svg>
                    <span>Kembali ke beranda</span>
                </a>
            </div>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <div class="admin-topbar__lead">
                    <button class="admin-icon-button" type="button" data-admin-toggle aria-label="Buka atau lipat navigasi admin" aria-expanded="true" aria-controls="admin-sidebar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h1>@yield('page-title', $pageTitle)</h1>
                </div>

                <div class="admin-topbar__actions">
                    <form class="admin-search" method="GET" action="{{ route($adminSearchRoute) }}" role="search">
                        <label class="sr-only" for="admin-search">Cari data pada modul ini</label>
                        <input id="admin-search" type="search" name="q" value="{{ request('q') }}" placeholder="Cari data…" maxlength="100">
                        <button class="admin-icon-button" type="submit" aria-label="Cari data">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.6"></circle><path d="m16 16 4.5 4.5"></path></svg>
                        </button>
                    </form>

                    <x-notification-bell
                        mode="admin"
                        :endpoint="route('admin.notifications.index')"
                        :see-all-url="route('admin.berita.index')"
                    />

                    @include('partials.admin-profile-menu')
                </div>
            </header>

            <main class="admin-content" id="main-content">
                <nav class="breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('admin.dashboard') }}">Panel</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page">@yield('page-title', $pageTitle)</span>
                </nav>
                @hasSection('content')
                    @yield('content')
                @else
                    @isset($adminSlot)
                        {{ $adminSlot }}
                    @endisset
                @endif
            </main>
        </div>
    </div>
    <dialog class="admin-confirm-dialog" data-confirm-dialog aria-labelledby="admin-confirm-title" aria-describedby="admin-confirm-message">
        <h2 id="admin-confirm-title">Konfirmasi penghapusan</h2>
        <p id="admin-confirm-message">Data yang dihapus tidak dapat dipulihkan.</p>
        <div class="admin-confirm-dialog__actions">
            <button class="btn btn--outline" type="button" data-confirm-cancel>Batal</button>
            <button class="btn btn--danger" type="button" data-confirm-proceed>Hapus</button>
        </div>
    </dialog>
    @stack('scripts')
</body>
</html>
