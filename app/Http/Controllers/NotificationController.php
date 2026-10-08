<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    public function news(): JsonResponse
    {
        $items = Cache::remember('public-notifications.news.v1', 60, function (): array {
            $now = now();

            return Berita::query()
                ->where('status', 'published')
                ->whereBetween('created_at', [$now->copy()->subDays(7), $now])
                ->latest()
                ->take(5)
                ->get(['id', 'title', 'content', 'image', 'created_at'])
                ->map(function (Berita $berita): array {
                    $excerpt = trim(preg_replace('/\s+/u', ' ', strip_tags($berita->content)) ?? '');

                    return [
                        'id' => $berita->getKey(),
                        'title' => $berita->title,
                        'excerpt' => Str::limit($excerpt, 120),
                        'image' => $berita->image
                            ? Storage::disk('public')->url($berita->image)
                            : null,
                        'url' => route('berita.show', $berita->getKey()),
                        'published_at' => $berita->created_at?->toIso8601String(),
                        'time_ago' => $berita->created_at?->locale('id')->diffForHumans() ?? 'Baru saja',
                    ];
                })
                ->all();
        });

        return response()->json([
            'count' => count($items),
            'items' => $items,
        ]);
    }
}
