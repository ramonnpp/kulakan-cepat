<!-- resources/views/pages/perusahaan/press_release.blade.php -->
@extends('layouts.app')

@section('title', 'Press Release - KulakanCepat')

@section('content')
<div class="container mx-auto p-8">
    <h1 class="text-3xl font-bold mb-4">Press Release</h1>
    <p class="text-lg mb-4">Temukan berita resmi dan pengumuman terbaru dari KulakanCepat.</p>
    <div class="space-y-6 mt-6">
        <!-- Contoh Press Release 1 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-2">KulakanCepat Raih Pendanaan Seri A untuk Ekspansi Nasional</h3>
            <p class="text-gray-600 text-sm mb-2">Tanggal: 15 Juli 2025</p>
            <p class="text-gray-700">KulakanCepat, platform grosir digital terdepan, hari ini mengumumkan keberhasilan dalam meraih pendanaan Seri A...</p>
            <a href="#" class="text-blue-500 hover:underline mt-2 inline-block">Baca Selengkapnya</a>
        </div>
        <!-- Contoh Press Release 2 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-2">Kolaborasi KulakanCepat dan Asosiasi Retail Indonesia</h3>
            <p class="text-gray-600 text-sm mb-2">Tanggal: 10 Juni 2025</p>
            <p class="text-gray-700">Dalam upaya memperkuat ekosistem retail, KulakanCepat menjalin kemitraan strategis dengan Asosiasi Retail Indonesia...</p>
            <a href="#" class="text-blue-500 hover:underline mt-2 inline-block">Baca Selengkapnya</a>
        </div>
    </div>
    <p class="mt-8">Untuk pertanyaan media, silakan <a href="{{ url('/dukungan/kontak') }}" class="text-blue-500 hover:underline">hubungi kami</a>.</p>
</div>
@endsection
