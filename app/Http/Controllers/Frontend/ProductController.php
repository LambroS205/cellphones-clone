<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Hiển thị trang chi tiết sản phẩm dựa vào slug
     */
    public function show($slug)
    {
        // Tìm sản phẩm theo slug (đường dẫn thân thiện).
        // Dùng firstOrFail() để nếu không tìm thấy sẽ tự động ném ra lỗi 404.
        $product = Product::with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Trả về view chi tiết sản phẩm (chúng ta sẽ thiết kế View này sau)
        return view('frontend.product.show', compact('product'));
    }
}
