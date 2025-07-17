<!-- resources/views/pages/dukungan/kebijakan_privasi.blade.php -->
@extends('layouts.app')

@section('title', 'Kebijakan Privasi - KulakanCepat')

@section('content')
<div class="container mx-auto p-8">
    <h1 class="text-3xl font-bold mb-4">Kebijakan Privasi</h1>
    <p class="text-lg mb-4">KulakanCepat berkomitmen untuk melindungi privasi data pribadi Anda. Kebijakan ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi Anda.</p>
    <div class="prose max-w-none">
        <h2 class="text-2xl font-semibold mt-6 mb-3">1. Informasi yang Kami Kumpulkan</h2>
        <p>Kami mengumpulkan informasi yang Anda berikan secara langsung, seperti nama, alamat email, nomor telepon, dan detail pembayaran saat Anda mendaftar atau menggunakan layanan kami.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-3">2. Bagaimana Kami Menggunakan Informasi Anda</h2>
        <p>Informasi yang kami kumpulkan digunakan untuk menyediakan, memelihara, dan meningkatkan layanan kami, memproses transaksi, dan berkomunikasi dengan Anda.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-3">3. Pembagian Informasi</h2>
        <p>Kami tidak akan menjual atau menyewakan informasi pribadi Anda kepada pihak ketiga. Kami dapat membagikan informasi dengan penyedia layanan yang bekerja atas nama kami untuk menjalankan fungsi tertentu.</p>
        <!-- Tambahkan lebih banyak poin jika diperlukan -->
    </div>
    <p class="mt-8">Untuk pertanyaan tentang kebijakan privasi, silakan <a href="{{ url('/dukungan/kontak') }}" class="text-blue-500 hover:underline">hubungi kami</a>.</p>
</div>
@endsection
