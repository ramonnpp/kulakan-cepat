<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\VisitSchedule;
use Carbon\Carbon;
use App\Exports\PerformanceReportExport; // Import class Export
use Maatwebsite\Excel\Facades\Excel;     // Import Fassad Excel

class SalesDashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk sales.
     */
    public function index()
    {
        $salesId = Auth::guard('sales')->id();
        $sales = Auth::guard('sales')->user();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $currentSales = Transaction::whereHas('customer', function ($query) use ($salesId) {
            $query->where('id_sales', $salesId);
        })
            ->where('status', 'FINISH')
            ->whereBetween('date_transaction', [$startOfMonth, $endOfMonth])
            ->sum('total_price');

        $targetSales = $sales->target_sales ?? 0;
        $progressPercentage = ($targetSales > 0) ? ($currentSales / $targetSales) * 100 : 0;

        $commissionRate = 0.05;
        $estimatedCommission = $currentSales * $commissionRate;

        $newOrdersThisMonth = Transaction::whereHas('customer', function ($query) use ($salesId) {
            $query->where('id_sales', $salesId);
        })
            ->whereBetween('date_transaction', [$startOfMonth, $endOfMonth])
            ->count();

        $topProducts = Product::withSum(['transactionDetails as total_sold' => function ($query) use ($salesId) {
            $query->whereHas('transaction', function ($subQuery) use ($salesId) {
                $subQuery->where('status', 'FINISH')
                    ->whereHas('customer', function ($customerQuery) use ($salesId) {
                        $customerQuery->where('id_sales', $salesId);
                    });
            });
        }], 'quantity')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        $allTransactionsThisYear = Transaction::whereYear('date_transaction', Carbon::now()->year)
            ->whereHas('customer', function ($query) use ($salesId) {
                $query->where('id_sales', $salesId);
            })
            ->where('status', 'FINISH')
            ->orderBy('date_transaction', 'asc')
            ->get(['date_transaction', 'total_price']);

        $monthlySalesTotals = $allTransactionsThisYear->groupBy(function ($transaction) {
            return Carbon::parse($transaction->date_transaction)->format('n');
        })->map(function ($monthlyTransactions) {
            return $monthlyTransactions->sum('total_price');
        });

        $monthlyChartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = $monthlySalesTotals->get($i, 0);
            $monthlyChartData[] = $total / 1000000;
        }

        return view('sales.dashboard', [
            'targetSales' => $targetSales,
            'currentSales' => $currentSales,
            'progressPercentage' => $progressPercentage,
            'estimatedCommission' => $estimatedCommission,
            'newOrdersThisMonth' => $newOrdersThisMonth,
            'topProducts' => $topProducts,
            'monthlyChartData' => $monthlyChartData,
        ]);
    }

    /**
     * Menampilkan halaman laporan kinerja pribadi.
     */
    public function performanceReport(Request $request)
    {
        $salesId = Auth::guard('sales')->id();
        $period = $request->input('period', 'monthly');

        switch ($period) {
            case 'quarterly':
                $startDate = Carbon::now()->startOfQuarter();
                $endDate = Carbon::now()->endOfQuarter();
                $periodLabel = 'Kuartal Ini';
                break;
            case 'yearly':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                $periodLabel = 'Tahun Ini';
                break;
            case 'monthly':
            default:
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                $periodLabel = 'Bulan Ini';
                break;
        }

        $transactionsInPeriodQuery = Transaction::whereHas('customer', function ($query) use ($salesId) {
            $query->where('id_sales', $salesId);
        })
            ->where('status', 'FINISH')
            ->whereBetween('date_transaction', [$startDate, $endDate]);

        $totalSales = (clone $transactionsInPeriodQuery)->sum('total_price');
        $totalOrders = (clone $transactionsInPeriodQuery)->count();
        $estimatedCommission = $totalSales * 0.05;

        $completedVisits = VisitSchedule::where('id_sales', $salesId)
            ->where('status', 'COMPLETED')
            ->whereBetween('start_time', [$startDate, $endDate])
            ->count();

        $salesTrend = (clone $transactionsInPeriodQuery)
            ->selectRaw('DATE(date_transaction) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $chartLabels = $salesTrend->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('d M');
        });
        $chartData = $salesTrend->pluck('total');

        $recentTransactions = (clone $transactionsInPeriodQuery)->with('customer')
            ->orderBy('date_transaction', 'desc')
            ->limit(10)
            ->get();

        return view('sales.performance-report', [
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'estimatedCommission' => $estimatedCommission,
            'completedVisits' => $completedVisits,
            'periodLabel' => $periodLabel,
            'activePeriod' => $period,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'recentTransactions' => $recentTransactions,
        ]);
    }

    /**
     * Menangani permintaan ekspor data kinerja ke Excel.
     */
    public function exportPerformanceReport(Request $request)
    {
        $salesId = Auth::guard('sales')->id();
        $period = $request->input('period', 'monthly');

        switch ($period) {
            case 'quarterly':
                $startDate = Carbon::now()->startOfQuarter();
                $endDate = Carbon::now()->endOfQuarter();
                $filename = 'laporan-kinerja-kuartal-ini.xlsx';
                break;
            case 'yearly':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                $filename = 'laporan-kinerja-tahun-ini.xlsx';
                break;
            case 'monthly':
            default:
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                $filename = 'laporan-kinerja-bulan-ini.xlsx';
                break;
        }

        return Excel::download(new PerformanceReportExport($salesId, $startDate, $endDate), $filename);
    }
}
