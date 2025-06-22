@extends('sales/layouts.app')

@section('content')
    <div class="mb-6">
        <a href="{{ route('sales.customers.index') }}"
            class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white mb-2">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Manajemen Customers
        </a>
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Profil Pelanggan</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md text-center">
                <div class="mb-4">
                    <div
                        class="w-24 h-24 rounded-full bg-red-100 dark:bg-red-900/50 mx-auto flex items-center justify-center text-3xl font-bold text-red-600 dark:text-red-300">
                        {{ strtoupper(substr($customer->name_store, 0, 2)) }}
                    </div>
                </div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $customer->name_store }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">ID: {{ $customer->id_customer }}</p>
                <span
                    class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $customer->status == 'ACTIVE' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $customer->status == 'ACTIVE' ? 'Aktif' : ($customer->status == 'INACTIVE' ? 'Tidak Aktif' : 'Baru') }}
                </span>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                <h3
                    class="text-lg font-semibold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-4">
                    Info Kontak</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>{{ $customer->name_owner }}</span>
                    </li>
                    <li class="flex items-center text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        <span>{{ $customer->no_phone }}</span>
                    </li>
                    <li class="flex items-center text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>{{ $customer->email ?? 'Tidak ada email' }}</span>
                    </li>
                    <li class="flex items-start text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 mr-3 text-gray-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>{{ $customer->address }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav id="tab-nav" class="-mb-px flex space-x-6" aria-label="Tabs">
                        <button data-tab="riwayat-pesanan"
                            class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-red-500 text-red-600">Riwayat
                            Pesanan</button>
                        <button data-tab="produk-favorit"
                            class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-500">Produk
                            Favorit</button>
                        <button data-tab="catatan-kunjungan"
                            class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-500">Catatan
                            Kunjungan</button>
                    </nav>
                </div>

                <div id="content-riwayat-pesanan" class="tab-content py-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        ID Pesanan</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Total</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($customer->transactions as $transaction)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                            #{{ $transaction->id_transaction }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $transaction->date_transaction->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Rp
                                            {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusClasses = [
                                                    'FINISH' => 'bg-green-100 text-green-800',
                                                    'CANCEL' => 'bg-red-100 text-red-800',
                                                    'PROCESS' => 'bg-blue-100 text-blue-800',
                                                    'WAITING_CONFIRMATION' => 'bg-yellow-100 text-yellow-800',
                                                    'SEND' => 'bg-purple-100 text-purple-800',
                                                ];
                                            @endphp
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[$transaction->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ str_replace('_', ' ', $transaction->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="#"
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Lihat</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Tidak ada riwayat pesanan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="content-produk-favorit" class="tab-content py-6 hidden">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Produk Paling Sering Dibeli</h3>
                    <ul class="space-y-3">
                        @forelse ($mostBoughtProducts as $product)
                            <li class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <span
                                    class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $product->name_product }}</span>
                                <span
                                    class="text-sm font-semibold text-blue-600 dark:text-blue-400">{{ $product->total_quantity }}
                                    unit</span>
                            </li>
                        @empty
                            <li class="text-center text-gray-500 dark:text-gray-400 py-4">Tidak ada data produk favorit.
                            </li>
                        @endforelse
                    </ul>
                </div>

                <div id="content-catatan-kunjungan" class="tab-content py-6 hidden">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Catatan Kunjungan</h3>
                        <button id="show_add_note_form_button"
                            class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition">Tambah
                            Catatan</button>
                    </div>
                    <div class="space-y-4">
                        @forelse ($customer->visitNotes as $note)
                            <div
                                class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                <p class="text-sm text-gray-800 dark:text-gray-200">{{ $note->note_text }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                    {{ $note->created_at->format('d M Y, H:i') }} &middot; {{ $note->interaction_type }}
                                    @if ($note->salesPerson)
                                        oleh {{ $note->salesPerson->name }}
                                    @endif
                                </p>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 dark:text-gray-400 py-4">Belum ada catatan kunjungan.</p>
                        @endforelse
                    </div>

                    <div id="add_note_form"
                        class="mt-6 p-4 bg-gray-100 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700 hidden">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Tambah Catatan Baru</h3>
                        <form action="{{ route('sales.customer.storeVisitNote', ['id' => $customer->id_customer]) }}"
                            method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="interaction_type"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipe
                                    Interaksi</label>
                                <select name="interaction_type" id="interaction_type" required
                                    class="w-full p-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 dark:text-white rounded-md focus:ring-blue-500 focus:border-blue-500 @error('interaction_type') border-red-500 @enderror">
                                    <option class="text-black" value="">Pilih Tipe Interaksi</option>
                                    <option class="text-black" value="Kunjungan Langsung"
                                        {{ old('interaction_type') == 'Kunjungan Langsung' ? 'selected' : '' }}>Kunjungan
                                        Langsung</option>
                                    <option class="text-black" value="Telepon"
                                        {{ old('interaction_type') == 'Telepon' ? 'selected' : '' }}>Telepon</option>
                                    <option class="text-black" value="Email"
                                        {{ old('interaction_type') == 'Email' ? 'selected' : '' }}>Email</option>
                                    <option class="text-black" value="WhatsApp"
                                        {{ old('interaction_type') == 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                                    <option class="text-black" value="Lainnya"
                                        {{ old('interaction_type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('interaction_type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="note_text"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan</label>
                                <textarea name="note_text" id="note_text"
                                    class="w-full p-2 border border-gray-300 dark:border-gray-600 bg-white text-white dark:bg-gray-700 rounded-md focus:ring-blue-500 focus:border-blue-500 @error('note_text') border-red-500 @enderror"
                                    rows="4" placeholder="Tulis catatan Anda di sini..." required>{{ old('note_text') }}</textarea>
                                @error('note_text')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button"
                                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 text-sm font-medium">Batal</button>
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium">Simpan
                                    Catatan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-button');
            const contents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Nonaktifkan semua tab
                    tabs.forEach(item => {
                        item.classList.remove('border-red-500', 'text-red-600');
                        item.classList.add('border-transparent', 'text-gray-500',
                            'hover:text-gray-700', 'hover:border-gray-300');
                    });
                    // Sembunyikan semua konten
                    contents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Aktifkan tab yang diklik
                    this.classList.add('border-red-500', 'text-red-600');
                    this.classList.remove('border-transparent', 'text-gray-500',
                        'hover:text-gray-700', 'hover:border-gray-300');

                    // Tampilkan konten yang sesuai
                    document.getElementById('content-' + this.dataset.tab).classList.remove(
                        'hidden');
                });
            });

            // Logika untuk form tambah catatan
            const showButton = document.getElementById('show_add_note_form_button');
            const addNoteForm = document.getElementById('add_note_form');
            const cancelButton = addNoteForm.querySelector('button[type="button"]');

            if (showButton) {
                showButton.addEventListener('click', () => {
                    addNoteForm.classList.remove('hidden');
                    showButton.classList.add('hidden');
                });
            }
            if (cancelButton) {
                cancelButton.addEventListener('click', () => {
                    addNoteForm.classList.add('hidden');
                    showButton.classList.remove('hidden');
                });
            }

            // Tampilkan form jika ada error validasi
            @if ($errors->any() && old('note_text'))
                document.getElementById('add_note_form').classList.remove('hidden');
                document.getElementById('show_add_note_form_button').classList.add('hidden');
                // Aktifkan juga tab catatan kunjungan
                document.querySelector('[data-tab="catatan-kunjungan"]').click();
            @endif
        });
    </script>
@endpush
