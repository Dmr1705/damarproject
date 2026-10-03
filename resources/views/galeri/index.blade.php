<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galeri Kegiatan - NU Sawangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-white flex flex-col min-h-screen relative overflow-x-hidden">

    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-48 bg-gradient-to-b from-emerald-500/20 via-emerald-500/5 to-transparent blur-3xl pointer-events-none z-40"></div>

    @include('layouts.public-navigation')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16 flex-grow w-full">
        <div class="reveal relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-white via-emerald-50/70 to-green-100/50 px-6 py-8 md:flex md:items-end md:justify-between md:px-10 md:py-10">
            <div>
                <span class="text-[#087A4B] font-bold text-xs uppercase tracking-[0.2em]">Dokumentasi</span>
                <h1 class="mt-2 text-3xl md:text-4xl font-black text-gray-900 tracking-tight">Galeri Kegiatan</h1>
                <p class="mt-3 max-w-xl text-sm leading-relaxed text-gray-500">Momen penting dan dokumentasi visual kegiatan NU Sawangan.</p>
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
        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @forelse ($galeris as $galeri)
            <button type="button" data-lightbox="{{ asset('storage/'.$galeri->photo) }}" data-title="{{ $galeri->title ?? 'Galeri' }}" class="reveal block w-full rounded-3xl overflow-hidden shadow-sm border border-gray-100 aspect-square bg-gray-50 relative text-left group hover:-translate-y-1 hover:shadow-xl transition duration-300">
                <img src="{{ asset('storage/'.$galeri->photo) }}" alt="{{ $galeri->title ?? 'Galeri' }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                
                @if($galeri->category)
                    <div class="absolute top-3 left-3">
                        <span class="px-2.5 py-1 bg-white/90 backdrop-blur-md text-[#087A4B] font-extrabold text-[10px] rounded-xl shadow-sm border border-emerald-100">
                            {{ $galeri->category }}
                        </span>
                        <span class="absolute inset-0 flex items-center justify-center bg-emerald-950/0 text-white opacity-0 transition group-hover:bg-emerald-950/25 group-hover:opacity-100">Perbesar</span>
                    </button>
                @endif

                @if($galeri->title)
                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-4 pt-8 text-white opacity-0 group-hover:opacity-100 transition duration-300">
                        <p class="text-xs font-bold truncate">{{ $galeri->title }}</p>
                    </div>
                @endif
            </div>
            @empty
            <div class="col-span-full text-center py-20 bg-white rounded-2xl border border-dashed border-gray-200">
                <div class="inline-flex flex-col items-center justify-center text-gray-400">
                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p class="text-gray-500 font-medium text-sm">Belum ada galeri kegiatan untuk kategori ini.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    @include('layouts.public-footer')

</body>

</html>