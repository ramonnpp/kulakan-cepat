@extends('admin.layouts.app')

@section('title', 'Tambah Kategori Produk')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header Halaman --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">Tambah Kategori Produk</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Tambahkan kategori produk baru ke dalam sistem.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-slate-700 bg-slate-200 rounded-lg shadow-sm hover:bg-slate-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-400/50 transition-colors dark:bg-slate-700 dark:text-slate-200 dark:hover:bg-slate-600 dark:focus:ring-slate-500/50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                <span>Kembali ke Daftar Kategori</span>
            </a>
        </div>
    </div>

    @if ($errors->any())<div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-red-500/20 dark:text-red-400" role="alert"><span class="font-medium">Oops!</span> Terjadi beberapa kesalahan dengan input Anda.</div>@endif

    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 shadow-md rounded-xl p-5">
        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.categories.form')
            <div class="mt-6 flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-800/50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                    <span>Simpan Kategori</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection