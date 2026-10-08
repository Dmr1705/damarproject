@extends('layouts.app')

@section('title', 'Berita Terkini · NU Sawangan')

@section('content')
    <section class="public-page-shell">
        <div class="public-page-header reveal md:flex md:items-end md:justify-between md:gap-8">
            <div>
                <span class="text-xs font-bold uppercase tracking-[0.16em] text-[#087A4B]">Warta & Informasi</span>
                <h1 class="mt-2">Berita Terkini</h1>
                <p class="mt-3 max-w-xl text-sm leading-relaxed text-gray-600">Ikuti kabar terbaru, kegiatan, dan informasi resmi NU Sawangan.</p>
            </div>
            <div class="mt-5 md:mt-0">
                @auth
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('berita.create') }}" class="bg-[#087A4B] hover:bg-[#065C39] text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md transition whitespace-nowrap">+ Tambah Berita</a>
                    @endif
                @endauth
            </div>
        </div>

        @if ($beritas->isNotEmpty())
            @php($featured = $beritas->first())
            <article class="reveal mt-8 grid overflow-hidden rounded-3xl border border-emerald-100 bg-white shadow-lg md:grid-cols-2">
                <div class="h-64 overflow-hidden bg-emerald-50 md:h-full">
                    @if ($featured->image)
                        <img src="{{ asset('storage/' . $featured->image) }}" alt="{{ $featured->title }}" class="h-full w-full object-cover transition duration-700 hover:scale-105">
                    @endif
                </div>
                <div class="flex flex-col justify-center p-7 md:p-10">
                    <span class="w-fit rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-[#087A4B]">Berita Pilihan</span>
                    <h2 class="mt-4 text-2xl font-black leading-tight text-gray-900">{{ $featured->title }}</h2>
                    <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-gray-500">{{ \Illuminate\Support\Str::limit(strip_tags($featured->content), 180) }}</p>
                    <a href="{{ route('berita.show', $featured->id) }}" class="mt-6 inline-flex w-fit items-center gap-2 text-sm font-bold text-[#087A4B] transition hover:gap-3">Baca Selengkapnya <span>&rarr;</span></a>
                </div>
            </article>
        @endif

        @php($additionalNewsCount = max(0, $beritas->count() - 1))
        <div @class([
            'public-news-grid mt-10 grid w-full gap-6',
            'mx-auto max-w-xl grid-cols-1' => $additionalNewsCount === 0,
            'mx-auto max-w-md grid-cols-1' => $additionalNewsCount === 1,
            'mx-auto max-w-4xl grid-cols-1 sm:grid-cols-2' => $additionalNewsCount === 2,
            'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3' => $additionalNewsCount >= 3,
        ])>
            @forelse ($beritas->skip(1) as $berita)
            <article class="public-news-card reveal flex flex-col group overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <div class="overflow-hidden relative h-56 bg-gradient-to-br from-emerald-50 to-gray-100">
                    @if($berita->image)
                    <img src="{{ asset('storage/'.$berita->image) }}" alt="{{ $berita->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400 font-medium text-sm">Tidak ada gambar</div>
                    @endif
                    <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-md text-[#087A4B] text-xs font-bold px-3 py-1 rounded-full shadow-xs">{{ $berita->created_at->format('d M Y') }}</span>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-[#087A4B] transition leading-snug">{{ $berita->title }}</h3>
                    <p class="text-gray-600 text-sm mb-6 line-clamp-3 leading-relaxed flex-grow">{{ \Illuminate\Support\Str::limit(strip_tags($berita->content), 100) }}</p>
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        <a href="{{ route('berita.show', $berita->id) }}" class="text-[#087A4B] hover:text-[#065C39] font-bold text-sm inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">Baca Selengkapnya <span>&rarr;</span></a>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-full text-center py-20 bg-white rounded-2xl border border-dashed border-gray-200">
                <p class="text-gray-400 font-medium">Belum ada berita yang diterbitkan saat ini.</p>
            </div>
            @endforelse
        </div>
    </section>
@endsection