<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the user's wallet
     */
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * Get the user's orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the user's wallet transactions
     */
    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    /**
     * Get the user's shipping addresses
     */
    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class);
    }

    /**
     * Get the user's default shipping address
     */
    public function defaultShippingAddress()
    {
        return $this->hasOne(ShippingAddress::class)->where('is_default', true);
    }

    /**
     * Get the user's billing address
     */
    public function billingAddress()
    {
        return $this->hasOne(ShippingAddress::class)->where('is_billing_address', true);
    }

    /**
     * Get the user's product reviews
     */
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    /**
     * Get the user's verified purchase reviews
     */
    public function verifiedPurchaseReviews()
    {
        return $this->hasMany(ProductReview::class)->where('is_verified_purchase', true);
    }

    /**
     * Get the user's chat rooms (as a customer)
     */
    public function chatRooms()
    {
        return $this->hasMany(ChatRoom::class);
    }

    /**
     * Get the chat rooms assigned to this admin
     */
    public function assignedChatRooms()
    {
        return $this->hasMany(ChatRoom::class, 'admin_id');
    }

    /**
     * Get the user's chat messages
     */
    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }

    /**
     * Get unread message count for this user
     */
    public function getUnreadMessageCountAttribute()
    {
        return ChatMessage::whereHas('chatRoom', function ($query) {
            $query->where('user_id', $this->id);
        })->where('sender_id', '!=', $this->id)
        ->where('is_read', false)
        ->count();
    }

    /**
     * Get unread message count for admin
     */
    public function getUnreadAdminMessageCountAttribute()
    {
        if (!$this->isAdmin()) {
            return 0;
        }

        return ChatMessage::whereHas('chatRoom', function ($query) {
            $query->where('admin_id', $this->id);
        })->where('sender_id', '!=', $this->id)
        ->where('is_read', false)
        ->count();
    }
}
