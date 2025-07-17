@extends('admin.layouts.app')

@section('title', 'Manajemen Kategori Produk')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header Halaman --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">Manajemen Kategori Produk</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Kelola semua kategori untuk produk Anda.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-800/50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                <span>Tambah Kategori</span>
            </a>
        </div>
    </div>

    <!-- @if (session('success'))<div class="mb-4 px-4 py-3 leading-normal text-green-700 bg-green-100 dark:text-green-100 dark:bg-green-700/30 rounded-lg" role="alert"><p>{{ session('success') }}</p></div>@endif -->
    
    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 shadow-md rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
    <thead class="text-xs text-slate-500 dark:text-slate-400 uppercase bg-slate-50 dark:bg-slate-800">
        <tr>
            {{-- Tambahkan header kolom baru untuk Ikon --}}
            <th class="px-5 py-3 text-left font-semibold">Ikon</th>
            <th class="px-5 py-3 text-left font-semibold">Nama Kategori</th>
            <th class="px-5 py-3 text-left font-semibold">Deskripsi</th>
            <th class="px-5 py-3 text-center font-semibold">Jumlah Produk</th>
            <th class="px-5 py-3 text-right font-semibold">Aksi</th>
        </tr>
    </thead>
    <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700">
        @forelse ($categories as $category)
        <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/50 transition-colors">
            {{-- Tambahkan data sel baru untuk Ikon --}}
            <td class="px-5 py-4">
                @if($category->icon)
                    <img src="{{ Storage::url($category->icon) }}" alt="{{ $category->name }}" class="h-10 w-10 rounded-full object-cover">
                @else
                    <div class="h-10 w-10 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-slate-400 text-xs">
                        N/A
                    </div>
                @endif
            </td>
            <td class="px-5 py-4 whitespace-nowrap">
                <div class="font-medium text-slate-800 dark:text-slate-100">{{ $category->name }}</div>
            </td>
            <td class="px-5 py-4 text-slate-600 dark:text-slate-300 max-w-sm truncate">{{ Str::limit($category->description, 70) ?? '-' }}</td>
            <td class="px-5 py-4 whitespace-nowrap text-center text-slate-600 dark:text-slate-300">
                {{ $category->products_count ?? 0 }}
            </td>
            <td class="px-5 py-4 whitespace-nowrap text-right text-sm">
                {{-- Aksi --}}
                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('admin.categories.edit', $category->id_product_category) }}" class="p-1.5 text-yellow-600 hover:text-yellow-500 dark:text-yellow-400 dark:hover:text-yellow-300 rounded-md hover:bg-yellow-100 dark:hover:bg-yellow-500/20 transition-colors" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category->id_product_category) }}" method="POST" class="inline" onsubmit="return confirm('Anda yakin ingin menghapus kategori ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300 rounded-md hover:bg-red-100 dark:hover:bg-red-500/20 transition-colors" title="Hapus">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="px-5 py-10 text-center text-sm text-slate-500 dark:text-slate-400">Tidak ada kategori produk ditemukan.</td></tr>
        @endforelse
    </tbody>
</table>
        </div>
        @if (isset($categories) && $categories->hasPages())
            <div class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">
                {{ $categories->appends(request()->query())->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</div>

@endsection