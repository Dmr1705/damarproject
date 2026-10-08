<?php

namespace App\Notifications;

use App\Models\Berita;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaBaruNotification extends Notification
{
    use Queueable;

    public function __construct(public Berita $berita) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $excerpt = trim(preg_replace('/\s+/u', ' ', strip_tags($this->berita->content)) ?? '');

        return [
            'berita_id' => $this->berita->getKey(),
            'judul' => $this->berita->title,
            'cuplikan' => Str::limit($excerpt, 90),
            'gambar' => $this->berita->image
                ? Storage::disk('public')->url($this->berita->image)
                : null,
            'url' => route('admin.berita.edit', $this->berita->getKey()),
            'nama_pembuat' => $this->berita->author?->name ?? 'Pengguna NU Sawangan',
        ];
    }
}
