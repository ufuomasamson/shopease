<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'logo', 'website', 'country',
        'is_active', 'is_featured', 'sort_order',
        'meta_title', 'meta_description', 'meta_keywords'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get products for this brand
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brand_id');
    }

    /**
     * Scope for active brands
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured brands
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get brand logo URL
     */
    public function getLogoUrlAttribute(): string
    {
        if ($this->logo) {
            return \Storage::url($this->logo);
        }
        return asset('images/placeholder-brand.jpg');
    }

    /**
     * Get products count for this brand
     */
    public function getProductsCountAttribute(): int
    {
        return $this->products()->count();
    }

    /**
     * Get total revenue for this brand
     */
    public function getTotalRevenueAttribute(): float
    {
        return $this->products()
            ->join('orders', 'products.id', '=', 'orders.product_id')
            ->where('orders.status', 'completed')
            ->sum('orders.total_price');
    }
}
