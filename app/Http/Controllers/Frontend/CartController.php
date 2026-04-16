<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService; // Nhúng Service vào

class CartController extends Controller
{
    protected CartService $cartService;

    // Dependency Injection: Tự động khởi tạo CartService
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function add(Request $request)
    {
        // 1. Validation (Kiểm tra dữ liệu đầu vào - Bảo mật cơ bản)
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // 2. Chuyển cho Service xử lý (Controller cực kỳ mỏng và sạch)
        $result = $this->cartService->addToCart($request->product_id, $request->quantity);

        // 3. Trả về kết quả
        // Nếu là request từ Ajax/Fetch (Frontend JS), trả về JSON
        if ($request->wantsJson()) {
            return response()->json($result);
        }

        // Nếu là submit form truyền thống, redirect về trang trước đó
        return back()->with('success', $result['message']);
    }

    public function index()
    {
        // Lấy giỏ hàng và tổng tiền qua Service
        $cartItems = $this->cartService->getCartContents();
        $totalPrice = $this->cartService->getTotalPrice();

        // Trả về View (Ta sẽ tạo View ở Giai đoạn 4)
        return view('frontend.cart.index', compact('cartItems', 'totalPrice'));
    }
}
