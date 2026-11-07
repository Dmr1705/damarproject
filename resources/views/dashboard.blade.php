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



    </div>
@endsection 
