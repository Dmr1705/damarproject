<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class AdminNotificationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $items = $user->notifications()
            ->latest()
            ->take(5)
            ->get()
            ->map(fn (DatabaseNotification $notification): array => [
                'id' => $notification->getKey(),
                'title' => $notification->data['judul'] ?? 'Berita baru',
                'excerpt' => $notification->data['cuplikan'] ?? '',
                'image' => $notification->data['gambar'] ?? null,
                'url' => $notification->data['url'] ?? route('admin.berita.index'),
                'time_ago' => $notification->created_at?->locale('id')->diffForHumans() ?? 'Baru saja',
                'read' => $notification->read_at !== null,
            ]);

        return response()->json([
            'unread_count' => $user->unreadNotifications()->count(),
            'items' => $items,
        ]);
    }

    public function read(Request $request, string $id): JsonResponse|RedirectResponse
    {
        $notification = $request->user()
            ->notifications()
            ->whereKey($id)
            ->firstOrFail();

        $notification->markAsRead();
        $beritaId = $notification->data['berita_id'] ?? null;
        $url = $beritaId && Berita::query()->whereKey($beritaId)->exists()
            ? route('admin.berita.edit', $beritaId)
            : route('admin.berita.index');

        return $request->expectsJson()
            ? response()->json(['url' => $url])
            : redirect()->to($url);
    }

    public function readAll(Request $request): JsonResponse
    {
        $request->user()
            ->unreadNotifications()
            ->update(['read_at' => now()]);

        return response()->json([
            'unread_count' => 0,
        ]);
    }
}
