<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $berita->title }} - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 shadow-sm fixed w-full z-50 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-8 h-8 bg-[#087A4B] rounded-full flex items-center justify-center text-white font-bold">NU</div>
                    <span class="font-bold text-xl text-[#087A4B]">Website Resmi</span>
                </a>
                <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-600 hover:text-[#087A4B]">Kembali ke Beranda</a>
            </div>
        </div>
    </nav>

    <!-- Content Berita -->
    <div class="pt-24 pb-12 flex-grow">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-6 sm:p-10 rounded-2xl shadow-sm border border-gray-100">
                <div class="mb-6 text-center">
                    <span class="text-sm text-[#087A4B] font-semibold">{{ $berita->created_at->format('l, d F Y') }}</span>
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mt-2">{{ $berita->title }}</h1>
                </div>

                @if($berita->image)
                    <div class="mb-8 rounded-xl overflow-hidden">
                        <img src="{{ asset('storage/'.$berita->image) }}" alt="{{ $berita->title }}" class="w-full h-auto object-cover max-h-[500px]">
                    </div>
                @endif

                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br(e($berita->content)) !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#17211B] text-white py-8 text-center text-sm">
        <p>&copy; {{ date('Y') }} Website Resmi. All rights reserved.</p>
    </footer>
</body>
</html>