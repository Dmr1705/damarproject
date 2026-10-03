<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NU - Digitalisasi Data dan Layanan Nahdlatul Ulama</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-slate-50 flex flex-col min-h-screen selection:bg-emerald-500 selection:text-white relative overflow-x-hidden">

    <!-- Efek Hijau Samar -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-6xl h-48 bg-gradient-to-b from-emerald-500/20 via-emerald-500/5 to-transparent blur-3xl pointer-events-none z-40"></div>

    <!-- NAVBAR PILL (Diperlebar ke max-w-6xl) -->
    @include('layouts.public-navigation')

    <!-- HERO SECTION (Diperlebar ke max-w-6xl agar sama persis dengan navbar) -->
    <div id="hero-section" class="pt-3 sm:pt-7 px-4 sm:px-6 w-full mx-auto scroll-mt-28">
        <div class="w-full max-w-6xl mx-auto bg-[#087A4B] text-white pt-20 pb-28 md:pt-24 md:pb-32 px-6 sm:px-12 lg:px-16 text-center relative overflow-hidden rounded-[2.5rem] shadow-xl print-color-adjust" style="background-image: linear-gradient(135deg, rgba(3, 61, 40, 0.84), rgba(8, 122, 75, 0.58)), url('{{ asset('storage/masjid.webp') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>
            <div class="absolute left-6 top-6 z-10 flex h-12 w-12 items-center justify-center rounded-full bg-white text-lg font-black text-[#087A4B] shadow-lg sm:left-10 sm:top-8" aria-label="Logo NU">NU</div>

            <div class="max-w-4xl mx-auto relative z-10">
                <span class="inline-flex items-center gap-1.5 py-1.5 px-4 rounded-full text-xs font-semibold bg-white/10 text-green-100 mb-6 backdrop-blur-sm border border-white/10 reveal delay-100">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Platform Terpadu Warga & Organisasi NU
                </span>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-black tracking-tight mb-6 leading-tight reveal delay-200">
                    Transformasi Digital <br class="hidden sm:inline" />Ekosistem Nahdlatul Ulama
                </h1>
                <p class="text-base sm:text-lg text-green-100/90 max-w-2xl mx-auto font-normal leading-relaxed mb-10 reveal delay-300">
                    Pusat integrasi data, pelayanan jamaah, tata kelola administrasi kepengurusan, serta transparansi informasi publik yang aman dan akuntabel.
                </p>
                <div class="flex flex-wrap justify-center gap-4 reveal delay-400">
                    <a href="{{ route('berita.index') }}" class="bg-white text-[#087A4B] font-bold px-8 py-3.5 rounded-full shadow-lg hover:bg-green-50 transition transform hover:-translate-y-0.5 text-sm md:text-base">
                        Jelajahi Berita & Informasi
                    </a>
                </div>

            </div>
        </div>
    </div>

    <section class="mx-auto grid max-w-6xl grid-cols-2 gap-4 px-4 py-10 sm:px-6 md:grid-cols-4">
        @foreach ($stats as $stat)
            <div class="reveal rounded-2xl border border-emerald-100 bg-white p-5 text-center shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                <strong class="block text-2xl font-black text-[#087A4B]">{{ number_format($stat['value'], 0, ',', '.') }}</strong>
                <span class="mt-1 block text-xs font-semibold uppercase tracking-wider text-gray-500">{{ $stat['label'] }}</span>
            </div>
        @endforeach
    </section>

    <section class="mx-auto grid max-w-6xl gap-8 px-4 py-12 sm:px-6 md:grid-cols-2 md:items-center">
        <div class="reveal">
            <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#087A4B]">Tentang NU Ciroyom</span>
            <h2 class="mt-3 text-3xl font-black tracking-tight text-gray-900">Satu ruang untuk tumbuh bersama.</h2>
            <p class="mt-4 max-w-xl text-sm leading-relaxed text-gray-600">Website ini menjadi pusat informasi dan digitalisasi data organisasi NU Ciroyom, membantu warga menemukan berita, dokumentasi, dan informasi anggota dengan lebih mudah.</p>
            <a href="#produk-section" class="mt-6 inline-flex rounded-xl bg-[#087A4B] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-900/10 transition hover:-translate-y-0.5 hover:bg-[#065C39]">Kenali Organisasi Kami</a>
        </div>
        <div class="reveal rounded-[2rem] bg-gradient-to-br from-[#087A4B] to-[#064A32] p-8 text-white shadow-xl">
            <p class="text-sm leading-relaxed text-emerald-50/80">“Digitalisasi bukan hanya tentang teknologi, tetapi tentang membuat pelayanan dan informasi lebih dekat dengan masyarakat.”</p>
            <div class="mt-8 h-2 rounded-full bg-white/20"><div class="h-2 w-3/4 rounded-full bg-emerald-300"></div></div>
            <p class="mt-3 text-xs font-bold uppercase tracking-wider text-emerald-200">Kolaborasi • Transparansi • Pelayanan</p>
        </div>
    </section>

    <!-- Organisasi Section (Diperlebar ke max-w-6xl) -->
    <div id="produk-section" class="max-w-6xl mx-auto px-4 sm:px-6 pt-20 pb-20 scroll-mt-28 flex-grow">
        <div class="text-center mb-12 reveal">
            <span class="text-[#087A4B] font-bold text-xs uppercase tracking-widest block mb-2 bg-emerald-50 py-1 px-3 rounded-full w-fit mx-auto border border-emerald-100">Ekosistem Digital</span>
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">ORGANISASI NU</h2>
            <p class="text-gray-500 text-sm mt-2">Solusi terintegrasi untuk kemudahan administrasi dan layanan organisasi.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="reveal delay-100 bg-white p-8 rounded-3xl shadow-xl shadow-black/5 border border-gray-100 transition duration-300 hover:-translate-y-2 hover:shadow-2xl flex flex-col h-full group/card">
                <div>
                    <div class="w-14 h-14 shrink-0 bg-emerald-50 rounded-2xl flex items-center justify-center mb-5 border border-emerald-100/80 shadow-xs overflow-hidden">
                        <img src="{{ asset('storage/logo%20organisasi/MuslimatNU.png') }}" alt="Logo Muslimat NU" class="w-10 h-10 object-contain">
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Muslimat NU</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Badan otonom khusus perempuan di bawah naungan organisasi kemasyarakatan Islam terbesar di Indonesia, Nahdlatul Ulama (NU).</p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="reveal delay-200 bg-white p-8 rounded-3xl shadow-xl shadow-black/5 border border-gray-100 transition duration-300 hover:-translate-y-2 hover:shadow-2xl flex flex-col h-full group/card">
                <div>
                    <div class="h-14 shrink-0 w-max px-3 bg-emerald-50 rounded-2xl flex items-center justify-center mb-5 border border-emerald-100/80 shadow-xs gap-3 overflow-hidden">
                        <img src="{{ asset('storage/logo%20organisasi/FATAYAT-NU.png') }}" alt="Logo Fatayat NU" class="h-10 w-auto object-contain">
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Fatayat NU</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Badan otonom Nahdlatul Ulama untuk perempuan muda usia 20 hingga 40 tahun, bergerak di bidang keagamaan, sosial, dan pemberdayaan.</p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="reveal delay-300 bg-white p-8 rounded-3xl shadow-xl shadow-black/5 border border-gray-100 transition duration-300 hover:-translate-y-2 hover:shadow-2xl flex flex-col h-full group/card">
                <div>
                    <div class="w-14 h-14 shrink-0 bg-emerald-50 rounded-2xl flex items-center justify-center mb-5 border border-emerald-100/80 shadow-xs overflow-hidden">
                        <img src="{{ asset('storage/logo%20organisasi/GP-Ansor.png') }}" alt="Logo GP Ansor" class="w-10 h-10 object-contain">
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">GP Ansor</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Organisasi kepemudaan Islam di Indonesia yang berafiliasi dengan Nahdlatul Ulama (NU).</p>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="reveal delay-100 bg-white p-8 rounded-3xl shadow-xl shadow-black/5 border border-gray-100 transition duration-300 hover:-translate-y-2 hover:shadow-2xl flex flex-col h-full group/card">
                <div>
                    <div class="w-14 h-14 shrink-0 bg-emerald-50 rounded-2xl flex items-center justify-center mb-5 border border-emerald-100/80 shadow-xs overflow-hidden">
                        <img src="{{ asset('storage/logo%20organisasi/IPNU.png') }}" alt="Logo IPNU" class="w-10 h-10 object-contain">
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">IPNU</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Ikatan Pelajar Nahdlatul Ulama, yaitu wadah berhimpun, komunikasi, dan kaderisasi bagi pelajar serta santri putra.</p>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="reveal delay-200 bg-white p-8 rounded-3xl shadow-xl shadow-black/5 border border-gray-100 transition duration-300 hover:-translate-y-2 hover:shadow-2xl flex flex-col h-full group/card">
                <div>
                    <div class="w-14 h-14 shrink-0 bg-emerald-50 rounded-2xl flex items-center justify-center mb-5 border border-emerald-100/80 shadow-xs overflow-hidden">
                        <img src="{{ asset('storage/logo%20organisasi/IPPNU.png') }}" alt="Logo IPPNU" class="w-10 h-10 object-contain">
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">IPPNU</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Ikatan Pelajar Putri Nahdlatul Ulama, yaitu badan otonom yang mewadahi pelajar dan santri putri.</p>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="reveal delay-300 bg-white p-8 rounded-3xl shadow-xl shadow-black/5 border border-gray-100 transition duration-300 hover:-translate-y-2 hover:shadow-2xl flex flex-col h-full group/card">
                <div>
                    <div class="w-14 h-14 shrink-0 bg-emerald-50 rounded-2xl flex items-center justify-center mb-5 border border-emerald-100/80 shadow-xs overflow-hidden">
                        <img src="{{ asset('storage/logo%20organisasi/PMII.png') }}" alt="Logo PMII" class="w-10 h-10 object-contain">
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">PMII</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Pergerakan Mahasiswa Islam Indonesia, yaitu organisasi kemahasiswaan ekstrakampus yang berlandaskan Islam Ahlussunnah wal Jama'ah.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('layouts.public-footer')

</body>
</html>