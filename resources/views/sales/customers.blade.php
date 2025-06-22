@extends('sales/layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Manajemen Customers</h1>
    </div>

    <div class="bg-gray-800 dark:bg-gray-800 p-4 rounded-xl shadow-lg mb-8">
        <form id="filter-form" action="{{ route('sales.customers.index') }}" method="GET"
            class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 items-center">
            <div class="md:col-span-3 lg:col-span-3">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="search_customer" name="search" placeholder="Cari nama toko, owner, kontak..."
                        value="{{ request('search') }}"
                        class="block w-full pl-12 pr-3 py-3 border-transparent rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-700 text-white transition placeholder-gray-400">
                </div>
            </div>
            <div class="md:col-span-1 lg:col-span-1">
                <select id="status_filter" name="status"
                    class="filter-select block w-full px-4 py-3 border-transparent rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-700 text-white transition appearance-none">
                    <option value="">Semua Status</option>
                    <option value="ACTIVE" {{ request('status') == 'ACTIVE' ? 'selected' : '' }}>Aktif</option>
                    <option value="INACTIVE" {{ request('status') == 'INACTIVE' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="PENDING_APPROVE" {{ request('status') == 'PENDING_APPROVE' ? 'selected' : '' }}>Baru
                    </option>
                </select>
            </div>
            <div class="md:col-span-2 lg:col-span-1">
                <select id="last_order_filter" name="last_order"
                    class="filter-select block w-full px-4 py-3 border-transparent rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-700 text-white transition appearance-none">
                    <option value="">Semua Waktu Order</option>
                    <option value="last_month" {{ request('last_order') == 'last_month' ? 'selected' : '' }}>Bulan Terakhir
                    </option>
                    <option value="last_3_months" {{ request('last_order') == 'last_3_months' ? 'selected' : '' }}>3 Bulan
                        Terakhir</option>
                    <option value="last_6_months" {{ request('last_order') == 'last_6_months' ? 'selected' : '' }}>6 Bulan
                        Terakhir</option>
                </select>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 p-2 md:p-6 rounded-xl shadow-md">
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($customers as $customer)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $customer->name_store }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $customer->address }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                <div class="font-medium">{{ $customer->name_owner }}</div>
                                <div>{{ $customer->no_phone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($customer->status == 'ACTIVE')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800/50 dark:text-green-200">Aktif</span>
                                @elseif ($customer->status == 'INACTIVE')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-800/50 dark:text-yellow-200">Tidak
                                        Aktif</span>
                                @else<span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800/50 dark:text-blue-200">Baru</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ optional($customer->transactions->last())->date_transaction ? \Carbon\Carbon::parse(optional($customer->transactions->last())->date_transaction)->isoFormat('D MMM YYYY') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('sales.customer.detail', ['id' => $customer->id_customer]) }}"
                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Lihat
                                    Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                customer yang cocok dengan kriteria pencarian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="md:hidden space-y-4">
            @forelse ($customers as $customer)
                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg shadow-md">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-bold text-lg text-gray-800 dark:text-white">{{ $customer->name_store }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $customer->name_owner }}</p>
                        </div>
                        <div>
                            @if ($customer->status == 'ACTIVE')
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                            @elseif ($customer->status == 'INACTIVE')
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Tidak
                                    Aktif</span>
                            @else<span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Baru</span>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4 border-t border-gray-200 dark:border-gray-600 pt-4 flex justify-between items-center">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            <p>Order Terakhir:</p>
                            <p class="font-semibold">
                                {{ optional($customer->transactions->last())->date_transaction ? \Carbon\Carbon::parse(optional($customer->transactions->last())->date_transaction)->isoFormat('D MMM YYYY') : 'N/A' }}
                            </p>
                        </div>
                        <a href="{{ route('sales.customer.detail', ['id' => $customer->id_customer]) }}"
                            class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-red-700">
                            Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 dark:text-gray-400 py-10">
                    Tidak ada customer yang cocok.
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $customers->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filter-form');
            const searchInput = document.getElementById('search_customer');
            const selects = form.querySelectorAll('select.filter-select');
            const submitForm = () => {
                form.submit();
            };
            let searchTimeout;
            searchInput.addEventListener('input', () => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(submitForm, 500);
            });
            selects.forEach(select => {
                select.addEventListener('change', submitForm);
            });
        });
    </script>
@endpush
