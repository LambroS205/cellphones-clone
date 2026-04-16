<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $result = $this->cartService->addToCart($request->product_id, $request->quantity);

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        return back()->with('success', $result['message']);
    }

    public function index()
    {
        $cartItems = $this->cartService->getCartContents();
        $totalPrice = $this->cartService->getTotalPrice();
        $itemCount = $this->cartService->getItemCount();

        return view('frontend.cart.index', compact('cartItems', 'totalPrice', 'itemCount'));
    }

    public function remove($productId)
    {
        $result = $this->cartService->removeFromCart((int) $productId);

        if (request()->wantsJson()) {
            return response()->json($result);
        }

        return back()->with($result['status'], $result['message']);
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $result = $this->cartService->updateQuantity((int) $productId, $request->quantity);

        if (request()->wantsJson()) {
            return response()->json($result);
        }

        return back()->with($result['status'], $result['message']);
    }

    public function clear()
    {
        $this->cartService->clearCart();

        return back()->with('success', 'Giỏ hàng đã được xóa.');
    }
}
