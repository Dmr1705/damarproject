<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Berita;
use App\Models\Galeri;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user()->load('profilAnggota');
        $currentMonth = CarbonImmutable::now()->startOfMonth();
        $chartStart = $currentMonth->subMonths(5);
        $monthKeyExpression = match (DB::connection()->getDriverName()) {
            'sqlite' => "strftime('%Y-%m', created_at)",
            'mysql', 'mariadb' => "DATE_FORMAT(created_at, '%Y-%m')",
            default => throw new \RuntimeException('Dashboard activity aggregation does not support the configured database driver.'),
        };

        $beritaByMonth = Berita::query()
            ->selectRaw("{$monthKeyExpression} as month_key, COUNT(*) as total")
            ->where('created_at', '>=', $chartStart)
            ->where('created_at', '<', $currentMonth->addMonth())
            ->groupByRaw($monthKeyExpression)
            ->pluck('total', 'month_key');

        $anggotaByMonth = Anggota::query()
            ->selectRaw("{$monthKeyExpression} as month_key, COUNT(*) as total")
            ->where('created_at', '>=', $chartStart)
            ->where('created_at', '<', $currentMonth->addMonth())
            ->groupByRaw($monthKeyExpression)
            ->pluck('total', 'month_key');

        $activityMonths = collect(range(5, 0))
            ->map(function (int $monthsAgo) use ($currentMonth, $beritaByMonth, $anggotaByMonth): array {
                $month = $currentMonth->subMonths($monthsAgo);
                $monthKey = $month->format('Y-m');

                return [
                    'key' => $monthKey,
                    'label' => $month->locale('id')->translatedFormat('M'),
                    'berita' => (int) ($beritaByMonth[$monthKey] ?? 0),
                    'anggota' => (int) ($anggotaByMonth[$monthKey] ?? 0),
                ];
            });

        $activityScale = max(1, (int) $activityMonths->max(
            fn (array $month): int => max($month['berita'], $month['anggota']),
        ));

        $currentMonthKey = $currentMonth->format('Y-m');
        $previousMonthKey = $currentMonth->subMonth()->format('Y-m');
        $newsThisMonth = (int) ($beritaByMonth[$currentMonthKey] ?? 0);
        $newsLastMonth = (int) ($beritaByMonth[$previousMonthKey] ?? 0);

        return view('dashboard', [
            'user' => $user,
            'anggota' => $user->profilAnggota,
            'totalBerita' => Berita::query()->count(),
            'totalAnggota' => Anggota::query()->count(),
            'totalGaleri' => Galeri::query()->count(),
            'newsThisMonth' => $newsThisMonth,
            'newsMonthChange' => $newsThisMonth - $newsLastMonth,
            'activityMonths' => $activityMonths,
            'activityScale' => $activityScale,
            'recentBerita' => Berita::query()
                ->latest()
                ->take(5)
                ->get(['id', 'title', 'status', 'created_at']),
            'recentAnggota' => Anggota::query()
                ->latest()
                ->take(5)
                ->get(['id', 'name', 'position', 'status', 'created_at']),
            'recentGaleri' => Galeri::query()
                ->latest()
                ->take(6)
                ->get(['id', 'title', 'category', 'photo', 'created_at']),
        ]);
    }
}
