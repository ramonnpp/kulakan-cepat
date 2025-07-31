@extends('sales/layouts.app')

@section('content')
    <div x-data="scannerApp" x-init="init()" class="max-w-7xl mx-auto py-1 px-4 sm:px-6 lg:px-8">

        {{-- Header Halaman --}}
        <header class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Product Scanner</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pindai produk, pilih pelanggan, dan selesaikan
                        transaksi dengan cepat.</p>
                </div>
                <a href="{{ route('sales.products.qr') }}"
                    class="flex-shrink-0 flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white font-semibold rounded-lg shadow-sm hover:bg-gray-100 dark:hover:bg-gray-600 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                        <path
                            d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                    </svg>
                    <span>Galeri QR Code</span>
                </a>
            </div>
        </header>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <main class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <div class="lg:col-span-3">
                <div class="bg-gray-900 p-2 sm:p-4 rounded-2xl shadow-2xl relative w-full aspect-video overflow-hidden">
                    <video id="video-scanner" class="w-full h-full object-cover rounded-xl" playsinline></video>
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="w-3/4 h-3/4 border-4 border-dashed border-white/20 rounded-2xl relative">
                            <div class="absolute w-full h-0.5 bg-red-500/80 shadow-[0_0_15px_red] animate-scan-line"></div>
                        </div>
                    </div>
                    <div id="status-indicator"
                        class="absolute top-4 left-4 px-3 py-1.5 rounded-full text-white font-semibold text-xs bg-gray-600/70 backdrop-blur-sm transition-colors shadow-lg">
                        Memulai Kamera...
                    </div>
                    <p x-show="feedback.message" x-text="feedback.message" x-cloak
                        :class="feedback.isError ? 'bg-red-600' : 'bg-green-500'"
                        class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white font-semibold px-4 py-2 rounded-lg shadow-lg text-center">
                    </p>
                </div>

                <div class="mt-6">
                    <div class="text-center text-gray-500 dark:text-gray-400 my-4">atau</div>
                    <form @submit.prevent="manualAdd" class="flex gap-2">
                        <input type="text" x-model="manualSku" id="manual-sku-input"
                            placeholder="Ketik kode SKU produk di sini"
                            class="flex-grow w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <button type="submit"
                            class="px-5 py-3 bg-red-600 text-white font-bold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all">Tambah</button>
                    </form>
                    <p x-show="manualError" x-cloak class="text-red-500 text-sm mt-2">Produk dengan SKU tersebut tidak
                        ditemukan!</p>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 p-5 sm:p-6 rounded-2xl shadow-lg h-full flex flex-col">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white border-b dark:border-gray-700 pb-4 mb-4">
                        Keranjang Belanja</h2>
                    <div class="mb-4">
                        <label for="customer-select"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Pelanggan</label>
                        <select x-model="selectedCustomer" id="customer-select"
                            class="mt-1 block w-full px-3 py-2.5 text-base border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md shadow-sm">
                            <option value="">-- Wajib Pilih Pelanggan --</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id_customer }}">{{ $customer->name_store }}</option>
                            @endforeach
                        </select>
                        <p x-show="checkoutSubmitted && !selectedCustomer" x-cloak class="text-red-500 text-xs mt-1">
                            Pelanggan harus dipilih sebelum checkout.</p>
                    </div>

                    <div class="overflow-y-auto flex-grow space-y-3 -mr-3 pr-3" x-show="cart.length > 0">
                        <template x-for="item in cart" :key="item.id_product">
                            <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="flex-grow">
                                    <p class="font-bold text-gray-900 dark:text-white" x-text="item.name_product"></p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="formatRupiah(item.price)">
                                    </p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <button @click="changeQty(item.id_product, -1)"
                                        class="w-7 h-7 bg-gray-200 dark:bg-gray-600 rounded-md flex items-center justify-center font-bold text-lg hover:bg-gray-300 dark:hover:bg-gray-500">-</button>
                                    <span class="font-semibold w-5 text-center" x-text="item.quantity"></span>
                                    <button @click="changeQty(item.id_product, 1)"
                                        class="w-7 h-7 bg-gray-200 dark:bg-gray-600 rounded-md flex items-center justify-center font-bold text-lg hover:bg-gray-300 dark:hover:bg-gray-500">+</button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="flex-grow flex flex-col items-center justify-center text-center text-gray-400"
                        x-show="cart.length === 0" x-cloak>
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="mt-4 text-lg font-semibold">Keranjang Kosong</p>
                        <p class="text-sm">Pindai produk untuk menambahkannya ke sini.</p>
                    </div>

                    <div class="mt-auto pt-6 border-t dark:border-gray-700">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-bold text-gray-600 dark:text-gray-300">Total Harga:</span>
                            <span x-text="formatRupiah(grandTotal)"
                                class="text-3xl font-bold text-gray-900 dark:text-white"></span>
                        </div>
                        <button @click="checkout" :disabled="cart.length === 0 || isProcessing"
                            class="w-full text-center py-4 bg-red-600 text-white font-bold text-lg rounded-lg shadow-lg hover:bg-red-700 transition duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed">
                            CHECKOUT
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }

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

    {{-- Memindahkan skrip langsung ke sini untuk memastikan termuat --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@zxing/library@0.19.1/umd/index.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('scannerApp', () => ({
                cart: [],
                manualSku: '',
                manualError: false,
                selectedCustomer: '',
                checkoutSubmitted: false,
                feedback: {
                    message: '',
                    isError: false
                },
                isProcessing: false,
                get grandTotal() {
                    return this.cart.reduce((t, i) => t + (i.price * i.quantity), 0);
                },
                init() {
                    this.startScanner();
                },
                startScanner() {
                    const codeReader = new ZXing.BrowserMultiFormatReader();
                    const videoElement = document.getElementById('video-scanner');
                    const statusIndicator = document.getElementById('status-indicator');
                    codeReader.listVideoInputDevices()
                        .then(devices => {
                            if (devices.length > 0) {
                                statusIndicator.textContent = 'Kamera Aktif';
                                statusIndicator.classList.replace('bg-gray-600/70', 'bg-green-500');
                                codeReader.decodeFromVideoDevice(undefined, videoElement, (result,
                                    err) => {
                                    if (result) this.processSku(result.text);
                                    if (err && !(err instanceof ZXing.NotFoundException)) {
                                        console.error('Scanner Error:', err);
                                        statusIndicator.textContent = 'Error Kamera';
                                        statusIndicator.classList.replace('bg-green-500',
                                            'bg-red-500');
                                    }
                                });
                            } else {
                                statusIndicator.textContent = 'Kamera Tdk Ditemukan';
                                statusIndicator.classList.replace('bg-gray-600/70', 'bg-red-500');
                            }
                        })
                        .catch(err => {
                            console.error('Camera Init Error:', err);
                            statusIndicator.textContent = 'Izin Kamera Dibutuhkan';
                            statusIndicator.classList.replace('bg-gray-600/70', 'bg-yellow-500');
                        });
                },
                async processSku(sku) {
                    if (!sku || this.isProcessing) return;
                    this.isProcessing = true;
                    this.manualError = false;
                    try {
                        const response = await fetch(`/sales/products/sku/${sku}`);
                        if (!response.ok) throw new Error('Product not found');
                        const product = await response.json();
                        this.addProductToCart(product);
                        this.showFeedback(`${product.name_product} ditambahkan!`);
                    } catch (error) {
                        this.showFeedback('Produk tidak ditemukan!', true);
                        if (document.activeElement.id === 'manual-sku-input') this.manualError =
                            true;
                    } finally {
                        setTimeout(() => {
                            this.isProcessing = false;
                        }, 300);
                    }
                },
                addProductToCart(product) {
                    const existing = this.cart.find(item => item.id_product === product.id_product);
                    if (existing) existing.quantity++;
                    else this.cart.push({
                        ...product,
                        quantity: 1
                    });
                    new Audio('https://www.soundjay.com/buttons/sounds/button-3.mp3').play();
                },
                manualAdd() {
                    if (this.manualSku.trim() === '') return;
                    this.processSku(this.manualSku.trim());
                    this.manualSku = '';
                },
                changeQty(id, amount) {
                    const item = this.cart.find(p => p.id_product === id);
                    if (item) {
                        item.quantity += amount;
                        if (item.quantity <= 0) this.cart = this.cart.filter(p => p.id_product !== id);
                    }
                },
                formatRupiah(num) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(num);
                },
                showFeedback(msg, isErr = false) {
                    this.feedback = {
                        message: msg,
                        isError: isErr
                    };
                    setTimeout(() => {
                        this.feedback.message = '';
                    }, 2500);
                },
                checkout() {
                    this.checkoutSubmitted = true;
                    if (!this.selectedCustomer) return;
                    if (this.cart.length === 0) {
                        this.showFeedback('Keranjang masih kosong!', true);
                        return;
                    }
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('sales.checkout.process') }}';
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    const customer = document.createElement('input');
                    customer.type = 'hidden';
                    customer.name = 'customer_id';
                    customer.value = this.selectedCustomer;
                    const cart = document.createElement('input');
                    cart.type = 'hidden';
                    cart.name = 'cart';
                    cart.value = JSON.stringify(this.cart);
                    form.append(csrf, customer, cart);
                    document.body.appendChild(form);
                    form.submit();
                }
            }));
        });
    </script>
@endsection
