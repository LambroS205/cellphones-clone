<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo danh mục cha
        $phoneCategory = Category::create([
            'name' => 'Điện thoại',
            'slug' => 'dien-thoai',
            'description' => 'Điện thoại thông minh chính hãng',
            'is_active' => true,
        ]);

        $laptopCategory = Category::create([
            'name' => 'Laptop',
            'slug' => 'laptop',
            'description' => 'Máy tính xách tay chính hãng',
            'is_active' => true,
        ]);

        // 2. Tạo danh mục con (Brands)
        $brands = ['Apple', 'Samsung', 'Xiaomi', 'Oppo'];
        foreach ($brands as $brand) {
            Category::create([
                'name' => $brand,
                'slug' => Str::slug($brand . ' phone'),
                'parent_id' => $phoneCategory->id,
                'is_active' => true,
            ]);
        }

        Category::create([
            'name' => 'MacBook',
            'slug' => 'macbook',
            'parent_id' => $laptopCategory->id,
            'is_active' => true,
        ]);
    }
}
