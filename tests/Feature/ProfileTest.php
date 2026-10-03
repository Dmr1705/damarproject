<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response->assertOk();
});

test('dashboard displays the authenticated account information', function () {
    $user = User::factory()->create([
        'name' => 'Akun Dinamis',
        'email' => 'dinamis@example.com',
        'role' => User::ROLE_ANGGOTA,
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/dashboard');

    $response
        ->assertOk()
        ->assertSee('Akun Dinamis')
        ->assertSee('dinamis@example.com')
        ->assertSee('ANGGOTA')
        ->assertSee('name="profile_photo"', false)
        ->assertSee('active:scale-95', false)
        ->assertSee('name="_method" value="PATCH"', false)
        ->assertDontSee('charlydwisaputra77@gmail.com');
});

test('public navigation displays the signed-in user profile photo', function () {
    $photoPath = 'profile-photos/public-avatar.jpg';
    $user = User::factory()->create(['profile_photo_path' => $photoPath]);

    $response = $this
        ->actingAs($user)
        ->get(route('home'));

    $response
        ->assertOk()
        ->assertSee(asset('storage/'.$photoPath), false);
});

test('user can upload and display a profile photo', function () {
    Storage::fake('public');

    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/dashboard')
        ->patch('/profile', [
            'name' => $user->name,
            'email' => $user->email,
            'profile_photo' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/dashboard');

    $photoPath = $user->refresh()->profile_photo_path;

    expect($photoPath)->not->toBeNull();
    expect(Storage::disk('public')->exists($photoPath))->toBeTrue();

    $this->get('/dashboard')
        ->assertSee(asset('storage/'.$photoPath), false);
});

test('replacing a profile photo removes the previous file', function () {
    Storage::fake('public');

    $oldPhotoPath = 'profile-photos/old-avatar.jpg';
    Storage::disk('public')->put($oldPhotoPath, 'old photo');
    $user = User::factory()->create(['profile_photo_path' => $oldPhotoPath]);

    $response = $this
        ->actingAs($user)
        ->from('/dashboard')
        ->patch('/profile', [
            'name' => $user->name,
            'email' => $user->email,
            'profile_photo' => UploadedFile::fake()->image('new-avatar.jpg'),
        ]);

    $response->assertSessionHasNoErrors();

    $newPhotoPath = $user->refresh()->profile_photo_path;

    expect($newPhotoPath)->not->toBe($oldPhotoPath);
    expect(Storage::disk('public')->exists($oldPhotoPath))->toBeFalse();
    expect(Storage::disk('public')->exists($newPhotoPath))->toBeTrue();
});

test('profile photo upload rejects non-image files', function () {
    Storage::fake('public');

    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/dashboard')
        ->patch('/profile', [
            'name' => $user->name,
            'email' => $user->email,
            'profile_photo' => UploadedFile::fake()->create('notes.txt', 1, 'text/plain'),
        ]);

    $response
        ->assertSessionHasErrors('profile_photo')
        ->assertRedirect('/dashboard');

    expect($user->refresh()->profile_photo_path)->toBeNull();
    expect(Storage::disk('public')->files('profile-photos'))->toBe([]);
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    $this->assertSame('Test User', $user->name);
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account', function () {
    Storage::fake('public');

    $photoPath = 'profile-photos/user.jpg';
    Storage::disk('public')->put($photoPath, 'profile photo');
    $user = User::factory()->create(['profile_photo_path' => $photoPath]);

    $response = $this
        ->actingAs($user)
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
    expect(Storage::disk('public')->exists($photoPath))->toBeFalse();
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect('/profile');

    $this->assertNotNull($user->fresh());
});
