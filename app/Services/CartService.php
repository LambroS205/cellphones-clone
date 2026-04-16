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
        // 1. Tìm sản phẩm, nếu không có ném ra lỗi 404
        $product = Product::findOrFail($productId);

        // 2. Lấy giỏ hàng hiện tại từ Session, nếu chưa có thì gán mảng rỗng
        $cart = Session::get('cart', []);

        // 3. Kiểm tra sản phẩm đã có trong giỏ chưa
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity; // Tăng số lượng
        } else {
            // Thêm mới vào giỏ
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->is_on_sale ? $product->sale_price : $product->price, // Sử dụng Accessor đã tạo ở Giai đoạn 2
                'quantity' => $quantity,
                'thumbnail' => $product->thumbnail,
                'slug' => $product->slug,
            ];
        }

        // 4. Lưu lại vào Session
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
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }
}

