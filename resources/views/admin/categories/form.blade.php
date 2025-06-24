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
</div>