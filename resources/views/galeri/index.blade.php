<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galeri Kegiatan - NU Sawangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="public-site flex min-h-screen flex-col overflow-x-hidden bg-slate-50 font-sans text-gray-900 antialiased">
    @include('layouts.public-navigation')

    <main class="public-page-shell flex-grow">
        <div class="public-page-header reveal md:flex md:items-end md:justify-between md:gap-8">
            <div>
                <span class="text-xs font-bold uppercase tracking-[0.16em] text-[#087A4B]">Dokumentasi</span>
                <h1 class="mt-2">Galeri Kegiatan</h1>
                <p class="mt-3 max-w-xl text-sm leading-relaxed text-slate-600">Momen penting dan dokumentasi visual kegiatan NU Sawangan.</p>
            </div>
            <div class="mt-5 md:mt-0">
                @auth
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.galeri.create') }}" class="bg-[#087A4B] hover:bg-[#065C39] text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md transition whitespace-nowrap">+ Tambah Galeri</a>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Filter Kategori -->
        <div class="reveal mt-8 flex items-center gap-2 overflow-x-auto rounded-2xl border border-gray-100 bg-white p-3 shadow-sm scrollbar-none">
            @php
                $categories = ['Muslimat', 'Fatayat', 'GP Ansor', 'IPNU', 'IPPNU', 'PMII'];
                $currentCategory = request('category');
            @endphp

            <a href="{{ route('galeri') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all shrink-0 {{ empty($currentCategory) ? 'bg-[#087A4B] text-white shadow-md shadow-emerald-500/20' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Semua
            </a>

            @foreach($categories as $cat)
                <a href="{{ route('galeri', ['category' => $cat]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all shrink-0 {{ $currentCategory == $cat ? 'bg-[#087A4B] text-white shadow-md shadow-emerald-500/20' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        <!-- Grid Galeri -->
        @php($galleryCount = $galeris->count())
        <div @class([
            'public-gallery-grid mt-8 grid w-full gap-5',
            'mx-auto max-w-xl grid-cols-1' => $galleryCount <= 1,
            'mx-auto max-w-4xl grid-cols-1 sm:grid-cols-2' => $galleryCount === 2,
            'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3' => $galleryCount === 3,
            'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4' => $galleryCount > 3,
        ])>
            @forelse ($galeris as $galeri)
            <button type="button" data-lightbox="{{ asset('storage/'.$galeri->photo) }}" data-title="{{ $galeri->title ?? 'Galeri' }}" aria-label="Perbesar {{ $galeri->title ?? 'foto galeri' }}" class="reveal group relative block aspect-square w-full overflow-hidden rounded-3xl border border-gray-100 bg-gray-50 text-left shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#087A4B]">
                <img src="{{ asset('storage/'.$galeri->photo) }}" alt="{{ $galeri->title ?? 'Galeri' }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                
                @if($galeri->category)
                    <div class="absolute top-3 left-3">
                        <span class="px-2.5 py-1 bg-white/90 backdrop-blur-md text-[#087A4B] font-extrabold text-[10px] rounded-xl shadow-sm border border-emerald-100">
                            {{ $galeri->category }}
                        </span>
                    </div>
                @endif

                <span class="pointer-events-none absolute inset-0 flex items-center justify-center bg-emerald-950/0 text-xs font-bold text-white opacity-0 transition duration-300 group-hover:bg-emerald-950/25 group-hover:opacity-100">Perbesar</span>

                @if($galeri->title)
                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-4 pt-8 text-white opacity-0 group-hover:opacity-100 transition duration-300">
                        <p class="text-xs font-bold truncate">{{ $galeri->title }}</p>
                    </div>
                @endif
            </button>
            @empty
            <div class="col-span-full text-center py-20 bg-white rounded-2xl border border-dashed border-gray-200">
                <div class="inline-flex flex-col items-center justify-center text-gray-400">
                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p class="text-gray-500 font-medium text-sm">Belum ada galeri kegiatan untuk kategori ini.</p>
                </div>
            </div>
            @endforelse
        </div>
    </main>

    @include('layouts.public-footer')

</body>

</html>