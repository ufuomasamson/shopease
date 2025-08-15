<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'icon', 'parent_id',
        'sort_order', 'is_active', 'is_featured',
        'meta_title', 'meta_description', 'meta_keywords'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the parent category
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get all descendants (children, grandchildren, etc.)
     */
    public function descendants(): HasMany
    {
        return $this->children()->with('descendants');
    }

    /**
     * Get all ancestors (parent, grandparent, etc.)
     */
    public function ancestors(): BelongsTo
    {
        return $this->parent()->with('ancestors');
    }

    /**
     * Get products in this category
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * Get all products in this category and subcategories
     */
    public function allProducts(): HasManyThrough
    {
        return $this->hasManyThrough(
            Product::class,
            Category::class,
            'parent_id',
            'category_id',
            'id',
            'id'
        );
    }

    /**
     * Check if category has children
     */
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    /**
     * Check if category is a child
     */
    public function isChild(): bool
    {
        return !is_null($this->parent_id);
    }

    /**
     * Check if category is a parent
     */
    public function isParent(): bool
    {
        return $this->children()->exists();
    }

    /**
     * Get the full category path (e.g., "Electronics > Phones > Smartphones")
     */
    public function getFullPathAttribute(): string
    {
        $path = [$this->name];
        $parent = $this->parent;
        
        while ($parent) {
            array_unshift($path, $parent->name);
            $parent = $parent->parent;
        }
        
        return implode(' > ', $path);
    }

    /**
     * Get category level (0 for root, 1 for first level, etc.)
     */
    public function getLevelAttribute(): int
    {
        $level = 0;
        $parent = $this->parent;
        
        while ($parent) {
            $level++;
            $parent = $parent->parent;
        }
        
        return $level;
    }

    /**
     * Scope for active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured categories
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for root categories (no parent)
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope for subcategories
     */
    public function scopeSubcategories($query)
    {
        return $query->whereNotNull('parent_id');
    }

    /**
     * Get category image URL
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return \Storage::url($this->image);
        }
        return asset('images/placeholder-category.jpg');
    }

    /**
     * Get products count in this category
     */
    public function getProductsCountAttribute(): int
    {
        return $this->products()->count();
    }

    /**
     * Get total products count including subcategories
     */
    public function getTotalProductsCountAttribute(): int
    {
        $count = $this->products()->count();
        
        foreach ($this->children as $child) {
            $count += $child->total_products_count;
        }
        
        return $count;
    }
}
