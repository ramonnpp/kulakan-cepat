@extends('sales.layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header Halaman --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Materi Penjualan</h1>
        <div class="w-full md:w-1/2 lg:w-1/3">
            <form action="{{ route('sales.sales_material.index') }}" method="GET">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari materi..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6">
        {{-- Filter Kategori --}}
        <div class="col-span-12 md:col-span-3">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Kategori</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('sales.sales_material.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ !request('category') ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            Semua Materi
                        </a>
                    </li>
                    @foreach($categories as $category)
                    <li>
                        <a href="{{ route('sales.sales_material.index', ['category' => $category]) }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request('category') == $category ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            {{ $category }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Daftar Materi --}}
        <div class="col-span-12 md:col-span-9">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($materials as $material)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transform transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg">
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @switch($material['file_type'])
                                    @case('PDF') bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300 @break
                                    @case('PPTX') bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300 @break
                                    @case('XLSX') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 @break
                                    @case('MP4') bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300 @break
                                    @default bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                @endswitch">
                                {{ $material['file_type'] }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $material['size'] }}</span>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800 dark:text-white truncate" title="{{ $material['title'] }}">
                            {{ $material['title'] }}
                        </h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Diunggah: {{ \Carbon\Carbon::parse($material['upload_date'])->isoFormat('D MMMM YYYY') }}
                        </p>
                    </div>
                    <a href="{{ $material['url'] }}" download class="block bg-gray-50 dark:bg-gray-700/50 px-5 py-3 text-sm font-semibold text-center text-blue-600 dark:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        Unduh Materi
                    </a>
                </div>
                @empty
                <div class="col-span-full text-center py-20">
                    <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200">Materi Tidak Ditemukan</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-2">Coba kata kunci atau kategori lain.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection