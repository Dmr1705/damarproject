<footer class="mt-auto border-t border-slate-200 bg-slate-50 font-sans font-semibold text-slate-700">
    <div class="mx-auto grid max-w-6xl gap-9 px-4 py-10 sm:px-6 md:grid-cols-2 md:gap-12 md:py-12 lg:grid-cols-[1.4fr_0.7fr_1fr]">
        <div>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3" aria-label="NU Ciroyom, Beranda">
                <img src="{{ asset('storage/NU.webp') }}" alt="" class="h-10 w-10 rounded-full object-cover">
                <span>
                    <span class="block whitespace-nowrap text-base font-bold tracking-tight text-[#087A4B] sm:text-xl">NU CIROYOM</span>
                    <span class="block text-[10px] font-medium uppercase tracking-wider text-slate-500">Digitalisasi Data</span>
                </span>
            </a>
            <p class="mt-4 max-w-sm text-sm leading-relaxed text-slate-500">Pusat informasi dan digitalisasi data organisasi NU Ciroyom yang aman, terbuka, dan mudah diakses.</p>
        </div>
        <div>
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-900">Navigasi</h2>
            <nav aria-label="Navigasi footer" class="mt-4 grid grid-cols-2 gap-x-6 gap-y-3 text-sm font-semibold text-slate-600">
                <a href="{{ route('home') }}" class="transition-colors hover:text-[#087A4B]">Beranda</a>
                <a href="{{ route('anggota') }}" class="transition-colors hover:text-[#087A4B]">Anggota</a>
                <a href="{{ route('galeri') }}" class="transition-colors hover:text-[#087A4B]">Galeri</a>
                <a href="{{ route('berita.index') }}" class="transition-colors hover:text-[#087A4B]">Berita</a>
            </nav>
        </div>
        <div>
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-900">Informasi</h2>
            <div class="mt-4 space-y-2 text-sm text-slate-600">
                <p>Ciroyom</p>
                <p>Informasi publik NU Ciroyom</p>
            </div>
        </div>
    </div>
    <div class="border-t border-slate-200">
        <div class="mx-auto flex max-w-6xl flex-col gap-1 px-4 py-4 text-xs text-slate-500 sm:px-6 sm:flex-row sm:items-center sm:justify-between">
            <span>&copy; {{ date('Y') }} NU Ciroyom. Hak Cipta Dilindungi.</span>
            <span>NU Ciroyom</span>
        </div>
    </div>
</footer>
