@extends('layouts.user')

@section('page-title', 'Customer Support Chat')

@section('styles')
<style>
    /* Jumia Theme for Chat Interface */
    .chat-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        display: flex;
    }

    .chat-sidebar {
        background: white;
        width: 350px;
        border-right: 1px solid #e5e7eb;
        display: flex;
        flex-direction: column;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .chat-main {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .chat-header {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        color: white;
        padding: 1.5rem;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .chat-header h2 {
        margin: 0;
        font-weight: 800;
        font-size: 1.5rem;
    }

    .chat-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }

    .new-chat-btn {
        background: #54d22d;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        margin: 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .new-chat-btn:hover {
        background: #45c01a;
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    .chat-rooms {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
    }

    .chat-room-item {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .chat-room-item:hover {
        border-color: #f68b1e;
        box-shadow: 0 4px 12px rgba(246, 139, 30, 0.15);
        transform: translateY(-2px);
    }

    .chat-room-item.active {
        border-color: #f68b1e;
        background: #fff8f0;
    }

    .chat-room-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.5rem;
    }

    .chat-room-subject {
        font-weight: 600;
        color: #111827;
        margin: 0;
        font-size: 1rem;
    }

    .chat-room-status {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-open {
        background: #d1fae5;
        color: #065f46;
    }

    .status-closed {
        background: #e5e7eb;
        color: #374151;
    }

    .chat-room-preview {
        color: #6b7280;
        font-size: 0.875rem;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .chat-room-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.75rem;
        font-size: 0.75rem;
        color: #9ca3af;
    }

    .chat-room-time {
        font-weight: 500;
    }

    .unread-badge {
        background: #ef4444;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .chat-placeholder {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 2rem;
        color: #6b7280;
    }

    .chat-placeholder-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }

    .chat-placeholder h3 {
        margin: 0 0 0.5rem 0;
        color: #374151;
        font-weight: 600;
    }

    .chat-placeholder p {
        margin: 0;
        color: #6b7280;
        max-width: 400px;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #6b7280;
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }

    .empty-state h3 {
        margin: 0 0 0.5rem 0;
        color: #374151;
        font-weight: 600;
    }

    .empty-state p {
        margin: 0 0 1.5rem 0;
        color: #6b7280;
    }
</style>
@endsection

@section('content')
<div class="chat-container">
    <div class="chat-sidebar">
        <div class="chat-header">
            <h2>Customer Support</h2>
            <p>Get help with your orders and questions</p>
        </div>

        <a href="{{ route('chat.create') }}" class="new-chat-btn">
            <i class="fas fa-plus mr-2"></i> Start New Chat
        </a>

        <div class="chat-rooms">
            @if($chatRooms->count() > 0)
                @foreach($chatRooms as $chatRoom)
                    <div class="chat-room-item {{ request()->route('chatRoom') && request()->route('chatRoom')->id === $chatRoom->id ? 'active' : '' }}"
                         onclick="window.location.href='{{ route('chat.show', $chatRoom) }}'">
                        <div class="chat-room-header">
                            <h4 class="chat-room-subject">{{ $chatRoom->subject ?: 'General Inquiry' }}</h4>
                            <span class="chat-room-status status-{{ $chatRoom->status }}">
                                {{ ucfirst($chatRoom->status) }}
                            </span>
                        </div>
                        
                        @if($chatRoom->latestMessage)
                            <p class="chat-room-preview">
                                {{ $chatRoom->latestMessage->message }}
                            </p>
                        @endif

                        <div class="chat-room-meta">
                            <span class="chat-room-time">
                                @if($chatRoom->last_message_at)
                                    {{ $chatRoom->last_message_at->diffForHumans() }}
                                @else
                                    {{ $chatRoom->created_at->diffForHumans() }}
                                @endif
                            </span>
                            
                            @if($chatRoom->unread_count > 0)
                                <span class="unread-badge">{{ $chatRoom->unread_count }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3>No Chats Yet</h3>
                    <p>Start a conversation with our customer support team to get help with your orders or ask questions.</p>
                    <a href="{{ route('chat.create') }}" class="new-chat-btn">
                        <i class="fas fa-plus mr-2"></i> Start First Chat
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="chat-main">
        <div class="chat-placeholder">
            <div class="chat-placeholder-icon">
                <i class="fas fa-comments"></i>
            </div>
            <h3>Welcome to Customer Support</h3>
            <p>Select a chat from the sidebar to start messaging, or create a new chat to get help with your questions.</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-refresh chat rooms every 30 seconds
    setInterval(function() {
        // You can implement AJAX refresh here if needed
    }, 30000);
</script>
@endsection
