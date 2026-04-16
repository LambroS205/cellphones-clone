<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Admin\DashboardController;

// ==========================================
// FRONTEND ROUTES (Khách hàng truy cập)
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('product.show');

// Giỏ hàng (Cart)
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');


// ==========================================
// ADMIN ROUTES (Chỉ Admin truy cập)
// ==========================================
// Sử dụng Middleware 'auth' (Yêu cầu đăng nhập) và 'role:Admin' (Yêu cầu Role Admin)
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'role:Admin']
], function () {

    // Đường dẫn: /admin (Tên route: admin.dashboard)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Các route quản lý danh mục, sản phẩm, đơn hàng sẽ thêm ở đây sau
});
