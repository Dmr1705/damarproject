<header class="profile-form-heading">
    <h2>Akun</h2>
    <p>Penghapusan akun bersifat permanen. Pastikan informasi yang diperlukan telah disimpan.</p>
</header>

<div class="profile-danger-copy">
    <span class="profile-danger-copy__icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 9v4m0 4h.01M10.3 3.9 2.5 18a2 2 0 0 0 1.7 3h15.6a2 2 0 0 0 1.7-3l-7.8-14.1a2 2 0 0 0-3.4 0Z"></path></svg>
    </span>
    <p>Data akun dan foto profil yang tersimpan akan dihapus secara permanen.</p>
</div>

<button class="btn btn--danger" type="button" data-open-delete-dialog>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 6h18M8 6V4h8v2m3 0-1 14H6L5 6m4 4v6m6-6v6"></path></svg>
    Hapus Akun
</button>

<dialog class="profile-delete-dialog" aria-labelledby="profile-delete-dialog-title" aria-describedby="profile-delete-dialog-description" data-profile-delete-dialog data-open-on-load="{{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }}">
    <form method="post" action="{{ route('profile.destroy') }}" class="profile-delete-dialog__form">
        @csrf
        @method('delete')

        <span class="profile-delete-dialog__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 9v4m0 4h.01M10.3 3.9 2.5 18a2 2 0 0 0 1.7 3h15.6a2 2 0 0 0 1.7-3l-7.8-14.1a2 2 0 0 0-3.4 0Z"></path></svg>
        </span>
        <h2 id="profile-delete-dialog-title">Hapus akun secara permanen?</h2>
        <p id="profile-delete-dialog-description">Masukkan kata sandi saat ini untuk mengonfirmasi. Tindakan ini tidak dapat dibatalkan.</p>

        <div class="profile-form__field">
            <label class="ui-label" for="delete_account_password">Kata sandi saat ini</label>
            <input class="ui-control" id="delete_account_password" name="password" type="password" autocomplete="current-password" required aria-invalid="{{ $errors->userDeletion->has('password') ? 'true' : 'false' }}" aria-describedby="{{ $errors->userDeletion->has('password') ? 'delete-account-password-error' : '' }}">
            @error('password', 'userDeletion')
                <p class="ui-error" id="delete-account-password-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-delete-dialog__actions">
            <button class="btn btn--outline" type="button" data-close-delete-dialog>Batal</button>
            <button class="btn btn--danger" type="submit">Konfirmasi Hapus Akun</button>
        </div>
    </form>
</dialog>
