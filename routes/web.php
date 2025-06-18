<?php

use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceAdminController;
use App\Http\Controllers\DeviceTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreRequestController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [ProductController::class, 'index'])->name('products.index');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
Route::post('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout.process');

//user transactions
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions/{id}/cancel', [TransactionController::class, 'cancel'])->name('transactions.cancel');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('admin')->group(function () {
    Route::get('/', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/devices', [DeviceAdminController::class, 'index'])->name('admin.devices.index');
    Route::get('/devices/create', [DeviceAdminController::class, 'create'])->name('admin.devices.create');
    Route::post('/devices', [DeviceAdminController::class, 'store'])->name('admin.devices.store');
    Route::get('/devices/{id}/edit', [DeviceAdminController::class, 'edit'])->name('admin.devices.edit');
    Route::put('/devices/{id}', [DeviceAdminController::class, 'update'])->name('admin.devices.update');
    Route::delete('/devices/{id}', [DeviceAdminController::class, 'destroy'])->name('admin.devices.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/device-types', [DeviceTypeController::class, 'index'])->name('admin.device-types.index');
    Route::post('/device-types', [DeviceTypeController::class, 'store'])->name('admin.device-types.store');
    Route::put('/device-types/{id}', [DeviceTypeController::class, 'update'])->name('admin.device-types.update');
    Route::delete('/device-types/{id}', [DeviceTypeController::class, 'destroy'])->name('admin.device-types.destroy');

    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('admin.transactions.index');
    Route::put('/transactions/{id}/approve', [AdminTransactionController::class, 'approve'])->name('admin.transactions.approve');
    Route::put('/transactions/{id}/reject', [AdminTransactionController::class, 'reject'])->name('admin.transactions.reject');
    Route::delete('/transactions/{id}', [AdminTransactionController::class, 'destroy'])->name('admin.transactions.destroy');

    Route::get('/admin/store-requests', [StoreRequestController::class, 'index'])->name('admin.store_requests.index');
Route::put('/admin/store-requests/{id}/approve', [StoreRequestController::class, 'approve'])->name('admin.store_requests.approve');
Route::put('/admin/store-requests/{id}/reject', [StoreRequestController::class, 'reject'])->name('admin.store_requests.reject');
});
