@extends("layouts.app")

@section("title", "Detail Pesanan #" . ($transaction->invoice_number ?? $transaction->id_transaction))

@section("content")
<main class="container mx-auto my-10 px-4">
    {{-- Header Halaman --}}
    <div class="mb-6 flex flex-col items-start justify-between sm:flex-row sm:items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Detail Pesanan</h2>
            <p class="text-sm text-gray-500">Lihat rincian lengkap dari transaksi Anda.</p>
        </div>
        <a href="{{ route("profile.show", ["#pesanan"]) }}" class="mt-2 text-sm text-red-600 hover:underline sm:mt-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 inline h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali ke Riwayat Pesanan
        </a>
    </div>

    <div class="rounded-lg bg-white p-6 shadow-md">
        {{-- Header Detail Pesanan --}}
        <div class="mb-6 flex flex-col justify-between gap-4 border-b pb-4 sm:flex-row sm:items-center">
            <div>
                <p class="text-sm text-gray-500">Nomor Invoice</p>
                <p class="text-lg font-bold text-red-700">#{{ $transaction->invoice_number ?? $transaction->id_transaction }}</p>
            </div>
            <div class="text-left sm:text-right">
                <p class="text-sm text-gray-500">Tanggal Pemesanan</p>
                <p class="font-semibold">{{ $transaction->date_transaction->isoFormat("D MMMM YYYY") }}</p>
            </div>
            <div class="text-left sm:text-right">
                <p class="text-sm text-gray-500">Status</p>
                @php
                    $status = strtolower($transaction->status);
                    $statusText = str_replace('_', ' ', $status);
                    $statusClass = match ($status) {
                        'finish' => 'bg-green-100 text-green-800',
                        'send', 'shipping' => 'bg-blue-100 text-blue-800',
                        'cancel' => 'bg-red-100 text-red-800',
                        'process' => 'bg-purple-100 text-purple-800',
                        default => 'bg-yellow-100 text-yellow-800',
                    };
                @endphp
                <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold {{ $statusClass }}">
                    {{ ucwords($statusText) }}
                </span>
            </div>
        </div>

        {{-- Grid Utama: Produk & Pengiriman --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            {{-- Kolom Kiri: Daftar Produk --}}
            <div class="lg:col-span-2">
                <h3 class="mb-4 text-lg font-bold text-gray-800">Produk yang Dipesan</h3>
                <div class="space-y-4">
                    @forelse ($transaction->details as $detail)
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <img src="{{ $detail->product->image_path ? asset('storage/' . $detail->product->image_path) : 'https://placehold.co/100x100/e2e8f0/94a3b8?text=Gambar' }}"
                                     alt="{{ $detail->product->name_product ?? 'Produk tidak tersedia' }}"
                                     class="h-16 w-16 rounded-lg border object-cover" />
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $detail->product->name_product ?? 'Produk tidak tersedia' }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $detail->quantity }} x Rp {{ number_format($detail->unit_price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            <p class="flex-shrink-0 font-semibold text-gray-800">
                                Rp {{ number_format($detail->quantity * $detail->unit_price, 0, ',', '.') }}
                            </p>
                        </div>
                    @empty
                        <div class="rounded-lg border-2 border-dashed border-gray-300 p-8 text-center">
                            <p class="text-gray-500">Detail produk tidak ditemukan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Kolom Kanan: Info Pengiriman & Rincian Pembayaran --}}
            <div class="lg:col-span-1">
                <div class="space-y-6">
                    {{-- Blok Info Pengiriman --}}
                    <div class="rounded-lg border bg-gray-50 p-4">
                        <h3 class="mb-3 text-lg font-bold text-gray-800">Info Pengiriman</h3>
                        @if ($transaction->shipping_address)
                            <div class="space-y-1 text-sm text-gray-600">
                                <p class="font-semibold text-gray-800">{{ $transaction->shipping_address['recipient_name'] ?? 'Penerima tidak tersedia' }}</p>
                                <p>{{ $transaction->shipping_address['phone'] ?? 'Nomor telepon tidak tersedia' }}</p>
                                <p class="pt-1">{{ $transaction->shipping_address['address'] ?? 'Alamat tidak tersedia' }}</p>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">Alamat pengiriman tidak tersedia.</p>
                        @endif
                    </div>

                    {{-- Blok Rincian Pembayaran --}}
                    <div class="rounded-lg border bg-gray-50 p-4">
                        <h3 class="mb-3 text-lg font-bold text-gray-800">Rincian Pembayaran</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Metode Pembayaran</span>
                                <span class="font-semibold">{{ strtoupper(str_replace('_', ' ', $transaction->method_payment)) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                            </div>
                            {{-- Tambahkan biaya kirim atau diskon di sini jika ada --}}
                            <div class="flex justify-between border-t pt-3 text-base font-bold">
                                <span>Total Tagihan</span>
                                <span class="text-red-700">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection