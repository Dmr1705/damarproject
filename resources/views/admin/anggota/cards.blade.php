<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Semua Kartu Anggota</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            @page { size: A4; margin: 10mm; }
            body {
                background: white;
                margin: 0 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .print-controls { display: none; }
            .member-card {
                break-inside: avoid;
                background-color: #087A4B !important;
                box-shadow: none !important;
                width: 86mm !important;
                height: 54mm !important;
                min-height: 54mm !important;
                aspect-ratio: auto !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-slate-100 p-6 font-sans text-slate-900">
    <div class="print-controls mx-auto mb-6 flex max-w-5xl items-center justify-between gap-3">
        <a href="{{ route('admin.anggota.index') }}" class="text-sm font-bold text-slate-600 hover:text-[#087A4B]">Kembali ke Halaman Admin</a>
        <button type="button" onclick="window.print()" class="rounded-xl bg-[#087A4B] px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-700">
            Cetak Semua Kartu
        </button>
    </div>

    <main class="mx-auto grid max-w-5xl grid-cols-1 justify-items-center gap-6 sm:grid-cols-2 lg:grid-cols-3 print:grid-cols-2 print:gap-4">
        @forelse ($anggotas as $anggota)
            <section class="member-card relative aspect-[86/54] w-[86mm] overflow-hidden rounded-[5mm] bg-gradient-to-br from-[#087A4B] to-[#064A32] p-[5mm] text-white shadow-xl print:shadow-none">
                @include('admin.anggota.partials.card', [
                    'anggota' => $anggota,
                    'organizationLogo' => $organizationLogos[$anggota->position ?? ''] ?? null,
                    'qrCode' => $qrCodes[$anggota->id],
                ])
            </section>
        @empty
            <p class="col-span-full rounded-xl bg-white p-6 text-sm font-bold text-slate-600">Belum ada data anggota untuk dicetak.</p>
        @endforelse
    </main>
</body>
</html>
