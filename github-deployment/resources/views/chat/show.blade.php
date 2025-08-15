@extends('layouts.user')

@section('page-title', 'Chat - ' . ($chatRoom->subject ?: 'General Inquiry'))

@section('styles')
<style>
    /* Jumia Theme for Chat Show */
    .chat-show-container {
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
        background: white;
        border-bottom: 1px solid #e5e7eb;
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .chat-header-info h3 {
        margin: 0;
        color: #111827;
        font-weight: 700;
        font-size: 1.125rem;
    }

    .chat-header-info p {
        margin: 0.25rem 0 0 0;
        color: #6b7280;
        font-size: 0.875rem;
    }

    .chat-header-actions {
        display: flex;
        gap: 0.5rem;
    }

    .chat-header-btn {
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        color: #374151;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .chat-header-btn:hover {
        background: #e5e7eb;
        color: #111827;
        text-decoration: none;
    }

    .chat-header-btn.danger {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }

    .chat-header-btn.danger:hover {
        background: #fee2e2;
        color: #b91c1c;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 1.5rem;
        background: #f9fafb;
    }

    .message-group {
        margin-bottom: 1.5rem;
    }

    .message-date {
        text-align: center;
        margin: 1rem 0;
        color: #9ca3af;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .message {
        display: flex;
        margin-bottom: 1rem;
        align-items: flex-end;
    }

    .message.user-message {
        justify-content: flex-end;
    }

    .message.admin-message {
        justify-content: flex-start;
    }

    .message.system-message {
        justify-content: center;
    }

    .message-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        font-weight: 600;
        color: #6b7280;
        margin: 0 0.5rem;
    }

    .message-content {
        max-width: 70%;
        padding: 0.75rem 1rem;
        border-radius: 18px;
        position: relative;
        word-wrap: break-word;
    }

    .user-message .message-content {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        color: white;
        border-bottom-right-radius: 4px;
    }

    .admin-message .message-content {
        background: white;
        color: #111827;
        border: 1px solid #e5e7eb;
        border-bottom-left-radius: 4px;
    }

    .system-message .message-content {
        background: #f3f4f6;
        color: #6b7280;
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        font-size: 0.875rem;
        font-style: italic;
        text-align: center;
    }

    .message-time {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 0.25rem;
        text-align: center;
    }

    .user-message .message-time {
        color: rgba(255, 255, 255, 0.8);
    }

    .message-file {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        padding: 0.75rem;
        margin-top: 0.5rem;
    }

    .message-file a {
        color: inherit;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .message-file a:hover {
        text-decoration: underline;
    }

    .chat-input {
        background: white;
        border-top: 1px solid #e5e7eb;
        padding: 1rem 1.5rem;
        box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.05);
    }

    .chat-input-form {
        display: flex;
        gap: 0.75rem;
        align-items: flex-end;
    }

    .chat-input-group {
        flex: 1;
        position: relative;
    }

    .chat-textarea {
        width: 100%;
        border: 2px solid #e5e7eb;
        border-radius: 20px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        resize: none;
        min-height: 44px;
        max-height: 120px;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .chat-textarea:focus {
        outline: none;
        border-color: #f68b1e;
        box-shadow: 0 0 0 3px rgba(246, 139, 30, 0.1);
    }

    .chat-actions {
        display: flex;
        gap: 0.5rem;
    }

    .chat-action-btn {
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        color: #6b7280;
        padding: 0.75rem;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
    }

    .chat-action-btn:hover {
        background: #e5e7eb;
        color: #374151;
    }

    .chat-send-btn {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 20px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        min-width: 80px;
    }

    .chat-send-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(246, 139, 30, 0.3);
    }

    .chat-send-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .file-upload-input {
        display: none;
    }

    .typing-indicator {
        padding: 0.5rem 1rem;
        color: #6b7280;
        font-size: 0.875rem;
        font-style: italic;
        display: none;
    }

    .typing-indicator.show {
        display: block;
    }

    .chat-status {
        padding: 0.5rem 1rem;
        background: #f3f4f6;
        border-bottom: 1px solid #e5e7eb;
        font-size: 0.875rem;
        color: #6b7280;
        text-align: center;
    }

    .chat-status.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .chat-status.closed {
        background: #e5e7eb;
        color: #374151;
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

    .back-to-chats {
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        color: #374151;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin: 1rem;
        width: calc(100% - 2rem);
        justify-content: center;
    }

    .back-to-chats:hover {
        background: #e5e7eb;
        color: #111827;
        text-decoration: none;
    }
</style>
@endsection

@section('content')
<div class="chat-show-container">
    <div class="chat-sidebar">
        <div class="chat-header">
            <h3>Customer Support</h3>
        </div>

        <a href="{{ route('chat.index') }}" class="back-to-chats">
            <i class="fas fa-arrow-left"></i>
            Back to Chats
        </a>

        <div class="chat-rooms">
            @foreach(auth()->user()->chatRooms()->with(['latestMessage', 'admin'])->orderBy('last_message_at', 'desc')->get() as $room)
                <div class="chat-room-item {{ $room->id === $chatRoom->id ? 'active' : '' }}"
                     onclick="window.location.href='{{ route('chat.show', $room) }}'">
                    <div class="chat-room-header">
                        <h4 class="chat-room-subject">{{ $room->subject ?: 'General Inquiry' }}</h4>
                        <span class="chat-room-status status-{{ $room->status }}">
                            {{ ucfirst($room->status) }}
                        </span>
                    </div>
                    
                    @if($room->latestMessage)
                        <p class="chat-room-preview">
                            {{ $room->latestMessage->message }}
                        </p>
                    @endif

                    <div class="chat-room-meta">
                        <span class="chat-room-time">
                            @if($room->last_message_at)
                                {{ $room->last_message_at->diffForHumans() }}
                            @else
                                {{ $room->created_at->diffForHumans() }}
                            @endif
                        </span>
                        
                        @if($room->unread_count > 0)
                            <span class="unread-badge">{{ $room->unread_count }}</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="chat-main">
        @if($chatRoom->status === 'closed')
            <div class="chat-status closed">
                <i class="fas fa-lock mr-2"></i>
                This chat has been closed. You can start a new chat if you need further assistance.
            </div>
        @elseif($chatRoom->status === 'pending')
            <div class="chat-status pending">
                <i class="fas fa-clock mr-2"></i>
                Waiting for a support agent to join your chat...
            </div>
        @endif

        <div class="chat-header">
            <div class="chat-header-info">
                <h3>{{ $chatRoom->subject ?: 'General Inquiry' }}</h3>
                <p>
                    @if($chatRoom->admin)
                        Support Agent: {{ $chatRoom->admin->name }}
                    @else
                        Waiting for assignment
                    @endif
                    • {{ $chatRoom->status }}
                </p>
            </div>
            
            <div class="chat-header-actions">
                @if($chatRoom->status === 'open')
                    <form action="{{ route('chat.close', $chatRoom) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="chat-header-btn danger" onclick="return confirm('Are you sure you want to close this chat?')">
                            <i class="fas fa-times"></i>
                            Close Chat
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="chat-messages" id="chatMessages">
            @php
                $currentDate = null;
            @endphp
            
            @foreach($messages as $message)
                @php
                    $messageDate = $message->created_at->format('Y-m-d');
                    if ($currentDate !== $messageDate) {
                        $currentDate = $messageDate;
                        echo '<div class="message-date">' . $message->display_date . '</div>';
                    }
                @endphp

                <div class="message-group">
                    <div class="message {{ $message->sender_id === auth()->id() ? 'user-message' : ($message->isSystemMessage() ? 'system-message' : 'admin-message') }}">
                        @if(!$message->isSystemMessage())
                            <div class="message-avatar">
                                {{ substr($message->sender->name, 0, 1) }}
                            </div>
                        @endif
                        
                        <div class="message-content">
                            @if($message->isSystemMessage())
                                <i class="fas fa-info-circle mr-2"></i>
                            @endif
                            
                            {{ $message->message }}
                            
                            @if($message->isFile() || $message->isImage())
                                <div class="message-file">
                                    <a href="{{ $message->file_url }}" target="_blank">
                                        <i class="fas fa-{{ $message->isImage() ? 'image' : 'file' }}"></i>
                                        {{ $message->file_name }}
                                        <span class="text-sm">({{ $message->file_size }})</span>
                                    </a>
                                </div>
                            @endif
                            
                            <div class="message-time">
                                {{ $message->display_time }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($chatRoom->status !== 'closed')
            <div class="chat-input">
                <form action="{{ route('chat.send-message', $chatRoom) }}" method="POST" id="chatForm">
                    @csrf
                    <div class="chat-input-form">
                        <div class="chat-input-group">
                            <textarea 
                                name="message" 
                                class="chat-textarea" 
                                placeholder="Type your message..."
                                id="messageInput"
                                required></textarea>
                        </div>
                        
                        <div class="chat-actions">
                            <label for="fileUpload" class="chat-action-btn" title="Attach file">
                                <i class="fas fa-paperclip"></i>
                            </label>
                            <input type="file" id="fileUpload" class="file-upload-input" accept="image/*,.pdf,.doc,.docx,.txt">
                            
                            <button type="submit" class="chat-send-btn" id="sendBtn">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chatMessages');
    const messageInput = document.getElementById('messageInput');
    const sendBtn = document.getElementById('sendBtn');
    const fileUpload = document.getElementById('fileUpload');
    const chatForm = document.getElementById('chatForm');
    
    // Auto-scroll to bottom
    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    scrollToBottom();
    
    // Auto-resize textarea
    messageInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });
    
    // File upload handling
    fileUpload.addEventListener('change', function() {
        if (this.files.length > 0) {
            const file = this.files[0];
            const formData = new FormData();
            formData.append('file', file);
            formData.append('_token', '{{ csrf_token() }}');
            
            // Show loading state
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            fetch('{{ route("chat.upload-file", $chatRoom) }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload page to show new message
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to upload file. Please try again.');
            })
            .finally(() => {
                sendBtn.disabled = false;
                sendBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
                fileUpload.value = '';
            });
        }
    });
    
    // Form submission
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const message = messageInput.value.trim();
        if (!message) return;
        
        // Show loading state
        sendBtn.disabled = true;
        sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        // Submit form
        fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                message: message
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Clear input
                messageInput.value = '';
                messageInput.style.height = 'auto';
                
                // Reload page to show new message
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to send message. Please try again.');
        })
        .finally(() => {
            sendBtn.disabled = false;
            sendBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
        });
    });
    
    // Auto-refresh messages every 10 seconds
    setInterval(function() {
        fetch('{{ route("chat.get-messages", $chatRoom) }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Check if there are new messages
                    const currentCount = {{ $messages->count() }};
                    if (data.messages.length > currentCount) {
                        window.location.reload();
                    }
                }
            })
            .catch(error => console.error('Error refreshing messages:', error));
    }, 10000);
});
</script>
@endsection
