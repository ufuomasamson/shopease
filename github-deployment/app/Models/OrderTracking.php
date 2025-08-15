<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'location_country',
        'location_city',
        'status',
        'description',
        'tracked_at',
        'admin_notes'
    ];

    protected $casts = [
        'tracked_at' => 'datetime',
    ];

    /**
     * Get the order that owns the tracking
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the formatted location
     */
    public function getFormattedLocationAttribute()
    {
        return "{$this->location_city}, {$this->location_country}";
    }

    /**
     * Get the tracking status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'shipped' => 'bg-primary',
            'in_transit' => 'bg-info',
            'out_for_delivery' => 'bg-warning',
            'delivered' => 'bg-success',
            'returned' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    /**
     * Get the tracking status text
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'shipped' => 'Shipped',
            'in_transit' => 'In Transit',
            'out_for_delivery' => 'Out for Delivery',
            'delivered' => 'Delivered',
            'returned' => 'Returned',
            default => 'Unknown'
        };
    }

    /**
     * Scope for active tracking entries
     */
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'delivered');
    }

    /**
     * Scope for completed tracking entries
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'delivered');
    }
}
