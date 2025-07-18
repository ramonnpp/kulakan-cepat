<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Konfirmasi - KulakanCepat</title>
    {{-- Memanggil CSS dari Vite --}}
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-2xl p-8 lg:p-10 w-full max-w-md text-center border border-gray-200/50 dark:border-gray-700">
        {{-- Ikon Ceklis Hijau --}}
        <div class="text-green-500 mb-4">
            <svg class="mx-auto h-16 w-16" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        {{-- Judul Notifikasi --}}
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
            Pendaftaran Berhasil!
        </h1>

        {{-- Pesan Informasi --}}
        <p class="text-gray-600 dark:text-gray-300 mb-6 px-4">
            Terima kasih, data Anda telah kami terima. Akun Anda sedang dalam proses peninjauan oleh Admin dan tinggal menunggu konfirmasi.
        </p>

        {{-- Tombol Kembali ke Login --}}
        <a href="{{ route('sales.login') }}"
           class="w-full block bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded-lg text-sm font-medium transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            Kembali ke Halaman Login
        </a>
    </div>

</body>
</html>