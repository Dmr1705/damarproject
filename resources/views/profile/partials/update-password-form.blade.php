<header class="profile-form-heading">
    <h2>Keamanan Akun</h2>
    <p>Gunakan kata sandi yang unik untuk menjaga keamanan akun Anda.</p>
</header>

<form method="post" action="{{ route('password.update') }}" class="profile-form" data-password-form>
    @csrf
    @method('put')

    <div class="profile-form__field">
        <label class="ui-label" for="update_password_current_password">Kata sandi saat ini</label>
        <div class="profile-password-field">
            <input class="ui-control" id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" required aria-invalid="{{ $errors->updatePassword->has('current_password') ? 'true' : 'false' }}" aria-describedby="{{ $errors->updatePassword->has('current_password') ? 'current-password-error' : '' }}">
            <button class="profile-password-toggle" type="button" aria-label="Tampilkan kata sandi saat ini" aria-pressed="false" data-password-toggle>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </button>
        </div>
        @error('current_password', 'updatePassword')
            <p class="ui-error" id="current-password-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="profile-form__field">
        <label class="ui-label" for="update_password_password">Kata sandi baru</label>
        <div class="profile-password-field">
            <input class="ui-control" id="update_password_password" name="password" type="password" autocomplete="new-password" required aria-invalid="{{ $errors->updatePassword->has('password') ? 'true' : 'false' }}" aria-describedby="password-strength-text{{ $errors->updatePassword->has('password') ? ' new-password-error' : '' }}" data-password-strength>
            <button class="profile-password-toggle" type="button" aria-label="Tampilkan kata sandi baru" aria-pressed="false" data-password-toggle>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </button>
        </div>
        <div class="profile-password-strength" role="progressbar" aria-label="Kekuatan kata sandi" aria-valuemin="0" aria-valuemax="4" aria-valuenow="0" data-password-strength-meter>
            <span></span><span></span><span></span><span></span>
        </div>
        <p class="profile-password-strength__text" id="password-strength-text" data-password-strength-text>Gunakan kombinasi huruf, angka, dan simbol.</p>
        @error('password', 'updatePassword')
            <p class="ui-error" id="new-password-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="profile-form__field">
        <label class="ui-label" for="update_password_password_confirmation">Konfirmasi kata sandi baru</label>
        <div class="profile-password-field">
            <input class="ui-control" id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required data-password-confirmation aria-describedby="password-match-message">
            <button class="profile-password-toggle" type="button" aria-label="Tampilkan konfirmasi kata sandi" aria-pressed="false" data-password-toggle>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </button>
        </div>
        <p class="profile-password-match" id="password-match-message" aria-live="polite" data-password-match></p>
    </div>

    <div class="profile-form__actions">
        <button class="btn btn--primary" type="submit" data-loading-button>
            <span class="profile-button__spinner" aria-hidden="true"></span>
            <span>Perbarui Kata Sandi</span>
        </button>
    </div>
</form>
