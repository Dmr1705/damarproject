<x-admin-layout>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-[#17211B]">Edit Berita</h2>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.berita.index') }}" class="px-4 py-2 bg-white border border-[#E1E9E4] rounded-md font-semibold text-[#66736B] hover:bg-gray-50">Kembali</a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-[#E1E9E4] shadow-sm overflow-hidden">
        <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data" class="p-6 lg:p-8">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <!-- Judul -->
                <div>
                    <label class="block text-sm font-medium text-[#17211B] mb-1">Judul Berita *</label>
                    <input type="text" name="title" value="{{ old('title', $berita->title) }}" required class="w-full border-[#E1E9E4] rounded-md shadow-sm focus:border-[#087A4B] focus:ring-[#087A4B]">
                    @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Konten -->
                <div>
                    <label class="block text-sm font-medium text-[#17211B] mb-1">Isi Berita *</label>
                    <textarea name="content" rows="8" required class="w-full border-[#E1E9E4] rounded-md shadow-sm focus:border-[#087A4B] focus:ring-[#087A4B]">{{ old('content', $berita->content) }}</textarea>
                    @error('content') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-[#17211B] mb-1">Status Publikasi *</label>
                    <select name="status" required class="w-full border-[#E1E9E4] rounded-md shadow-sm focus:border-[#087A4B] focus:ring-[#087A4B]">
                        <option value="published" {{ old('status', $berita->status) == 'published' ? 'selected' : '' }}>Published (Terbit)</option>
                        <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>Draft (Simpan Sementara)</option>
                    </select>
                    @error('status') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Gambar -->
                <div>
                    @if($berita->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $berita->image) }}" class="h-32 rounded border border-[#E1E9E4] object-cover">
                        </div>
                    @endif
                    <label class="block text-sm font-medium text-[#17211B] mb-1">Ganti Gambar (Opsional)</label>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/jpg" class="w-full border border-[#E1E9E4] rounded-md shadow-sm text-sm file:mr-4 file:py-2 file:px-4 file:bg-[#E9F7EF] file:text-[#087A4B] file:border-0 file:rounded-l-md hover:file:bg-[#d4f0df]">
                    <p class="text-xs text-[#66736B] mt-1">Biarkan kosong jika tidak ingin mengganti gambar.</p>
                    @error('image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-8 border-t border-[#E1E9E4] pt-6 flex justify-end">
                <button type="submit" class="px-6 py-2 bg-[#087A4B] text-white rounded-md font-semibold hover:bg-[#065C39]">Perbarui Berita</button>
            </div>
        </form>
    </div>
</x-admin-layout>