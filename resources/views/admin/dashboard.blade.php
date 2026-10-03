<x-admin-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-[#17211B]">Dashboard Utama</h2>
        <p class="text-sm text-[#66736B] mt-1">Ringkasan statistik data organisasi dan pengguna.</p>
    </div>

    <!-- Cards Grid (Ditambah menjadi 6 cards sesuai Aturan #45) -->
    <div class="bento-card-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Total Anggota -->
        <div class="bg-white p-6 rounded-xl border border-[#E1E9E4] shadow-sm flex items-center">
            <div class="p-3 bg-[#E9F7EF] rounded-lg text-[#087A4B]">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-[#66736B]">Total Anggota</p>
                <p class="text-2xl font-semibold text-[#17211B]">{{ $totalAnggota }}</p>
            </div>
        </div>

        <!-- Anggota Aktif -->
        <div class="bg-white p-6 rounded-xl border border-[#E1E9E4] shadow-sm flex items-center">
            <div class="p-3 bg-[#E9F7EF] rounded-lg text-[#087A4B]">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-[#66736B]">Anggota Aktif</p>
                <p class="text-2xl font-semibold text-[#17211B]">{{ $anggotaAktif }}</p>
            </div>
        </div>

        <!-- Jumlah Akun Anggota -->
        <div class="bg-white p-6 rounded-xl border border-[#E1E9E4] shadow-sm flex items-center">
            <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-[#66736B]">Akun Terdaftar</p>
                <p class="text-2xl font-semibold text-[#17211B]">{{ $jumlahAkunAnggota }}</p>
            </div>
        </div>

        <!-- Total Berita -->
        <div class="bg-white p-6 rounded-xl border border-[#E1E9E4] shadow-sm flex items-center">
            <div class="p-3 bg-[#E9F7EF] rounded-lg text-[#087A4B]">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-[#66736B]">Total Berita</p>
                <p class="text-2xl font-semibold text-[#17211B]">{{ $totalBerita }}</p>
            </div>
        </div>

        <!-- Draft Berita -->
        <div class="bg-white p-6 rounded-xl border border-[#E1E9E4] shadow-sm flex items-center">
            <div class="p-3 bg-yellow-50 rounded-lg text-yellow-600">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-[#66736B]">Draft Berita</p>
                <p class="text-2xl font-semibold text-[#17211B]">{{ $draftBerita }}</p>
            </div>
        </div>

        <!-- Jumlah Admin -->
        <div class="bg-white p-6 rounded-xl border border-[#E1E9E4] shadow-sm flex items-center">
            <div class="p-3 bg-purple-50 rounded-lg text-purple-600">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-[#66736B]">Admin Sistem</p>
                <p class="text-2xl font-semibold text-[#17211B]">{{ $jumlahAdmin }}</p>
            </div>
        </div>
    </div>
</x-admin-layout>