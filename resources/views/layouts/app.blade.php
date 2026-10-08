<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'NU Sawangan'))</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
        <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
        <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
        <script src="{{ asset('js/landing.js') }}" defer></script>
    </head>
    <body class="public-site">
        <a class="skip-link" href="#main-content">Langsung ke konten utama</a>
        @include('partials.navbar')

        @isset($header)
            <header class="public-page-shell public-page-header">
                <div>
                        {{ $header }}
                </div>
            </header>
        @endisset

        <main id="main-content">
            @hasSection('content')
                @yield('content')
            @else
                @isset($slot)
                    {{ $slot }}
                @endisset
            @endif
            </main>
        @include('partials.footer')
    </body>
</html>
