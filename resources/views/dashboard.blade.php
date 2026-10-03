@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto space-y-8 pb-12">
        
        <!-- Header Banner -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-[#087A4B] text-xs font-bold mb-3 border border-emerald-100/60">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Status: {{ ucfirst($anggota?->status ?? 'Aktif') }} ({{ strtoupper($user->role ?? 'anggota') }})
                </div>
                <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">Dashboard Pengguna</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola informasi profil, keamanan akun, serta preferensi Anda di ekosistem DIGDAYA NU.</p>
            </div>
        </div>

        <!-- Main Grid Content -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left Column: User Profile Card -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden text-center relative">
                    <div class="h-32 bg-gradient-to-r from-[#087A4B] to-emerald-600 relative p-6">
                        <div class="absolute -bottom-10 left-1/2 -translate-x-1/2">
                            <div class="w-20 h-20 overflow-hidden rounded-2xl bg-white shadow-md border-4 border-white flex items-center justify-center text-[#087A4B] text-2xl font-black">
                                @if ($user->profile_photo_path)
                                    <img src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="Foto profil {{ $user->name }}" class="h-full w-full object-cover">
                                @else
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="pt-14 pb-8 px-6">
                        <h2 class="text-lg font-black text-slate-900">{{ $user->name }}</h2>
                        <p class="text-xs text-slate-400 font-medium mt-0.5 truncate">{{ $user->email }}</p>

                        <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-2 gap-4 text-left">
                            <div class="bg-slate-50/70 p-3.5 rounded-2xl border border-slate-100">
                                <span class="block text-[10px] uppercase font-black text-slate-400 mb-1">Terdaftar</span>
                                <span class="text-xs font-bold text-slate-700">{{ $user->created_at?->format('d M Y') }}</span>
                            </div>
                            <div class="bg-slate-50/70 p-3.5 rounded-2xl border border-slate-100">
                                <span class="block text-[10px] uppercase font-black text-slate-400 mb-1">Peran Akun</span>
                                <span class="text-xs font-black uppercase text-[#087A4B]">{{ $user->role ?? 'anggota' }}</span>
                            </div>
                        </div>

                        <div class="mt-6">
                            <a href="{{ $user->isAdmin() ? route('admin.dashboard') : route('home') }}" class="w-full py-3.5 bg-[#087A4B] hover:bg-emerald-700 text-white font-bold text-xs rounded-2xl shadow-md shadow-emerald-500/20 transition flex items-center justify-center gap-2">
                                {{ $user->isAdmin() ? 'Kelola Panel Admin' : 'Kembali ke Beranda' }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings Forms -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Update Profile Form Card -->
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                        <div>
                            <h3 class="text-base font-black text-slate-900">Informasi Profil</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Perbarui nama profil dan alamat email akun Anda.</p>
                        </div>
                        <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-[#087A4B] flex items-center justify-center font-bold shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-slate-50/60 border border-slate-200/80 focus:bg-white focus:border-[#087A4B] focus:ring-2 focus:ring-emerald-500/20 rounded-2xl px-4 py-3 text-sm font-bold text-slate-800 transition outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-slate-50/60 border border-slate-200/80 focus:bg-white focus:border-[#087A4B] focus:ring-2 focus:ring-emerald-500/20 rounded-2xl px-4 py-3 text-sm font-bold text-slate-800 transition outline-none">
                        </div>

                        <div>
                            <label for="profile_photo" class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Foto Profil (Opsional)</label>
                            <input type="file" id="profile_photo" name="profile_photo" accept="image/jpeg,image/png" class="w-full rounded-2xl border border-slate-200/80 bg-slate-50/60 text-sm text-slate-700 file:mr-4 file:border-0 file:bg-emerald-50 file:px-4 file:py-3 file:font-bold file:text-[#087A4B]">
                            <p class="mt-2 text-xs text-slate-400">Format JPG atau PNG, maksimal 2 MB.</p>
                            @error('profile_photo')
                                <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="px-6 py-3 bg-[#087A4B] hover:bg-emerald-700 text-white font-bold text-xs rounded-2xl shadow-md shadow-emerald-500/20 transition-all active:scale-95">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Update Password Form Card -->
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                        <div>
                            <h3 class="text-base font-black text-slate-900">Perbarui Kata Sandi</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.</p>
                        </div>
                        <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4-4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    </div>

                    <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" placeholder="••••••••" class="w-full bg-slate-50/60 border border-slate-200/80 focus:bg-white focus:border-[#087A4B] focus:ring-2 focus:ring-emerald-500/20 rounded-2xl px-4 py-3 text-sm font-bold text-slate-800 transition outline-none">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Kata Sandi Baru</label>
                                <input type="password" name="password" placeholder="••••••••" class="w-full bg-slate-50/60 border border-slate-200/80 focus:bg-white focus:border-[#087A4B] focus:ring-2 focus:ring-emerald-500/20 rounded-2xl px-4 py-3 text-sm font-bold text-slate-800 transition outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Konfirmasi Sandi</label>
                                <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full bg-slate-50/60 border border-slate-200/80 focus:bg-white focus:border-[#087A4B] focus:ring-2 focus:ring-emerald-500/20 rounded-2xl px-4 py-3 text-sm font-bold text-slate-800 transition outline-none">
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-2xl shadow-sm transition">
                                Perbarui Sandi
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
@endsection