<?php

use App\Models\Berita;
use App\Models\User;
use App\Notifications\BeritaBaruNotification;
use Illuminate\Support\Facades\Cache;

test('public and admin headers render the shared notification bell in their respective modes', function () {
    $this->get(route('home'))
        ->assertSee('data-mode="public"', false)
        ->assertSee('data-storage-key="nu_seen_news_ids"', false)
        ->assertSee('aria-label="Notifikasi"', false);

    $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertSee('data-mode="admin"', false)
        ->assertSee(route('admin.notifications.index'), false)
        ->assertSee(route('admin.notifications.read-all'), false);
});

test('public news notifications include only published news from the last seven days', function () {
    $this->travelTo(now()->startOfDay());
    Cache::forget('public-notifications.news.v1');
    $author = User::factory()->create();

    $recentNews = Berita::query()->create([
        'title' => 'Berita terkini',
        'content' => '<p>Isi kabar <strong>penting</strong> untuk warga.</p>',
        'status' => 'published',
        'author_id' => $author->id,
    ]);
    $recentNews->forceFill(['created_at' => now()->subDays(2)])->saveQuietly();
    $oldNews = Berita::query()->create([
        'title' => 'Berita lama',
        'content' => 'Kabar lebih dari tujuh hari.',
        'status' => 'published',
        'author_id' => $author->id,
    ]);
    $oldNews->forceFill(['created_at' => now()->subDays(8)])->saveQuietly();
    Berita::query()->create([
        'title' => 'Draf internal',
        'content' => 'Draf tidak boleh terlihat.',
        'status' => 'draft',
        'author_id' => $author->id,
        'created_at' => now(),
    ]);

    $this->getJson(route('notifications.news'))
        ->assertOk()
        ->assertJsonPath('count', 1)
        ->assertJsonPath('items.0.title', 'Berita terkini')
        ->assertJsonPath('items.0.excerpt', 'Isi kabar penting untuk warga.')
        ->assertJsonPath('items.0.url', route('berita.show', $recentNews->id))
        ->assertJsonMissing(['title' => 'Berita lama'])
        ->assertJsonMissing(['title' => 'Draf internal']);
});

test('publishing news notifies other panel users once but not its author', function () {
    $author = User::factory()->create(['role' => User::ROLE_ADMIN]);
    $anotherAdmin = User::factory()->create(['role' => User::ROLE_ADMIN]);
    $member = User::factory()->create(['role' => User::ROLE_ANGGOTA]);
    $this->actingAs($author);

    $this->post(route('admin.berita.store'), [
        'title' => 'Kabar diterbitkan',
        'content' => '<p>Isi kabar baru.</p>',
        'status' => 'draft',
    ])->assertRedirect(route('admin.berita.index'));

    $berita = Berita::query()->where('title', 'Kabar diterbitkan')->firstOrFail();
    $this->assertDatabaseCount('notifications', 0);

    $this->put(route('admin.berita.update', $berita->id), [
        'title' => 'Kabar diterbitkan',
        'content' => '<p>Isi kabar baru.</p>',
        'status' => 'published',
    ])->assertRedirect(route('admin.berita.index'));

    $this->assertDatabaseCount('notifications', 2);
    expect($anotherAdmin->notifications()->count())->toBe(1);
    expect($member->notifications()->count())->toBe(1);
    expect($author->notifications()->count())->toBe(0);

    $this->put(route('admin.berita.update', $berita->id), [
        'title' => 'Kabar diterbitkan diperbarui',
        'content' => '<p>Isi kabar yang diperbarui.</p>',
        'status' => 'published',
    ])->assertRedirect(route('admin.berita.index'));

    $this->assertDatabaseCount('notifications', 2);
});

test('admin notification feed belongs to the signed-in user and marks one item read', function () {
    $author = User::factory()->create(['role' => User::ROLE_ADMIN]);
    $recipient = User::factory()->create(['role' => User::ROLE_ADMIN]);
    $otherUser = User::factory()->create(['role' => User::ROLE_ANGGOTA]);
    $berita = Berita::query()->create([
        'title' => 'Berita untuk panel',
        'content' => '<p>Cuplikan panel.</p>',
        'status' => 'published',
        'author_id' => $author->id,
    ]);
    $recipient->notify(new BeritaBaruNotification($berita));
    $notification = $recipient->notifications()->firstOrFail();

    $this->actingAs($recipient)
        ->getJson(route('admin.notifications.index'))
        ->assertOk()
        ->assertJsonPath('unread_count', 1)
        ->assertJsonPath('items.0.title', 'Berita untuk panel')
        ->assertJsonPath('items.0.read', false)
        ->assertJsonPath('items.0.url', route('admin.berita.edit', $berita->id));

    $this->actingAs($otherUser)
        ->postJson(route('admin.notifications.read', $notification->id))
        ->assertNotFound();

    expect($notification->fresh()->read_at)->toBeNull();

    $this->actingAs($recipient)
        ->postJson(route('admin.notifications.read', $notification->id))
        ->assertOk()
        ->assertJsonPath('url', route('admin.berita.edit', $berita->id));

    expect($notification->fresh()->read_at)->not->toBeNull();
});

test('admin can mark all personal notifications read', function () {
    $author = User::factory()->create(['role' => User::ROLE_ADMIN]);
    $recipient = User::factory()->create(['role' => User::ROLE_ADMIN]);
    $otherUser = User::factory()->create(['role' => User::ROLE_ADMIN]);
    $berita = Berita::query()->create([
        'title' => 'Berita untuk dibaca',
        'content' => 'Isi berita.',
        'status' => 'published',
        'author_id' => $author->id,
    ]);
    $recipient->notify(new BeritaBaruNotification($berita));
    $otherUser->notify(new BeritaBaruNotification($berita));

    $this->actingAs($recipient)
        ->postJson(route('admin.notifications.read-all'))
        ->assertOk()
        ->assertJsonPath('unread_count', 0);

    expect($recipient->unreadNotifications()->count())->toBe(0);
    expect($otherUser->unreadNotifications()->count())->toBe(1);
});
