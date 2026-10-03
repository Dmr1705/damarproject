<?php

use App\Models\Galeri;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('gallery create page includes the photo preview script', function () {
    $user = User::factory()->create(['role' => 'admin']);

    $response = $this
        ->actingAs($user)
        ->get(route('admin.galeri.create'));

    $response
        ->assertOk()
        ->assertSee('function previewImage(event)', false)
        ->assertSee('new FileReader()', false);
});

test('admin can upload a gallery photo', function () {
    Storage::fake('public');

    $user = User::factory()->create(['role' => 'admin']);

    $response = $this
        ->actingAs($user)
        ->post(route('admin.galeri.store'), [
            'title' => 'Kegiatan Pengajian',
            'category' => 'Muslimat',
            'photo' => UploadedFile::fake()->image('pengajian.jpg'),
        ]);

    $response->assertRedirect(route('admin.galeri.index'));

    $galeri = Galeri::query()->firstOrFail();

    $this->assertSame('Kegiatan Pengajian', $galeri->title);
    $this->assertSame('Muslimat', $galeri->category);
    expect(Storage::disk('public')->exists($galeri->photo))->toBeTrue();
});
