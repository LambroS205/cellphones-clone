<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy ID của các danh mục con để gán cho sản phẩm
        $appleId = Category::where('slug', 'apple-phone')->first()->id;
        $samsungId = Category::where('slug', 'samsung-phone')->first()->id;
        $xiaomiId = Category::where('slug', 'xiaomi-phone')->first()->id;
        $macbookId = Category::where('slug', 'macbook')->first()->id;

        $products = [
            [
                'category_id' => $appleId,
                'name' => 'iPhone 15 Pro Max 256GB',
                'price' => 34990000,
                'sale_price' => 29990000, // Đang giảm giá
                'is_featured' => true,
            ],
            [
                'category_id' => $samsungId,
                'name' => 'Samsung Galaxy S24 Ultra 5G 256GB',
                'price' => 33990000,
                'sale_price' => 31990000,
                'is_featured' => true,
            ],
            [
                'category_id' => $xiaomiId,
                'name' => 'Xiaomi 14 5G 12GB 256GB',
                'price' => 22990000,
                'sale_price' => 19990000,
                'is_featured' => true,
            ],
            [
                'category_id' => $appleId,
                'name' => 'iPhone 13 128GB | Chính hãng VN/A',
                'price' => 18990000,
                'sale_price' => 13990000,
                'is_featured' => true, // Đánh dấu nổi bật để hiện ở trang chủ
            ],
            [
                'category_id' => $macbookId,
                'name' => 'MacBook Air M3 13 inch 8GB 256GB',
                'price' => 27990000,
                'sale_price' => null, // Không giảm giá
                'is_featured' => true,
            ]
        ];

        foreach ($products as $item) {
            Product::create([
                'category_id' => $item['category_id'],
                'name' => $item['name'],
                'slug' => Str::slug($item['name']) . '-' . rand(1000, 9999),
                'sku' => strtoupper(Str::random(8)),
                'short_description' => 'Sản phẩm ' . $item['name'] . ' chính hãng, bảo hành 12 tháng.',
                'description' => 'Đây là bài viết mô tả chi tiết cho ' . $item['name'] . '...',
                'price' => $item['price'],
                'sale_price' => $item['sale_price'],
                'stock_quantity' => rand(10, 100),
                'thumbnail' => 'https://via.placeholder.com/300x300?text=' . urlencode($item['name']),
                'is_featured' => $item['is_featured'],
                'is_active' => true,
            ]);
        }
    }
}
