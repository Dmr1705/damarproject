<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
        ]);

        $term = trim($validated['q'] ?? '');
        $pattern = '%'.strtr($term, ['!' => '!!', '%' => '!%', '_' => '!_']).'%';

        $news = DB::table('beritas')
            ->selectRaw("'berita' as type, id, title, content as excerpt, null as context, image, created_at")
            ->where('status', 'published');
        $gallery = DB::table('galeris')
            ->selectRaw("'galeri' as type, id, COALESCE(title, category, 'Galeri kegiatan') as title, category as excerpt, null as context, photo as image, created_at");
        $members = DB::table('anggota')
            ->selectRaw("'anggota' as type, id, name as title, position as excerpt, region as context, photo as image, created_at")
            ->where('is_public', true)
            ->whereIn('status', ['Aktif', 'aktif']);

        if ($term === '') {
            $news->whereRaw('1 = 0');
            $gallery->whereRaw('1 = 0');
            $members->whereRaw('1 = 0');
        } else {
            $news->where(function (Builder $query) use ($pattern): void {
                $query->whereRaw("title LIKE ? ESCAPE '!'", [$pattern])
                    ->orWhereRaw("content LIKE ? ESCAPE '!'", [$pattern]);
            });
            $gallery->where(function (Builder $query) use ($pattern): void {
                $query->whereRaw("title LIKE ? ESCAPE '!'", [$pattern])
                    ->orWhereRaw("category LIKE ? ESCAPE '!'", [$pattern]);
            });
            $members->where(function (Builder $query) use ($pattern): void {
                $query->whereRaw("name LIKE ? ESCAPE '!'", [$pattern])
                    ->orWhereRaw("position LIKE ? ESCAPE '!'", [$pattern])
                    ->orWhereRaw("region LIKE ? ESCAPE '!'", [$pattern]);
            });
        }

        $results = DB::query()
            ->fromSub($news->unionAll($gallery)->unionAll($members), 'search_results')
            ->orderByDesc('created_at')
            ->orderBy('title')
            ->paginate(9)
            ->withQueryString();

        $results->through(function (object $result) use ($term): object {
            if ($result->type === 'anggota' && filled($result->context)) {
                $position = (string) ($result->excerpt ?? '');
                $region = (string) $result->context;
                $result->excerpt = $position !== '' ? "{$position} · {$region}" : $region;
            }

            $result->excerpt = Str::limit(strip_tags((string) ($result->excerpt ?? '')), 200);
            $result->imageUrl = filled($result->image) ? asset('storage/'.$result->image) : null;
            $result->url = match ($result->type) {
                'berita' => route('berita.show', $result->id),
                'galeri' => route('galeri'),
                'anggota' => route('anggota'),
                default => route('home'),
            };
            $result->titleSegments = $this->highlightSegments((string) $result->title, $term);
            $result->excerptSegments = $this->highlightSegments($result->excerpt, $term);

            return $result;
        });

        return view('search', [
            'term' => $term,
            'results' => $results,
        ]);
    }

    /**
     * @return array<int, array{text: string, match: bool}>
     */
    private function highlightSegments(string $text, string $term): array
    {
        if ($term === '') {
            return [['text' => $text, 'match' => false]];
        }

        $segments = preg_split('/('.preg_quote($term, '/').')/iu', $text, -1, PREG_SPLIT_DELIM_CAPTURE);

        if ($segments === false) {
            return [['text' => $text, 'match' => false]];
        }

        return array_map(fn (string $segment): array => [
            'text' => $segment,
            'match' => preg_match('/^'.preg_quote($term, '/').'$/iu', $segment) === 1,
        ], $segments);
    }
}
