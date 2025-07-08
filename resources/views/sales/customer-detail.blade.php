@extends('sales.layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- BAGIAN INFO PELANGGAN --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $customer->name_store }}</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">{{ $customer->name_owner }} - ({{ $customer->no_phone }})</p>
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
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 font-medium">#{{ $transaction->id_transaction }}</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($transaction->date_transaction)->isoFormat('D MMM YY') }}</td>
                                    <td class="px-6 py-4">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $transaction->status == 'FINISH' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                            {{ $transaction->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button type="button" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 view-order-btn" data-id="{{ $transaction->id_transaction }}" title="Lihat Detail">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-10 text-gray-500">Tidak ada riwayat pesanan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Tampilan Kartu untuk Mobile --}}
                <div class="md:hidden space-y-4">
                    @forelse($transactions as $transaction)
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg shadow">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-bold text-gray-800 dark:text-white">ID: #{{ $transaction->id_transaction }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($transaction->date_transaction)->isoFormat('dddd, D MMMM YY') }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $transaction->status == 'FINISH' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ $transaction->status }}</span>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600 flex justify-between items-center">
                                <p class="text-lg font-bold text-gray-800 dark:text-white">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                                <button type="button" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700 view-order-btn" data-id="{{ $transaction->id_transaction }}">
                                    Lihat
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
                        <textarea name="note_text" rows="3" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Tambahkan catatan baru..."></textarea>
                        <button type="submit" class="mt-2 w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Simpan Catatan</button>
                    </form>
                    <div class="mt-4 space-y-3 max-h-40 overflow-y-auto">
                        @forelse($visitNotes as $note)
                            <div class="text-sm p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <p class="text-gray-800 dark:text-gray-200">{{ $note->note_text }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $note->created_at->diffForHumans() }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-center text-gray-500 py-4">Belum ada catatan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL UNTUK DETAIL PESANAN --}}
    <div id="orderDetailModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full bg-black bg-opacity-50 transition-opacity duration-300">
        <div class="relative p-4 w-full max-w-md md:max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="modalTitle">Detail Pesanan</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" id="closeModalBtn">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                        <span class="sr-only">Tutup modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 space-y-4" id="modalBody">
                    <div class="text-center py-10"><p class="text-gray-500 dark:text-gray-400">Memuat data...</p></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('orderDetailModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const modalTitle = document.getElementById('modalTitle');
    const modalBody = document.getElementById('modalBody');

    const showModal = () => { modal.classList.remove('hidden'); modal.classList.add('flex'); };
    const hideModal = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modalBody.innerHTML = `<div class="text-center py-10"><p class="text-gray-500 dark:text-gray-400">Memuat data...</p></div>`;
    };

    closeModalBtn.addEventListener('click', hideModal);
    modal.addEventListener('click', (e) => e.target === modal && hideModal());

    document.querySelectorAll('.view-order-btn').forEach(button => {
        button.addEventListener('click', function () {
            const transactionId = this.dataset.id;
            const url = `{{ route('sales.orders.show', '') }}/${transactionId}`;
            
            showModal();

            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    modalTitle.innerText = `Detail Pesanan #${data.id_transaction}`;
                    let productsHtml = '';
                    
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

                    const transactionDate = new Date(data.date_transaction).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                    const statusClass = data.status === 'FINISH' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
                    const totalPrice = Number(data.total_price).toLocaleString('id-ID');

                    modalBody.innerHTML = `
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm dark:text-gray-200 mb-4">
                            <div><strong>Tanggal Pesanan:</strong><br>${transactionDate}</div>
                            <div><strong>Status:</strong><br><span class="px-2 py-1 text-xs font-semibold rounded-full ${statusClass}">${data.status}</span></div>
                        </div>
                        <h4 class="text-lg font-semibold dark:text-white mb-2">Rincian Produk:</h4>
                        
                        {{-- --- PERBAIKAN DI SINI --- --}}
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
                    modalBody.innerHTML = `<div class="text-center py-10 text-red-500"><p>Terjadi kesalahan saat memuat data pesanan.</p></div>`;
                });
        });
    });
});
</script>
@endpush