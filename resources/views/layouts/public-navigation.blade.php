@php
    $isHome = request()->routeIs('home');
    $homeUrl = route('home');
    $homeSectionUrl = $isHome ? '#hero-section' : $homeUrl;
    $organizationUrl = $isHome ? '#produk-section' : $homeUrl . '#produk-section';
@endphp

<nav id="navbar-wrapper" class="sticky top-0 left-0 w-full z-50 py-4 px-4 sm:px-6 flex flex-col items-center">
    <div id="navbar-box" class="w-full max-w-6xl bg-white/90 backdrop-blur-lg rounded-full shadow-sm border border-emerald-500/20 px-6 md:px-10 py-4 transition-all duration-1000 ease-[cubic-bezier(0.22,1,0.36,1)] motion-reduce:transition-none flex justify-between items-center gap-4 relative z-20">
        <div class="flex min-w-0 items-center gap-2 sm:gap-3">
            <img src="{{ asset('storage/NU.webp') }}" alt="Logo NU" class="h-8 w-8 shrink-0 rounded-full object-cover shadow-sm shadow-green-900/20 sm:h-10 sm:w-10">
            <div class="min-w-0">
                <span class="block whitespace-nowrap text-base font-bold tracking-tight text-[#087A4B] sm:text-xl">NU CIROYOM</span>
                <span class="-mt-1 hidden whitespace-nowrap text-[10px] font-medium uppercase tracking-wider text-gray-600 sm:block">NU Digitalisasi</span>
            </div>
        </div>

        <div class="hidden lg:flex shrink-0 items-center gap-1 rounded-full border border-emerald-100 bg-emerald-50/60 p-1 text-sm font-semibold text-gray-500">
            <a href="{{ $homeSectionUrl }}" class="{{ $isHome ? 'bg-white text-[#087A4B] shadow-sm' : '' }} rounded-full px-3 py-2 transition hover:text-[#087A4B]">Beranda</a>
            <a href="{{ $organizationUrl }}" class="rounded-full px-3 py-2 transition hover:bg-white/70 hover:text-[#087A4B]">Organisasi</a>
            <a href="{{ route('anggota') }}" class="{{ request()->routeIs('anggota') ? 'bg-white text-[#087A4B] shadow-sm' : '' }} rounded-full px-3 py-2 transition hover:bg-white/70 hover:text-[#087A4B]">Anggota</a>
            <a href="{{ route('galeri') }}" class="{{ request()->routeIs('galeri') ? 'bg-white text-[#087A4B] shadow-sm' : '' }} rounded-full px-3 py-2 transition hover:bg-white/70 hover:text-[#087A4B]">Galeri</a>
            <a href="{{ route('berita.index') }}" class="{{ request()->routeIs('berita*') ? 'bg-white text-[#087A4B] shadow-sm' : '' }} rounded-full px-3 py-2 transition hover:bg-white/70 hover:text-[#087A4B]">Berita</a>
        </div>

        <div class="flex shrink-0 items-center gap-3">
            @if (Illuminate\Support\Facades\Route::has('login'))
                @auth
                <a href="{{ url('/dashboard') }}" aria-label="Akun {{ Auth::user()->name }}, {{ Auth::user()->role ?? 'Admin' }}" class="group flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#087A4B] px-1.5 py-1.5 text-white shadow-md transition hover:bg-[#065C39] sm:h-auto sm:w-44 sm:justify-start sm:gap-3 sm:px-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center overflow-hidden rounded-full border border-white/25 bg-white/15 text-xs font-bold text-white" aria-hidden="true">
                        @if (Auth::user()->profile_photo_path)
                            <img src="{{ asset('storage/'.Auth::user()->profile_photo_path) }}" alt="" class="h-full w-full object-cover">
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @endif
                    </span>
                    <span class="hidden min-w-0 flex-1 overflow-hidden text-right sm:block">
                        <span class="block truncate whitespace-nowrap text-xs font-bold sm:text-sm group-hover:animate-marquee">
                            {{ Auth::user()->name }}
                        </span>
                        <span class="block truncate text-[10px] font-medium capitalize tracking-wider text-emerald-200">
                            {{ Auth::user()->role ?? 'Admin' }}
                        </span>
                    </span>
                </a>
                @else
                <a href="{{ route('login') }}" class="text-xs sm:text-sm font-bold text-[#087A4B] bg-emerald-50 px-5 py-2.5 rounded-full hover:bg-emerald-100 transition border border-emerald-200/60">Masuk</a>
                @endauth
            @endif

            <button id="mobile-menu-button" class="lg:hidden p-2 rounded-full text-gray-600 hover:text-[#087A4B] hover:bg-emerald-50 transition focus:outline-none" aria-label="Menu" aria-expanded="false" aria-controls="mobile-menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="grid w-full max-w-6xl grid-rows-[0fr] -translate-y-2 opacity-0 pointer-events-none transition-[grid-template-rows,opacity,transform] duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] motion-reduce:transition-none lg:hidden" aria-hidden="true" inert>
        <div class="min-h-0 overflow-hidden">
            <div class="mt-2 flex flex-col gap-4 rounded-3xl border border-emerald-100 bg-white/95 p-5 text-sm font-semibold text-gray-600 shadow-xl backdrop-blur-md">
                <a href="{{ $homeSectionUrl }}" class="{{ $isHome ? 'text-[#087A4B] font-bold' : '' }} px-2 transition hover:text-[#087A4B]">Beranda</a>
                <a href="{{ $organizationUrl }}" class="px-2 transition hover:text-[#087A4B]">Organisasi</a>
                <a href="{{ route('anggota') }}" class="{{ request()->routeIs('anggota') ? 'text-[#087A4B] font-bold' : '' }} px-2 transition hover:text-[#087A4B]">Anggota</a>
                <a href="{{ route('galeri') }}" class="{{ request()->routeIs('galeri') ? 'text-[#087A4B] font-bold' : '' }} px-2 transition hover:text-[#087A4B]">Galeri</a>
                <a href="{{ route('berita.index') }}" class="{{ request()->routeIs('berita*') ? 'text-[#087A4B] font-bold' : '' }} px-2 transition hover:text-[#087A4B]">Berita</a>
            </div>
        </div>
    </div>
</nav>
