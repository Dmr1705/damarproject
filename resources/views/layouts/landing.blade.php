<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Kenali NU Sawangan, baca kabar terbaru, dan temukan dokumentasi kegiatan serta direktori anggota.">
    <meta name="theme-color" content="#FFFFFF">
    <title>NU Sawangan — Menjaga Tradisi, Merawat Negeri</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notification-bell.css') }}">
    <script src="{{ asset('js/landing.js') }}" defer></script>
    <script src="{{ asset('js/notification-bell.js') }}" defer></script>
</head>
<body class="landing-page">
    <a class="skip-link" href="#main-content">Langsung ke konten utama</a>

    @include('partials.navbar')

    <main id="main-content">
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
