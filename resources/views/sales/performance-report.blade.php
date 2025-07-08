@extends('sales/layouts.app')

@section('content')
<div class="flex flex-wrap justify-between items-center gap-4 mb-6">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Laporan Kinerja Pribadi</h1>
    
    <div class="flex items-center space-x-2">
        <a href="{{ route('sales.performance_report.export', ['period' => $activePeriod]) }}"
           class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
           <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export Excel
        </a>
        
        <div class="flex items-center space-x-1 bg-gray-100 dark:bg-gray-700 p-1 rounded-lg">
            <a href="{{ route('sales.performance_report', ['period' => 'monthly']) }}"
               class="px-3 py-1.5 text-sm font-semibold rounded-md transition {{ $activePeriod == 'monthly' ? 'bg-white dark:bg-gray-900 text-blue-600 shadow' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
               Bulanan
            </a>
            <a href="{{ route('sales.performance_report', ['period' => 'quarterly']) }}"
               class="px-3 py-1.5 text-sm font-semibold rounded-md transition {{ $activePeriod == 'quarterly' ? 'bg-white dark:bg-gray-900 text-blue-600 shadow' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
               Kuartal
            </a>
            <a href="{{ route('sales.performance_report', ['period' => 'yearly']) }}"
               class="px-3 py-1.5 text-sm font-semibold rounded-md transition {{ $activePeriod == 'yearly' ? 'bg-white dark:bg-gray-900 text-blue-600 shadow' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
               Tahunan
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border-l-4 border-blue-500">
        <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">Total Penjualan ({{ $periodLabel }})</h2>
        <p class="text-3xl font-bold text-gray-800 dark:text-white mt-1">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border-l-4 border-green-500">
        <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">Estimasi Komisi</h2>
        <p class="text-3xl font-bold text-gray-800 dark:text-white mt-1">Rp {{ number_format($estimatedCommission, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border-l-4 border-purple-500">
        <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">Total Pesanan</h2>
        <p class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalOrders }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border-l-4 border-yellow-500">
        <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase">Kunjungan Selesai</h2>
        <p class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $completedVisits }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
    <div class="lg:col-span-3 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Tren Penjualan ({{ $periodLabel }})</h2>
        <div class="h-80">
            <canvas id="salesTrendChart"></canvas>
        </div>
    </div>

    <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Transaksi Terbaru</h2>
        <div class="overflow-y-auto max-h-80">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <tbody>
                    @forelse ($recentTransactions as $transaction)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-3 px-2">
                                <p class="font-semibold text-gray-800 dark:text-white truncate">{{ $transaction->customer->name_store ?? 'Pelanggan Dihapus' }}</p>
                                <p class="text-xs">{{ \Carbon\Carbon::parse($transaction->date_transaction)->isoFormat('D MMMM YYYY') }}</p>
                            </td>
                            <td class="py-3 px-2 text-right font-medium text-green-600 dark:text-green-400">
                                Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center py-10 text-gray-500">
                                Tidak ada data transaksi pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesTrendChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Penjualan',
                    data: @json($chartData),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 3,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
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
                                if (parseInt(value) >= 1000000) {
                                    return 'Rp ' + (value / 1000000) + 'jt';
                                } else if (parseInt(value) >= 1000) {
                                    return 'Rp ' + (value / 1000) + 'k';
                                }
                                return 'Rp ' + value;
                            }
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
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