<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatRoom extends Model
{
    protected $fillable = [
        'user_id',
        'admin_id',
        'status',
        'subject',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    protected $dates = [
        'last_message_at',
    ];

    /**
     * Get the user that owns the chat room
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin assigned to this chat room
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get the messages for this chat room
     */
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get the latest message for this chat room
     */
    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class)->latest('created_at');
    }

    /**
     * Get unread message count for a specific user
     */
    public function getUnreadCountAttribute()
    {
        return $this->messages()
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->count();
    }

    /**
     * Check if chat room is active
     */
    public function isActive(): bool
    {
        return $this->status === 'open';
    }

    /**
     * Check if chat room is closed
     */
    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    /**
     * Check if chat room is pending assignment
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Get status badge class for display
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'open' => 'bg-success',
            'pending' => 'bg-warning',
            'closed' => 'bg-secondary',
            default => 'bg-secondary'
        };
    }

    /**
     * Get status text for display
     */
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'open' => 'Active',
            'pending' => 'Pending',
            'closed' => 'Closed',
            default => 'Unknown'
        };
    }

    /**
     * Update last message timestamp
     */
    public function updateLastMessageTime(): void
    {
        $this->update(['last_message_at' => now()]);
    }

    /**
     * Assign admin to chat room
     */
    public function assignAdmin(User $admin): void
    {
        $this->update([
            'admin_id' => $admin->id,
            'status' => 'open'
        ]);
    }

    /**
     * Close chat room
     */
    public function close(): void
    {
        $this->update(['status' => 'closed']);
    }

    /**
     * Reopen chat room
     */
    public function reopen(): void
    {
        $this->update(['status' => 'open']);
    }
}
