@php
    $profileMenuUser = auth()->user();
    $profileMenuPhoto = $profileMenuUser?->profile_photo_path;
    $profileMenuName = $profileMenuUser?->name ?? 'Pengguna';
    $profileMenuInitials = Illuminate\Support\Str::upper(Illuminate\Support\Str::substr($profileMenuName, 0, 2));
@endphp

<div class="admin-profile" data-admin-profile>
    <button
        class="admin-profile__trigger"
        type="button"
        aria-label="Menu akun {{ $profileMenuName }}"
        aria-haspopup="menu"
        aria-expanded="false"
        aria-controls="admin-profile-menu"
        data-profile-trigger
    >
        <span class="admin-profile__avatar" aria-hidden="true">
            @if ($profileMenuPhoto)
                <img src="{{ asset('storage/'.$profileMenuPhoto) }}" alt="">
            @else
                {{ $profileMenuInitials }}
            @endif
        </span>
        <span class="admin-profile__trigger-name">{{ $profileMenuName }}</span>
        <svg class="admin-profile__chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path d="m6 9 6 6 6-6"></path>
        </svg>
    </button>

    <div class="admin-profile__menu" id="admin-profile-menu" role="menu" aria-label="Menu akun" aria-hidden="true">
        <div class="admin-profile__head">
            <span class="admin-profile__head-avatar" aria-hidden="true">
                @if ($profileMenuPhoto)
                    <img src="{{ asset('storage/'.$profileMenuPhoto) }}" alt="">
                @else
                    {{ $profileMenuInitials }}
                @endif
            </span>
            <span class="admin-profile__identity">
                <span class="admin-profile__name">{{ $profileMenuName }}</span>
                <span class="admin-profile__email" title="{{ $profileMenuUser?->email }}">{{ $profileMenuUser?->email }}</span>
                <span class="admin-profile__role">{{ $profileMenuUser?->role === 'admin' ? 'Administrator' : 'Anggota' }}</span>
            </span>
        </div>

        <hr class="admin-profile__divider">

        <nav class="admin-profile__links" aria-label="Menu akun">
            <a class="admin-profile__item" href="{{ route('profile.edit') }}" role="menuitem" tabindex="0" data-menu-order="1">
                <span class="admin-profile__item-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"></circle><path d="M4 21v-1a8 8 0 0 1 16 0v1"></path></svg>
                </span>
                <span>Profil Saya</span>
            </a>
            <a class="admin-profile__item" href="{{ route('profile.edit') }}#keamanan" role="menuitem" tabindex="0" data-menu-order="2">
                <span class="admin-profile__item-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="10" width="16" height="11" rx="2"></rect><path d="M8 10V7a4 4 0 1 1 8 0v3M12 14v3"></path></svg>
                </span>
                <span>Pengaturan Akun</span>
            </a>
            <a class="admin-profile__item" href="{{ route('home') }}" target="_blank" rel="noopener" role="menuitem" tabindex="0" data-menu-order="3">
                <span class="admin-profile__item-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"></circle><path d="M3 12h18M12 3a15 15 0 0 1 0 18M12 3a15 15 0 0 0 0 18"></path></svg>
                </span>
                <span>Lihat Website</span>
                <svg class="admin-profile__external-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M14 4h6v6M20 4l-9 9"></path><path d="M18 13v6a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h6"></path></svg>
            </a>

            <hr class="admin-profile__divider">

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="admin-profile__item admin-profile__item--danger" type="submit" role="menuitem" tabindex="0" data-menu-order="4">
                    <span class="admin-profile__item-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M10 17l5-5-5-5M15 12H3"></path><path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"></path></svg>
                    </span>
                    <span>Keluar</span>
                </button>
            </form>
        </nav>
    </div>
</div>
