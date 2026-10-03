<?php

use App\Models\Galeri;
use App\Models\User;
use DOMDocument;
use DOMXPath;

it('keeps gallery controls inside the page and adapts columns to the image count', function (int $imageCount, string $expectedGridClass) {
    $admin = User::factory()->create(['role' => 'admin']);

    for ($index = 1; $index <= $imageCount; $index++) {
        Galeri::create([
            'title' => "Kegiatan {$index}",
            'photo' => "galeri/kegiatan-{$index}.jpg",
            'category' => 'Muslimat',
        ]);
    }

    $response = $this->actingAs($admin)->get(route('galeri'));

    $response->assertOk()->assertSee('Galeri Kegiatan');

    $document = new DOMDocument;
    $previousErrorMode = libxml_use_internal_errors(true);
    $loaded = $document->loadHTML($response->getContent(), LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
    libxml_clear_errors();
    libxml_use_internal_errors($previousErrorMode);

    expect($loaded)->toBeTrue();

    $xpath = new DOMXPath($document);
    $main = $xpath->query('//*[contains(concat(" ", normalize-space(@class), " "), " public-page-shell ")]')->item(0);

    expect($main)->not->toBeNull();
    expect($xpath->query('.//div[contains(concat(" ", normalize-space(@class), " "), " public-page-header ")]', $main)->length)->toBe(1);
    expect($xpath->query('.//div[contains(concat(" ", normalize-space(@class), " "), " public-gallery-grid ")]', $main)->length)->toBe(1);

    $header = $xpath->query('.//div[contains(concat(" ", normalize-space(@class), " "), " public-page-header ")]', $main)->item(0);
    $galleryGrid = $xpath->query('.//div[contains(concat(" ", normalize-space(@class), " "), " public-gallery-grid ")]', $main)->item(0);

    expect($xpath->query('.//a[contains(@href, "/admin/galeri/tambah")]', $header)->length)->toBe(1);
    expect($galleryGrid->getAttribute('class'))->toContain($expectedGridClass);
})->with([
    'empty gallery stays constrained' => [0, 'max-w-xl'],
    'single photo stays centered' => [1, 'max-w-xl'],
    'two photos fill a balanced row' => [2, 'max-w-4xl'],
    'three photos use three desktop columns' => [3, 'lg:grid-cols-3'],
    'larger galleries expand to four desktop columns' => [4, 'xl:grid-cols-4'],
]);
