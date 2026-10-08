@extends('layouts.admin')

@section('page-title', 'Pengaturan Akun')

@section('content')
    @php
        $dashboardUrl = $user->isAdmin() ? route('admin.dashboard') : route('dashboard');
        $profileTab = $errors->userDeletion->isNotEmpty()
            ? 'bahaya'
            : ($errors->updatePassword->isNotEmpty() || request()->query('tab') === 'keamanan' ? 'keamanan' : 'informasi');
    @endphp

    <div class="profile-page" data-account-settings data-active-tab="{{ $profileTab }}">
        <header class="profile-page__header">
            <div>
                <h2>Pengaturan Akun</h2>
                <p>Kelola informasi pribadi, keamanan, dan preferensi akun SAWANGAN NU Anda.</p>
            </div>
            <a class="btn btn--outline" href="{{ $dashboardUrl }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M19 12H5m7 7-7-7 7-7"></path></svg>
                Kembali ke Dashboard
            </a>
        </header>

        @if (session('status') === 'profile-updated' || session('status') === 'password-updated' || session('status') === 'verification-link-sent')
            <div class="profile-toast" role="status" aria-live="polite" data-profile-toast>
                <span class="profile-toast__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 12 4 4L19 6"></path></svg>
                </span>
                <span>
                    @if (session('status') === 'profile-updated')
                        Perubahan profil berhasil disimpan.
                    @elseif (session('status') === 'password-updated')
                        Kata sandi berhasil diperbarui.
                    @else
                        Tautan verifikasi baru telah dikirim.
                    @endif
                </span>
                <button class="profile-toast__close" type="button" aria-label="Tutup notifikasi" data-toast-dismiss>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"></path></svg>
                </button>
            </div>
        @elseif ($errors->any() || $errors->updatePassword->any() || $errors->userDeletion->any())
            <div class="profile-toast profile-toast--error" role="alert" aria-live="assertive" data-profile-toast>
                <span class="profile-toast__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v5m0 4h.01M10.3 3.9 2.5 18a2 2 0 0 0 1.7 3h15.6a2 2 0 0 0 1.7-3l-7.8-14.1a2 2 0 0 0-3.4 0Z"></path></svg>
                </span>
                <span>Periksa kembali data yang ditandai sebelum menyimpan.</span>
                <button class="profile-toast__close" type="button" aria-label="Tutup notifikasi" data-toast-dismiss>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"></path></svg>
                </button>
            </div>
        @endif

        <div class="profile-page__layout">
            <aside class="profile-summary" aria-label="Ringkasan akun">
                <div class="profile-summary__banner"></div>
                <div class="profile-summary__body">
                    <div class="profile-summary__avatar" data-profile-avatar>
                        @if ($user->profile_photo_path)
                            <img src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="Foto profil {{ $user->name }}" width="112" height="112" data-profile-avatar-image>
                        @else
                            <span aria-hidden="true" data-profile-avatar-initials>{{ Illuminate\Support\Str::upper(Illuminate\Support\Str::substr($user->name, 0, 2)) }}</span>
                            <img src="{{ config('images.fallback') }}" alt="" width="112" height="112" data-profile-avatar-image hidden>
                        @endif
                    </div>
                    <button class="profile-summary__camera" type="button" aria-label="Pilih foto profil" data-profile-photo-trigger>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 7h3l1.5-2h7L17 7h3a1 1 0 0 1 1 1v11a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1Z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                    </button>
                    <h3>{{ $user->name }}</h3>
                    <p class="profile-summary__email">{{ $user->email }}</p>
                    <span class="profile-summary__role">{{ $user->isAdmin() ? 'Administrator' : 'Anggota' }}</span>

                    <dl class="profile-summary__details">
                        <div>
                            <dt>Terdaftar sejak</dt>
                            <dd>{{ $user->created_at?->locale('id')->translatedFormat('d M Y') ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>
            </aside>

            <div class="profile-settings" data-profile-tabs>
                <div class="profile-tabs" role="tablist" aria-label="Pengaturan akun">
                    <button class="profile-tabs__tab" id="profile-tab-informasi" type="button" role="tab" aria-controls="informasi" aria-selected="true" tabindex="0" data-profile-tab="informasi">Informasi Profil</button>
                    <button class="profile-tabs__tab" id="profile-tab-keamanan" type="button" role="tab" aria-controls="keamanan" aria-selected="false" tabindex="-1" data-profile-tab="keamanan">Keamanan</button>
                    <button class="profile-tabs__tab" id="profile-tab-bahaya" type="button" role="tab" aria-controls="bahaya" aria-selected="false" tabindex="-1" data-profile-tab="bahaya"> Penghapusan Akun</button>
                </div>

                <section class="profile-panel" id="informasi" role="tabpanel" aria-labelledby="profile-tab-informasi" data-profile-panel="informasi">
                    @include('profile.partials.update-profile-information-form')
                </section>

                <section class="profile-panel" id="keamanan" role="tabpanel" aria-labelledby="profile-tab-keamanan" data-profile-panel="keamanan" hidden>
                    @include('profile.partials.update-password-form')
                </section>

                <section class="profile-panel profile-panel--danger" id="bahaya" role="tabpanel" aria-labelledby="profile-tab-bahaya" data-profile-panel="bahaya" hidden>
                    @include('profile.partials.delete-user-form')
                </section>
            </div>
        </div>
    </div>
@endsection
