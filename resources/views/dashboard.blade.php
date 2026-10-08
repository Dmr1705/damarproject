@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
    @php
        $roleLabel = $user->isAdmin() ? 'ADMIN' : strtoupper($user->role ?? 'ANGGOTA');
        $membershipStatus = strtoupper($anggota?->status ?? 'Aktif');
    @endphp

    <div class="admin-dashboard">
        <header class="dashboard-welcome anim-fade-up">
            <div class="dashboard-welcome__copy">
                <p class="dashboard-welcome__date">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                <h2>Assalamu'alaikum, <span>{{ $user->name }}</span></h2>
                <span class="dashboard-welcome__status">
                    <span aria-hidden="true"></span>
                    {{ $membershipStatus }} ({{ $roleLabel }})
                </span>
            </div>

            @if ($user->isAdmin())
                <nav class="dashboard-quick-actions" aria-label="Aksi cepat">
                    <a class="btn btn--primary" href="{{ route('admin.berita.create') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 5v14M5 12h14"></path></svg>
                        Tambah Berita
                    </a>
                    <a class="btn btn--outline" href="{{ route('admin.anggota.create') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 5v14M5 12h14"></path></svg>
                        Tambah Anggota
                    </a>
                    <a class="btn btn--outline" href="{{ route('admin.galeri.create') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2"></rect><circle cx="8.5" cy="9" r="1.5"></circle><path d="m21 15-5-5L5 20"></path></svg>
                        Unggah Galeri
                    </a>
                </nav>
            @endif
        </header>

        <section class="dashboard-stats" aria-label="Statistik konten">
            <article class="dashboard-stat anim-fade-up delay-1">
                <span class="dashboard-stat__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M5 4h12a2 2 0 0 1 2 2v14H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"></path><path d="M7 8h8M7 12h8M7 16h5"></path></svg>
                </span>
                <span class="dashboard-stat__label">Total Berita</span>
                <strong class="dashboard-stat__value" data-count-up="{{ $totalBerita }}">0</strong>
                <span class="dashboard-stat__hint">{{ $newsThisMonth }} ditambahkan bulan ini</span>
            </article>

            <article class="dashboard-stat anim-fade-up delay-2">
                <span class="dashboard-stat__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="8" r="3"></circle><path d="M3 20v-1a6 6 0 0 1 12 0v1zM16 5.2a3 3 0 0 1 0 5.6M18 14a5 5 0 0 1 3 4.6V20h-3"></path></svg>
                </span>
                <span class="dashboard-stat__label">Total Anggota</span>
                <strong class="dashboard-stat__value" data-count-up="{{ $totalAnggota }}">0</strong>
                <span class="dashboard-stat__hint">Data anggota terdaftar</span>
            </article>

            <article class="dashboard-stat anim-fade-up delay-3">
                <span class="dashboard-stat__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="16" rx="2"></rect><circle cx="8.5" cy="9" r="1.5"></circle><path d="m21 15-5-5L5 20"></path></svg>
                </span>
                <span class="dashboard-stat__label">Foto Galeri</span>
                <strong class="dashboard-stat__value" data-count-up="{{ $totalGaleri }}">0</strong>
                <span class="dashboard-stat__hint">Dokumentasi tersimpan</span>
            </article>

            <article class="dashboard-stat anim-fade-up delay-4">
                <span class="dashboard-stat__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19V5M4 19h17"></path><path d="m7 15 4-4 3 2 6-7"></path></svg>
                </span>
                <span class="dashboard-stat__label">Berita Bulan Ini</span>
                <strong class="dashboard-stat__value" data-count-up="{{ $newsThisMonth }}">0</strong>
                <span @class(['dashboard-stat__hint', 'dashboard-stat__hint--positive' => $newsMonthChange > 0, 'dashboard-stat__hint--negative' => $newsMonthChange < 0])>
                    @if ($newsMonthChange > 0)
                        Naik {{ $newsMonthChange }} dari bulan lalu
                    @elseif ($newsMonthChange < 0)
                        Turun {{ abs($newsMonthChange) }} dari bulan lalu
                    @else
                        Sama dengan bulan lalu
                    @endif
                </span>
            </article>
        </section>

        <section class="dashboard-panel dashboard-activity anim-fade-up" aria-labelledby="activity-chart-title">
            <div class="dashboard-section-heading">
                <div>
                    <h2 id="activity-chart-title">Aktivitas 6 Bulan Terakhir</h2>
                    <p>Jumlah berita dan anggota baru setiap bulan.</p>
                </div>
                <div class="dashboard-chart-legend" aria-label="Legenda grafik">
                    <span><i class="dashboard-chart-legend__news" aria-hidden="true"></i>Berita</span>
                    <span><i class="dashboard-chart-legend__members" aria-hidden="true"></i>Anggota</span>
                </div>
            </div>

            @if ($totalBerita === 0 && $totalAnggota === 0)
                <div class="dashboard-empty dashboard-empty--compact">
                    <p>Belum ada aktivitas untuk ditampilkan. Grafik akan terisi saat berita atau anggota baru ditambahkan.</p>
                </div>
            @else
                <div class="dashboard-chart" role="img" aria-label="Grafik aktivitas berita dan anggota baru selama enam bulan terakhir">
                    @foreach ($activityMonths as $month)
                        @php
                            $newsHeight = $month['berita'] > 0 ? max(6, ($month['berita'] / $activityScale) * 100) : 0;
                            $membersHeight = $month['anggota'] > 0 ? max(6, ($month['anggota'] / $activityScale) * 100) : 0;
                        @endphp
                        <div class="dashboard-chart__month">
                            <div class="dashboard-chart__bars" aria-hidden="true">
                                <span class="dashboard-chart__bar dashboard-chart__bar--news" style="--bar-height: {{ $newsHeight }}%"></span>
                                <span class="dashboard-chart__bar dashboard-chart__bar--members" style="--bar-height: {{ $membersHeight }}%"></span>
                            </div>
                            <span class="dashboard-chart__label">{{ $month['label'] }}</span>
                            <span class="visually-hidden">{{ $month['label'] }}: {{ $month['berita'] }} berita, {{ $month['anggota'] }} anggota</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <div class="dashboard-recent-grid">
            <section class="dashboard-panel dashboard-recent" aria-labelledby="recent-news-title">
                <div class="dashboard-section-heading">
                    <div>
                        <h2 id="recent-news-title">Berita Terbaru</h2>
                        <p>Konten berita yang terakhir diperbarui.</p>
                    </div>
                    <a class="dashboard-view-all" href="{{ route('admin.berita.index') }}">Lihat semua</a>
                </div>

                @if ($recentBerita->isNotEmpty())
                    <ul class="dashboard-list">
                        @foreach ($recentBerita as $berita)
                            <li class="dashboard-list__item">
                                <span class="dashboard-list__icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M5 4h12a2 2 0 0 1 2 2v14H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"></path><path d="M7 8h8M7 12h8M7 16h5"></path></svg>
                                </span>
                                <span class="dashboard-list__copy">
                                    <strong>{{ $berita->title }}</strong>
                                    <span>{{ $berita->created_at?->locale('id')->translatedFormat('d M Y') ?? 'Tanggal tidak tersedia' }}</span>
                                </span>
                                <span class="dashboard-list__badges">
                                    <span @class(['dashboard-status', 'dashboard-status--published' => $berita->status === 'published', 'dashboard-status--draft' => $berita->status !== 'published'])>
                                        {{ $berita->status === 'published' ? 'Terbit' : 'Draft' }}
                                    </span>
                                    @if ($berita->status === 'published' && $berita->created_at?->greaterThanOrEqualTo(now()->subDays(7)))
                                        <span class="dashboard-status dashboard-status--new">Baru</span>
                                    @endif
                                </span>
                                <a class="dashboard-list__action" href="{{ route('admin.berita.edit', $berita->id) }}" aria-label="Lihat berita {{ $berita->title }}">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"></path></svg>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="dashboard-empty">
                        <p>Belum ada berita. Tambahkan berita untuk mulai mengisi halaman ini.</p>
                        @if ($user->isAdmin())
                            <a class="text-link" href="{{ route('admin.berita.create') }}">Tambah berita</a>
                        @endif
                    </div>
                @endif
            </section>

            <section class="dashboard-panel dashboard-recent" aria-labelledby="recent-members-title">
                <div class="dashboard-section-heading">
                    <div>
                        <h2 id="recent-members-title">Anggota Terbaru</h2>
                        <p>Anggota yang terakhir ditambahkan.</p>
                    </div>
                    <a class="dashboard-view-all" href="{{ route('admin.anggota.index') }}">Lihat semua</a>
                </div>

                @if ($recentAnggota->isNotEmpty())
                    <ul class="dashboard-list">
                        @foreach ($recentAnggota as $member)
                            <li class="dashboard-list__item">
                                <span class="dashboard-list__icon dashboard-list__icon--member" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="8" r="3"></circle><path d="M3 20v-1a6 6 0 0 1 12 0v1zM16 5.2a3 3 0 0 1 0 5.6M18 14a5 5 0 0 1 3 4.6V20h-3"></path></svg>
                                </span>
                                <span class="dashboard-list__copy">
                                    <strong>{{ $member->name }}</strong>
                                    <span>{{ $member->position ?: 'Anggota' }} · {{ $member->created_at?->locale('id')->translatedFormat('d M Y') ?? 'Tanggal tidak tersedia' }}</span>
                                </span>
                                <span @class(['dashboard-status', 'dashboard-status--published' => in_array(strtolower($member->status ?? ''), ['aktif', 'active'], true), 'dashboard-status--draft' => ! in_array(strtolower($member->status ?? ''), ['aktif', 'active'], true)])>
                                    {{ $member->status ?: 'Belum diatur' }}
                                </span>
                                <a class="dashboard-list__action" href="{{ route('admin.anggota.edit', $member->id) }}" aria-label="Lihat anggota {{ $member->name }}">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"></path></svg>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="dashboard-empty">
                        <p>Belum ada anggota. Data anggota baru akan ditampilkan di sini.</p>
                        @if ($user->isAdmin())
                            <a class="text-link" href="{{ route('admin.anggota.create') }}">Tambah anggota</a>
                        @endif
                    </div>
                @endif
            </section>
        </div>

        <section class="dashboard-panel dashboard-gallery" aria-labelledby="recent-gallery-title">
            <div class="dashboard-section-heading">
                <div>
                    <h2 id="recent-gallery-title">Galeri Terbaru</h2>
                    <p>Dokumentasi yang baru ditambahkan.</p>
                </div>
                <a class="dashboard-view-all" href="{{ route('admin.galeri.index') }}">Lihat semua</a>
            </div>

            @if ($recentGaleri->isNotEmpty())
                <div class="dashboard-gallery__grid">
                    @foreach ($recentGaleri as $photo)
                        @php
                            $photoPath = $photo->photo;
                        @endphp
                        <a class="dashboard-gallery__item" href="{{ route('admin.galeri.index') }}" aria-label="{{ $photo->title ?: $photo->category ?: 'Lihat foto galeri' }}">
                            @if ($photoPath)
                                <img src="{{ asset('storage/'.$photoPath) }}" alt="{{ $photo->title ?: 'Dokumentasi kegiatan NU Sawangan' }}" width="400" height="300" loading="lazy" onerror="this.onerror=null;this.src='{{ config('images.fallback') }}'">
                            @else
                                <span class="dashboard-gallery__placeholder" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="4" width="18" height="16" rx="2"></rect><circle cx="8.5" cy="9" r="1.5"></circle><path d="m21 15-5-5L5 20"></path></svg>
                                </span>
                            @endif
                            <span class="dashboard-gallery__caption">{{ $photo->title ?: $photo->category ?: 'Dokumentasi' }}</span>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="dashboard-empty dashboard-empty--compact">
                    <p>Belum ada dokumentasi galeri. Unggah foto kegiatan untuk mulai membangun galeri.</p>
                    @if ($user->isAdmin())
                        <a class="text-link" href="{{ route('admin.galeri.create') }}">Unggah galeri</a>
                    @endif
                </div>
            @endif
        </section>
    </div>
@endsection
