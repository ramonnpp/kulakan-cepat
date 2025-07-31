@extends('sales/layouts.app')

@section('content')
    <div x-data="qrCodePage" class="bg-gray-50 dark:bg-gray-900 min-h-screen py-8">
        <div class="container mx-auto px-4">

            {{-- Header Halaman --}}
            <header class="mb-8">
                <div
                    class="flex flex-col sm:flex-row justify-between items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm">
                    <div class="text-center sm:text-left">
                        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Galeri QR Code</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Unduh atau cetak semua QR code produk Anda
                            di sini.</p>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        {{-- Tombol Kembali --}}
                        <a href="{{ route('sales.scanner') }}"
                            class="no-print flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white font-semibold rounded-lg shadow-sm hover:bg-gray-100 dark:hover:bg-gray-600 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Scanner</span>
                        </a>
                        {{-- Tombol Cetak --}}
                        <button onclick="window.print()"
                            class="no-print flex items-center gap-2 px-4 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-sm hover:bg-red-700 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5 4v3H4a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7V9h6v3z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Cetak Semua</span>
                        </button>
                    </div>
                </div>
            </header>

            {{-- Grid Kartu QR --}}
            <main class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6"
                id="qr-code-grid">
                @forelse ($products as $product)
                    <div
                        class="qr-card group relative bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-xl hover:-translate-y-1">
                        <div class="p-5 flex flex-col items-center justify-center">
                            {{-- Area Gambar QR Code --}}
                            <div class="qr-code-container p-3 bg-white rounded-lg border border-gray-100 mb-4">
                                {!! QrCode::size(150)->generate($product->SKU) !!}
                            </div>

                            {{-- Info Produk --}}
                            <div class="text-center">
                                <h3 class="font-bold text-md text-gray-900 dark:text-white leading-tight">
                                    {{ $product->name_product }}</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-mono">SKU: {{ $product->SKU }}
                                </p>
                            </div>
                        </div>

                        {{-- Tombol Download --}}
                        <div
                            class="absolute inset-x-0 bottom-0 p-3 bg-white/50 dark:bg-black/30 backdrop-blur-sm transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                            <button
                                @click="downloadQRCode($event.currentTarget.closest('.qr-card'), '{{ $product->SKU }}_qrcode.png')"
                                class="no-print w-full flex items-center justify-center gap-2 px-3 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                                    <path
                                        d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                                </svg>
                                <span>Unduh</span>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20 bg-white dark:bg-gray-800 rounded-2xl shadow-sm">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Produk Kosong</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada produk untuk ditampilkan.</p>
                    </div>
                @endforelse
            </main>
        </div>
    </div>

    <style>
        @media print {
            body {
                background-color: white !important;
            }

            .no-print {
                display: none !important;
            }

            main#qr-code-grid {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                gap: 0.5rem;
            }

            .qr-card {
                box-shadow: none !important;
                border: 1px solid #EEE;
                break-inside: avoid;
                page-break-inside: avoid;
                transform: none !important;
            }

            .dark .dark\:bg-gray-800,
            .dark .dark\:bg-gray-900 {
                background-color: white !important;
            }

            .dark .dark\:text-white,
            .dark .dark\:text-gray-400 {
                color: black !important;
            }
        }
    </style>
@endsection

@push('scripts')
    {{-- Library untuk mengubah HTML ke Gambar --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html-to-image/1.11.11/html-to-image.min.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('qrCodePage', () => ({
                downloadQRCode(element, fileName) {
                    const container = element.querySelector('.p-5');

                    htmlToImage.toPng(container, {
                            quality: 1,
                            backgroundColor: '#FFFFFF',
                            pixelRatio: 3
                        })
                        .then(function(dataUrl) {
                            const link = document.createElement('a');
                            link.download = fileName;
                            link.href = dataUrl;
                            link.click();
                        })
                        .catch(function(error) {
                            console.error('Maaf, terjadi kesalahan saat membuat gambar.', error);
                            alert('Gagal mengunduh gambar. Silakan coba lagi.');
                        });
                }
            }));
        });
    </script>
@endpush
