@extends('sales/layouts.app')
@section('content')
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Dashboard Utama</h1>

    {{-- Grid Responsif dengan Efek --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border border-transparent hover:border-blue-500 transform transition duration-300 hover:shadow-lg hover:-translate-y-1 cursor-pointer">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Progres Target Penjualan</h2>
            <div class="flex items-center">
                <div class="relative w-24 h-24">
                    <div
                        class="w-full h-full rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 dark:text-blue-400 text-2xl font-bold">
                        75%</div>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Target: Rp 200.000.000</p>
                    <p class="text-lg font-bold text-blue-700 dark:text-blue-300">Rp 150.000.000</p>
                </div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Update terakhir: Hari ini</p>
        </div>

        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border border-transparent hover:border-green-500 transform transition duration-300 hover:shadow-lg hover:-translate-y-1 cursor-pointer">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Estimasi Komisi</h2>
            <p class="text-4xl font-bold text-green-600 dark:text-green-400">Rp 15.000.000</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Berdasarkan penjualan bulan ini</p>
        </div>

        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border border-transparent hover:border-purple-500 transform transition duration-300 hover:shadow-lg hover:-translate-y-1 cursor-pointer">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Pesanan Baru (Bulan Ini)</h2>
            <p class="text-4xl font-bold text-purple-600 dark:text-purple-400">125</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Peningkatan 10% dari bulan lalu</p>
        </div>

        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border border-transparent hover:border-yellow-500 transform transition duration-300 hover:shadow-lg hover:-translate-y-1 cursor-pointer">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Potensi Pendapatan</h2>
            <p class="text-4xl font-bold text-yellow-600 dark:text-yellow-400">Rp 25.000.000</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Dari prospek aktif</p>
        </div>
    </div>

    {{-- Grid Responsif untuk Bagian Bawah --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Grafik Penjualan Bulanan --}}
        <div
            class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md transform transition duration-300 hover:shadow-lg">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Grafik Penjualan Bulanan (2025)</h2>
            <div class="h-80">
                <canvas id="monthlySalesChart"></canvas>
            </div>
        </div>

        {{-- Produk Terlaris --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md transform transition duration-300 hover:shadow-lg">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Produk Terlaris</h2>
            <ul class="space-y-3">
                <li class="flex justify-between items-center text-gray-700 dark:text-gray-300">
                    <span>Produk A</span>
                    <span class="font-semibold text-blue-600 dark:text-blue-400">120 Unit</span>
                </li>
                <li class="flex justify-between items-center text-gray-700 dark:text-gray-300">
                    <span>Produk B</span>
                    <span class="font-semibold text-blue-600 dark:text-blue-400">95 Unit</span>
                </li>
                <li class="flex justify-between items-center text-gray-700 dark:text-gray-300">
                    <span>Produk C</span>
                    <span class="font-semibold text-blue-600 dark:text-blue-400">80 Unit</span>
                </li>
                <li class="flex justify-between items-center text-gray-700 dark:text-gray-300">
                    <span>Produk D</span>
                    <span class="font-semibold text-blue-600 dark:text-blue-400">70 Unit</span>
                </li>
                <li class="flex justify-between items-center text-gray-700 dark:text-gray-300">
                    <span>Produk E</span>
                    <span class="font-semibold text-blue-600 dark:text-blue-400">65 Unit</span>
                </li>
            </ul>
        </div>
    </div>
@endsection

@push('scripts')
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
                            data: [110, 130, 165, 140, 190, 210, 200, 230, 260, 240, 280,
                                310
                            ], // Data dummy
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgb(59, 130, 246)'
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
                                    text: 'Nilai Penjualan (dalam Juta Rupiah)'
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
