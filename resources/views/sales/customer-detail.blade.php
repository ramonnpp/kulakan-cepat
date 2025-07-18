@extends('sales.layouts.app')

@section('content')
    @php
        // Definisikan status di sini agar mudah dikelola
        $statuses = [
            'WAITING_CONFIRMATION' => [
                'label' => 'Menunggu Konfirmasi',
                'badge_color' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            ],
            'PROCESS' => [
                'label' => 'Proses',
                'badge_color' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            ],
            'SEND' => [
                'label' => 'Dikirim',
                'badge_color' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300',
            ],
            'FINISH' => [
                'label' => 'Selesai',
                'badge_color' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            ],
            'CANCEL' => [
                'label' => 'Batal',
                'badge_color' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            ],
        ];
    @endphp

    {{-- Alpine.js State untuk Kontrol Modal --}}
    <div x-data="{
        isModalOpen: false,
        modalAction: '',
        currentStatus: '',
        transactionId: ''
    }" @keydown.escape.window="isModalOpen = false">

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-2">
            <div class="flex justify-end mb-6">
                <a href="{{ route('sales.customers.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                    <span>Kembali Ke Menu Customer</span>
                </a>
            </div>
            {{-- BAGIAN INFO PELANGGAN --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md mb-6">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $customer->name_store }}</h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">{{ $customer->name_owner }} - ({{ $customer->no_phone }})
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-500 mt-2">{{ $customer->address }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- KOLOM KIRI: RIWAYAT PESANAN --}}
                <div class="md:col-span-2 bg-white dark:bg-gray-800 p-4 md:p-6 rounded-xl shadow-md">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Riwayat Pesanan</h2>

                    {{-- Tampilan Tabel untuk Desktop --}}
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">ID</th>
                                    <th scope="col" class="px-6 py-3">Tanggal</th>
                                    <th scope="col" class="px-6 py-3">Total</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                    <tr
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 font-medium">#{{ $transaction->id_transaction }}</td>
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($transaction->date_transaction)->isoFormat('D MMM YY') }}
                                        </td>
                                        <td class="px-6 py-4">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                        </td>

                                        {{-- Kolom Status dengan Tombol Badge untuk membuka modal --}}
                                        <td class="px-6 py-4">
                                            <button
                                                @click="isModalOpen = true; modalAction = '{{ route('sales.orders.updateStatus', $transaction) }}'; currentStatus = '{{ $transaction->status }}'; transactionId = '#{{ $transaction->id_transaction }}'"
                                                type="button"
                                                class="inline-flex items-center gap-x-1.5 rounded-full px-3 py-1 text-xs font-medium {{ $statuses[$transaction->status]['badge_color'] ?? 'bg-gray-100 text-gray-800' }} transition-transform transform hover:scale-105 cursor-pointer">
                                                {{ $statuses[$transaction->status]['label'] ?? 'Tidak Diketahui' }}
                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                            </button>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <button type="button"
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 view-order-btn"
                                                data-id="{{ $transaction->id_transaction }}" title="Lihat Detail">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-10 text-gray-500">Tidak ada riwayat
                                            pesanan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Tampilan Kartu untuk Mobile --}}
                    <div class="md:hidden space-y-4">
                        @forelse($transactions as $transaction)
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg shadow space-y-3">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-gray-800 dark:text-white">ID:
                                            #{{ $transaction->id_transaction }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($transaction->date_transaction)->isoFormat('dddd, D MMMM YY') }}
                                        </p>
                                    </div>
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full {{ $statuses[$transaction->status]['badge_color'] ?? '' }}">
                                        {{ $statuses[$transaction->status]['label'] ?? 'Tidak Diketahui' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-lg font-bold text-gray-800 dark:text-white">Rp
                                        {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                                </div>
                                <div
                                    class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600 flex justify-end items-center gap-4">
                                    <button type="button"
                                        class="text-sm font-semibold text-blue-600 hover:underline dark:text-blue-400 view-order-btn"
                                        data-id="{{ $transaction->id_transaction }}">
                                        Lihat Detail
                                    </button>
                                    <button type="button"
                                        @click="isModalOpen = true; modalAction = '{{ route('sales.orders.updateStatus', $transaction) }}'; currentStatus = '{{ $transaction->status }}'; transactionId = '#{{ $transaction->id_transaction }}'"
                                        class="text-sm font-semibold text-indigo-600 hover:underline dark:text-indigo-400">
                                        Ubah Status
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p class="text-center py-10 text-gray-500">Tidak ada riwayat pesanan.</p>
                        @endforelse
                    </div>
                </div>

                {{-- KOLOM KANAN: INFO LAIN & CATATAN --}}
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Produk Terlaris</h3>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                            @forelse($mostBoughtProducts as $product)
                                <li class="flex justify-between">
                                    <span>{{ Str::limit($product->name_product, 25) }}</span>
                                    <span class="font-bold">{{ $product->total_quantity }}</span>
                                </li>
                            @empty
                                <li>Belum ada data.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Catatan Kunjungan</h3>
                        <form action="{{ route('sales.customer.storeVisitNote', $customer->id_customer) }}" method="POST">
                            @csrf
                            <textarea name="note_text" rows="3"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                placeholder="Tambahkan catatan baru..."></textarea>
                            <button type="submit"
                                class="mt-2 w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Simpan
                                Catatan</button>
                        </form>
                        <div class="mt-4 space-y-3 max-h-40 overflow-y-auto">
                            @forelse($visitNotes as $note)
                                <div class="text-sm p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-gray-800 dark:text-gray-200">{{ $note->note_text }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $note->created_at->diffForHumans() }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-center text-gray-500 py-4">Belum ada catatan.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL UNTUK UBAH STATUS --}}
        <div x-show="isModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75" style="display: none;">
            <div @click.away="isModalOpen = false" x-show="isModalOpen" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 m-4">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Ubah Status Pesanan</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Transaksi <span x-text="transactionId"
                                class="font-semibold"></span></p>
                    </div>
                    <button @click="isModalOpen = false"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form :action="modalAction" method="POST" class="mt-4 space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label for="status-select"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Status Baru</label>
                        <select id="status-select" name="status"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @foreach ($statuses as $key => $status)
                                <option :selected="currentStatus === '{{ $key }}'" value="{{ $key }}">
                                    {{ $status['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button @click="isModalOpen = false" type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white dark:bg-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-500 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL UNTUK DETAIL PESANAN (Kode Anda yang sudah ada) --}}
        <div id="orderDetailModal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full bg-black bg-opacity-50 transition-opacity duration-300">
            <div class="relative p-4 w-full max-w-md md:max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="modalTitle">Detail Pesanan
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            id="closeModalBtn">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Tutup modal</span>
                        </button>
                    </div>
                    <div class="p-4 md:p-5 space-y-4" id="modalBody">
                        <div class="text-center py-10">
                            <p class="text-gray-500 dark:text-gray-400">Memuat data...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Script untuk modal detail pesanan (Kode Anda yang sudah ada) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('orderDetailModal');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const modalTitle = document.getElementById('modalTitle');
            const modalBody = document.getElementById('modalBody');

            const showModal = () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            };
            const hideModal = () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                modalBody.innerHTML =
                    `<div class="text-center py-10"><p class="text-gray-500 dark:text-gray-400">Memuat data...</p></div>`;
            };

            closeModalBtn.addEventListener('click', hideModal);
            modal.addEventListener('click', (e) => e.target === modal && hideModal());

            document.querySelectorAll('.view-order-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const transactionId = this.dataset.id;
                    const url = `{{ route('sales.orders.show', '') }}/${transactionId}`;

                    showModal();

                    fetch(url)
                        .then(response => {
                            if (!response.ok) throw new Error(
                                `HTTP error! status: ${response.status}`);
                            return response.json();
                        })
                        .then(data => {
                            modalTitle.innerText = `Detail Pesanan #${data.id_transaction}`;
                            let productsHtml = '';

                            const statuses = {!! json_encode($statuses) !!};
                            const currentStatusInfo = statuses[data.status] || {
                                badge_color: 'bg-gray-100 text-gray-800',
                                label: 'Tidak Diketahui'
                            };


                            data.details.forEach(detail => {
                                const price = Number(detail.unit_price);
                                const subtotal = detail.quantity * price;
                                productsHtml += `
                                <tr class="border-b dark:border-gray-700 dark:text-gray-200">
                                    <td class="py-2 px-4">${detail.product ? detail.product.name_product : 'Produk Dihapus'}</td>
                                    <td class="py-2 px-4 text-center">${detail.quantity}</td>
                                    <td class="py-2 px-4 text-right">Rp ${price.toLocaleString('id-ID')}</td>
                                    <td class="py-2 px-4 text-right">Rp ${subtotal.toLocaleString('id-ID')}</td>
                                </tr>
                            `;
                            });

                            const transactionDate = new Date(data.date_transaction)
                                .toLocaleDateString('id-ID', {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric'
                                });

                            const totalPrice = Number(data.total_price).toLocaleString('id-ID');

                            modalBody.innerHTML = `
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm dark:text-gray-200 mb-4">
                                <div><strong>Tanggal Pesanan:</strong><br>${transactionDate}</div>
                                <div><strong>Status:</strong><br><span class="px-2 py-1 text-xs font-semibold rounded-full ${currentStatusInfo.badge_color}">${currentStatusInfo.label}</span></div>
                            </div>
                            <h4 class="text-lg font-semibold dark:text-white mb-2">Rincian Produk:</h4>
                            
                            <div class="overflow-x-auto border border-gray-200 dark:border-gray-600 rounded-lg">
                                <table class="min-w-full text-sm text-left">
                                    <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                                        <tr>
                                            <th class="py-2 px-4 font-semibold whitespace-nowrap">Produk</th>
                                            <th class="py-2 px-4 text-center font-semibold whitespace-nowrap">Qty</th>
                                            <th class="py-2 px-4 text-right font-semibold whitespace-nowrap">Harga</th>
                                            <th class="py-2 px-4 text-right font-semibold whitespace-nowrap">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>${productsHtml}</tbody>
                                    <tfoot>
                                        <tr class="font-semibold dark:text-white">
                                            <td colspan="3" class="py-3 px-4 text-right border-t-2 dark:border-gray-600">Total</td>
                                            <td class="py-3 px-4 text-right text-lg border-t-2 dark:border-gray-600">Rp ${totalPrice}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        `;
                        })
                        .catch(error => {
                            console.error('Fetch Error:', error);
                            modalBody.innerHTML =
                                `<div class="text-center py-10 text-red-500"><p>Terjadi kesalahan saat memuat data pesanan.</p></div>`;
                        });
                });
            });
        });
    </script>
@endpush
