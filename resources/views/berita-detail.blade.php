@extends('layouts.app')

@section('title', $berita->title.' · NU Sawangan')

@section('content')
    <section class="public-page-shell">
        <article class="reveal mx-auto max-w-4xl">
            <a href="{{ route('berita.index') }}" class="mb-7 inline-flex items-center gap-2 text-sm font-bold text-[#087A4B] transition hover:gap-3">
                <span aria-hidden="true">←</span> Kembali ke berita
            </a>

            <header class="mb-8">
                <time datetime="{{ $berita->created_at->toDateString() }}" class="text-sm font-semibold text-[#087A4B]">{{ $berita->created_at->locale('id')->translatedFormat('l, d F Y') }}</time>
                <h1 class="mt-3 max-w-3xl text-3xl font-semibold leading-tight tracking-[-0.045em] text-[#17382B] sm:text-5xl">{{ $berita->title }}</h1>
            </header>

            @if ($berita->image)
                <figure class="mb-8 overflow-hidden rounded-3xl bg-emerald-50">
                    <img src="{{ asset('storage/' . $berita->image) }}" alt="{{ $berita->title }}" class="max-h-[560px] w-full object-cover">
                </figure>
            @endif

            <div class="min-w-0 overflow-hidden rounded-3xl border border-emerald-900/10 bg-white p-6 sm:p-10"
                    style="box-shadow: 0 12px 32px -8px rgba(6, 44, 32, 0.22), 0 4px 12px -4px rgba(6, 44, 32, 0.12) !important;">
                <div class="prose break-word-safe max-w-none text-gray-700 prose-a:text-[#087A4B] prose-a:font-semibold prose-a:no-underline prose-a:transition hover:prose-a:underline">
                    {!! nl2br(e($berita->content)) !!}
                </div>
            </div>
        </article>
    </section>
@endsection
