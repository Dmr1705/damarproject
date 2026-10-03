<div class="absolute -right-10 -top-10 h-32 w-32 rounded-full border-[12px] border-white/10"></div>
<div class="absolute -bottom-16 -left-10 h-36 w-36 rounded-full border-[14px] border-white/10"></div>

<div class="relative flex items-center justify-between border-b border-white/25 pb-2">
    <div>
        <p class="text-[9px] font-black uppercase tracking-[0.18em] text-emerald-100">Kartu Anggota</p>
        <p class="text-[7px] font-medium uppercase tracking-widest text-emerald-200">NU Sawangan</p>
    </div>
    @if ($organizationLogo)
        <img src="{{ asset('storage/logo organisasi/' . $organizationLogo) }}" alt="Logo {{ $anggota->position }}" class="h-[11mm] w-[11mm] rounded-xl bg-white object-contain p-1">
    @else
        <div class="flex h-[11mm] w-[11mm] items-center justify-center rounded-xl bg-white text-[10px] font-black text-[#087A4B]">NU</div>
    @endif
</div>

<div class="relative mt-[4mm] flex items-center gap-3">
    @if ($anggota->photo)
        <img src="{{ asset('storage/' . $anggota->photo) }}" alt="Foto {{ $anggota->name }}" class="h-[23mm] w-[18mm] rounded-xl border-2 border-white/60 object-cover">
    @else
        <div class="flex h-[23mm] w-[18mm] items-center justify-center rounded-xl border-2 border-white/60 bg-white/15 text-lg font-black">
            {{ strtoupper(substr($anggota->name, 0, 2)) }}
        </div>
    @endif

    <div class="min-w-0">
        <h1 class="truncate text-[15px] font-black leading-tight">{{ $anggota->name }}</h1>
        <p class="mt-1 text-[9px] font-bold text-emerald-100">{{ $anggota->position ?: 'Anggota NU' }}</p>
        <p class="mt-0.5 truncate text-[8px] text-emerald-100/80">{{ $anggota->region ?: 'Wilayah Pusat / Umum' }}</p>
    </div>
</div>

<div class="relative mt-[3mm] flex items-end justify-between pr-[20mm] text-[7px] text-emerald-100">
    <span>Status: {{ ucfirst($anggota->status ?: 'Aktif') }}</span>
    <span class="text-right">{{ $anggota->joined_at ? \Carbon\Carbon::parse($anggota->joined_at)->format('d/m/Y') : 'Anggota Resmi' }}</span>
</div>

<img src="{{ $qrCode }}" alt="QR {{ $anggota->name }}" class="absolute bottom-[2.5mm] right-[4mm] h-[16mm] w-[16mm] rounded-md bg-white p-1">
