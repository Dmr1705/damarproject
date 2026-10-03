@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8 pb-12">
        
        <!-- Header Banner -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-[#087A4B] text-xs font-bold mb-3 border border-emerald-100/60">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Modul Berita
                </div>
                <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">Tambah Berita Baru</h1>
                <p class="text-sm text-slate-500 mt-1">Buat dan publikasikan artikel atau informasi kegiatan terbaru.</p>
            </div>
            <div>
                <a href="{{ route('admin.berita.index') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-2xl border border-slate-200 shadow-sm transition-all active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm">
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Judul -->
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Judul Berita *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="Masukkan judul berita..." class="w-full px-4 py-3 bg-slate-50/60 border border-slate-200/80 focus:bg-white focus:border-[#087A4B] focus:ring-2 focus:ring-emerald-500/20 rounded-2xl text-sm transition-all text-slate-800 outline-none placeholder:text-slate-400 font-bold">
                    @error('title') <p class="text-xs text-red-600 mt-1.5 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Konten -->
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Isi Berita *</label>
                    <textarea name="content" rows="8" required placeholder="Tulis isi berita di sini..." class="w-full px-4 py-3 bg-slate-50/60 border border-slate-200/80 focus:bg-white focus:border-[#087A4B] focus:ring-2 focus:ring-emerald-500/20 rounded-2xl text-sm transition-all text-slate-800 outline-none placeholder:text-slate-400 font-medium">{{ old('content') }}</textarea>
                    @error('content') <p class="text-xs text-red-600 mt-1.5 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Status Publikasi *</label>
                    <select name="status" required class="w-full px-4 py-3 bg-slate-50/60 border border-slate-200/80 focus:bg-white focus:border-[#087A4B] focus:ring-2 focus:ring-emerald-500/20 rounded-2xl text-sm font-bold text-slate-700 cursor-pointer outline-none transition-all">
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published (Terbit)</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Simpan Sementara)</option>
                    </select>
                    @error('status') <p class="text-xs text-red-600 mt-1.5 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Gambar -->
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2">Gambar / Thumbnail (Opsional)</label>
                    <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/jpg" class="sr-only" aria-describedby="image-upload-help image-file-name">
                    <label for="image" id="image-dropzone" class="group flex min-h-56 w-full cursor-pointer flex-col items-center justify-center rounded-3xl border-2 border-dashed @error('image') border-red-300 bg-red-50/30 @else border-slate-200 bg-slate-50/50 hover:border-[#087A4B] @enderror p-6 transition-all focus-within:ring-2 focus-within:ring-emerald-500/40">
                        <div id="image-preview-container" class="hidden mb-4 w-full flex flex-col items-center">
                            <img id="image-preview" src="#" alt="Preview thumbnail" class="max-h-48 rounded-2xl border border-slate-200 object-cover shadow-sm">
                            <p id="image-file-name" class="mt-2 text-xs font-medium text-slate-500"></p>
                        </div>

                        <div id="image-placeholder" class="flex flex-col items-center text-center py-4">
                            <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-2xl border border-emerald-100 bg-emerald-50 text-[#087A4B] shadow-sm transition-transform group-hover:scale-110">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <p class="mb-1 text-sm font-bold text-slate-700">Klik untuk memilih gambar atau seret ke sini</p>
                            <p id="image-upload-help" class="text-xs text-slate-400">Format: JPG, PNG (Maks. 2MB)</p>
                        </div>
                    </label>
                    @error('image') <p class="text-xs text-red-600 mt-1.5 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Action Button -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.berita.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-2xl transition-all">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-[#087A4B] hover:bg-emerald-700 text-white font-bold text-xs rounded-2xl shadow-md shadow-emerald-500/20 transition-all active:scale-95">
                        Simpan Berita
                    </button>
                </div>
            </form>
        </div>

    </div>

    @push('scripts')
        <script>
            function previewNewsImage(event) {
                const file = event.target.files[0];
                if (!file) {
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (loadEvent) {
                    document.getElementById('image-preview').src = loadEvent.target.result;
                    document.getElementById('image-file-name').textContent = file.name;
                    document.getElementById('image-preview-container').classList.remove('hidden');
                    document.getElementById('image-placeholder').classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }

            const imageDropzone = document.getElementById('image-dropzone');
            const imageInput = document.getElementById('image');

            imageInput.addEventListener('change', previewNewsImage);

            imageDropzone.addEventListener('dragover', function (event) {
                event.preventDefault();
                imageDropzone.classList.add('border-[#087A4B]');
            });

            imageDropzone.addEventListener('dragleave', function () {
                imageDropzone.classList.remove('border-[#087A4B]');
            });

            imageDropzone.addEventListener('drop', function (event) {
                event.preventDefault();
                imageDropzone.classList.remove('border-[#087A4B]');

                if (event.dataTransfer.files.length > 0) {
                    imageInput.files = event.dataTransfer.files;
                    previewNewsImage({ target: imageInput });
                }
            });
        </script>
    @endpush
@endsection