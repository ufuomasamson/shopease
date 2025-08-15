<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'sku', 'title', 'category_id', 'brand_id', 'description',
        'price', 'discount_percentage', 'stock_quantity',
        'image', 'additional_images',
        'weight', 'dimensions', 'shipping_cost',
        'is_active', 'is_featured'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'stock_quantity' => 'integer',
        'weight' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'additional_images' => 'array',
    ];

    protected $dates = [
        'published_at'
    ];

    /**
     * Get the orders for this product
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the category for this product
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand that owns the product
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the reviews for this product
     */
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    /**
     * Get approved reviews for this product
     */
    public function approvedReviews()
    {
        return $this->reviews()->approved();
    }

    /**
     * Get the average rating for this product
     */
    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    /**
     * Get the total review count for this product
     */
    public function getReviewCountAttribute()
    {
        return $this->approvedReviews()->count();
    }

    /**
     * Get star rating display for average rating
     */
    public function getStarRatingAttribute(): string
    {
        $rating = round($this->average_rating);
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $stars .= '<i class="fas fa-star text-warning"></i>';
            } else {
                $stars .= '<i class="far fa-star text-muted"></i>';
            }
        }
        return $stars;
    }

    /**
     * Check if product is in stock
     */
    public function hasStock(int $quantity = 1): bool
    {
        return $this->stock_quantity >= $quantity;
    }

    /**
     * Check if product is low in stock
     */
    public function isLowStock(): bool
    {
        return $this->stock_quantity <= 5; // Default threshold of 5
    }

    /**
     * Check if product is out of stock
     */
    public function isOutOfStock(): bool
    {
        return $this->stock_quantity <= 0;
    }

    /**
     * Decrease stock
     */
    public function decreaseStock(int $quantity = 1): bool
    {
        if (!$this->hasStock($quantity)) {
            return false;
        }

        $this->decrement('stock_quantity', $quantity);
        return true;
    }

    /**
     * Increase stock
     */
    public function increaseStock(int $quantity = 1): void
    {
        $this->increment('stock_quantity', $quantity);
    }

    /**
     * Get the final price (with discount applied)
     */
    public function getFinalPriceAttribute(): float
    {
        if ($this->discount_percentage > 0) {
            return $this->price * (1 - ($this->discount_percentage / 100));
        }
        return $this->price;
    }

    /**
     * Get the discount amount
     */
    public function getDiscountAmountAttribute(): float
    {
        if ($this->discount_percentage > 0) {
            return $this->price * ($this->discount_percentage / 100);
        }
        return 0;
    }

    /**
     * Check if product has discount
     */
    public function hasDiscount(): bool
    {
        return $this->discount_percentage > 0;
    }

    /**
     * Get shipping cost for this product
     */
    public function getShippingCostAttribute(): float
    {
        return $this->shipping_cost ?? 0;
    }

    /**
     * Get product status badge class
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return $this->is_active ? 'success' : 'secondary';
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for products in stock
     */
    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    /**
     * Check if product can be ordered
     */
    public function canBeOrdered(): bool
    {
        return $this->is_active && $this->stock_quantity > 0;
    }

    /**
     * Get main product image URL
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return \Storage::url($this->image);
        }
        return asset('images/placeholder-product.jpg');
    }

    /**
     * Get additional images as array
     */
    public function getAdditionalImagesArrayAttribute(): array
    {
        if (is_string($this->additional_images)) {
            return json_decode($this->additional_images, true) ?: [];
        }
        return is_array($this->additional_images) ? $this->additional_images : [];
    }
}
