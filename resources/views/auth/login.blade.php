<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-semibold text-[#17211B]">Selamat Datang</h2>
        <p class="text-sm text-[#66736B]">Silakan masuk ke akun organisasi Anda</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-[#17211B]">Email</label>
            <input id="email" class="block mt-1 w-full border-[#E1E9E4] focus:border-[#087A4B] focus:ring-[#087A4B] rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4" x-data="{ show: false }">
            <label for="password" class="block font-medium text-sm text-[#17211B]">Password</label>
            <div class="relative">
                <input id="password" class="block mt-1 w-full border-[#E1E9E4] focus:border-[#087A4B] focus:ring-[#087A4B] rounded-md shadow-sm" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-[#66736B] hover:text-[#087A4B]">
                    <span x-text="show ? 'Sembunyikan' : 'Tampilkan'"></span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-[#E1E9E4] text-[#087A4B] shadow-sm focus:ring-[#087A4B]" name="remember">
                <span class="ms-2 text-sm text-[#66736B]">Ingat Saya</span>
            </label>

            <!-- Menggunakan \Illuminate\Support\Facades\Route untuk menghindari error Intelephense -->
            @if (\Illuminate\Support\Facades\Route::has('password.request'))
                <a class="text-sm text-[#087A4B] hover:text-[#065C39] hover:underline" href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
            @endif
        </div>

        <!-- Buttons -->
        <div class="flex flex-col mt-6 gap-4">
            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-[#087A4B] border border-transparent rounded-md font-semibold text-white hover:bg-[#065C39] focus:bg-[#065C39] active:bg-[#065C39] focus:outline-none focus:ring-2 focus:ring-[#087A4B] focus:ring-offset-2 transition ease-in-out duration-150">
                Masuk
            </button>
            
            <p class="text-sm text-center text-[#66736B]">
                Belum memiliki akun? 
                <a href="{{ route('register') }}" class="text-[#087A4B] hover:text-[#065C39] hover:underline font-medium">Daftar Sekarang</a>
            </p>
        </div>
    </form>
</x-guest-layout>