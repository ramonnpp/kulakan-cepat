@extends('sales/layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Laporan Kinerja Pribadi</h1>
        <div class="flex items-center bg-white dark:bg-gray-700/50 px-4 py-2 rounded-lg shadow-sm">
            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Periode:</span>
            <select class="ml-2 border-none bg-transparent text-gray-800 dark:text-white font-semibold focus:ring-0">
                <option>Bulan Ini</option>
                <option>Bulan Lalu</option>
                <option>Tahun Ini</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md flex items-center space-x-4 transform transition duration-300 hover:-translate-y-1 hover:shadow-lg">
            <div class="bg-blue-100 dark:bg-blue-900/50 p-4 rounded-full">
                <svg class="w-8 h-8 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16h10M7 12h.01M7 8h.01M17 8h.01M17 12h.01M17 16h.01M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Penjualan Bulan Ini</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white">Rp 150.000.000</p>
            </div>
        </div>
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md flex items-center space-x-4 transform transition duration-300 hover:-translate-y-1 hover:shadow-lg">
            <div class="bg-green-100 dark:bg-green-900/50 p-4 rounded-full">
                <svg class="w-8 h-8 text-green-500 dark:text-green-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Pencapaian Target</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white">75%</p>
            </div>
        </div>
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md flex items-center space-x-4 transform transition duration-300 hover:-translate-y-1 hover:shadow-lg">
            <div class="bg-yellow-100 dark:bg-yellow-900/50 p-4 rounded-full">
                <svg class="w-8 h-8 text-yellow-500 dark:text-yellow-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Pelanggan Baru</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white">15</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Grafik Penjualan Bulanan</h3>
            <div class="h-80">
                <canvas id="monthlySalesChart"></canvas>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Produk Terlaris Anda</h3>
            <ul class="space-y-4">
                <li class="flex items-center">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 font-bold mr-3">1</span>
                    <span class="text-gray-700 dark:text-gray-300">Produk X</span>
                    <span class="ml-auto font-semibold text-gray-800 dark:text-white">500 unit</span>
                </li>
                <li class="flex items-center">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 font-bold mr-3">2</span>
                    <span class="text-gray-700 dark:text-gray-300">Produk Y</span>
                    <span class="ml-auto font-semibold text-gray-800 dark:text-white">300 unit</span>
                </li>
                <li class="flex items-center">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 font-bold mr-3">3</span>
                    <span class="text-gray-700 dark:text-gray-300">Produk Z</span>
                    <span class="ml-auto font-semibold text-gray-800 dark:text-white">200 unit</span>
                </li>
                <li class="flex items-center">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-600 font-bold mr-3">4</span>
                    <span class="text-gray-700 dark:text-gray-300">Produk A</span>
                    <span class="ml-auto font-semibold text-gray-800 dark:text-white">150 unit</span>
                </li>
                <li class="flex items-center">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-600 font-bold mr-3">5</span>
                    <span class="text-gray-700 dark:text-gray-300">Produk B</span>
                    <span class="ml-auto font-semibold text-gray-800 dark:text-white">120 unit</span>
                </li>
            </ul>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Script untuk grafik tetap sama seperti sebelumnya --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('monthlySalesChart');

            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt',
                            'Nov', 'Des'
                        ],
                        datasets: [{
                            label: 'Penjualan (Juta Rp)',
                            data: [100, 120, 150, 130, 180, 200, 190, 220, 250, 230, 270, 300],
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            tension: 0.3,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Nilai Penjualan (Juta Rp)'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Bulan'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            label += 'Rp ' + context.parsed.y + '.000.000';
                                        }
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
