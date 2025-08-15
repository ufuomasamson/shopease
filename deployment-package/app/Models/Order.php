<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'product_id', 'quantity', 'total_price', 'status',
        'shipping_address_id', 'shipping_method', 'shipping_cost',
        'tracking_number', 'carrier', 'order_notes', 'payment_method',
        'payment_status', 'transaction_id', 'estimated_delivery',
        'delivered_at', 'delivery_notes', 'is_cancelled', 'cancelled_at',
        'cancellation_reason', 'is_refunded', 'refunded_at', 'refund_amount'
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'quantity' => 'integer',
        'shipping_cost' => 'decimal:2',
        'is_cancelled' => 'boolean',
        'is_refunded' => 'boolean',
        'refund_amount' => 'decimal:2',
        'estimated_delivery' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    protected $dates = [
        'estimated_delivery', 'delivered_at', 'cancelled_at', 'refunded_at'
    ];

    /**
     * Get the user that owns the order
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that was ordered
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the order's tracking history
     */
    public function tracking()
    {
        return $this->hasMany(OrderTracking::class)->orderBy('tracked_at', 'desc');
    }

    /**
     * Get the latest tracking status
     */
    public function latestTracking()
    {
        return $this->hasOne(OrderTracking::class)->latest('tracked_at');
    }

    /**
     * Get the shipping address for this order
     */
    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    /**
     * Check if order has tracking information
     */
    public function hasTracking(): bool
    {
        return $this->tracking()->exists();
    }

    /**
     * Get current tracking status
     */
    public function getCurrentStatusAttribute()
    {
        return $this->latestTracking?->status ?? 'pending';
    }

    /**
     * Get current location
     */
    public function getCurrentLocationAttribute()
    {
        $latest = $this->latestTracking;
        if (!$latest) return 'Not yet shipped';
        
        return "{$latest->location_city}, {$latest->location_country}";
    }

    /**
     * Get the status badge class for display
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-warning',
            'processing' => 'bg-info',
            'shipped' => 'bg-primary',
            'completed' => 'bg-success',
            'cancelled' => 'bg-danger',
            'refunded' => 'bg-secondary',
            default => 'bg-secondary'
        };
    }

    /**
     * Get the status text for display
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => 'Pending',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'refunded' => 'Refunded',
            default => 'Unknown'
        };
    }

    /**
     * Calculate total price
     */
    public static function calculateTotal(float $price, int $quantity): float
    {
        return $price * $quantity;
    }

    /**
     * Calculate total with shipping
     */
    public function getTotalWithShippingAttribute(): float
    {
        return $this->total_price + $this->shipping_cost;
    }

    /**
     * Check if order is delivered
     */
    public function isDelivered(): bool
    {
        return $this->current_status === 'delivered';
    }

    /**
     * Check if order is in transit
     */
    public function isInTransit(): bool
    {
        return in_array($this->current_status, ['shipped', 'in_transit', 'out_for_delivery']);
    }

    /**
     * Check if order is cancelled
     */
    public function isCancelled(): bool
    {
        return $this->is_cancelled;
    }

    /**
     * Check if order is refunded
     */
    public function isRefunded(): bool
    {
        return $this->is_refunded;
    }

    /**
     * Check if order is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if order is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if order can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'processing']) && !$this->is_cancelled;
    }

    /**
     * Check if order can be refunded
     */
    public function canBeRefunded(): bool
    {
        return $this->isCompleted() && !$this->is_refunded;
    }

    /**
     * Get tracking URL if available
     */
    public function getTrackingUrlAttribute(): ?string
    {
        if (!$this->tracking_number || !$this->carrier) {
            return null;
        }

        $carrierUrls = [
            'DHL' => "https://www.dhl.com/en/express/tracking.html?AWB={$this->tracking_number}",
            'FedEx' => "https://www.fedex.com/fedextrack/?trknbr={$this->tracking_number}",
            'UPS' => "https://www.ups.com/track?tracknum={$this->tracking_number}",
            'USPS' => "https://tools.usps.com/go/TrackConfirmAction?tLabels={$this->tracking_number}",
            'GIG Logistics' => "https://giglogistics.com/track/{$this->tracking_number}",
            'Jumia Express' => "https://www.jumia.com.ng/track/{$this->tracking_number}",
            'Konga Express' => "https://www.konga.com/track/{$this->tracking_number}",
        ];

        return $carrierUrls[$this->carrier] ?? null;
    }

    /**
     * Scope for active orders (not cancelled/refunded)
     */
    public function scopeActive($query)
    {
        return $query->where('is_cancelled', false)->where('is_refunded', false);
    }

    /**
     * Scope for cancelled orders
     */
    public function scopeCancelled($query)
    {
        return $query->where('is_cancelled', true);
    }

    /**
     * Scope for refunded orders
     */
    public function scopeRefunded($query)
    {
        return $query->where('is_refunded', true);
    }

    /**
     * Scope for orders by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for orders with tracking
     */
    public function scopeWithTracking($query)
    {
        return $query->whereNotNull('tracking_number');
    }
}
