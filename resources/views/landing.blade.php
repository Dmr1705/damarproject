@extends('layouts.landing')

@section('content')
    @php
        $featuredNews = $beritas->first();
    @endphp

    {{-- Hero: pengantar singkat, aksi utama, dan foto komunitas. --}}
    <section class="hero-section page-wrap" id="hero-section">
        <div class="hero-copy">
            <p class="eyebrow reveal is-visible">Nahdlatul Ulama · Sawangan</p>
            <h1 class="hero-title reveal is-visible" data-reveal-delay="1">
                <span>Menjaga Tradisi,</span>
                <span class="hero-title__second">Merawat <strong>Negeri</strong></span>
            </h1>
            <p class="hero-description reveal is-visible" data-reveal-delay="2">
                Mengenal kabar, kegiatan, dan khidmah warga NU Sawangan dalam satu ruang yang dekat dan mudah dijelajahi.
            </p>
            <div class="hero-actions reveal is-visible" data-reveal-delay="3">
                <a class="button button--primary anim-pulse" href="{{ route('berita.index') }}">
                    Selengkapnya
                    <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg>
                </a>
                <a class="button button--text" href="#kegiatan-section">
                    <span class="button__jump" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M12 5v14m-6-6 6 6 6-6"></path></svg>
                    </span>
                    Jelajahi kegiatan
                </a>
            </div>
            <a class="scroll-cue" href="#tentang-section">
                <span class="scroll-cue__icon" aria-hidden="true"><span></span></span>
                <span>Gulir untuk mengenal lebih jauh</span>
            </a>
        </div>

        <figure class="hero-visual reveal is-visible" data-reveal-delay="2">
            <div class="hero-photo media-frame">
                <img src="{{ config('images.hero') }}" data-fallback="{{ config('images.fallback') }}" alt="Jemaah Indonesia beribadah bersama di dalam sebuah masjid" width="1200" height="1600" fetchpriority="high" onerror="if (this.dataset.fallback && !this.dataset.fallbackUsed) { this.dataset.fallbackUsed = 'true'; this.src = this.dataset.fallback; } else { this.hidden = true; this.parentElement.classList.add('is-fallback'); }">
                <div class="media-fallback" aria-hidden="true">
                    <span class="media-fallback__mark">NU</span>
                    <span>Foto kegiatan warga belum dapat dimuat</span>
                </div>
                <span class="hero-photo__caption">Kebersamaan dalam khidmah</span>
            </div>
            <figcaption class="hero-visual__index"><span>01</span> Bersama warga, merawat tradisi</figcaption>
        </figure>

        <aside class="hero-note reveal is-visible" data-reveal-delay="3" aria-label="Berita terbaru">
            <span class="hero-note__rule" aria-hidden="true"></span>
            <p class="eyebrow">Kabar terbaru</p>
            @if ($featuredNews)
                <h2>{{ $featuredNews->title }}</h2>
                @php
                    $featuredExcerpt = trim(strip_tags($featuredNews->content ?? ''));
                    $featuredIsNew = $featuredNews->created_at?->greaterThanOrEqualTo(now()->subDays(7)) ?? false;
                @endphp
                @if ($featuredIsNew)
                    <span class="hero-note__badge">Baru</span>
                @endif
                <p>{{ \Illuminate\Support\Str::limit($featuredExcerpt ?: 'Baca kabar terbaru dan informasi kegiatan NU Sawangan.', 105) }}</p>
                <a href="{{ route('berita.show', $featuredNews->id) }}">Baca kabar <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></a>
            @else
                <h2>Ikuti kabar NU Sawangan.</h2>
                <p>Jelajahi halaman berita untuk melihat informasi yang tersedia.</p>
                <a href="{{ route('berita.index') }}">Lihat berita <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></a>
            @endif
            <svg class="hero-note__ornament" viewBox="0 0 40 40" aria-hidden="true"><path d="m20 2 4 12 12-4-7 10 9 9-13-2-5 12-4-12-12 4 7-10-9-9 13 2z"></path></svg>
        </aside>
    </section>

    {{-- Tentang: tujuan portal dan statistik yang berasal dari data beranda. --}}
    <section class="about-section section-pad" id="tentang-section">
        <div class="about-grid page-wrap">
            <figure class="about-visual reveal">
                <div class="about-photo media-frame">
                    <img src="{{ config('images.about') }}" data-fallback="{{ config('images.fallback') }}" alt="Jemaah berkumpul di dalam masjid di Jawa Barat" width="900" height="1100" loading="lazy" onerror="if (this.dataset.fallback && !this.dataset.fallbackUsed) { this.dataset.fallbackUsed = 'true'; this.src = this.dataset.fallback; } else { this.hidden = true; this.parentElement.classList.add('is-fallback'); }">
                    <div class="media-fallback" aria-hidden="true">
                        <span class="media-fallback__mark">01</span>
                        <span>Foto belum dapat dimuat</span>
                    </div>
                </div>
                <figcaption class="about-visual__caption">Mengenal lebih dekat khidmah NU Sawangan</figcaption>
            </figure>

            <div class="about-copy">
                <p class="eyebrow reveal">Tentang NU Sawangan</p>
                <h2 class="section-title reveal" data-reveal-delay="1">Tradisi yang dijaga,<br><em>kebersamaan yang dirawat.</em></h2>
                <p class="section-copy reveal" data-reveal-delay="2">
                    Beranda ini menjadi pintu untuk menemukan kabar organisasi, direktori anggota, dan dokumentasi kegiatan NU Sawangan. Telusuri informasi yang tersedia dan tetap terhubung dengan gerak warga.
                </p>
                <a class="text-link reveal" data-reveal-delay="3" href="{{ route('anggota') }}">Kenali anggota NU Sawangan <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></a>

                <div class="stat-grid" aria-label="Ringkasan NU Sawangan">
                    @foreach (array_slice($stats, 0, 3) as $stat)
                        <div class="stat-item reveal">
                            <strong class="stat-item__value" data-counter="{{ $stat['value'] }}">{{ number_format($stat['value'], 0, ',', '.') }}</strong>
                            <span class="stat-item__label">{{ $stat['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Kegiatan: tiga pintu menuju informasi dan dokumentasi yang sudah tersedia. --}}
    <section class="program-section section-pad" id="kegiatan-section">
        <div class="page-wrap">
            <div class="section-heading reveal">
                <div>
                    <p class="eyebrow">Temukan yang ingin Anda ikuti</p>
                    <h2 class="section-title">Ruang untuk tetap <em>terhubung.</em></h2>
                </div>
                <p class="section-copy">Kabar, anggota, dan dokumentasi kegiatan—pilih jalur informasi yang Anda perlukan.</p>
            </div>

            <div class="program-grid">
                <article class="program-card reveal" data-searchable>
                    <a class="program-card__link" href="{{ route('berita.index') }}" aria-label="Jelajahi berita NU Sawangan">
                        <div class="program-card__image media-frame">
                            <img src="{{ config('images.kegiatan_1') }}" data-fallback="{{ config('images.fallback') }}" alt="Jemaah muslim beribadah di masjid di Jakarta, Indonesia" width="800" height="600" loading="lazy" onerror="if (this.dataset.fallback && !this.dataset.fallbackUsed) { this.dataset.fallbackUsed = 'true'; this.src = this.dataset.fallback; } else { this.hidden = true; this.parentElement.classList.add('is-fallback'); }">
                            <div class="media-fallback" aria-hidden="true"><span class="media-fallback__mark">02</span><span>Foto kegiatan belum dapat dimuat</span></div>
                        </div>
                        <div class="program-card__body">
                            <span class="program-card__category">Kabar organisasi</span>
                            <h3>Berita NU Sawangan</h3>
                            <p>Baca informasi dan cerita terbaru yang telah diterbitkan.</p>
                            <span class="program-card__action">Jelajahi berita <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></span>
                        </div>
                    </a>
                </article>

                <article class="program-card reveal" data-searchable>
                    <a class="program-card__link" href="{{ route('anggota') }}" aria-label="Jelajahi direktori anggota NU Sawangan">
                        <div class="program-card__image media-frame">
                            <img src="{{ config('images.kegiatan_2') }}" data-fallback="{{ config('images.fallback') }}" alt="Jemaah mengikuti salat berjamaah di Sulawesi Selatan, Indonesia" width="800" height="600" loading="lazy" onerror="if (this.dataset.fallback && !this.dataset.fallbackUsed) { this.dataset.fallbackUsed = 'true'; this.src = this.dataset.fallback; } else { this.hidden = true; this.parentElement.classList.add('is-fallback'); }">
                            <div class="media-fallback" aria-hidden="true"><span class="media-fallback__mark">03</span><span>Foto kegiatan belum dapat dimuat</span></div>
                        </div>
                        <div class="program-card__body">
                            <span class="program-card__category">Direktori</span>
                            <h3>Kenali para anggota</h3>
                            <p>Temukan direktori anggota dan informasi organisasi.</p>
                            <span class="program-card__action">Buka direktori <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></span>
                        </div>
                    </a>
                </article>

                <article class="program-card reveal" data-searchable>
                    <a class="program-card__link" href="{{ route('galeri') }}" aria-label="Lihat galeri kegiatan NU Sawangan">
                        <div class="program-card__image media-frame">
                            <img src="{{ config('images.kegiatan_3') }}" data-fallback="{{ config('images.fallback') }}" alt="Jemaah memenuhi ruang masjid untuk beribadah bersama di Jakarta, Indonesia" width="800" height="600" loading="lazy" onerror="if (this.dataset.fallback && !this.dataset.fallbackUsed) { this.dataset.fallbackUsed = 'true'; this.src = this.dataset.fallback; } else { this.hidden = true; this.parentElement.classList.add('is-fallback'); }">
                            <div class="media-fallback" aria-hidden="true"><span class="media-fallback__mark">04</span><span>Foto kegiatan belum dapat dimuat</span></div>
                        </div>
                        <div class="program-card__body">
                            <span class="program-card__category">Dokumentasi</span>
                            <h3>Jejak kebersamaan</h3>
                            <p>Lihat dokumentasi kegiatan yang tersimpan di galeri.</p>
                            <span class="program-card__action">Buka galeri <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></span>
                        </div>
                    </a>
                </article>
            </div>
        </div>
    </section>

    {{-- Berita: tampilkan berita terbit dari data route beranda. --}}
    <section class="news-section section-pad" id="berita-section">
        <div class="page-wrap">
            <div class="section-heading reveal">
                <div>
                    <p class="eyebrow">Kabar dari Sawangan</p>
                    <h2 class="section-title">Cerita terbaru <em>NU Sawangan.</em></h2>
                </div>
                <a class="text-link" href="{{ route('berita.index') }}">Semua berita <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></a>
            </div>

            @if ($beritas->isNotEmpty())
                <div class="news-grid">
                    @foreach ($beritas as $berita)
                        <article class="news-card reveal" data-searchable>
                            <a class="news-card__image media-frame" href="{{ route('berita.show', $berita->id) }}" aria-label="Baca berita: {{ $berita->title }}">
                                @if ($berita->image)
                                    <img src="{{ asset('storage/' . $berita->image) }}" alt="{{ $berita->title }}" width="800" height="600" loading="lazy">
                                @else
                                    <span class="news-card__image-fallback" aria-hidden="true">NU<br>Sawangan</span>
                                @endif
                            </a>
                            <div class="news-card__body">
                                <time datetime="{{ $berita->created_at->toDateString() }}">{{ $berita->created_at->translatedFormat('d F Y') }}</time>
                                <h3><a href="{{ route('berita.show', $berita->id) }}">{{ $berita->title }}</a></h3>
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($berita->content), 125) }}</p>
                                <a class="text-link" href="{{ route('berita.show', $berita->id) }}">Baca selengkapnya <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="news-empty reveal">
                    <svg class="news-empty__mark" viewBox="0 0 40 40" aria-hidden="true"><path d="m20 2 4 12 12-4-7 10 9 9-13-2-5 12-4-12-12 4 7-10-9-9 13 2z"></path></svg>
                    <div>
                        <h3>Belum ada berita terbaru.</h3>
                        <p>Informasi akan tampil di sini setelah berita diterbitkan.</p>
                    </div>
                    <a class="text-link" href="{{ route('berita.index') }}">Kunjungi halaman berita <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></a>
                </div>
            @endif
        </div>
    </section>

    {{-- Ajakan: latar lokal dengan overlay agar teks tetap jelas. --}}
    <section class="cta-section section-pad">
        <div class="cta-panel page-wrap reveal">
            <img class="cta-panel__image" src="{{ config('images.cta') }}" data-fallback="{{ config('images.fallback') }}" alt="" width="1600" height="900" loading="lazy" onerror="if (this.dataset.fallback && !this.dataset.fallbackUsed) { this.dataset.fallbackUsed = 'true'; this.src = this.dataset.fallback; } else { this.hidden = true; }">
            <div class="cta-panel__content">
                <p class="eyebrow eyebrow--light">Mari saling mengenal</p>
                <h2>Khidmah tumbuh<br>lewat <em>kebersamaan.</em></h2>
                <p>Kenali lebih dekat warga dan kegiatan NU Sawangan melalui informasi yang tersedia.</p>
                <a class="button button--light" href="{{ route('galeri') }}">Jelajahi galeri <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></a>
            </div>
            <span class="cta-panel__seal" aria-hidden="true">NU<br><small>SAWANGAN</small></span>
        </div>
    </section>

    {{-- Kontak: navigasi singkat menuju kanal informasi yang sudah tersedia. --}}
    <section class="contact-section section-pad" id="kontak-section">
        <div class="contact-row page-wrap reveal">
            <div>
                <p class="eyebrow">Tetap terhubung</p>
                <h2 class="section-title">Informasi NU Sawangan,<br><em>lebih dekat.</em></h2>
            </div>
            <p class="section-copy">Kunjungi kanal berita, galeri, atau direktori anggota untuk menemukan informasi publik yang Anda perlukan.</p>
            <a class="button button--primary" href="{{ route('anggota') }}">Lihat direktori <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></a>
        </div>
    </section>
@endsection
