<!-- resources/views/pages/dukungan/kontak.blade.php -->
@extends('layouts.app')

@section('title', 'Kontak - KulakanCepat')

@section('content')
<div class="container mx-auto p-8">
    <h1 class="text-3xl font-bold mb-4">Hubungi Kami</h1>
    <p class="text-lg mb-4">Kami siap membantu Anda. Silakan hubungi kami melalui salah satu metode di bawah ini:</p>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">
        <div>
            <h2 class="text-2xl font-semibold mb-3">Informasi Kontak</h2>
            <p class="mb-2"><strong>Email:</strong> <a href="mailto:info@kulakancepat.com" class="text-blue-500 hover:underline">info@kulakancepat.com</a></p>
            <p class="mb-2"><strong>Telepon:</strong> +62 812-3456-7890</p>
            <p class="mb-2"><strong>Alamat:</strong> Jl. Contoh No. 123, Jakarta, Indonesia</p>
        </div>
        <div>
            <h2 class="text-2xl font-semibold mb-3">Formulir Kontak</h2>
            <form class="space-y-4">
                <div>
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap:</label>
                    <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Nama Anda">
                </div>
                <div>
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <input type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Email Anda">
                </div>
                <div>
                    <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Pesan:</label>
                    <textarea id="message" name="message" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Tulis pesan Anda di sini"></textarea>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Kirim Pesan</button>
            </form>
        </div>
    </div>
</div>
@endsection
