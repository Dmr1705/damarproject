<?php

use App\Models\Berita;
use App\Models\User;
use DOMDocument;
use DOMXPath;

test('homepage presents public information and published news only', function () {
    $author = User::factory()->create();
    Berita::create([
        'title' => 'Berita yang diterbitkan',
        'content' => 'Isi berita.',
        'status' => 'published',
        'author_id' => $author->id,
    ]);
    Berita::create([
        'title' => 'Berita draf',
        'content' => 'Isi draf.',
        'status' => 'draft',
        'author_id' => $author->id,
    ]);

    $this->get(route('home'))
        ->assertSee('Satu ruang untuk')
        ->assertSee('Lihat direktori anggota')
        ->assertSee('Berita yang diterbitkan')
        ->assertDontSee('Berita draf');
});

test('public news pages do not expose draft articles', function () {
    $author = User::factory()->create();
    $published = Berita::create([
        'title' => 'Kabar untuk warga',
        'content' => 'Isi kabar.',
        'status' => 'published',
        'author_id' => $author->id,
    ]);
    $draft = Berita::create([
        'title' => 'Catatan internal',
        'content' => 'Isi catatan.',
        'status' => 'draft',
        'author_id' => $author->id,
    ]);

    $this->get(route('berita.index'))
        ->assertSee($published->title)
        ->assertDontSee($draft->title);

    $this->get(route('berita.show', $draft->id))->assertNotFound();
});

test('public news cards keep their image and article details together inside the page', function () {
    $author = User::factory()->create();
    $publishedAt = now();

    Berita::create([
        'title' => 'Berita Pilihan',
        'content' => 'Isi berita pilihan.',
        'status' => 'published',
        'author_id' => $author->id,
        'created_at' => $publishedAt->copy()->subMinute(),
        'updated_at' => $publishedAt->copy()->subMinute(),
    ]);
    Berita::create([
        'title' => 'Berita Berikutnya',
        'content' => 'Isi berita berikutnya.',
        'status' => 'published',
        'author_id' => $author->id,
        'created_at' => $publishedAt,
        'updated_at' => $publishedAt,
    ]);

    $response = $this->get(route('berita.index'));

    $response->assertOk();

    $document = new DOMDocument;
    $previousErrorMode = libxml_use_internal_errors(true);
    $loaded = $document->loadHTML($response->getContent(), LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
    libxml_clear_errors();
    libxml_use_internal_errors($previousErrorMode);

    expect($loaded)->toBeTrue();

    $xpath = new DOMXPath($document);
    $main = $xpath->query('//*[contains(concat(" ", normalize-space(@class), " "), " public-page-shell ")]')->item(0);

    expect($main)->not->toBeNull();

    $newsGrid = $xpath->query('.//div[contains(concat(" ", normalize-space(@class), " "), " public-news-grid ")]', $main)->item(0);

    expect($newsGrid)->not->toBeNull();
    expect($newsGrid->getAttribute('class'))->toContain('max-w-md');

    $newsCard = $xpath->query('.//article[contains(concat(" ", normalize-space(@class), " "), " public-news-card ")]', $newsGrid)->item(0);

    expect($newsCard)->not->toBeNull();
    expect($xpath->query('.//h3[normalize-space(.) = "Berita Berikutnya"]', $newsCard)->length)->toBe(1);
});
