<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách tất cả đơn hàng cho Admin
     */
    public function index()
    {
        // CÁCH LÀM SAI (Sẽ gây lỗi N+1 khi ra View gọi $order->user->name):
        // $orders = Order::latest()->paginate(20);

        // CÁCH LÀM ĐÚNG CỦA SENIOR DEV: Dùng hàm with()
        // Giải thích: Hàm with() sẽ gom toàn bộ ID của user và items lại,
        // và chỉ dùng đúng 2 câu query dùng IN (...) để lấy dữ liệu.
        // Thay vì 21 query, ta chỉ tốn đúng 3 query cho mọi trường hợp.
        $orders = Order::with(['user', 'items.product'])
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }
}
