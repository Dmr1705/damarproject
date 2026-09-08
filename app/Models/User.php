<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    const ROLE_ADMIN = 'admin';
    const ROLE_ANGGOTA = 'anggota';

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function profilAnggota()
    {
        return $this->hasOne(Anggota::class, 'user_id');
    }

    public function beritas()
    {
        return $this->hasMany(Berita::class, 'author_id');
    }
}