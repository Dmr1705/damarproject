<?php

use App\Models\Anggota;
use App\Models\User;

test('public banom filter shows members saved with the selected banom', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('admin.anggota.store'), [
        'name' => 'Anggota PMII',
        'role' => 'PMII',
        'status' => 'Aktif',
        'is_public' => '1',
    ]);

    Anggota::create([
        'name' => 'Anggota IPNU',
        'position' => 'IPNU',
        'status' => 'Aktif',
        'is_public' => true,
    ]);

    $response = $this->get(route('anggota', ['category' => 'PMII']));

    $this->assertDatabaseHas('anggota', [
        'name' => 'Anggota PMII',
        'position' => 'PMII',
    ]);
    $response->assertSee('Anggota PMII')->assertDontSee('Anggota IPNU');
});

test('editing a member updates the banom used by the public filter', function () {
    $user = User::factory()->create();
    $anggota = Anggota::create([
        'name' => 'Anggota Berubah',
        'position' => 'IPNU',
        'status' => 'Aktif',
        'is_public' => true,
    ]);

    $editResponse = $this->actingAs($user)->get(route('admin.anggota.edit', $anggota));
    $editResponse->assertSee('value="IPNU" selected', false);

    $this->actingAs($user)->put(route('admin.anggota.update', $anggota), [
        'name' => $anggota->name,
        'role' => 'PMII',
        'wilayah' => 'Ciroyom',
        'status' => 'Aktif',
        'is_public' => '1',
    ]);

    $this->assertDatabaseHas('anggota', [
        'id' => $anggota->id,
        'position' => 'PMII',
        'region' => 'Ciroyom',
    ]);
    $this->get(route('anggota', ['category' => 'PMII']))
        ->assertSee('Anggota Berubah');
});

test('admin search finds members by banom and displays their region', function () {
    $user = User::factory()->create();
    Anggota::create([
        'name' => 'Anggota Dicari',
        'position' => 'PMII',
        'region' => 'Ciroyom',
        'status' => 'Aktif',
        'is_public' => true,
    ]);

    $response = $this->actingAs($user)->get(route('admin.anggota.index', ['search' => 'PMII']));

    $response->assertSee('Anggota Dicari')->assertSee('Ciroyom');
});
