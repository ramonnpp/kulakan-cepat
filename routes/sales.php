<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SalesLoginController;
use App\Http\Controllers\Sales\SalesController;
use App\Http\Controllers\Sales\VisitScheduleController;
use App\Http\Controllers\Sales\SalesDashboardController;
use App\Http\Controllers\Sales\SalesMaterialController;

/*
|--------------------------------------------------------------------------
| Sales Routes
|--------------------------------------------------------------------------
*/

Route::prefix('sales')->name('sales.')->group(function () {
    // Rute Autentikasi
    Route::get('/login', [SalesLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [SalesLoginController::class, 'login']);
    Route::post('/logout', [SalesLoginController::class, 'logout'])->name('logout');

    // Rute untuk menampilkan form registrasi sales (GET)
    Route::get('/register', [App\Http\Controllers\Auth\SalesRegisterController::class, 'showRegistrationForm'])->name('register');

    // Rute untuk memproses pendaftaran sales (POST)
    Route::post('/register', [App\Http\Controllers\Auth\SalesRegisterController::class, 'register'])->name('register.submit');

    // Rute untuk halaman "pending"
    Route::get('/pending', function () {
        return view('sales.auth.pending');
    })->name('pending');

    // Grup Rute yang Dilindungi Middleware
    Route::middleware(['auth.sales'])->group(function () {

        Route::get('/dashboard', [SalesDashboardController::class, 'index'])->name('dashboard');

        // Rute Manajemen Pelanggan
        Route::get('/customers', [SalesController::class, 'index'])->name('customers.index');
        Route::get('/customers/{customer}', [SalesController::class, 'show'])->name('customers.show');
        Route::post('/customers/{id}/notes', [SalesController::class, 'storeVisitNote'])->name('customer.storeVisitNote');

        // Rute Jadwal Kunjungan
        Route::resource('visit-schedule', VisitScheduleController::class)
            ->except(['show'])
            ->names('visit_schedule');
        Route::patch('visit-schedule/{schedule}/complete', [VisitScheduleController::class, 'complete'])->name('visit_schedule.complete');


        // Rute Laporan Kinerja
        Route::get('/performance-report', [SalesDashboardController::class, 'performanceReport'])->name('performance_report');
        Route::get('/performance-report/export', [SalesDashboardController::class, 'exportPerformanceReport'])->name('performance_report.export');

        // Rute Materi Penjualan
        Route::get('/sales-material', [SalesMaterialController::class, 'index'])->name('sales_material.index');

        // Rute Scanner
        Route::get('/scanner', [SalesController::class, 'scanner'])->name('scanner');
        Route::get('/products/qr-codes', [SalesController::class, 'qrCodes'])->name('products.qr');
        Route::get('/products/sku/{sku}', [SalesController::class, 'getProductBySku'])->name('products.sku');
        Route::post('/checkout/process', [SalesController::class, 'processCheckout'])->name('checkout.process');
        // -------------------------

        // Rute untuk Detail Pesanan (Modal)
        Route::get('/orders/{transaction}', [SalesController::class, 'showOrder'])->name('orders.show');

        // Rute untuk Profil Sales
        Route::get('/profile', [SalesController::class, 'profile'])->name('profile.show');
        Route::put('/profile', [SalesController::class, 'updateProfile'])->name('profile.update');
        Route::post('/profile/photo', [SalesController::class, 'updatePhoto'])->name('profile.updatePhoto');

        Route::patch('/orders/{transaction}/update-status', [SalesController::class, 'updateOrderStatus'])->name('orders.updateStatus');
    });
});
