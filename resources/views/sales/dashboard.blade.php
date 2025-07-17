@extends('sales/layouts.app')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Dashboard Sales</h1>

{{-- Grid Responsif untuk KPI --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border border-transparent hover:border-blue-500 transform transition duration-300 hover:shadow-lg hover:-translate-y-1">
        <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wider">Progres Target Penjualan</h2>
        <p class="text-3xl font-black text-blue-600 dark:text-blue-400">Rp {{ number_format($currentSales, 0, ',', '.') }}</p>
        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 my-3">
            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ min($progressPercentage, 100) }}%"></div>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400">
            <span class="font-bold">{{ number_format($progressPercentage, 1) }}%</span> dari target Rp {{ number_format($targetSales, 0, ',', '.') }}
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border border-transparent hover:border-green-500 transform transition duration-300 hover:shadow-lg hover:-translate-y-1">
        <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wider">Estimasi Komisi</h2>
        <p class="text-3xl font-black text-green-600 dark:text-green-400">Rp {{ number_format($estimatedCommission, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">Berdasarkan penjualan bulan ini.</p>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border border-transparent hover:border-purple-500 transform transition duration-300 hover:shadow-lg hover:-translate-y-1">
        <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wider">Pesanan Baru</h2>
        <p class="text-3xl font-black text-purple-600 dark:text-purple-400">{{ $newOrdersThisMonth }} <span class="text-lg">Pesanan</span></p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">Total pesanan di bulan {{ \Carbon\Carbon::now()->isoFormat('MMMM') }}.</p>
    </div>
    
   <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border border-transparent hover:border-yellow-500 transform transition duration-300 hover:shadow-lg hover:-translate-y-1">
    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wider">Pelanggan yang Aktif</h2>
    <p class="text-3xl font-black text-yellow-600 dark:text-yellow-400">{{ $activeCustomersCount ?? 0 }} <span class="text-lg">Pelanggan</span></p>
    <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">Jumlah pelanggan yang Anda tangani.</p>
</div>
</div>

{{-- Grid Responsif untuk Bagian Bawah --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md transform transition duration-300 hover:shadow-lg">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Grafik Penjualan Anda (Tahun {{ \Carbon\Carbon::now()->year }})</h2>
        <div class="h-80">
            <canvas id="monthlySalesChart"></canvas>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md transform transition duration-300 hover:shadow-lg">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Produk Terlaris Anda</h2>
        <ul class="space-y-4">
             @forelse ($topProducts as $product)
                <li class="flex justify-between items-center text-gray-700 dark:text-gray-300">
                    <span class="truncate pr-4">{{ $product->name_product }}</span>
                    <span class="font-semibold text-blue-600 dark:text-blue-400 flex-shrink-0">{{ $product->total_sold }} Unit</span>
                </li>
            @empty
                <li class="text-center text-gray-500 dark:text-gray-400 py-8">
                    Belum ada data penjualan.
                </li>
            @endforelse
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
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Penjualan (Juta Rp)',
                        data: @json($monthlyChartData),
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
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value;
                                }
                            },
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
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = 'Penjualan';
                                    if (context.parsed.y !== null) {
                                        label += ': Rp ' + context.parsed.y + ' Juta';
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