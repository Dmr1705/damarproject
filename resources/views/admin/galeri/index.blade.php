@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto space-y-8 pb-12">
        
        <!-- Header Banner -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-[#087A4B] text-xs font-bold mb-3 border border-emerald-100/60">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Modul Galeri & Dokumentasi
                </div>
                <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">Data Galeri Foto</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola dokumentasi foto kegiatan organisasi berdasarkan kategori.</p>
            </div>
            <div>
                <a href="{{ route('admin.galeri.create') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-[#087A4B] hover:bg-emerald-700 text-white font-bold text-xs rounded-2xl shadow-md shadow-emerald-500/20 transition-all active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Foto
                </a>
            </div>
        </div>

        <!-- Alert Success -->
        @if (session('success'))
            <div class="flash-message anim-fade-down bg-emerald-50 border border-emerald-200/80 text-[#087A4B] px-6 py-4 rounded-3xl shadow-sm flex items-center gap-3" data-flash-message role="status">
                <div class="w-8 h-8 rounded-2xl bg-emerald-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-[#087A4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('admin.galeri.index') }}" method="GET" class="admin-gallery-search" role="search">
            <label class="sr-only" for="gallery-search">Cari judul atau kategori galeri</label>
            <input class="ui-control" id="gallery-search" type="search" name="q" value="{{ request('q', request('search')) }}" placeholder="Cari judul atau kategori…">
            <button class="btn btn--primary" type="submit">Cari galeri</button>
        </form>

        <!-- Grid Galeri -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($galeris as $galeri)
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col group">
                    <div class="relative aspect-video overflow-hidden bg-slate-100">
                        <img src="{{ asset('storage/' . $galeri->photo) }}" alt="{{ $galeri->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @if($galeri->category)
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 bg-white/90 backdrop-blur-md text-[#087A4B] font-extrabold text-[10px] rounded-xl shadow-sm border border-emerald-100">
                                    {{ $galeri->category }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between gap-4">
                        <div>
                            <p class="text-sm font-bold text-slate-800 line-clamp-2">{{ $galeri->title ?: 'Tanpa Keterangan' }}</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $galeri->created_at ? $galeri->created_at->format('d M Y') : '-' }}</p>
                        </div>
                        <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                            <a href="{{ route('admin.galeri.edit', $galeri->id) }}" class="px-3.5 py-2 bg-emerald-50 hover:bg-emerald-100 text-[#087A4B] font-bold text-xs rounded-xl transition">Edit</a>
                            <form action="{{ route('admin.galeri.destroy', $galeri->id) }}" method="POST" class="inline" data-confirm-delete data-confirm-message="Foto galeri ini akan dihapus secara permanen.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3.5 py-2 bg-red-50 hover:bg-red-100 text-red-600 font-bold text-xs rounded-xl transition">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-slate-100 shadow-sm">
                    <div class="inline-flex flex-col items-center justify-center text-slate-400">
                        <div class="w-16 h-16 bg-slate-50 rounded-3xl flex items-center justify-center mb-4 border border-slate-100">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-700 mb-1">Belum ada foto galeri.</p>
                        <p class="text-xs text-slate-400 max-w-xs mb-5">Dokumentasi foto yang Anda tambahkan akan muncul di sini.</p>
                        <a href="{{ route('admin.galeri.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-[#087A4B] font-bold text-xs rounded-xl transition">
                            + Tambah Foto Pertama
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(isset($galeris) && method_exists($galeris, 'hasPages') && $galeris->hasPages())
            <div class="bg-white px-6 py-4 rounded-3xl border border-slate-100 shadow-sm">
                {{ $galeris->links() }}
            </div>
        @endif

    </div>
@endsection