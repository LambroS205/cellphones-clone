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
        $product = Product::with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('frontend.product.show', compact('product'));
    }

    /**
     * Hiển thị danh sách sản phẩm theo danh mục
     */
    public function indexByCategory($categorySlug)
    {
        $products = Product::with('category')
            ->whereHas('category', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            })
            ->where('is_active', true)
            ->paginate(12);

        return view('frontend.product.index', compact('products'));
    }
}
