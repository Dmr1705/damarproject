<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Pusat informasi, direktori anggota, berita, dan dokumentasi kegiatan NU Sawangan.">
    <meta name="theme-color" content="#f7f8f3">
    <title>NU Sawangan | Informasi dan Layanan Organisasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="public-site flex min-h-screen flex-col overflow-x-hidden bg-slate-50 font-sans text-gray-900 antialiased selection:bg-emerald-500 selection:text-white">
    @include('layouts.public-navigation')

    <main>
        <section id="hero-section" class="public-landing-hero mx-auto grid w-full max-w-6xl scroll-mt-28 items-center gap-10 px-4 pb-12 pt-8 sm:px-6 md:grid-cols-[0.92fr_1.08fr] md:gap-12 md:pb-16 md:pt-10">
            <div class="relative z-10">
                <p class="reveal mb-5 inline-flex items-center gap-2 rounded-full border border-emerald-800/10 bg-white/80 px-4 py-2 text-xs font-semibold tracking-wide text-[#087A4B] shadow-sm">
                    <span class="h-2 w-2 rounded-full bg-[#087A4B]" aria-hidden="true"></span>
                    NU Sawangan
                </p>
                <h1 class="reveal delay-100 max-w-2xl text-4xl font-semibold leading-[1.04] tracking-[-0.045em] text-[#17382B] sm:text-5xl lg:text-6xl">
                    Satu ruang untuk <span class="text-[#087A4B]">NU Sawangan.</span>
                </h1>
                <p class="reveal delay-200 mt-6 max-w-xl text-base leading-relaxed text-slate-600 sm:text-lg">
                    Temukan kabar, anggota, dan dokumentasi kegiatan NU Sawangan dalam satu tempat yang mudah diakses.
                </p>
                <div class="reveal delay-300 mt-8 flex flex-wrap items-center gap-3">
                    <a href="{{ route('berita.index') }}" class="group inline-flex min-h-12 items-center justify-center gap-3 rounded-full bg-[#087A4B] px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-950/10 transition duration-300 ease-[cubic-bezier(0.32,0.72,0,1)] hover:-translate-y-0.5 hover:bg-[#065C39] active:scale-[0.98]">
                        Baca berita
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-white/15 transition-transform duration-300 ease-[cubic-bezier(0.32,0.72,0,1)] group-hover:translate-x-0.5" aria-hidden="true">↗</span>
                    </a>
                    <a href="{{ route('anggota') }}" class="inline-flex min-h-12 items-center justify-center rounded-full px-5 py-3 text-sm font-bold text-[#087A4B] transition duration-300 ease-[cubic-bezier(0.32,0.72,0,1)] hover:bg-emerald-900/5 active:scale-[0.98]">
                        Lihat direktori anggota
                    </a>
                </div>
            </div>

            <div class="reveal delay-200 landing-image-shell relative mx-auto w-full max-w-2xl">
                <div class="landing-identity-frame flex min-h-[300px] flex-col items-center justify-center overflow-hidden rounded-[1.65rem] px-6 py-8 sm:min-h-[390px] md:min-h-[470px]">
                    <div class="landing-identity-mark">
                        <img src="{{ asset('storage/NU.webp') }}" alt="Lambang Nahdlatul Ulama" class="h-full w-full object-cover" fetchpriority="high">
                    </div>
                    <p class="mt-6 text-center text-sm font-bold uppercase tracking-[0.18em] text-[#087A4B]">Nahdlatul Ulama</p>
                    <p class="mt-1 text-center text-2xl font-semibold tracking-[-0.04em] text-[#17382B] sm:text-3xl">Sawangan</p>
                    <div class="landing-org-marks mt-7 flex items-center justify-center gap-2.5 sm:gap-4" aria-label="Badan otonom dan organisasi">
                        <img src="{{ asset('storage/logo%20organisasi/MuslimatNU.png') }}" alt="Muslimat NU" loading="lazy">
                        <img src="{{ asset('storage/logo%20organisasi/FATAYAT-NU.png') }}" alt="Fatayat NU" loading="lazy">
                        <img src="{{ asset('storage/logo%20organisasi/GP-Ansor.png') }}" alt="GP Ansor" loading="lazy">
                        <img src="{{ asset('storage/logo%20organisasi/IPNU.png') }}" alt="IPNU" loading="lazy">
                        <img src="{{ asset('storage/logo%20organisasi/IPPNU.png') }}" alt="IPPNU" loading="lazy">
                        <img src="{{ asset('storage/logo%20organisasi/PMII.png') }}" alt="PMII" loading="lazy">
                    </div>
                </div>
            </div>
        </section>

        <section aria-label="Ringkasan NU Sawangan" class="mx-auto grid max-w-5xl grid-cols-2 gap-3 px-4 pb-12 sm:px-6 md:grid-cols-4">
            @foreach ($stats as $stat)
                <div class="reveal rounded-2xl border border-emerald-900/5 bg-white px-3 py-3 shadow-sm sm:px-4">
                    <strong class="block text-2xl font-semibold tabular-nums tracking-tight text-[#087A4B]">{{ number_format($stat['value'], 0, ',', '.') }}</strong>
                    <span class="mt-1 block text-xs font-medium text-slate-500">{{ $stat['label'] }}</span>
                </div>
            @endforeach
        </section>

        <section class="public-section-band">
            <div class="mx-auto grid max-w-6xl gap-10 px-4 py-16 sm:px-6 md:grid-cols-[0.8fr_1.2fr] md:items-center md:gap-16 md:py-24">
                <div class="reveal">
                    <p class="text-sm font-semibold text-[#087A4B]">Satu pintu informasi</p>
                    <h2 class="mt-3 max-w-lg text-3xl font-semibold leading-tight tracking-[-0.04em] text-[#17382B] sm:text-4xl">Yang dibutuhkan warga, lebih mudah ditemukan.</h2>
                </div>
                <div class="reveal delay-100">
                    <p class="max-w-2xl text-base leading-relaxed text-slate-600">
                        NU Sawangan menghubungkan kabar organisasi, direktori anggota, dan dokumentasi kegiatan agar informasi penting dapat diakses dengan jelas.
                    </p>
                    <div class="mt-7 grid gap-3 sm:grid-cols-3">
                        <a href="{{ route('anggota') }}" class="public-service-link">
                            <span class="public-service-index">01</span>
                            <span><strong>Anggota</strong><small>Direktori publik</small></span>
                            <span class="public-service-arrow" aria-hidden="true">↗</span>
                        </a>
                        <a href="{{ route('galeri') }}" class="public-service-link">
                            <span class="public-service-index">02</span>
                            <span><strong>Galeri</strong><small>Dokumentasi kegiatan</small></span>
                            <span class="public-service-arrow" aria-hidden="true">↗</span>
                        </a>
                        <a href="{{ route('berita.index') }}" class="public-service-link">
                            <span class="public-service-index">03</span>
                            <span><strong>Berita</strong><small>Kabar organisasi</small></span>
                            <span class="public-service-arrow" aria-hidden="true">↗</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="produk-section" class="mx-auto max-w-6xl scroll-mt-28 px-4 py-16 sm:px-6 md:py-24">
            <div class="reveal mb-9 max-w-2xl">
                <p class="text-sm font-semibold text-[#087A4B]">Badan otonom dan organisasi</p>
                <h2 class="mt-3 text-3xl font-semibold leading-tight tracking-[-0.04em] text-[#17382B] sm:text-4xl">Tumbuh bersama dalam satu ekosistem.</h2>
                <p class="mt-4 max-w-xl text-sm leading-relaxed text-slate-600 sm:text-base">Kenali organisasi yang hadir dan bergerak bersama warga NU Sawangan.</p>
            </div>

            <div class="bento-card-grid organization-card-grid grid grid-cols-1 gap-4 md:grid-cols-2">
                <article class="reveal organization-feature-card rounded-3xl bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-start gap-5">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 p-2">
                            <img src="{{ asset('storage/logo%20organisasi/MuslimatNU.png') }}" alt="Logo Muslimat NU" class="h-full w-full object-contain">
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#17382B]">Muslimat NU</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">Badan otonom khusus perempuan di bawah naungan Nahdlatul Ulama.</p>
                        </div>
                    </div>
                </article>

                <article class="reveal organization-feature-card rounded-3xl bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-start gap-5">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 p-2">
                            <img src="{{ asset('storage/logo%20organisasi/FATAYAT-NU.png') }}" alt="Logo Fatayat NU" class="h-full w-full object-contain">
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#17382B]">Fatayat NU</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">Wadah perempuan muda NU dalam bidang keagamaan, sosial, dan pemberdayaan.</p>
                        </div>
                    </div>
                </article>

                <article class="reveal organization-feature-card rounded-3xl bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-start gap-5">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 p-2">
                            <img src="{{ asset('storage/logo%20organisasi/GP-Ansor.png') }}" alt="Logo GP Ansor" class="h-full w-full object-contain">
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#17382B]">GP Ansor</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">Organisasi kepemudaan Islam yang berafiliasi dengan Nahdlatul Ulama.</p>
                        </div>
                    </div>
                </article>

                <article class="reveal organization-feature-card rounded-3xl bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-start gap-5">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 p-2">
                            <img src="{{ asset('storage/logo%20organisasi/IPNU.png') }}" alt="Logo IPNU" class="h-full w-full object-contain">
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#17382B]">IPNU</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">Wadah berhimpun dan kaderisasi bagi pelajar serta santri putra.</p>
                        </div>
                    </div>
                </article>

                <article class="reveal organization-feature-card rounded-3xl bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-start gap-5">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 p-2">
                            <img src="{{ asset('storage/logo%20organisasi/IPPNU.png') }}" alt="Logo IPPNU" class="h-full w-full object-contain">
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#17382B]">IPPNU</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">Wadah berhimpun dan kaderisasi bagi pelajar serta santri putri.</p>
                        </div>
                    </div>
                </article>

                <article class="reveal organization-feature-card rounded-3xl bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-start gap-5">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 p-2">
                            <img src="{{ asset('storage/logo%20organisasi/PMII.png') }}" alt="Logo PMII" class="h-full w-full object-contain">
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#17382B]">PMII</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">Organisasi kemahasiswaan yang berlandaskan Islam Ahlussunnah wal Jama'ah.</p>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        @if ($beritas->isNotEmpty())
            <section class="public-section-band">
                <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 md:py-24">
                    <div class="reveal mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div class="max-w-2xl">
                            <p class="text-sm font-semibold text-[#087A4B]">Kabar terbaru</p>
                            <h2 class="mt-3 text-3xl font-semibold leading-tight tracking-[-0.04em] text-[#17382B] sm:text-4xl">Berita dari NU Sawangan.</h2>
                        </div>
                        <a href="{{ route('berita.index') }}" class="inline-flex w-fit items-center gap-2 text-sm font-bold text-[#087A4B] transition duration-300 hover:gap-3">Semua berita <span aria-hidden="true">↗</span></a>
                    </div>
                    <div class="grid gap-5 md:grid-cols-3">
                        @foreach ($beritas as $berita)
                            <article class="reveal overflow-hidden rounded-3xl bg-white shadow-sm">
                                @if ($berita->image)
                                    <img src="{{ asset('storage/' . $berita->image) }}" alt="{{ $berita->title }}" class="h-52 w-full object-cover" loading="lazy">
                                @else
                                    <div class="flex h-52 items-center justify-center bg-emerald-50 text-sm font-medium text-emerald-800">NU Sawangan</div>
                                @endif
                                <div class="p-6">
                                    <time datetime="{{ $berita->created_at->toDateString() }}" class="text-xs font-semibold text-slate-500">{{ $berita->created_at->translatedFormat('d F Y') }}</time>
                                    <h3 class="mt-3 line-clamp-2 text-lg font-semibold leading-snug text-[#17382B]">{{ $berita->title }}</h3>
                                    <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-slate-600">{{ \Illuminate\Support\Str::limit(strip_tags($berita->content), 115) }}</p>
                                    <a href="{{ route('berita.show', $berita->id) }}" class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-[#087A4B] transition duration-300 hover:gap-3">Baca berita <span aria-hidden="true">↗</span></a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </main>

    @include('layouts.public-footer')
</body>

</html>
