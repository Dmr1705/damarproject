<x-admin-layout>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-[#17211B]">Edit Data Anggota</h2>
            <p class="text-sm text-[#66736B] mt-1">Perbarui informasi untuk <strong>{{ $anggota->name }}</strong>.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.anggota.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-[#E1E9E4] rounded-md font-semibold text-[#66736B] hover:bg-gray-50 hover:text-[#17211B] transition ease-in-out duration-150">
                Kembali
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-[#E1E9E4] shadow-sm overflow-hidden">
        <form action="{{ route('admin.anggota.update', $anggota->id) }}" method="POST" enctype="multipart/form-data" class="p-6 lg:p-8">
            @csrf
            @method('PUT') <!-- Method Spoofing untuk proses Update -->

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div class="col-span-1 md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-[#17211B] mb-1">Nama Lengkap *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $anggota->name) }}" required
                        class="w-full border-[#E1E9E4] focus:border-[#087A4B] focus:ring-[#087A4B] rounded-md shadow-sm">
                    @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Role / Badan Otonom -->
                <div>
                    <label for="role" class="block text-sm font-medium text-[#17211B] mb-1">Role / Badan Otonom *</label>
                    <select name="role" id="role" required
                        class="w-full border-[#E1E9E4] focus:border-[#087A4B] focus:ring-[#087A4B] rounded-md shadow-sm text-[#17211B]">
                        <option value="">Pilih Role / Banom</option>
                        <option value="Muslimat" {{ old('role', $anggota->position) == 'Muslimat' ? 'selected' : '' }}>Muslimat</option>
                        <option value="Fatayat" {{ old('role', $anggota->position) == 'Fatayat' ? 'selected' : '' }}>Fatayat</option>
                        <option value="GP Ansor" {{ old('role', $anggota->position) == 'GP Ansor' ? 'selected' : '' }}>GP Ansor</option>
                        <option value="IPNU" {{ old('role', $anggota->position) == 'IPNU' ? 'selected' : '' }}>IPNU</option>
                        <option value="IPPNU" {{ old('role', $anggota->position) == 'IPPNU' ? 'selected' : '' }}>IPPNU</option>
                        <option value="PMII" {{ old('role', $anggota->position) == 'PMII' ? 'selected' : '' }}>PMII</option>
                    </select>
                    @error('role') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Wilayah -->
                <div>
                    <label for="wilayah" class="block text-sm font-medium text-[#17211B] mb-1">Wilayah / Cabang</label>
                    <input type="text" name="wilayah" id="wilayah" value="{{ old('wilayah', $anggota->region) }}"
                        class="w-full border-[#E1E9E4] focus:border-[#087A4B] focus:ring-[#087A4B] rounded-md shadow-sm">
                    @error('wilayah') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-[#17211B] mb-1">Status Keanggotaan *</label>
                    <select name="status" id="status" required
                        class="w-full border-[#E1E9E4] focus:border-[#087A4B] focus:ring-[#087A4B] rounded-md shadow-sm text-[#17211B]">
                        <option value="Aktif" {{ old('status', $anggota->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Nonaktif" {{ old('status', $anggota->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="Pending" {{ old('status', $anggota->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Alumni" {{ old('status', $anggota->status) == 'Alumni' ? 'selected' : '' }}>Alumni</option>
                    </select>
                    @error('status') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Tanggal Bergabung -->
                <div>
                    <label for="joined_at" class="block text-sm font-medium text-[#17211B] mb-1">Tanggal Bergabung</label>
                    <input type="date" name="joined_at" id="joined_at" value="{{ old('joined_at', $anggota->joined_at ? \Carbon\Carbon::parse($anggota->joined_at)->format('Y-m-d') : '') }}"
                        class="w-full border-[#E1E9E4] focus:border-[#087A4B] focus:ring-[#087A4B] rounded-md shadow-sm">
                    @error('joined_at') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Visibilitas Publik -->
                <div>
                    <label for="is_public" class="block text-sm font-medium text-[#17211B] mb-1">Tampilkan di Publik? *</label>
                    <select name="is_public" id="is_public" required
                        class="w-full border-[#E1E9E4] focus:border-[#087A4B] focus:ring-[#087A4B] rounded-md shadow-sm text-[#17211B]">
                        <option value="1" {{ old('is_public', $anggota->is_public) == '1' ? 'selected' : '' }}>Ya, Tampilkan (Publik)</option>
                        <option value="0" {{ old('is_public', $anggota->is_public) == '0' ? 'selected' : '' }}>Tidak, Sembunyikan (Privat)</option>
                    </select>
                    @error('is_public') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Foto Profile -->
                <div class="col-span-1 md:col-span-2 flex items-start space-x-4">
                    @if($anggota->photo)
                        <div class="flex-shrink-0">
                            <img src="{{ asset('storage/' . $anggota->photo) }}" alt="Foto Lama" class="h-20 w-20 rounded-lg object-cover border border-[#E1E9E4]">
                        </div>
                    @endif
                    <div class="flex-grow">
                        <label for="photo" class="block text-sm font-medium text-[#17211B] mb-1">Ganti Foto Profil (Opsional)</label>
                        <input type="file" name="photo" id="photo" accept="image/jpeg,image/png,image/jpg"
                            class="w-full border border-[#E1E9E4] rounded-md shadow-sm text-sm text-[#66736B] file:mr-4 file:py-2 file:px-4 file:rounded-l-md file:border-0 file:text-sm file:font-semibold file:bg-[#E9F7EF] file:text-[#087A4B] hover:file:bg-[#d4f0df]">
                        <p class="text-xs text-[#66736B] mt-1">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG. Maksimal 2MB.</p>
                        @error('photo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-8 border-t border-[#E1E9E4] pt-6 flex justify-end gap-4">
                <a href="{{ route('admin.anggota.index') }}" class="px-4 py-2 bg-white border border-[#E1E9E4] rounded-md font-medium text-[#66736B] hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-[#087A4B] border border-transparent rounded-md font-semibold text-white hover:bg-[#065C39] focus:ring-2 focus:ring-[#087A4B] focus:ring-offset-2 transition ease-in-out duration-150">
                    Perbarui Data
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>