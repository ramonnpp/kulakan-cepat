<!-- resources/views/pages/dukungan/pusat_bantuan.blade.php -->
@extends('layouts.app')

@section('title', 'Pusat Bantuan - KulakanCepat')

@section('content')
<div class="container mx-auto p-8">
    <h1 class="text-3xl font-bold mb-4">Pusat Bantuan</h1>
    <p class="text-lg mb-4">Temukan jawaban atas pertanyaan Anda di Pusat Bantuan kami. Kami menyediakan berbagai artikel dan panduan untuk membantu Anda.</p>
    <h2 class="text-2xl font-semibold mt-6 mb-3">Pertanyaan Umum</h2>
    <ul class="list-disc list-inside space-y-2">
        <li>Bagaimana cara mendaftar sebagai merchant?</li>
        <li>Bagaimana cara mencari produk?</li>
        <li>Bagaimana cara melakukan pembayaran?</li>
        <li>Bagaimana cara melacak pesanan?</li>
    </ul>
    <p class="mt-6">Tidak menemukan jawaban yang Anda cari? <a href="{{ url('/kontak') }}" class="text-blue-500 hover:underline">Hubungi kami</a>.</p>
</div>
@endsection
