<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#17211B] leading-tight">
            {{ __('Dashboard Anggota') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-[#E1E9E4]">
                <div class="p-6 text-[#17211B]">
                    Selamat datang di Panel Anggota! Akses Anda adalah pengguna biasa.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>