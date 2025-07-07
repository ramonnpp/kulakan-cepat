<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SalesLoginController;
use App\Http\Controllers\Sales\SalesController;
use App\Http\Controllers\Sales\VisitScheduleController;

/*
|--------------------------------------------------------------------------
| Sales Routes
|--------------------------------------------------------------------------
|
| Here is where you can register sales routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('sales')->name('sales.')->group(function () {
    Route::get('/login', [SalesLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [SalesLoginController::class, 'login']);
    Route::post('/logout', [SalesLoginController::class, 'logout'])->name('logout');

    // Grup rute yang dilindungi oleh middleware auth.sales
    Route::middleware(['auth.sales'])->group(function () {
        Route::get('/dashboard', function () {
            return view('sales.dashboard');
        })->name('dashboard');

        Route::get('/customers', [SalesController::class, 'index'])->name('customers.index');
        Route::get('/customers/{id}', [SalesController::class, 'show'])->name('customer.detail');
        Route::post('/customers/{id}/notes', [SalesController::class, 'storeVisitNote'])->name('customer.storeVisitNote');
        Route::get('/customers/{id}/edit-status', [SalesController::class, 'editStatus'])->name('customer.editStatus');
        Route::put('/customers/{id}/update-status', [SalesController::class, 'updateStatus'])->name('customer.updateStatus');

        Route::get('/performance-report', function () {
            return view('sales.performance-report');
        })->name('performance_report');

        Route::resource('visit-schedule', VisitScheduleController::class)
            ->names('visit_schedule');

        Route::get('/sales-material', function () {
            return view('sales.sales-material');
        })->name('sales_material');

        Route::get('/leads/create', [SalesController::class, 'createLead'])->name('leads.create');
        Route::post('/leads', [SalesController::class, 'storeLead'])->name('leads.store');

        Route::get('/scanner', function () {
            return view('sales.scanner');
        })->name('scanner');
    });
});
