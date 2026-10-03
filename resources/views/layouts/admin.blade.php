<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'WebsiteNU') }} - Panel Admin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#F7FAF8] text-[#17211B]" x-data="{ sidebarOpen: window.innerWidth >= 1024 }" @resize.window="sidebarOpen = window.innerWidth >= 1024" :class="{ 'overflow-hidden': sidebarOpen && window.innerWidth < 1024 }">

    <div class="min-h-screen flex">

        <button type="button" x-show="sidebarOpen && window.innerWidth < 1024" x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-slate-950/40 backdrop-blur-[1px] lg:hidden" aria-label="Tutup menu admin"></button>

        <!-- Sidebar Kiri -->
        <aside :class="sidebarOpen ? 'w-64 translate-x-0' : 'w-0 -translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 bg-white border-r border-[#E1E9E4] transition-all duration-300 ease-in-out overflow-hidden flex flex-col shadow-sm">

            <!-- Logo Header Sidebar -->
            <div class="h-20 flex items-center gap-3 px-6 border-b border-[#E1E9E4] shrink-0">
                <div class="w-10 h-10 bg-[#087A4B] rounded-xl flex items-center justify-center text-white font-black text-base shadow-sm shadow-green-900/20">
                    NU
                </div>
                <div>
                    <span class="font-black text-base text-[#087A4B] tracking-tight block">Panel Admin</span>
                    <span class="text-[10px] text-gray-400 font-semibold tracking-wider uppercase block -mt-1">NU Sawangan</span>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto w-64">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-2xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-50 text-[#087A4B]' : 'text-[#66736B] hover:bg-gray-50 hover:text-[#17211B]' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                <!-- Menu Khusus Admin -->
                @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="pt-4 pb-2 text-[11px] font-black uppercase tracking-wider text-gray-400 px-4">Menu Admin</div>

                <a href="{{ route('admin.berita.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-2xl transition {{ request()->routeIs('admin.berita.*') ? 'bg-emerald-50 text-[#087A4B]' : 'text-[#66736B] hover:bg-gray-50 hover:text-[#17211B]' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    Data Berita
                </a>

                <a href="{{ route('admin.anggota.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-2xl transition {{ request()->routeIs('admin.anggota.*') ? 'bg-emerald-50 text-[#087A4B]' : 'text-[#66736B] hover:bg-gray-50 hover:text-[#17211B]' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Data Anggota
                </a>

                <a href="{{ route('admin.galeri.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('admin.galeri*') ? 'bg-emerald-50 text-[#087A4B]' : 'text-slate-600 hover:bg-slate-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Data Galeri
                </a>

                @endif
            </nav>

            <div class="p-4 border-t border-[#E1E9E4] shrink-0 w-64">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-2xl text-red-600 hover:bg-red-50 transition">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Area Konten Utama -->
        <div :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-0'" class="flex-1 flex flex-col transition-all duration-300 ease-in-out min-w-0">

            <header class="h-16 bg-white border-b border-[#E1E9E4] px-3 sm:px-6 flex items-center justify-between sticky top-0 z-30 shadow-sm">
                <div class="flex items-center gap-4">
                    <!-- Tombol Hamburger untuk Toggle Sidebar -->
                    <button type="button" @click="sidebarOpen = !sidebarOpen" :aria-expanded="sidebarOpen.toString()" aria-label="Toggle menu admin" class="p-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 focus:outline-none transition shadow-sm cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <span class="font-black text-[#087A4B] text-base tracking-tight">NU Sawangan</span>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Tombol Kembali ke Beranda -->
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-emerald-50 hover:bg-emerald-100 text-[#087A4B] font-bold text-xs rounded-xl transition border border-emerald-100 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="hidden sm:inline">Ke Beranda</span>
                    </a>

                    <div class="h-6 w-[1px] bg-gray-200 hidden sm:block"></div>

                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 overflow-hidden rounded-xl bg-emerald-50 text-[#087A4B] font-black text-xs flex items-center justify-center border border-emerald-100">
                            @if (auth()->user()?->profile_photo_path)
                                <img src="{{ asset('storage/'.auth()->user()->profile_photo_path) }}" alt="Foto profil {{ auth()->user()->name }}" class="h-full w-full object-cover">
                            @else
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            @endif
                        </div>
                        <span class="text-sm font-bold text-[#17211B] hidden sm:inline">{{ auth()->user()->name ?? 'User' }}</span>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6 lg:p-8">
                @yield('content')
            </main>

        </div>
    </div>

    @stack('scripts')
</body>

</html>