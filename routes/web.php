<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;

// ==========================================
// FRONTEND ROUTES (Khách hàng truy cập)
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/danh-muc/{categorySlug}', [ProductController::class, 'indexByCategory'])->name('products.by-category');

// Giỏ hàng (Cart)
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/{productId}', [CartController::class, 'remove'])->name('cart.remove');
Route::put('/cart/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');


// ==========================================
// ADMIN ROUTES (Chỉ Admin truy cập)
// ==========================================
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'role:Admin']
], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Order management routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
});
