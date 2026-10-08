@extends('layouts.app')

@section('title', $berita->title.' · NU Sawangan')

@section('content')
    <section class="public-page-shell">
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
    </section>
@endsection
