<x-guest-layout>
    <div class="auth-form">
        <span class="ui-badge">Akun warga</span>
        <h2>Daftar akun baru</h2>
        <p class="auth-form__intro">Bergabunglah dengan ruang layanan digital NU Sawangan.</p>

        <form method="POST" action="{{ route('register') }}" class="auth-form__fields">
            @csrf

            <div class="auth-field">
                <label class="ui-label" for="name">Nama lengkap</label>
                <input class="ui-control" id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama lengkap Anda" @error('name') aria-invalid="true" @enderror>
                @error('name')
                    <p class="ui-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-field">
                <label class="ui-label" for="email">Email</label>
                <input class="ui-control" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com" @error('email') aria-invalid="true" @enderror>
                @error('email')
                    <p class="ui-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-field">
                <label class="ui-label" for="roleSelect">Daftar sebagai</label>
                <select class="ui-control" name="role" id="roleSelect" data-role-select @error('role') aria-invalid="true" @enderror>
                    <option value="anggota" {{ old('role') === 'anggota' ? 'selected' : '' }}>Anggota</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <p class="ui-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-field" id="adminCodeWrapper" @if (old('role') !== 'admin') hidden @endif>
                <label class="ui-label" for="admin_secret_code">Password khusus admin</label>
                <input class="ui-control" id="admin_secret_code" type="password" name="admin_secret_code" autocomplete="off" placeholder="Masukkan kode rahasia admin" @error('admin_secret_code') aria-invalid="true" @enderror>
                @error('admin_secret_code')
                    <p class="ui-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-field">
                <label class="ui-label" for="passwordInput">Password</label>
                <div class="auth-password-field">
                    <input class="ui-control" type="password" name="password" id="passwordInput" required autocomplete="new-password" placeholder="Minimal 8 karakter" @error('password') aria-invalid="true" @enderror>
                    <button class="auth-password-toggle" type="button" data-password-toggle aria-controls="passwordInput" aria-pressed="false">Tampilkan</button>
                </div>
                @error('password')
                    <p class="ui-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-field">
                <label class="ui-label" for="password_confirmation">Konfirmasi password</label>
                <input class="ui-control" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" @error('password_confirmation') aria-invalid="true" @enderror>
                @error('password_confirmation')
                    <p class="ui-error">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn btn--primary btn--pill btn--lg auth-form__submit" type="submit">Daftar akun baru</button>
        </form>

        <p class="auth-form__footnote">Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
    </div>
</x-guest-layout>
