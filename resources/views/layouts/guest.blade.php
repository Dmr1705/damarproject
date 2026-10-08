<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'NU Sawangan') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
        <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
        <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
        <script src="{{ asset('js/auth.js') }}" defer></script>
    </head>
    <body class="auth-page">
        <main class="auth-shell">
            <section class="auth-visual" aria-label="NU Sawangan">
                <img class="auth-visual__image" src="{{ config('images.auth_bg') }}" data-fallback="{{ config('images.fallback') }}" alt="Jemaah berkumpul dan beribadah bersama di masjid" width="1600" height="1200" onerror="if (this.dataset.fallback && !this.dataset.fallbackUsed) { this.dataset.fallbackUsed = 'true'; this.src = this.dataset.fallback; } else { this.hidden = true; }">
                <a class="auth-brand" href="{{ route('home') }}">
                    <img src="{{ config('images.logo') }}" alt="Logo Majelis Wakil Cabang Nahdlatul Ulama Kecamatan Sawangan" width="48" height="48" onerror="this.onerror=null;this.hidden=true">
                    <span>NU Sawangan</span>
                </a>
                <div class="auth-visual__copy">
                    <span class="auth-kicker">Nahdlatul Ulama · Sawangan</span>
                    <h1>Merawat khidmah,<br><em>menyambung umat.</em></h1>
                    <p>Ruang informasi dan layanan warga NU Sawangan.</p>
                </div>
            </section>
            <section class="auth-panel">
                <div class="auth-panel__inner anim-fade-up">
                    {{ $slot }}
                </div>
            </section>
        </main>
        @stack('scripts')
    </body>
</html>