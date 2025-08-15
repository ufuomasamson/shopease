<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReview extends Model
{
    protected $fillable = [
        'product_id', 'user_id', 'rating', 'title', 'comment',
        'is_verified_purchase', 'is_approved', 'images'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified_purchase' => 'boolean',
        'is_approved' => 'boolean',
        'images' => 'array',
    ];

    /**
     * Get the product being reviewed
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user who wrote the review
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for approved reviews
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope for verified purchase reviews
     */
    public function scopeVerifiedPurchase($query)
    {
        return $query->where('is_verified_purchase', true);
    }

    /**
     * Scope for reviews by rating
     */
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Get review images URLs
     */
    public function getImageUrlsAttribute(): array
    {
        if (!$this->images) {
            return [];
        }
        
        return array_map(function($image) {
            return \Storage::url($image);
        }, $this->images);
    }

    /**
     * Get star rating display
     */
    public function getStarRatingAttribute(): string
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '<i class="fas fa-star text-warning"></i>';
            } else {
                $stars .= '<i class="far fa-star text-muted"></i>';
            }
        }
        return $stars;
    }

    /**
     * Check if review has images
     */
    public function hasImages(): bool
    {
        return !empty($this->images);
    }

    /**
     * Get review status badge class
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return $this->is_approved ? 'success' : 'warning';
    }

    /**
     * Get review status text
     */
    public function getStatusTextAttribute(): string
    {
        return $this->is_approved ? 'Approved' : 'Pending';
    }
}
