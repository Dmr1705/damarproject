<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AnggotaController extends Controller
{
    public function publicIndex(Request $request): View
    {
        $query = Anggota::query()
            ->where('is_public', true)
            ->whereIn('status', ['Aktif', 'aktif']);

        $category = $request->query('category');
        $categories = ['Muslimat', 'Fatayat', 'GP Ansor', 'IPNU', 'IPPNU', 'PMII'];
        $query->when($category && in_array($category, $categories, true), function ($query) use ($category) {
            $query->where('position', $category);
        });

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%")
                    ->orWhere('region', 'like', "%{$search}%");
            });
        }

        $anggotas = $query->latest()->paginate(12)->withQueryString();

        return view('anggota.index', compact('anggotas', 'categories'));
    }

    public function index(Request $request): View
    {
        $query = Anggota::query();

        // Fitur Pencarian (disesuaikan ke role)
        $search = $request->query('q', $request->query('search'));
        if (filled($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%")
                    ->orWhere('region', 'like', "%{$search}%");
            });
        }

        // Fitur Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Menggunakan Pagination 10 data per halaman
        $anggotas = $query->latest()->paginate(10)->withQueryString();
        $memberOptions = Anggota::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.anggota.index', compact('anggotas', 'memberOptions'));
    }

    public function create(): View
    {
        return view('admin.anggota.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:Muslimat,Fatayat,GP Ansor,IPNU,IPPNU,PMII',
            'wilayah' => 'nullable|string|max:255',
            'status' => 'required|in:Aktif,aktif,Nonaktif,nonaktif,Alumni,alumni,Pending,pending',
            'joined_at' => 'nullable|date',
            'is_public' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'role.required' => 'Role/Badan Otonom wajib dipilih.',
            'role.in' => 'Pilihan role tidak valid.',
            'status.required' => 'Status keanggotaan wajib diisi.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Format gambar harus berupa jpeg, png, atau jpg.',
            'photo.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos/anggota', 'public');
        }

        $validated['position'] = $validated['role'];
        $validated['region'] = $validated['wilayah'] ?? null;
        unset($validated['role'], $validated['wilayah']);
        $validated['user_id'] = Auth::id();

        Anggota::create($validated);

        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil ditambahkan.');
    }

    public function edit($id): View
    {
        $anggota = Anggota::findOrFail($id);

        return view('admin.anggota.edit', compact('anggota'));
    }

    public function card(Anggota $anggota): View
    {
        return view('admin.anggota.card', [
            'anggota' => $anggota,
            'organizationLogo' => $this->organizationLogoFor($anggota),
            'qrCode' => $this->qrCodeFor($anggota),
        ]);
    }

    public function cards(): View
    {
        $anggotas = Anggota::query()->latest()->get();

        return view('admin.anggota.cards', [
            'anggotas' => $anggotas,
            'qrCodes' => $anggotas->mapWithKeys(fn (Anggota $anggota): array => [
                $anggota->id => $this->qrCodeFor($anggota),
            ]),
            'organizationLogos' => [
                'Muslimat' => 'MuslimatNU.png',
                'Fatayat' => 'FATAYAT-NU.png',
                'GP Ansor' => 'GP-Ansor.png',
                'IPNU' => 'IPNU.png',
                'IPPNU' => 'IPPNU.png',
                'PMII' => 'PMII.png',
            ],
        ]);
    }

    private function qrCodeFor(Anggota $anggota): string
    {
        $payload = implode("\n", [
            'KARTU ANGGOTA NU Sawangan',
            '------------------------',
            'ID Anggota: '.$anggota->id,
            'Nama: '.$anggota->name,
            'Organisasi: '.($anggota->position ?: 'Anggota NU'),
            'Wilayah: '.($anggota->region ?: 'Wilayah Pusat / Umum'),
            'Status: '.ucfirst($anggota->status ?: 'Aktif'),
            'Tanggal Bergabung: '.($anggota->joined_at ?: 'Belum diisi'),
            'Bio: '.($anggota->bio ?: 'Belum diisi'),
            'Tampil Publik: '.($anggota->is_public ? 'Ya' : 'Tidak'),
        ]);

        return (new SvgWriter)
            ->write(QrCode::create($payload)->setSize(120)->setMargin(4))
            ->getDataUri();
    }

    private function organizationLogoFor(Anggota $anggota): ?string
    {
        return [
            'Muslimat' => 'MuslimatNU.png',
            'Fatayat' => 'FATAYAT-NU.png',
            'GP Ansor' => 'GP-Ansor.png',
            'IPNU' => 'IPNU.png',
            'IPPNU' => 'IPPNU.png',
            'PMII' => 'PMII.png',
        ][$anggota->position ?? ''] ?? null;
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $anggota = Anggota::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:Muslimat,Fatayat,GP Ansor,IPNU,IPPNU,PMII',
            'wilayah' => 'nullable|string|max:255',
            'status' => 'required|in:Aktif,aktif,Nonaktif,nonaktif,Alumni,alumni,Pending,pending',
            'joined_at' => 'nullable|date',
            'is_public' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'role.required' => 'Role/Badan Otonom wajib dipilih.',
            'role.in' => 'Pilihan role tidak valid.',
            'status.required' => 'Status keanggotaan wajib diisi.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $validated['position'] = $validated['role'];
        $validated['region'] = $validated['wilayah'] ?? null;
        unset($validated['role'], $validated['wilayah']);

        if ($request->hasFile('photo')) {
            if ($anggota->photo && Storage::disk('public')->exists($anggota->photo)) {
                Storage::disk('public')->delete($anggota->photo);
            }
            $validated['photo'] = $request->file('photo')->store('photos/anggota', 'public');
        }

        $anggota->update($validated);

        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        $anggota = Anggota::findOrFail($id);

        if ($anggota->photo && Storage::disk('public')->exists($anggota->photo)) {
            Storage::disk('public')->delete($anggota->photo);
        }

        $anggota->delete();

        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil dihapus.');
    }
}
