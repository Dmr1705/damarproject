<?php

use App\Models\Anggota;
use App\Models\User;

test('guest cannot access the member card', function () {
    $anggota = Anggota::create([
        'name' => 'Siti Aminah',
        'position' => 'Muslimat',
        'status' => 'Aktif',
        'is_public' => true,
    ]);

    $response = $this->get(route('admin.anggota.card', $anggota));

    $response->assertRedirect(route('login'));
});

test('authenticated user can view a printable member card', function () {
    $user = User::factory()->create();
    $anggota = Anggota::create([
        'name' => 'Siti Aminah',
        'position' => 'Muslimat',
        'region' => 'Ciroyom',
        'status' => 'Aktif',
        'is_public' => true,
    ]);

    $response = $this->actingAs($user)->get(route('admin.anggota.card', $anggota));

    $response->assertOk()
        ->assertSee('Kartu Anggota')
        ->assertSee('Kembali ke Halaman Admin')
        ->assertSee('Siti Aminah')
        ->assertSee('Ciroyom')
        ->assertSee('MuslimatNU.png')
        ->assertSee('data:image/svg+xml');
});

test('authenticated user can view all printable member cards', function () {
    $user = User::factory()->create();
    Anggota::create([
        'name' => 'Siti Aminah',
        'position' => 'Muslimat',
        'status' => 'Aktif',
        'is_public' => true,
    ]);
    Anggota::create([
        'name' => 'Ahmad Fauzi',
        'position' => 'IPNU',
        'status' => 'Aktif',
        'is_public' => true,
    ]);

    $response = $this->actingAs($user)->get(route('admin.anggota.cards'));

    $response->assertOk()
        ->assertSee('Cetak Semua Kartu')
        ->assertSee('Siti Aminah')
        ->assertSee('Ahmad Fauzi')
        ->assertSee('MuslimatNU.png')
        ->assertSee('IPNU.png')
        ->assertSee('data:image/svg+xml');
});

test('new member is linked to the authenticated account', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('admin.anggota.store'), [
        'name' => 'Anggota Terhubung',
        'role' => 'IPNU',
        'wilayah' => 'Ciroyom',
        'status' => 'Aktif',
        'joined_at' => '2026-09-08',
        'is_public' => '1',
    ]);

    $response->assertRedirect(route('admin.anggota.index'));
    expect(Anggota::query()->where('name', 'Anggota Terhubung')->first()->user_id)
        ->toBe($user->id);
});
