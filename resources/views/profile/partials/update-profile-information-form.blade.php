<header class="profile-form-heading">
    <h2>Informasi Profil</h2>
    <p>Perbarui nama, alamat email, dan foto yang digunakan di akun Anda.</p>
</header>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form id="profile-update-form" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="profile-form" data-profile-update-form>
    @csrf
    @method('patch')

    <div class="profile-form__field">
        <label class="ui-label" for="name">Nama lengkap</label>
        <div class="profile-input">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="4"></circle><path d="M4 21v-1a8 8 0 0 1 16 0v1"></path></svg>
            <input class="ui-control" id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name" aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}" aria-describedby="{{ $errors->has('name') ? 'name-error' : '' }}">
        </div>
        @error('name')
            <p class="ui-error" id="name-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="profile-form__field">
        <label class="ui-label" for="email">Alamat email</label>
        <div class="profile-input">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m4 7 8 6 8-6"></path></svg>
            <input class="ui-control" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}">
        </div>
        @error('email')
            <p class="ui-error" id="email-error">{{ $message }}</p>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="profile-verification">
                <p>Email Anda belum terverifikasi. <button form="send-verification" class="profile-verification__link">Kirim ulang tautan verifikasi</button></p>
            </div>
        @endif
    </div>

    <div class="profile-form__field">
        <label class="ui-label" for="profile_photo">Foto profil <span>(opsional)</span></label>
        <input
            class="profile-photo-input"
            id="profile_photo"
            name="profile_photo"
            type="file"
            form="profile-update-form"
            accept="image/jpeg,image/png"
            aria-invalid="{{ $errors->has('profile_photo') ? 'true' : 'false' }}"
            aria-describedby="{{ $errors->has('profile_photo') ? 'profile-photo-error' : 'profile-photo-hint' }}"
            data-profile-photo-input
        >
        <label class="profile-photo-dropzone" for="profile_photo" data-profile-photo-dropzone>
            <span class="profile-photo-dropzone__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 16V4m0 0L7 9m5-5 5 5"></path><path d="M4 16v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3"></path></svg>
            </span>
            <span class="profile-photo-dropzone__copy">
                <strong>Pilih foto atau tarik ke sini</strong>
                <span>JPG atau PNG, ukuran maksimal 2 MB.</span>
            </span>
            <span class="profile-photo-dropzone__button">Pilih foto</span>
        </label>
        <p class="ui-error" id="profile-photo-client-error" data-photo-client-error role="alert" hidden></p>
        @error('profile_photo')
            <p class="ui-error" id="profile-photo-error">{{ $message }}</p>
        @enderror
        <p class="profile-form__hint" id="profile-photo-hint">Foto tersimpan dapat diganti dengan memilih berkas baru.</p>
        <div class="profile-photo-preview" data-profile-photo-preview hidden>
            <img src="" alt="Pratinjau foto profil baru" width="56" height="56" data-profile-photo-preview-image>
            <span class="profile-photo-preview__copy">
                <strong data-profile-photo-filename></strong>
                <span>Pratinjau foto baru</span>
            </span>
            <button class="btn btn--outline btn--sm" type="button" data-clear-profile-photo>Hapus foto terpilih</button>
        </div>
    </div>

    <div class="profile-form__actions">
        <button class="btn btn--primary" type="submit" data-loading-button>
            <span class="profile-button__spinner" aria-hidden="true"></span>
            <span>Simpan Perubahan</span>
        </button>
    </div>
</form>
