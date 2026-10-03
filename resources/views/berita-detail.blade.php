<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($berita->content), 155) }}">
    <meta name="theme-color" content="#f7f8f3">
    <title>{{ $berita->title }} | NU Sawangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="public-site flex min-h-screen flex-col overflow-x-hidden bg-slate-50 font-sans text-gray-900 antialiased">
    @include('layouts.public-navigation')

    <main class="public-page-shell flex-grow">
        <article class="reveal mx-auto max-w-4xl">
            <a href="{{ route('berita.index') }}" class="mb-7 inline-flex items-center gap-2 text-sm font-bold text-[#087A4B] transition hover:gap-3">
                <span aria-hidden="true">←</span> Kembali ke berita
            </a>

            <header class="mb-8">
                <time datetime="{{ $berita->created_at->toDateString() }}" class="text-sm font-semibold text-[#087A4B]">{{ $berita->created_at->translatedFormat('l, d F Y') }}</time>
                <h1 class="mt-3 max-w-3xl text-3xl font-semibold leading-tight tracking-[-0.045em] text-[#17382B] sm:text-5xl">{{ $berita->title }}</h1>
            </header>

            @if ($berita->image)
                <figure class="mb-8 overflow-hidden rounded-3xl bg-emerald-50">
                    <img src="{{ asset('storage/' . $berita->image) }}" alt="{{ $berita->title }}" class="max-h-[560px] w-full object-cover">
                </figure>
            @endif

            <div class="rounded-3xl border border-emerald-900/5 bg-white p-6 shadow-sm sm:p-10">
                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($berita->content)) !!}
                </div>
            </div>
        </article>
    </main>

    @include('layouts.public-footer')
</body>

</html>
