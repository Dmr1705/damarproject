<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Terjadi kendala · NU Sawangan')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
</head>
<body class="error-page">
    <main class="error-card anim-fade-up">
        <a class="error-brand" href="{{ route('home') }}">
            <img src="{{ config('images.logo') }}" alt="" width="48" height="48" onerror="this.onerror=null;this.hidden=true">
            <span>NU Sawangan</span>
        </a>
        <p class="error-card__code">@yield('code')</p>
        <h1>@yield('heading')</h1>
        <p class="error-card__message">@yield('message')</p>
        <a class="btn btn--primary btn--pill btn--lg" href="{{ route('home') }}">Kembali ke Beranda</a>
    </main>
</body>
</html>
