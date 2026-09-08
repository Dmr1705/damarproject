@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8 pb-12">
        
        <!-- Header Banner -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-[#087A4B] text-xs font-bold mb-3 border border-emerald-100/60">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Modul Galeri & Dokumentasi
                </div>
                <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">Edit Foto Galeri</h1>
                <p class="text-sm text-slate-500 mt-1">Perbarui informasi, kategori, atau ganti foto dokumentasi.</p>
            </div>
            <div>
                <a href="{{ route('admin.galeri.index') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-2xl transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-6 md:p-8">
            
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl text-sm font-semibold">
                    <p class="font-bold mb-1">Terjadi kesalahan input:</p>
                    <ul class="list-disc list-inside space-y-1 text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Kategori Organisasi -->
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Kategori Organisasi <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <select name="category" class="w-full px-4 py-3 bg-slate-50/60 border border-slate-200/80 focus:bg-white focus:border-[#087A4B] focus:ring-2 focus:ring-emerald-500/20 rounded-2xl text-sm font-bold text-slate-800 outline-none transition-all">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Muslimat" {{ old('category', $galeri->category) == 'Muslimat' ? 'selected' : '' }}>Muslimat</option>
                        <option value="Fatayat" {{ old('category', $galeri->category) == 'Fatayat' ? 'selected' : '' }}>Fatayat</option>
                        <option value="GP Ansor" {{ old('category', $galeri->category) == 'GP Ansor' ? 'selected' : '' }}>GP Ansor</option>
                        <option value="IPNU" {{ old('category', $galeri->category) == 'IPNU' ? 'selected' : '' }}>IPNU</option>
                        <option value="IPPNU" {{ old('category', $galeri->category) == 'IPPNU' ? 'selected' : '' }}>IPPNU</option>
                        <option value="PMII" {{ old('category', $galeri->category) == 'PMII' ? 'selected' : '' }}>PMII</option>
                    </select>
                </div>

                <!-- Judul / Keterangan -->
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Judul / Keterangan Foto <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <input type="text" name="title" value="{{ old('title', $galeri->title) }}" placeholder="Contoh: Kegiatan Pengajian Rutin" class="w-full px-4 py-3 bg-slate-50/60 border border-slate-200/80 focus:bg-white focus:border-[#087A4B] focus:ring-2 focus:ring-emerald-500/20 rounded-2xl text-sm font-bold text-slate-800 outline-none transition-all placeholder:text-slate-400">
                </div>

                <!-- Upload File Foto -->
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Ganti File Foto <span class="text-slate-400 font-normal">(Opsional, biarkan kosong jika tidak diubah)</span></label>
                    
                    <div class="flex flex-col items-center justify-center border-2 border-dashed border-slate-200 hover:border-[#087A4B] rounded-3xl p-6 bg-slate-50/50 transition-all group relative cursor-pointer" onclick="document.getElementById('photo-input').click()">
                        
                        <!-- Existing / Preview Container -->
                        <div id="preview-container" class="mb-4 w-full flex flex-col items-center">
                            <img id="image-preview" src="{{ $galeri->photo ? asset('storage/' . $galeri->photo) : '#' }}" alt="Preview" class="max-h-48 rounded-2xl object-cover shadow-sm border border-slate-200 {{ $galeri->photo ? '' : 'hidden' }}">
                            <p class="text-xs text-slate-500 mt-2 font-medium" id="file-name">{{ $galeri->photo ? 'Foto saat ini' : '' }}</p>
                        </div>

                        <!-- Default Prompt -->
                        <div id="upload-placeholder" class="{{ $galeri->photo ? 'hidden' : 'flex' }} flex-col items-center text-center py-4">
                            <div class="w-14 h-14 bg-emerald-50 text-[#087A4B] rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-sm border border-emerald-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-700 mb-1">Klik untuk mengganti foto atau seret ke sini</p>
                            <p class="text-xs text-slate-400">Format: JPG, PNG, JPEG (Maks. 2MB)</p>
                        </div>

                        <input type="file" name="photo" id="photo-input" accept="image/*" class="hidden" onchange="previewImage(event)">
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.galeri.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm rounded-2xl transition-all">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-[#087A4B] hover:bg-emerald-700 text-white font-bold text-sm rounded-2xl shadow-md shadow-emerald-500/20 transition-all">
                        Perbarui Foto
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgPreview = document.getElementById('image-preview');
                    imgPreview.src = e.target.result;
                    imgPreview.classList.remove('hidden');
                    document.getElementById('file-name').textContent = file.name;
                    document.getElementById('preview-container').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
    @endpush
@endsection