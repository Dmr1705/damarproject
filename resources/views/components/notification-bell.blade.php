@props([
    'mode' => 'public',
    'endpoint',
    'storageKey' => '',
    'seeAllUrl',
])

@php
    $notificationPanelId = 'notification-panel-'.$mode;
@endphp

<div
    class="notification-bell"
    data-notification-bell
    data-mode="{{ $mode }}"
    data-endpoint="{{ $endpoint }}"
    data-storage-key="{{ $storageKey }}"
    data-see-all-url="{{ $seeAllUrl }}"
    data-read-url-template="{{ $mode === 'admin' ? route('admin.notifications.read', ['id' => '__notification_id__']) : '' }}"
    data-read-all-url="{{ $mode === 'admin' ? route('admin.notifications.read-all') : '' }}"
>
    <button
        class="notification-bell__trigger"
        type="button"
        aria-label="Notifikasi"
        aria-haspopup="true"
        aria-expanded="false"
        aria-controls="{{ $notificationPanelId }}"
        data-notification-trigger
    >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"></path>
        </svg>
        <span class="notification-bell__badge" data-notification-badge hidden></span>
        <span class="notification-bell__sr" data-notification-sr-count></span>
    </button>

    <section
        class="notification-bell__panel"
        id="{{ $notificationPanelId }}"
        aria-label="Notifikasi terbaru"
        aria-hidden="true"
        data-notification-panel
        hidden
    >
        <header class="notification-bell__header">
            <div>
                <h2>Notifikasi</h2>
                <p class="notification-bell__header-count" data-notification-header-count></p>
            </div>
            <button class="notification-bell__mark-all" type="button" data-notification-mark-all>
                Tandai semua dibaca
            </button>
        </header>

        <div class="notification-bell__message" role="status" aria-live="polite" data-notification-message hidden></div>

        <ul class="notification-bell__list" aria-live="polite" aria-relevant="additions text" data-notification-list hidden></ul>

        <div class="notification-bell__loading" aria-label="Memuat notifikasi" data-notification-loading>
            @foreach (range(1, 3) as $skeleton)
                <div class="notification-bell__skeleton" aria-hidden="true">
                    <span class="notification-bell__skeleton-image anim-shimmer"></span>
                    <span class="notification-bell__skeleton-copy">
                        <span class="notification-bell__skeleton-line anim-shimmer"></span>
                        <span class="notification-bell__skeleton-line notification-bell__skeleton-line--short anim-shimmer"></span>
                    </span>
                </div>
            @endforeach
        </div>

        <div class="notification-bell__empty" data-notification-empty hidden>
            <span class="notification-bell__empty-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <path d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"></path>
                </svg>
            </span>
            <p>Belum ada kabar terbaru</p>
        </div>

        <div class="notification-bell__error" data-notification-error hidden>
            <p>Gagal memuat notifikasi.</p>
            <button class="notification-bell__retry" type="button" data-notification-retry>Coba lagi</button>
        </div>

        <footer class="notification-bell__footer">
            <a href="{{ $seeAllUrl }}">Lihat semua berita</a>
        </footer>
    </section>
</div>
