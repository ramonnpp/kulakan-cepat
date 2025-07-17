<div class="space-y-6">
    {{-- Nama Kategori --}}
    <div>
        <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Kategori <span class="text-red-500">*</span></label>
        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name', $category->name ?? '') }}"
            class="w-full px-3 py-2 text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm focus:ring-primary/50 focus:border-primary/50 @error('name') border-red-500 @enderror"
            placeholder="Masukkan nama kategori"
            required>
        @error('name')
            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Deskripsi Kategori (Opsional) --}}
    <div>
        <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Deskripsi Kategori</label>
        <textarea
            name="description"
            id="description"
            rows="4"
            class="w-full px-3 py-2 text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-sm focus:ring-primary/50 focus:border-primary/50 @error('description') border-red-500 @enderror"
            placeholder="Masukkan deskripsi kategori (opsional)">{{ old('description', $category->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Input Icon BARU --}}
    <div>
        <label for="icon" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Ikon Kategori</label>
        <input type="file" name="icon" id="icon" class="mt-1 block w-full text-sm text-gray-500
            file:mr-4 file:py-2 file:px-4
            file:rounded-lg file:border-0
            file:text-sm file:font-semibold
            file:bg-red-50 file:text-red-700
            hover:file:bg-red-100
        "/>
        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Kosongkan jika tidak ingin mengubah ikon.</p>
        @error('icon')
            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Preview Ikon Saat Ini (hanya untuk halaman edit) --}}
    @if(isset($category) && $category->icon)
    <div class="mt-2">
        <p class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Ikon Saat Ini:</p>
        <img src="{{ Storage::url($category->icon) }}" alt="Ikon {{ $category->name }}" class="h-16 w-16 rounded-md object-cover border p-1">
    </div>
    @endif
</div>