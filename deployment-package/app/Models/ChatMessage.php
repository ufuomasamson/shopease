<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    protected $fillable = [
        'chat_room_id',
        'sender_id',
        'message',
        'message_type',
        'file_path',
        'file_name',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    protected $dates = [
        'read_at',
    ];

    /**
     * Get the chat room that owns the message
     */
    public function chatRoom(): BelongsTo
    {
        return $this->belongsTo(ChatRoom::class);
    }

    /**
     * Get the sender of the message
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Check if message is from admin
     */
    public function isFromAdmin(): bool
    {
        return $this->sender && $this->sender->isAdmin();
    }

    /**
     * Check if message is from user
     */
    public function isFromUser(): bool
    {
        return $this->sender && !$this->sender->isAdmin();
    }

    /**
     * Check if message is a system message
     */
    public function isSystemMessage(): bool
    {
        return $this->message_type === 'system';
    }

    /**
     * Check if message is a file
     */
    public function isFile(): bool
    {
        return $this->message_type === 'file';
    }

    /**
     * Check if message is an image
     */
    public function isImage(): bool
    {
        return $this->message_type === 'image';
    }

    /**
     * Mark message as read
     */
    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    /**
     * Get file URL if message is a file
     */
    public function getFileUrlAttribute(): ?string
    {
        if ($this->file_path) {
            return \Storage::url($this->file_path);
        }
        return null;
    }

    /**
     * Get file size in human readable format
     */
    public function getFileSizeAttribute(): ?string
    {
        if ($this->file_path && \Storage::exists($this->file_path)) {
            $bytes = \Storage::size($this->file_path);
            $units = ['B', 'KB', 'MB', 'GB'];
            
            for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
                $bytes /= 1024;
            }
            
            return round($bytes, 2) . ' ' . $units[$i];
        }
        return null;
    }

    /**
     * Get message time in human readable format
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get message date for display
     */
    public function getDisplayDateAttribute(): string
    {
        if ($this->created_at->isToday()) {
            return 'Today';
        } elseif ($this->created_at->isYesterday()) {
            return 'Yesterday';
        } else {
            return $this->created_at->format('M j, Y');
        }
    }

    /**
     * Get message time for display
     */
    public function getDisplayTimeAttribute(): string
    {
        return $this->created_at->format('g:i A');
    }
}
