<?php

use App\Models\Anggota;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\User;

it('searches published news, public gallery entries, and active public members', function () {
    $author = User::factory()->create();

    $published = Berita::create([
        'title' => 'Pengajian warga Sawangan',
        'content' => 'Kegiatan pengajian rutin.',
        'status' => 'published',
        'author_id' => $author->id,
    ]);
    Berita::create([
        'title' => 'Pengajian internal',
        'content' => 'Catatan pengajian yang belum diterbitkan.',
        'status' => 'draft',
        'author_id' => $author->id,
    ]);
    $gallery = Galeri::create([
        'title' => 'Dokumentasi pengajian',
        'category' => 'Muslimat',
        'photo' => 'galeri/pengajian.jpg',
    ]);
    $member = Anggota::create([
        'name' => 'Anggota Fulan',
        'position' => 'Fatayat',
        'region' => 'Pengajian Sawangan',
        'status' => 'Aktif',
        'is_public' => true,
    ]);
    Anggota::create([
        'name' => 'Pengajian Privat',
        'position' => 'Fatayat',
        'status' => 'Aktif',
        'is_public' => false,
    ]);
    Anggota::create([
        'name' => 'Pengajian Nonaktif',
        'position' => 'Fatayat',
        'status' => 'Nonaktif',
        'is_public' => true,
    ]);

    $this->get(route('search', ['q' => 'Pengajian']))
        ->assertSee($published->title)
        ->assertSee($gallery->title)
        ->assertSee($member->name)
        ->assertSee('<mark>Pengajian</mark>', false)
        ->assertDontSee('Pengajian internal')
        ->assertDontSee('Pengajian Privat')
        ->assertDontSee('Pengajian Nonaktif');
});

it('treats LIKE wildcard characters in the search term literally', function () {
    $author = User::factory()->create();
    $literalMatch = Berita::create([
        'title' => 'Diskusi%literal',
        'content' => 'Berita dengan karakter persen.',
        'status' => 'published',
        'author_id' => $author->id,
    ]);
    Berita::create([
        'title' => 'Diskusi acara biasa',
        'content' => 'Berita tanpa karakter khusus.',
        'status' => 'published',
        'author_id' => $author->id,
    ]);

    $this->get(route('search', ['q' => '%']))
        ->assertSee($literalMatch->title)
        ->assertDontSee('Diskusi acara biasa');
});

it('escapes matching content while highlighting the search term', function () {
    $author = User::factory()->create();
    Berita::create([
        'title' => 'Pengajian <script>alert("x")</script>',
        'content' => 'Pengajian warga.',
        'status' => 'published',
        'author_id' => $author->id,
    ]);

    $this->get(route('search', ['q' => 'Pengajian']))
        ->assertSee('<mark>Pengajian</mark>', false)
        ->assertSee('&lt;script&gt;', false)
        ->assertDontSee('<script>', false);
});

it('rejects search terms longer than one hundred characters', function () {
    $this->get(route('search', ['q' => str_repeat('a', 101)]))
        ->assertSessionHasErrors('q');
});

it('shows a friendly empty state when no result matches', function () {
    $this->get(route('search', ['q' => 'topik-tidak-ditemukan']))
        ->assertSee('Tidak ada hasil untuk')
        ->assertSee('Coba kata kunci yang lebih umum');
});

it('asks for a search term when the query is empty', function () {
    $this->get(route('search'))
        ->assertSee('Mulai dengan kata kunci.');
});

it('paginates matching content nine items at a time and keeps the query string', function () {
    $author = User::factory()->create();

    foreach (range(1, 10) as $number) {
        Berita::create([
            'title' => 'Pengajian warga '.str_pad((string) $number, 2, '0', STR_PAD_LEFT),
            'content' => 'Kegiatan rutin.',
            'status' => 'published',
            'author_id' => $author->id,
        ]);
    }

    $this->get(route('search', ['q' => 'Pengajian', 'page' => 2]))
        ->assertSee('10 hasil untuk')
        ->assertSee('q=Pengajian')
        ->assertSee('Pengajian warga 10');
});

it('filters admin indexes from the topbar query parameter', function () {
    $user = User::factory()->create();
    $author = User::factory()->create();
    $matchingNews = Berita::create([
        'title' => 'Kabar Khidmah',
        'content' => 'Isi berita.',
        'status' => 'published',
        'author_id' => $author->id,
    ]);
    Berita::create([
        'title' => 'Kabar Lain',
        'content' => 'Isi lain.',
        'status' => 'published',
        'author_id' => $author->id,
    ]);
    $matchingGallery = Galeri::create([
        'title' => 'Dokumentasi Khidmah',
        'photo' => 'galeri/khidmah.jpg',
    ]);
    Galeri::create([
        'title' => 'Dokumentasi lain',
        'photo' => 'galeri/lain.jpg',
    ]);
    $matchingMember = Anggota::create([
        'name' => 'Anggota Khidmah',
        'position' => 'Fatayat',
        'status' => 'Aktif',
        'is_public' => true,
    ]);
    Anggota::create([
        'name' => 'Anggota lain',
        'position' => 'Muslimat',
        'status' => 'Aktif',
        'is_public' => true,
    ]);

    $this->actingAs($user)
        ->get(route('admin.berita.index', ['q' => 'Khidmah']))
        ->assertSee($matchingNews->title)
        ->assertDontSee('Kabar Lain');

    $this->get(route('admin.galeri.index', ['q' => 'Khidmah']))
        ->assertSee($matchingGallery->title)
        ->assertDontSee('Dokumentasi lain');

    $this->get(route('admin.anggota.index', ['q' => 'Khidmah']))
        ->assertSee($matchingMember->name)
        ->assertDontSee('Anggota lain');
});
