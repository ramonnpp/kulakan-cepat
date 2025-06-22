@extends('sales/layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Materi Penjualan</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">Dokumen & Materi Pendukung Penjualan</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            <div
                class="group bg-gray-50 dark:bg-gray-700/50 rounded-lg p-5 flex flex-col items-center text-center transform transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                <div class="mb-4 text-red-500 dark:text-red-400">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-4V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-md font-semibold text-gray-900 dark:text-white mb-2">Panduan Produk Q3 2025</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Detail produk baru, fitur unggulan, dan keunggulan
                    kompetitif.</p>
                <a href="#"
                    class="mt-auto w-full text-center px-4 py-2 bg-red-600 text-white font-semibold rounded-md text-sm hover:bg-red-700 transition duration-200 group-hover:scale-105">
                    Unduh PDF
                </a>
            </div>

            <div
                class="group bg-gray-50 dark:bg-gray-700/50 rounded-lg p-5 flex flex-col items-center text-center transform transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                <div class="mb-4 text-blue-500 dark:text-blue-400">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M4.632 3.533A2 2 0 016.277 2.333h7.446a2 2 0 011.645 1.2l2.392 5.98a2 2 0 01-1.645 2.8l-7.446.001a2 2 0 01-1.645-1.2L2.24 8.333a2 2 0 011.645-2.8l.747-1.866zM2.25 13.001a2 2 0 011.645-1.2l7.446-.001a2 2 0 011.645 1.2l.001.002a2 2 0 01-1.645 2.8l-7.446.001a2 2 0 01-1.645-2.8l-.001-.002z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-md font-semibold text-gray-900 dark:text-white mb-2">Presentasi Grosir</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Slide untuk menjelaskan paket penawaran grosir
                    kepada calon pelanggan.</p>
                <a href="#"
                    class="mt-auto w-full text-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md text-sm hover:bg-blue-700 transition duration-200 group-hover:scale-105">
                    Unduh PPTX
                </a>
            </div>

            <div
                class="group bg-gray-50 dark:bg-gray-700/50 rounded-lg p-5 flex flex-col items-center text-center transform transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                <div class="mb-4 text-green-500 dark:text-green-400">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.732 3.732a1 1 0 00-1.414 0l-5.5 5.5a1 1 0 000 1.414l5.5 5.5a1 1 0 001.414-1.414L6.914 11H16a1 1 0 100-2H6.914l4.818-4.818a1 1 0 000-1.414z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-md font-semibold text-gray-900 dark:text-white mb-2">Studi Kasus Toko A</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Contoh nyata bagaimana produk kita membantu
                    meningkatkan omset pelanggan.</p>
                <a href="#"
                    class="mt-auto w-full text-center px-4 py-2 bg-green-600 text-white font-semibold rounded-md text-sm hover:bg-green-700 transition duration-200 group-hover:scale-105">
                    Unduh DOCX
                </a>
            </div>

            <div
                class="group bg-gray-50 dark:bg-gray-700/50 rounded-lg p-5 flex flex-col items-center text-center transform transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                <div class="mb-4 text-purple-500 dark:text-purple-400">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-md font-semibold text-gray-900 dark:text-white mb-2">Video Tutorial Aplikasi</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Video pendek untuk membantu pelanggan menggunakan
                    aplikasi pemesanan.</p>
                <a href="#"
                    class="mt-auto w-full text-center px-4 py-2 bg-purple-600 text-white font-semibold rounded-md text-sm hover:bg-purple-700 transition duration-200 group-hover:scale-105">
                    Tonton MP4
                </a>
            </div>

        </div>
    </div>
@endsection
