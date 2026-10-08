@extends('layouts.app')

@section('title', 'Anggota NU Sawangan')

@section('content')
    <section class="public-page-shell">
        <div class="public-page-header reveal">
            <div>
                <span class="text-xs font-bold uppercase tracking-[0.16em] text-[#087A4B]">Modul Keanggotaan</span>
                <h1 class="mt-2">Anggota NU Sawangan</h1>
                <p class="mt-3 max-w-xl text-sm leading-relaxed text-slate-600">Kenali anggota aktif dari berbagai badan otonom NU Sawangan dalam satu direktori.</p>
            </div>
        </div>

        <div class="mt-8 flex flex-col gap-4 rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-wider text-gray-400">Filter Banom</p>
                    <p class="mt-1 text-sm text-gray-500">Pilih kategori untuk melihat anggota terkait.</p>
                </div>
                <form action="{{ route('anggota') }}" method="GET" class="flex w-full gap-2 md:w-auto">
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari anggota..." class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:border-[#087A4B] focus:ring-2 focus:ring-emerald-500/20 md:w-56">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <button type="submit" class="rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#087A4B]">Cari</button>
                </form>
            </div>
            <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-none">
                <a href="{{ route('anggota') }}" class="shrink-0 rounded-xl px-4 py-2 text-xs font-bold transition {{ request('category') ? 'bg-gray-100 text-gray-600 hover:bg-gray-200' : 'bg-[#087A4B] text-white shadow-md shadow-emerald-500/20' }}">Semua</a>
                @foreach ($categories as $category)
                    <a href="{{ route('anggota', ['category' => $category, 'search' => request('search')]) }}" class="shrink-0 rounded-xl px-4 py-2 text-xs font-bold transition {{ request('category') === $category ? 'bg-[#087A4B] text-white shadow-md shadow-emerald-500/20' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">{{ $category }}</a>
                @endforeach
            </div>
        </div>

        <div class="bento-card-grid mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($anggotas as $anggota)
                <article class="reveal group overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-xl">
                    <div class="h-1 bg-gradient-to-r from-emerald-400 to-[#087A4B]"></div>
                    <div class="flex items-center gap-4 p-5">
                        @if ($anggota->photo)
                            <img src="{{ asset('storage/' . $anggota->photo) }}" alt="{{ $anggota->name }}" class="h-16 w-16 rounded-2xl object-cover">
                        @else
                            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-lg font-black text-[#087A4B] ring-4 ring-emerald-50 transition group-hover:bg-[#087A4B] group-hover:text-white">
                                {{ strtoupper(substr($anggota->name, 0, 2)) }}
                            </div>
                        @endif
                        <div class="min-w-0">
                            <h2 class="truncate text-base font-bold text-gray-900">{{ $anggota->name }}</h2>
                            <p class="mt-1 text-xs font-bold text-[#087A4B]">{{ $anggota->position }}</p>
                            <p class="mt-1 truncate text-xs text-gray-500">{{ $anggota->region ?: 'Wilayah Pusat / Umum' }}</p>
                        </div>
                    </div>
                </article>
            @empty
                <div class="reveal col-span-full rounded-2xl border border-dashed border-gray-200 bg-white py-16 text-center">
                    <p class="font-medium text-gray-400">Belum ada anggota publik yang tersedia.</p>
                </div>
            @endforelse
        </div>

        @if ($anggotas->hasPages())
            <div class="mt-8">{{ $anggotas->links() }}</div>
        @endif
    </section>
@endsection