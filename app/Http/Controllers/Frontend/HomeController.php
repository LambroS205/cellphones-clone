<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Cache::remember() hoạt động như sau:
        // 1. Tìm trong Redis xem có key 'home_featured_products' không.
        // 2. Nếu có, trả về ngay lập tức (Thời gian phản hồi ~2ms, không chạm vào DB).
        // 3. Nếu chưa có, chạy hàm function() bên trong, chọc DB, lưu vào Redis trong 3600 giây (1 giờ), rồi trả về.

        $featuredProducts = Cache::remember('home_featured_products', 3600, function () {
            return Product::with('category')
                ->where('is_active', true)
                ->where('is_featured', true)
                ->take(10)
                ->get();
        });
        return view('frontend.home', compact('featuredProducts'));
    }
}
