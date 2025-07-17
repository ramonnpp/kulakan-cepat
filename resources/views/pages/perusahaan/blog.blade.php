<!-- resources/views/pages/perusahaan/blog.blade.php -->
@extends('layouts.app')

@section('title', 'Blog - KulakanCepat')

@section('content')
<div class="container mx-auto p-8">
    <h1 class="text-3xl font-bold mb-4">Blog KulakanCepat</h1>
    <p class="text-lg mb-4">Baca artikel terbaru kami tentang tren bisnis, tips untuk merchant dan toko, serta berita terkini dari KulakanCepat.</p>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        <!-- Contoh Artikel 1 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-2">Strategi Jitu Meningkatkan Penjualan Toko Retail</h3>
            <p class="text-gray-600 text-sm mb-4">Pelajari tips dan trik untuk mengoptimalkan penjualan di toko retail Anda.</p>
            <a href="#" class="text-blue-500 hover:underline">Baca Selengkapnya</a>
        </div>
        <!-- Contoh Artikel 2 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-2">Manfaat Bergabung Sebagai Merchant di KulakanCepat</h3>
            <p class="text-gray-600 text-sm mb-4">Temukan keuntungan menjadi bagian dari jaringan merchant kami.</p>
            <a href="#" class="text-blue-500 hover:underline">Baca Selengkapnya</a>
        </div>
    </div>
    <p class="mt-8">Lihat semua artikel di <a href="#" class="text-blue-500 hover:underline">arsip blog</a>.</p>
</div>
@endsection
    