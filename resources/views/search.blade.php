@extends('layouts.app')

@section('title', $term === '' ? 'Cari informasi · NU Sawangan' : 'Hasil pencarian: '.$term.' · NU Sawangan')

@section('content')
    <section class="search-page section-pad">
        <div class="page-wrap">
            <nav class="breadcrumb search-page__breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">Pencarian</span>
            </nav>

            <header class="search-page__header">
                <p class="eyebrow">Pencarian informasi</p>
                <h1 class="section-title">Temukan kabar <em>NU Sawangan.</em></h1>
                <p class="section-copy">Telusuri berita, dokumentasi kegiatan, dan direktori anggota yang tersedia untuk publik.</p>

                <form class="search-page__form" action="{{ route('search') }}" method="GET" role="search">
                    <label class="visually-hidden" for="search-page-input">Kata kunci pencarian</label>
                    <input class="ui-control" id="search-page-input" name="q" type="search" value="{{ $term }}" maxlength="100" placeholder="Contoh: pengajian, kegiatan, anggota">
                    <button class="button button--primary" type="submit">Cari</button>
                </form>
            </header>

            @if ($term !== '')
                <p class="search-page__count" role="status">
                    {{ $results->total() }} hasil untuk <strong>“{{ $term }}”</strong>
                </p>

                @if ($results->isNotEmpty())
                    <div class="search-page__results">
                        @foreach ($results as $result)
                            <article class="search-result ui-card">
                                <a class="search-result__media" href="{{ $result->url }}" aria-label="Buka {{ $result->title }}">
                                    @if ($result->imageUrl)
                                        <img src="{{ $result->imageUrl }}" data-fallback="{{ config('images.fallback') }}" alt="" width="800" height="600" loading="lazy" onerror="if (this.dataset.fallback && !this.dataset.fallbackUsed) { this.dataset.fallbackUsed = 'true'; this.src = this.dataset.fallback; } else { this.hidden = true; this.parentElement.classList.add('is-fallback'); }">
                                    @else
                                        <span class="search-result__placeholder" aria-hidden="true">NU<br>Sawangan</span>
                                    @endif
                                </a>
                                <div class="search-result__body">
                                    <span class="ui-badge">{{ ucfirst($result->type) }}</span>
                                    <h2><a href="{{ $result->url }}">
                                        @foreach ($result->titleSegments as $segment)
                                            @if ($segment['match'])
                                                <mark>{{ $segment['text'] }}</mark>
                                            @else
                                                {{ $segment['text'] }}
                                            @endif
                                        @endforeach
                                    </a></h2>
                                    @if ($result->excerpt !== '')
                                        <p>
                                            @foreach ($result->excerptSegments as $segment)
                                                @if ($segment['match'])
                                                    <mark>{{ $segment['text'] }}</mark>
                                                @else
                                                    {{ $segment['text'] }}
                                                @endif
                                            @endforeach
                                        </p>
                                    @endif
                                    <a class="text-link" href="{{ $result->url }}">Buka informasi <span aria-hidden="true">→</span></a>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="search-page__pagination">
                        {{ $results->links() }}
                    </div>
                @else
                    <div class="empty-state search-page__empty">
                        <h2>Tidak ada hasil untuk “{{ $term }}”.</h2>
                        <p>Coba kata kunci yang lebih umum, periksa ejaan, atau gunakan nama kegiatan maupun organisasi.</p>
                        <a class="button button--outline" href="{{ route('berita.index') }}">Jelajahi semua berita</a>
                    </div>
                @endif
            @else
                <div class="empty-state search-page__empty">
                    <h2>Mulai dengan kata kunci.</h2>
                    <p>Masukkan topik, nama kegiatan, atau nama anggota yang ingin Anda temukan.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
