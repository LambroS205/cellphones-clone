<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'short_description',
        'description', 'price', 'sale_price', 'stock_quantity',
        'thumbnail', 'is_featured', 'is_active'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getIsOnSaleAttribute(): bool
    {
        return $this->sale_price > 0 && $this->sale_price < $this->price;
    }

    // --- CODE THÊM MỚI ---
    /**
     * Hàm boot của Model, tự động được gọi khi Model khởi tạo.
     * Sử dụng Model Events để quản lý Cache.
     */
    protected static function booted()
    {
        // Khi một sản phẩm được thêm mới hoặc cập nhật
        static::saved(function ($product) {
            Cache::forget('home_featured_products');
        });

        // Khi một sản phẩm bị xoá
        static::deleted(function ($product) {
            Cache::forget('home_featured_products');
        });
    }
}
