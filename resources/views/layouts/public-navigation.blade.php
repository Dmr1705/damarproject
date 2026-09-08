@php
    $isHome = request()->routeIs('home');
    $homeUrl = route('home');
    $homeSectionUrl = $isHome ? '#hero-section' : $homeUrl;
    $organizationUrl = $isHome ? '#produk-section' : $homeUrl . '#produk-section';
@endphp

<nav id="navbar-wrapper" class="fixed top-0 left-0 w-full z-50 transition-all duration-500 ease-in-out py-4 px-4 sm:px-6 flex flex-col items-center">
    <div id="navbar-box" class="w-full max-w-6xl bg-white/80 backdrop-blur-lg rounded-full shadow-sm border border-emerald-500/20 px-6 md:px-10 py-3 transition-all duration-500 ease-in-out flex justify-between items-center relative z-20">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 sm:w-10 sm:h-10 bg-[#087A4B] rounded-full flex items-center justify-center text-white font-black text-base sm:text-lg shadow-sm shadow-green-900/20">NU</div>
            <div>
                <span class="font-bold text-lg sm:text-xl text-[#087A4B] tracking-tight block">NU CIROYOM</span>
                <span class="text-[10px] text-gray-600 font-medium tracking-wider uppercase block -mt-1">Digitalisasi Data</span>
            </div>
        </div>

        <div class="hidden md:flex items-center gap-6 lg:gap-10 text-sm font-semibold text-gray-400">
            <a href="{{ $homeSectionUrl }}" class="{{ $isHome ? 'nav-menu-link' : '' }} transition hover:text-[#087A4B]">Beranda</a>
            <a href="{{ $organizationUrl }}" class="{{ $isHome ? 'nav-menu-link' : '' }} transition hover:text-[#087A4B]">Organisasi</a>
            <a href="{{ route('anggota') }}" class="{{ request()->routeIs('anggota') ? 'text-[#087A4B] font-bold' : '' }} transition hover:text-[#087A4B]">Anggota</a>
            <a href="{{ route('galeri') }}" class="{{ request()->routeIs('galeri') ? 'text-[#087A4B] font-bold' : '' }} transition hover:text-[#087A4B]">Galeri</a>
            <a href="{{ route('berita.index') }}" class="{{ request()->routeIs('berita*') ? 'text-[#087A4B] font-bold' : '' }} transition hover:text-[#087A4B]">Berita</a>
        </div>

        <div class="flex items-center gap-4">
            @if (Illuminate\Support\Facades\Route::has('login'))
                @auth
                <a href="{{ url('/dashboard') }}" class="w-32 sm:w-44 bg-[#087A4B] hover:bg-[#065C39] text-white px-4 py-1.5 rounded-full shadow-md transition flex flex-col justify-center overflow-hidden relative group text-right">
                    <div class="w-full overflow-hidden relative whitespace-nowrap">
                        <span class="font-bold text-xs sm:text-sm block truncate group-hover:overflow-visible group-hover:animate-marquee">
                            {{ Auth::user()->name }}
                        </span>
                    </div>
                    <span class="text-[10px] text-emerald-200 capitalize tracking-wider font-medium block truncate">
                        {{ Auth::user()->role ?? 'Admin' }}
                    </span>
                </a>
                @else
                <a href="{{ route('login') }}" class="text-xs sm:text-sm font-bold text-[#087A4B] bg-emerald-50 px-5 py-2.5 rounded-full hover:bg-emerald-100 transition border border-emerald-200/60">Masuk</a>
                @endauth
            @endif

            <button id="mobile-menu-button" class="md:hidden p-2 rounded-full text-gray-600 hover:text-[#087A4B] hover:bg-emerald-50 transition focus:outline-none" aria-label="Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden w-full max-w-6xl mt-2 bg-white/95 backdrop-blur-md rounded-3xl shadow-xl border border-emerald-100 p-5 flex flex-col gap-4 text-sm font-semibold text-gray-600 transition-all z-10">
        <a href="{{ $homeSectionUrl }}" class="{{ $isHome ? 'nav-menu-link' : '' }} px-2 transition hover:text-[#087A4B]">Beranda</a>
        <a href="{{ $organizationUrl }}" class="{{ $isHome ? 'nav-menu-link' : '' }} px-2 transition hover:text-[#087A4B]">Organisasi</a>
        <a href="{{ route('anggota') }}" class="{{ request()->routeIs('anggota') ? 'text-[#087A4B] font-bold' : '' }} px-2 transition hover:text-[#087A4B]">Anggota</a>
        <a href="{{ route('galeri') }}" class="{{ request()->routeIs('galeri') ? 'text-[#087A4B] font-bold' : '' }} px-2 transition hover:text-[#087A4B]">Galeri</a>
        <a href="{{ route('berita.index') }}" class="{{ request()->routeIs('berita*') ? 'text-[#087A4B] font-bold' : '' }} px-2 transition hover:text-[#087A4B]">Berita</a>
    </div>
</nav>
