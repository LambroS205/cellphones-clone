<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Xử lý logic thêm sản phẩm vào giỏ hàng
     */
    public function addToCart(int $productId, int $quantity = 1): array
    {
        $product = Product::findOrFail($productId);

        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->effective_price,
                'quantity' => $quantity,
                'thumbnail' => $product->thumbnail,
                'slug' => $product->slug,
            ];
        }

        Session::put('cart', $cart);

        return [
            'status' => 'success',
            'message' => 'Đã thêm ' . $product->name . ' vào giỏ hàng.',
            'cart_count' => count($cart)
        ];
    }

    /**
     * Lấy toàn bộ giỏ hàng
     */
    public function getCartContents(): array
    {
        return Session::get('cart', []);
    }

    /**
     * Tính tổng tiền giỏ hàng
     */
    public function getTotalPrice(): float
    {
        $cart = $this->getCartContents();
        $total = 0.0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function removeFromCart(int $productId): array
    {
        $cart = Session::get('cart', []);

        if (!isset($cart[$productId])) {
            return [
                'status' => 'error',
                'message' => 'Sản phẩm không tồn tại trong giỏ hàng.',
            ];
        }

        unset($cart[$productId]);
        Session::put('cart', $cart);

        return [
            'status' => 'success',
            'message' => 'Đã xóa sản phẩm khỏi giỏ hàng.',
            'cart_count' => count($cart)
        ];
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ hàng
     */
    public function updateQuantity(int $productId, int $quantity): array
    {
        if ($quantity < 1) {
            return $this->removeFromCart($productId);
        }

        $cart = Session::get('cart', []);

        if (!isset($cart[$productId])) {
            return [
                'status' => 'error',
                'message' => 'Sản phẩm không tồn tại trong giỏ hàng.',
            ];
        }

        $cart[$productId]['quantity'] = $quantity;
        Session::put('cart', $cart);

        return [
            'status' => 'success',
            'message' => 'Đã cập nhật số lượng.',
            'cart_count' => count($cart)
        ];
    }

    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function clearCart(): void
    {
        Session::forget('cart');
    }

    /**
     * Đếm tổng số lượng sản phẩm trong giỏ hàng
     */
    public function getItemCount(): int
    {
        $cart = $this->getCartContents();
        $count = 0;

        foreach ($cart as $item) {
            $count += $item['quantity'];
        }

        return $count;
    }
}

