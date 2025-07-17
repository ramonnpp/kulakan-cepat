<!-- resources/views/pages/dukungan/syarat_ketentuan.blade.php -->
@extends('layouts.app')

@section('title', 'Syarat & Ketentuan - KulakanCepat')

@section('content')
<div class="container mx-auto p-8">
    <h1 class="text-3xl font-bold mb-4">Syarat & Ketentuan</h1>
    <p class="text-lg mb-4">Dengan menggunakan layanan KulakanCepat, Anda setuju untuk terikat oleh syarat dan ketentuan berikut:</p>
    <div class="prose max-w-none">
        <h2 class="text-2xl font-semibold mt-6 mb-3">1. Penggunaan Layanan</h2>
        <p>Pengguna wajib mematuhi semua hukum dan peraturan yang berlaku saat menggunakan platform KulakanCepat. Dilarang keras menggunakan layanan ini untuk tujuan ilegal atau tidak sah.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-3">2. Akun Pengguna</h2>
        <p>Anda bertanggung jawab untuk menjaga kerahasiaan informasi akun Anda dan untuk semua aktivitas yang terjadi di bawah akun Anda.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-3">3. Konten Pengguna</h2>
        <p>Setiap konten yang Anda unggah ke platform KulakanCepat harus mematuhi standar komunitas kami dan tidak boleh melanggar hak cipta atau kekayaan intelektual pihak lain.</p>
        <!-- Tambahkan lebih banyak poin jika diperlukan -->
    </div>
    <p class="mt-8">Untuk pertanyaan lebih lanjut, silakan <a href="{{ url('/dukungan/kontak') }}" class="text-blue-500 hover:underline">hubungi kami</a>.</p>
</div>
@endsection
