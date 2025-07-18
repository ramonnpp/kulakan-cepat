@extends('admin.layouts.app')

@section('title', 'Laporan & Analitik')

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
  <div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
    {{-- Header Section --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">Laporan & Analitik</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
          Ringkasan performa bisnis dan wawasan penjualan.
        </p>
      </div>

      <div class="flex items-center gap-2">
        {{-- Period Filter --}}
        <form
          action="{{ route('admin.reports.index') }}"
          method="GET"
          id="reportFilterForm"
          class="flex items-center gap-2">
          <select
            name="period"
            onchange="this.form.submit()"
            class="focus:border-primary focus:ring-primary w-full rounded-lg border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:ring-1 sm:w-auto dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100">
            <option value="7days" @selected($period == '7days')>7 Hari Terakhir</option>
            <option value="30days" @selected($period == '30days')>30 Hari Terakhir</option>
            <option value="1year" @selected($period == '1year')>Tahun Ini</option>
          </select>
        </form>

        {{-- Export Button --}}
        <a
          href="{{ route('admin.reports.export.excel', request()->query()) }}"
          class="inline-flex items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-green-700">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4"
            viewBox="0 0 20 20"
            fill="currentColor">
            <path
              d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm2 1v2h12V6H4zm0 4h12v2H4v-2zm0 4h12v2H4v-2z" />
          </svg>
          <span>Export Excel</span>
        </a>
      </div>
    </div>

    {{-- KPI Cards --}}
    <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
      @php
        $kpiCards = [
          [
            'title' => 'Total Revenue',
            'value' => $stats->totalRevenue,
            'change' => $stats->revenueChange,
            'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
          ],
          [
            'title' => 'Total Orders',
            'value' => $stats->totalOrders,
            'change' => $stats->ordersChange,
            'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
          ],
          [
            'title' => 'Active Customers',
            'value' => $stats->activeCustomers,
            'change' => $stats->customersChange,
            'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
          ],
          [
            'title' => 'Avg Order Value',
            'value' => $stats->avgOrderValue,
            'change' => $stats->avgOrderChange,
            'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
          ],
        ];
      @endphp

      @foreach ($kpiCards as $card)
        <div
          class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800/50">
          <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
              {{ $card['title'] }}
            </p>
            <svg
              class="h-6 w-6 text-slate-400"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}" />
            </svg>
          </div>

          <p class="mt-2 text-3xl font-bold text-slate-800 dark:text-slate-100">
            {{ $card['value'] }}
          </p>

          <p
            class="{{ $card['change'] >= 0 ? 'text-green-500' : 'text-red-500' }} mt-1 flex items-center text-xs">
            <svg class="mr-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
              @if ($card['change'] >= 0)
                <path
                  fill-rule="evenodd"
                  d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293a1 1 0 011.414 0l-3 3a1 1 0 010 1.414z"
                  clip-rule="evenodd" />
              @else
                <path
                  fill-rule="evenodd"
                  d="M12 13a1 1 0 100 2h5a1 1 0 001-1v-5a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414l3.293 3.293a1 1 0 001.414 0l-3-3a1 1 0 000-1.414z"
                  clip-rule="evenodd" />
              @endif
            </svg>
            <span>{{ number_format(abs($card['change']), 1) }}% dari periode lalu</span>
          </p>
        </div>
      @endforeach
    </div>

    {{-- Main Charts --}}
    <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-5">
      {{-- Revenue Trend Chart --}}
      <div
        class="rounded-xl border border-slate-200 bg-white p-6 shadow-md lg:col-span-3 dark:border-slate-700 dark:bg-slate-800/50">
        <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-100">
          Tren Pendapatan
        </h3>
        <div class="h-80">
          <canvas id="revenueTrendChart"></canvas>
        </div>
      </div>

      {{-- Category Distribution Chart --}}
      <div
        class="rounded-xl border border-slate-200 bg-white p-6 shadow-md lg:col-span-2 dark:border-slate-800 dark:bg-slate-800/50">
        <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-100">
          Distribusi Kategori Produk
        </h3>
        <div class="flex h-80 items-center justify-center">
          <canvas id="categoryDistributionChart"></canvas>
        </div>
      </div>
    </div>

 {{-- Comparison Chart & Top Lists --}}
<div class="space-y-6">
  {{-- Revenue Comparison Chart --}}
  <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-md dark:border-slate-800 dark:bg-slate-800/50">
    <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-100">
      Perbandingan Pendapatan (Tahun Ini vs Tahun Lalu)
    </h3>
    <div class="h-[400px] w-full">
      <canvas id="revenueComparisonChart"></canvas>
    </div>
  </div>

  {{-- Top Products & Top Customers --}}
  <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
    {{-- Top Products --}}
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-md dark:border-slate-800 dark:bg-slate-800/50">
      <h3 class="mb-6 text-lg font-semibold text-slate-800 dark:text-slate-100">
        Produk Terlaris
      </h3>
      <div class="space-y-4">
        @forelse ($topProducts as $index => $product)
          <div class="flex items-center justify-between rounded-lg border border-slate-100 bg-slate-50 p-4 transition-all hover:shadow-sm dark:border-slate-700 dark:bg-slate-700/30">
            <div class="flex items-center space-x-4">
              <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-600 dark:bg-blue-900/50 dark:text-blue-400">
                {{ $index + 1 }}
              </div>
              <div>
                <p class="font-medium text-slate-800 dark:text-slate-100">
                  {{ Str::limit($product->name_product, 25) }}
                </p>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                  {{ $product->total_sold }} terjual
                </p>
              </div>
            </div>
            <div class="text-right">
              <p class="font-semibold text-slate-800 dark:text-slate-200">
                Rp {{ number_format($product->total_revenue, 0, ',', '.') }}
              </p>
            </div>
          </div>
        @empty
          <div class="flex items-center justify-center rounded-lg border-2 border-dashed border-slate-200 p-8 text-center dark:border-slate-700">
            <p class="text-slate-500 dark:text-slate-400">Tidak ada data penjualan pada periode ini.</p>
          </div>
        @endforelse
      </div>
    </div>

    {{-- Top Customers --}}
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-md dark:border-slate-800 dark:bg-slate-800/50">
      <h3 class="mb-6 text-lg font-semibold text-slate-800 dark:text-slate-100">
        Pelanggan Terbaik
      </h3>
      <div class="space-y-4">
        @forelse ($topCustomers as $index => $customer)
          <div class="flex items-center justify-between rounded-lg border border-slate-100 bg-slate-50 p-4 transition-all hover:shadow-sm dark:border-slate-700 dark:bg-slate-700/30">
            <div class="flex items-center space-x-4">
              <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 text-sm font-bold text-green-600 dark:bg-green-900/50 dark:text-green-400">
                {{ $index + 1 }}
              </div>
              <div>
                <p class="font-medium text-slate-800 dark:text-slate-100">
                  {{ Str::limit($customer->name_store, 25) }}
                </p>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                  {{ $customer->total_orders }} pesanan
                </p>
              </div>
            </div>
            <div class="text-right">
              <p class="font-semibold text-slate-800 dark:text-slate-200">
                Rp {{ number_format($customer->total_spent, 0, ',', '.') }}
              </p>
            </div>
          </div>
        @empty
          <div class="flex items-center justify-center rounded-lg border-2 border-dashed border-slate-200 p-8 text-center dark:border-slate-700">
            <p class="text-slate-500 dark:text-slate-400">Tidak ada data pelanggan pada periode ini.</p>
          </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const isDarkMode = document.documentElement.classList.contains('dark')
      const gridColor = isDarkMode ? '#334155' : '#e2e8f0'
      const textColor = isDarkMode ? '#94a3b8' : '#64748b'

      // Chart configuration
      const chartDefaults = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            labels: { color: textColor },
          },
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: { color: gridColor },
            ticks: {
              color: textColor,
              callback: function (value) {
                return 'Rp ' + value / 1000000 + ' Jt'
              },
            },
          },
          x: {
            grid: { display: false },
            ticks: { color: textColor },
          },
        },
      }

      // Revenue Trend Chart
      const revenueTrendCtx = document.getElementById('revenueTrendChart')
      if (revenueTrendCtx) {
        new Chart(revenueTrendCtx, {
          type: 'line',
          data: {
            labels: @json($revenueTrend['labels']),
            datasets: [
              {
                label: 'Pendapatan',
                data: @json($revenueTrend['data']),
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                fill: true,
                tension: 0.4,
              },
            ],
          },
          options: {
            ...chartDefaults,
            plugins: { legend: { display: false } },
          },
        })
      }

      // Category Distribution Chart
      const categoryDistCtx = document.getElementById('categoryDistributionChart')
      if (categoryDistCtx) {
        new Chart(categoryDistCtx, {
          type: 'pie',
          data: {
            labels: @json($categoryDistribution['labels']),
            datasets: [
              {
                label: 'Distribusi',
                data: @json($categoryDistribution['data']),
                backgroundColor: [
                  '#4f46e5',
                  '#16a34a',
                  '#f97316',
                  '#dc2626',
                  '#9333ea',
                  '#06b6d4',
                  '#d97706',
                ],
                borderColor: isDarkMode ? '#1e293b' : '#fff',
                borderWidth: 2,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'bottom',
                labels: { color: textColor },
              },
            },
          },
        })
      }

      // Revenue Comparison Chart
      const revenueCompCtx = document.getElementById('revenueComparisonChart')
      if (revenueCompCtx) {
        new Chart(revenueCompCtx, {
          type: 'bar',
          data: {
            labels: @json($revenueComparison['labels']),
            datasets: [
              {
                label: 'Tahun Ini',
                data: @json($revenueComparison['current']),
                backgroundColor: '#4f46e5',
                borderRadius: 4,
              },
              {
                label: 'Tahun Lalu',
                data: @json($revenueComparison['previous']),
                backgroundColor: isDarkMode ? '#475569' : '#e2e8f0',
                borderRadius: 4,
              },
            ],
          },
          options: {
            ...chartDefaults,
            plugins: {
              legend: {
                position: 'top',
                labels: { color: textColor },
              },
            },
          },
        })
      }
    })
  </script>
@endpush
