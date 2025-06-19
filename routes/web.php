<?php

use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceAdminController;
use App\Http\Controllers\DeviceTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreRequestController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::post('/increase/{id}', [CartController::class, 'increase'])->name('increase');
        Route::post('/decrease/{id}', [CartController::class, 'decrease'])->name('decrease');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    });

    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::post('/{id}/cancel', [TransactionController::class, 'cancel'])->name('cancel');
    });
});

Route::get('/', [ProductController::class, 'index'])->name('products.index');

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    // Route::prefix('admin')->name('admin.')->group(function () {
    // Route::get('/', fn() => view('admin.dashboard'))->name('dashboard');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('devices')->name('devices.')->group(function () {
        Route::get('/', [DeviceAdminController::class, 'index'])->name('index');
        Route::get('/create', [DeviceAdminController::class, 'create'])->name('create');
        Route::post('/', [DeviceAdminController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [DeviceAdminController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DeviceAdminController::class, 'update'])->name('update');
        Route::delete('/{id}', [DeviceAdminController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('device-types')->name('device-types.')->group(function () {
        Route::get('/', [DeviceTypeController::class, 'index'])->name('index');
        Route::post('/', [DeviceTypeController::class, 'store'])->name('store');
        Route::put('/{id}', [DeviceTypeController::class, 'update'])->name('update');
        Route::delete('/{id}', [DeviceTypeController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [AdminTransactionController::class, 'index'])->name('index');
        Route::put('/{id}/approve', [AdminTransactionController::class, 'approve'])->name('approve');
        Route::put('/{id}/reject', [AdminTransactionController::class, 'reject'])->name('reject');
        Route::delete('/{id}', [AdminTransactionController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/invoice', [TransactionController::class, 'invoice'])->name('invoice');
    });

    Route::prefix('store-requests')->name('store_requests.')->group(function () {
        Route::get('/', [StoreRequestController::class, 'index'])->name('index');
        Route::put('/{id}/approve', [StoreRequestController::class, 'approve'])->name('approve');
        Route::put('/{id}/reject', [StoreRequestController::class, 'reject'])->name('reject');
    });
});
