<footer class="mt-auto border-t border-emerald-950/10 bg-[#102019] text-white">
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-4">
        <div class="md:col-span-2">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#087A4B] text-sm font-bold">NU</div>
                <span class="text-lg font-bold">NU CIROYOM</span>
            </div>
            <p class="mt-4 max-w-md text-sm leading-relaxed text-emerald-100/65">Pusat informasi dan digitalisasi data organisasi NU Ciroyom yang aman, terbuka, dan mudah diakses.</p>
        </div>
        <div>
            <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-200">Navigasi</h2>
            <div class="mt-4 flex flex-col gap-3 text-sm text-emerald-100/70">
                <a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a>
                <a href="{{ route('anggota') }}" class="transition hover:text-white">Anggota</a>
                <a href="{{ route('galeri') }}" class="transition hover:text-white">Galeri</a>
                <a href="{{ route('berita.index') }}" class="transition hover:text-white">Berita</a>
            </div>
        </div>
        <div>
            <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-200">Hubungi Kami</h2>
            <div class="mt-4 flex flex-col gap-3 text-sm text-emerald-100/70">
                <span>Ciroyom, Kota Bandung</span>
                <span>Informasi publik NU Ciroyom</span>
            </div>
        </div>
    </div>
    <div class="border-t border-white/10">
        <div class="mx-auto max-w-6xl px-4 py-4 text-xs text-emerald-100/50 sm:px-6">&copy; {{ date('Y') }} NU Ciroyom. Hak Cipta Dilindungi.</div>
    </div>
</footer>
