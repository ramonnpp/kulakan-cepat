@extends('sales/layouts.app')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Product Scanner</h1>
        <div id="status-indicator"
            class="px-4 py-2 rounded-lg text-white font-semibold text-sm bg-gray-500 transition-colors">
            Menunggu Kamera...
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        <div class="lg:col-span-3">
            <div class="bg-black p-4 rounded-2xl shadow-2xl relative w-full aspect-video overflow-hidden">
                <video id="video-scanner" class="w-full h-full object-cover" playsinline></video>
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="w-3/4 h-1/2 border-4 border-dashed border-white/30 rounded-2xl relative">
                        <div class="absolute w-full h-0.5 bg-red-500 animate-scan-line"></div>
                    </div>
                </div>
                <p id="feedback-text"
                    class="absolute bottom-4 left-4 text-white font-semibold bg-black/50 px-3 py-1 rounded-lg hidden"></p>
            </div>

            <div class="mt-6 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md">
                <label for="manual-barcode-input"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tidak bisa scan? Masukkan kode
                    secara manual:</label>
                <form id="manual-scan-form" class="flex gap-2">
                    <input type="text" id="manual-barcode-input" placeholder="Ketik kode barcode di sini..."
                        class="flex-grow w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 dark:text-white rounded-lg focus:ring-red-500 focus:border-red-500">
                    <button type="submit"
                        class="px-5 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-sm hover:bg-red-700">Tambah</button>
                </form>
                <p id="manual-error-message" class="text-red-500 text-sm mt-2 hidden">Barcode tidak ditemukan!</p>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md h-full flex flex-col">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Keranjang</h2>
                <div class="overflow-y-auto flex-grow">
                    <table class="min-w-full">
                        <tbody id="product-table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr id="empty-row">
                                <td colspan="3" class="py-16 text-center text-gray-400">
                                    <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M12 4v16m8-8H4"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M3.75 4.875c0-1.036.84-1.875 1.875-1.875h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 013.75 9.375v-4.5zM3.75 14.625c0-1.036.84-1.875 1.875-1.875h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 013.75 19.125v-4.5zM13.5 4.875c0-1.036.84-1.875 1.875-1.875h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 0113.5 9.375v-4.5zM13.5 14.625c0-1.036.84-1.875 1.875-1.875h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 0113.5 19.125v-4.5z">
                                        </path>
                                    </svg>
                                    <p class="mt-2">Arahkan kamera ke barcode</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-medium text-gray-600 dark:text-gray-300">Total:</span>
                        <span id="grand-total" class="text-2xl font-bold text-gray-900 dark:text-white">Rp 0</span>
                    </div>
                    <button
                        class="w-full text-center px-4 py-3 bg-red-600 text-white font-semibold rounded-lg text-sm hover:bg-red-700 transition duration-200">
                        Buat Pesanan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes scan-line-anim {
            0% {
                top: 0%;
            }

            100% {
                top: 100%;
            }
        }

        .animate-scan-line {
            animation: scan-line-anim 2.5s infinite alternate ease-in-out;
        }
    </style>
@endsection

@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@zxing/library@latest/umd/zxing.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const codeReader = new ZXing.BrowserMultiFormatReader();
            const videoElement = document.getElementById('video-scanner');
            const productTableBody = document.getElementById('product-table-body');
            const emptyRow = document.getElementById('empty-row');
            const grandTotalEl = document.getElementById('grand-total');
            const statusIndicator = document.getElementById('status-indicator');
            const feedbackText = document.getElementById('feedback-text');
            const manualScanForm = document.getElementById('manual-scan-form'); // Form manual
            const manualBarcode_input = document.getElementById('manual-barcode-input'); // Input manual
            const manualErrorMessage = document.getElementById('manual-error-message'); // Error manual
            const scanSound = new Audio('https://www.soundjay.com/buttons/sounds/button-3.mp3');

            // --- DATABASE PRODUK DUMMY ---
            const productsDB = {
                '8992761134013': {
                    name: 'Kopi Kapal Api Special 165g',
                    price: 15000
                },
                '8992753101103': {
                    name: 'Indomie Goreng Original',
                    price: 3500
                },
                '8992741990103': {
                    name: 'Teh Botol Sosro Kotak 250ml',
                    price: 4000
                },
                '8886303845012': {
                    name: 'Milo Activ-Go Cokelat 220ml',
                    price: 9000
                },
                '4902430707018': {
                    name: 'Pocari Sweat Kaleng 330ml',
                    price: 7500
                },
            };

            let scannedProducts = {};

            const formatRupiah = (number) => new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);

            const renderTable = () => {
                productTableBody.innerHTML = '';
                let grandTotal = 0;
                const barcodes = Object.keys(scannedProducts);
                if (barcodes.length === 0) {
                    productTableBody.innerHTML =
                        `<tr id="empty-row"><td colspan="3" class="py-16 text-center text-gray-400"><svg class="w-12 h-12 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4v16m8-8H4"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3.75 4.875c0-1.036.84-1.875 1.875-1.875h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 013.75 9.375v-4.5zM3.75 14.625c0-1.036.84-1.875 1.875-1.875h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 013.75 19.125v-4.5zM13.5 4.875c0-1.036.84-1.875 1.875-1.875h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 0113.5 9.375v-4.5zM13.5 14.625c0-1.036.84-1.875 1.875-1.875h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 0113.5 19.125v-4.5z"></path></svg><p class="mt-2">Arahkan kamera ke barcode</p></td></tr>`;
                } else {
                    barcodes.forEach(barcode => {
                        const item = scannedProducts[barcode];
                        const subtotal = item.product.price * item.qty;
                        grandTotal += subtotal;
                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td class="py-3 pr-3">
                        <p class="font-medium text-gray-900 dark:text-white">${item.product.name}</p>
                        <p class="text-xs text-gray-500">${barcode}</p>
                    </td>
                    <td class="py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                           <button data-barcode="${barcode}" class="qty-change-btn decrease bg-gray-200 dark:bg-gray-600 rounded-full w-6 h-6">-</button>
                           <span class="font-semibold w-4 text-center">${item.qty}</span>
                           <button data-barcode="${barcode}" class="qty-change-btn increase bg-gray-200 dark:bg-gray-600 rounded-full w-6 h-6">+</button>
                        </div>
                    </td>
                    <td class="py-3 text-right font-semibold text-gray-800 dark:text-white">${formatRupiah(subtotal)}</td>
                `;
                        productTableBody.appendChild(row);
                    });
                }
                grandTotalEl.textContent = formatRupiah(grandTotal);
            };

            const processBarcode = (barcode) => {
                const product = productsDB[barcode];
                if (!product) {
                    return false; // Mengembalikan false jika produk tidak ditemukan
                }

                scanSound.play();
                showFeedback(`${product.name} ditambahkan!`);

                if (scannedProducts[barcode]) {
                    scannedProducts[barcode].qty++;
                } else {
                    scannedProducts[barcode] = {
                        product: product,
                        qty: 1
                    };
                }
                renderTable();
                return true; // Mengembalikan true jika berhasil
            };

            productTableBody.addEventListener('click', function(e) {
                if (e.target.classList.contains('qty-change-btn')) {
                    const barcode = e.target.dataset.barcode;
                    if (e.target.classList.contains('increase')) {
                        scannedProducts[barcode].qty++;
                    } else if (e.target.classList.contains('decrease')) {
                        scannedProducts[barcode].qty--;
                        if (scannedProducts[barcode].qty <= 0) {
                            delete scannedProducts[barcode];
                        }
                    }
                    renderTable();
                }
            });

            let feedbackTimeout;
            const showFeedback = (message, isError = false) => {
                feedbackText.textContent = message;
                feedbackText.className =
                    `absolute bottom-4 left-4 font-semibold px-3 py-1 rounded-lg ${isError ? 'bg-red-500 text-white' : 'bg-green-500 text-white'}`;
                feedbackText.classList.remove('hidden');
                clearTimeout(feedbackTimeout);
                feedbackTimeout = setTimeout(() => feedbackText.classList.add('hidden'), 2000);
            };

            // Logika untuk form manual
            manualScanForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const barcode = manualBarcode_input.value.trim();
                if (!barcode) return;

                if (processBarcode(barcode)) {
                    manualBarcode_input.value = ''; // Berhasil, kosongkan input
                    manualErrorMessage.classList.add('hidden');
                } else {
                    manualErrorMessage.classList.remove('hidden'); // Gagal, tampilkan error
                }
            });

            // Mulai proses pemindaian kamera
            codeReader.listVideoInputDevices()
                .then((videoInputDevices) => {
                    if (videoInputDevices.length > 0) {
                        statusIndicator.textContent = 'Kamera Aktif';
                        statusIndicator.classList.replace('bg-gray-500', 'bg-green-500');

                        codeReader.decodeFromVideoDevice(videoInputDevices[0].deviceId, 'video-scanner', (
                            result, err) => {
                            if (result) {
                                processBarcode(result.getText());
                            }
                            if (err && !(err instanceof ZXing.NotFoundException)) {
                                console.error(err);
                                statusIndicator.textContent = 'Error Kamera';
                                statusIndicator.classList.replace('bg-green-500', 'bg-red-500');
                            }
                        });
                    } else {
                        statusIndicator.textContent = 'Kamera Tidak Ditemukan';
                        statusIndicator.classList.replace('bg-gray-500', 'bg-red-500');
                    }
                })
                .catch((err) => {
                    console.error(err);
                    statusIndicator.textContent = 'Izin Kamera Dibutuhkan';
                    statusIndicator.classList.replace('bg-gray-500', 'bg-yellow-500');
                });
        });
    </script>
@endpush
