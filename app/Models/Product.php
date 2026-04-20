<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'price',
        'sale_price',
        'stock_quantity',
        'thumbnail',
        'images',
        'is_featured',
        'is_active',
        'specifications',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'specifications' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getIsOnSaleAttribute(): bool
    {
        return $this->sale_price > 0 && $this->sale_price < $this->price;
    }

    public function getEffectivePriceAttribute(): float
    {
        return $this->is_on_sale ? $this->sale_price : $this->price;
    }

    public function getDiscountPercentageAttribute(): float
    {
        if (!$this->is_on_sale || $this->price == 0) {
            return 0;
        }
        return round((($this->price - $this->sale_price) / $this->price) * 100, 2);
    }

    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOnSale($query)
    {
        return $query->whereNotNull('sale_price')
            ->where('sale_price', '>', 0)
            ->whereColumn('sale_price', '<', 'price');
    }

    public function scopeByBrand($query, $brandId)
    {
        return $query->where('brand_id', $brandId);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
                ->orWhere('sku', 'like', "%{$keyword}%")
                ->orWhere('short_description', 'like', "%{$keyword}%");
        });
    }
}
