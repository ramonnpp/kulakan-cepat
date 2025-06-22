<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HalamanUtamaController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\Auth\SalesLoginController;
use App\Http\Controllers\Sales\SalesController;
use App\Http\Controllers\Sales\VisitScheduleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// == RUTE PUBLIK (BISA DIAKSES SEMUA) ==
Route::get('/', [HomeController::class, 'landing'])->name('landing');

// == RUTE OTENTIKASI (HANYA UNTUK TAMU) ==
Route::middleware('guest:customer')->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

// Halaman tunggu persetujuan
Route::get('/pending-approval', function () {
    return view('auth.pending');
})->name('auth.pending');


// == RUTE YANG MEMBUTUHKAN LOGIN CUSTOMER ==
Route::middleware('auth:customer')->group(function () {
    // Halaman Utama & Katalog
    Route::get('/home', [HalamanUtamaController::class, 'index'])->name('home');
    Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/produk/{product}', [ProductController::class, 'show'])->name('product.show');

    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Profil Pengguna
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profil/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Keranjang Belanja - Route yang Diperluas
    Route::prefix('keranjang')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/tambah/{product}', [CartController::class, 'add'])->name('add');
        Route::patch('/update', [CartController::class, 'update'])->name('update');
        Route::delete('/hapus', [CartController::class, 'remove'])->name('remove');
        Route::delete('/kosongkan', [CartController::class, 'clear'])->name('clear');
        Route::get('/jumlah', [CartController::class, 'getCartCount'])->name('count');
        Route::get('/total', [CartController::class, 'getCartTotal'])->name('total');
    });

    Route::post('/address', [AddressController::class, 'store'])->name('address.store');
    Route::put('/address/{address}', [AddressController::class, 'update'])->name('address.update');
    Route::delete('/address/{address}', [AddressController::class, 'destroy'])->name('address.destroy');
    Route::post('/address/{address}/select', [AddressController::class, 'selectForCheckout'])->name('address.select');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/order/confirmation/{transaction}', [OrderDetailController::class, 'confirmation'])->name('order.confirmation');
    Route::get('/order/{transaction}', [OrderDetailController::class, 'show'])->name('order.show');
});

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
