<?php

use App\Models\Berita;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('an uploaded thumbnail is selectable and stored with a berita article', function () {
    Storage::fake('public');
    $user = User::factory()->create();

    $formResponse = $this->actingAs($user)->get(route('admin.berita.create'));
    $formResponse->assertSee('for="image"', false)
        ->assertSee('id="image"', false)
        ->assertSee('id="image-preview-container" class="hidden mb-4 w-full flex flex-col items-center"', false)
        ->assertSee('id="image-preview"', false)
        ->assertSee('function previewNewsImage(event)', false)
        ->assertSee("addEventListener('drop'", false);

    $response = $this->post(route('admin.berita.store'), [
        'title' => 'Berita dengan Thumbnail',
        'content' => 'Konten berita untuk pengujian upload thumbnail.',
        'status' => 'published',
        'image' => UploadedFile::fake()->image('thumbnail.png'),
    ]);

    $response->assertRedirect(route('admin.berita.index'));

    $berita = Berita::query()->where('title', 'Berita dengan Thumbnail')->firstOrFail();
    Storage::disk('public')->assertExists($berita->image);
});
