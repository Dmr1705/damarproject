<footer class="site-footer">
    <div class="site-footer__main">
        <div class="site-footer__brand">
            <a class="brand brand--footer" href="{{ route('home') }}" aria-label="NU Sawangan, kembali ke beranda">
                <img class="brand__mark" src="{{ config('images.logo') }}" alt="" width="52" height="52" loading="lazy">
                <span class="brand__text">
                    <span class="brand__name">NU Sawangan</span>
                    <span class="brand__tagline">Khidmah untuk umat dan negeri</span>
                </span>
            </a>
            <p>Ruang informasi publik untuk mengenal kabar, anggota, dan dokumentasi kegiatan NU Sawangan.</p>
            <div class="social-note">
                <span class="social-note__icons" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.5" cy="6.7" r=".7"></circle></svg>
                    <svg viewBox="0 0 24 24"><path d="M14 21v-8h3l.5-3H14V8c0-.9.3-1.5 1.6-1.5h2V3.8c-.4-.1-1.5-.2-2.8-.2-2.8 0-4.7 1.7-4.7 4.9V10H7v3h3.1v8"></path></svg>
                    <svg viewBox="0 0 24 24"><path d="M21 7.2a3 3 0 0 0-2.1-2.1C17 4.6 12 4.6 12 4.6s-5 0-6.9.5A3 3 0 0 0 3 7.2 31 31 0 0 0 2.5 12 31 31 0 0 0 3 16.8a3 3 0 0 0 2.1 2.1c1.9.5 6.9.5 6.9.5s5 0 6.9-.5a3 3 0 0 0 2.1-2.1 31 31 0 0 0 .5-4.8 31 31 0 0 0-.5-4.8Z"></path><path d="m10 15.2 4.8-3.2L10 8.8z"></path></svg>
                </span>
                <span>Kanal sosial resmi akan ditautkan di sini.</span>
            </div>
        </div>

        <div class="site-footer__column">
            <h2>Jelajahi</h2>
            <a href="{{ route('home') }}#tentang-section">Tentang NU Sawangan</a>
            <a href="{{ route('home') }}#kegiatan-section">Kegiatan</a>
            <a href="{{ route('anggota') }}">Direktori anggota</a>
        </div>

        <div class="site-footer__column">
            <h2>Informasi</h2>
            <a href="{{ route('berita.index') }}">Berita terbaru</a>
            <a href="{{ route('galeri') }}">Galeri kegiatan</a>
            <a href="{{ route('home') }}#kontak-section">Kontak organisasi</a>
        </div>

        <div class="site-footer__column site-footer__contact">
            <h2>Wilayah</h2>
            <p>Sawangan</p>
            <p>Informasi publik NU Sawangan</p>
            <a class="footer-contact-link" href="{{ route('anggota') }}">Temukan anggota <svg class="icon-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"></path></svg></a>
        </div>
    </div>
    <div class="site-footer__bottom">
        <span>&copy; {{ date('Y') }} NU Sawangan. Hak cipta dilindungi.</span>
        <a href="{{ route('home') }}">Kembali ke atas <svg class="icon-arrow icon-arrow--up" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 19V5M6 11l6-6 6 6"></path></svg></a>
    </div>
</footer>
