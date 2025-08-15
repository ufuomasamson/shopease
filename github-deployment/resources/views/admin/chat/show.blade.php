@extends('layouts.admin')

@section('page-title', 'Chat - ' . ($chatRoom->subject ?: 'General Inquiry'))

@section('content')
<div class="admin-chat-show-container">
    <!-- Chat Sidebar -->
    <div class="chat-sidebar">
        <div class="chat-sidebar-header">
            <h4>Chat Information</h4>
        </div>
        
        <div class="chat-sidebar-content">
            <div class="chat-info-item">
                <label>User:</label>
                <span>{{ $chatRoom->user->name }}</span>
            </div>
            
            <div class="chat-info-item">
                <label>Email:</label>
                <span>{{ $chatRoom->user->email }}</span>
            </div>
            
            <div class="chat-info-item">
                <label>Subject:</label>
                <span>{{ $chatRoom->subject ?: 'General Inquiry' }}</span>
            </div>
            
            <div class="chat-info-item">
                <label>Status:</label>
                <span class="status-badge status-{{ $chatRoom->status }}">
                    {{ ucfirst($chatRoom->status) }}
                </span>
            </div>
            
            <div class="chat-info-item">
                <label>Created:</label>
                <span>{{ $chatRoom->created_at->format('M d, Y H:i') }}</span>
            </div>
            
            @if($chatRoom->last_message_at)
            <div class="chat-info-item">
                <label>Last Message:</label>
                <span>{{ $chatRoom->last_message_at->format('M d, Y H:i') }}</span>
            </div>
            @endif
        </div>
        
        <div class="chat-sidebar-actions">
            @if($chatRoom->status === 'pending')
                <button class="btn btn-primary w-100 mb-2" onclick="assignChat()">
                    <i class="fas fa-user-plus"></i> Assign to Me
                </button>
            @endif
            
            @if($chatRoom->status === 'open')
                <button class="btn btn-warning w-100 mb-2" onclick="closeChat()">
                    <i class="fas fa-times-circle"></i> Close Chat
                </button>
            @endif
            
            @if($chatRoom->status === 'closed')
                <button class="btn btn-success w-100 mb-2" onclick="reopenChat()">
                    <i class="fas fa-redo"></i> Reopen Chat
                </button>
            @endif
            
            <a href="{{ route('admin.chat.index') }}" class="btn btn-outline-secondary w-100">
                <i class="fas fa-arrow-left"></i> Back to Chats
            </a>
        </div>
    </div>

    <!-- Chat Main Area -->
    <div class="chat-main">
        <!-- Chat Header -->
        <div class="chat-header">
            <div class="chat-header-info">
                <h3>{{ $chatRoom->subject ?: 'General Inquiry' }}</h3>
                <p>Chat with {{ $chatRoom->user->name }} ({{ $chatRoom->user->email }})</p>
            </div>
            
            <div class="chat-header-actions">
                @if($chatRoom->status === 'pending')
                    <button class="chat-header-btn" onclick="assignChat()">
                        <i class="fas fa-user-plus"></i> Assign
                    </button>
                @endif
                
                @if($chatRoom->status === 'open')
                    <button class="chat-header-btn danger" onclick="closeChat()">
                        <i class="fas fa-times-circle"></i> Close
                    </button>
                @endif
                
                @if($chatRoom->status === 'closed')
                    <button class="chat-header-btn success" onclick="reopenChat()">
                        <i class="fas fa-redo"></i> Reopen
                    </button>
                @endif
            </div>
        </div>

        <!-- Chat Messages -->
        <div class="chat-messages" id="chatMessages">
            @foreach($messages as $message)
                <div class="chat-message {{ $message->sender_id === auth()->id() ? 'admin' : 'user' }}" data-message-id="{{ $message->id }}">
                    <div class="message-avatar">
                        @if($message->sender_id === auth()->id())
                            <i class="fas fa-user-shield"></i>
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </div>
                    
                    <div class="message-content">
                        <div class="message-header">
                            <span class="message-sender">
                                {{ $message->sender_id === auth()->id() ? 'You' : $message->sender->name }}
                            </span>
                            <span class="message-time">
                                {{ $message->created_at->format('M d, Y H:i') }}
                            </span>
                        </div>
                        
                        <div class="message-text">
                            @if($message->message_type === 'system')
                                <em class="system-message">{{ $message->message }}</em>
                            @else
                                {{ $message->message }}
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Chat Input -->
        @if($chatRoom->status !== 'closed')
        <div class="chat-input">
            <form id="chatForm" onsubmit="sendMessage(event)">
                <div class="input-group">
                    <input type="text" 
                           id="messageInput" 
                           class="form-control" 
                           placeholder="Type your message..." 
                           maxlength="1000"
                           required>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Send
                    </button>
                </div>
            </form>
        </div>
        @else
        <div class="chat-closed-notice">
            <div class="alert alert-warning text-center">
                <i class="fas fa-lock"></i> This chat is closed. You cannot send new messages.
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Jumia Theme for Admin Chat Show */
    .admin-chat-show-container {
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

    .chat-sidebar-header {
        background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
        color: white;
        padding: 1.5rem;
        text-align: center;
    }

    .chat-sidebar-header h4 {
        margin: 0;
        font-weight: 600;
    }

    .chat-sidebar-content {
        padding: 1.5rem;
        flex: 1;
    }

    .chat-info-item {
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .chat-info-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .chat-info-item label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.25rem;
        font-size: 0.875rem;
    }

    .chat-info-item span {
        color: #6b7280;
        font-size: 0.9rem;
    }

    .status-badge {
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
        background: #fee2e2;
        color: #991b1b;
    }

    .chat-sidebar-actions {
        padding: 1.5rem;
        border-top: 1px solid #f3f4f6;
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
        text-decoration: none;
    }

    .chat-header-btn.success {
        background: #d1fae5;
        color: #065f46;
        border-color: #a7f3d0;
    }

    .chat-header-btn.success:hover {
        background: #a7f3d0;
        color: #064e3b;
        text-decoration: none;
    }

    .chat-messages {
        flex: 1;
        padding: 1.5rem;
        overflow-y: auto;
        background: #f9fafb;
    }

    .chat-message {
        display: flex;
        margin-bottom: 1.5rem;
        align-items: flex-start;
    }

    .chat-message.user {
        flex-direction: row;
    }

    .chat-message.admin {
        flex-direction: row-reverse;
    }

    .message-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin: 0 0.75rem;
    }

    .chat-message.user .message-avatar {
        background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
        color: white;
    }

    .chat-message.admin .message-avatar {
        background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);
        color: white;
    }

    .message-content {
        max-width: 70%;
        background: white;
        padding: 1rem;
        border-radius: 18px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .chat-message.user .message-content {
        border-bottom-left-radius: 4px;
    }

    .chat-message.admin .message-content {
        border-bottom-right-radius: 4px;
        background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);
        color: white;
    }

    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .message-sender {
        font-weight: 600;
        color: #374151;
    }

    .chat-message.admin .message-sender {
        color: white;
    }

    .message-time {
        color: #9ca3af;
        font-size: 0.75rem;
    }

    .chat-message.admin .message-time {
        color: rgba(255, 255, 255, 0.8);
    }

    .message-text {
        line-height: 1.5;
        color: #374151;
    }

    .chat-message.admin .message-text {
        color: white;
    }

    .system-message {
        color: #6b7280;
        font-style: italic;
    }

    .chat-input {
        background: white;
        border-top: 1px solid #e5e7eb;
        padding: 1.5rem;
    }

    .input-group {
        display: flex;
        gap: 0.75rem;
    }

    .form-control {
        flex: 1;
        border: 1px solid #e5e7eb;
        border-radius: 25px;
        padding: 0.75rem 1.25rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #17a2b8;
        box-shadow: 0 0 0 3px rgba(23, 162, 184, 0.1);
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 25px;
        font-size: 0.95rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
    }

    .btn-warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        color: white;
    }

    .btn-warning:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }

    .btn-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .btn-outline-secondary {
        background: transparent;
        color: #6b7280;
        border: 1px solid #e5e7eb;
    }

    .btn-outline-secondary:hover {
        background: #f3f4f6;
        color: #374151;
    }

    .w-100 {
        width: 100%;
    }

    .mb-2 {
        margin-bottom: 0.5rem;
    }

    .chat-closed-notice {
        padding: 1.5rem;
        background: white;
        border-top: 1px solid #e5e7eb;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid transparent;
    }

    .alert-warning {
        background: #fef3c7;
        color: #92400e;
        border-color: #fde68a;
    }

    .text-center {
        text-align: center;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .chat-sidebar {
            width: 300px;
        }
    }

    @media (max-width: 768px) {
        .admin-chat-show-container {
            flex-direction: column;
        }
        
        .chat-sidebar {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .chat-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .chat-header-actions {
            justify-content: center;
        }
        
        .message-content {
            max-width: 85%;
        }
    }
</style>

<script>
    let currentChatId = {{ $chatRoom->id }};
    let messageCheckInterval = null;

    // Start message checking when page loads
    document.addEventListener('DOMContentLoaded', function() {
        startMessagePolling();
        scrollToBottom();
    });

    function startMessagePolling() {
        // Check for new messages every 3 seconds
        messageCheckInterval = setInterval(function() {
            checkForNewMessages();
        }, 3000);
    }

    function stopMessagePolling() {
        if (messageCheckInterval) {
            clearInterval(messageCheckInterval);
            messageCheckInterval = null;
        }
    }

    function checkForNewMessages() {
        fetch('{{ route("admin.chat.get-messages", $chatRoom) }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateChatMessages(data.messages);
                }
            })
            .catch(error => {
                console.error('Error checking for new messages:', error);
            });
    }

    function updateChatMessages(messages) {
        const messagesContainer = document.getElementById('chatMessages');
        const currentMessageIds = Array.from(messagesContainer.children).map(el => parseInt(el.dataset.messageId));
        
        // Add only new messages
        messages.forEach(msg => {
            if (!currentMessageIds.includes(msg.id)) {
                addMessageToChat(msg);
            }
        });
        
        scrollToBottom();
    }

    function addMessageToChat(messageData) {
        const messagesContainer = document.getElementById('chatMessages');
        
        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message ${messageData.sender_id === {{ auth()->id() }} ? 'admin' : 'user'}`;
        messageDiv.dataset.messageId = messageData.id;
        
        const messageTime = new Date(messageData.created_at);
        const timeString = messageTime.toLocaleDateString('en-US', { 
            month: 'short', 
            day: 'numeric', 
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        
        messageDiv.innerHTML = `
            <div class="message-avatar">
                <i class="fas fa-${messageData.sender_id === {{ auth()->id() }} ? 'user-shield' : 'user'}"></i>
            </div>
            
            <div class="message-content">
                <div class="message-header">
                    <span class="message-sender">
                        ${messageData.sender_id === {{ auth()->id() }} ? 'You' : messageData.sender.name}
                    </span>
                    <span class="message-time">
                        ${timeString}
                    </span>
                </div>
                
                <div class="message-text">
                    ${messageData.message_type === 'system' ? `<em class="system-message">${messageData.message}</em>` : messageData.message}
                </div>
            </div>
        `;
        
        messagesContainer.appendChild(messageDiv);
    }

    function sendMessage(event) {
        event.preventDefault();
        
        const input = document.getElementById('messageInput');
        const message = input.value.trim();
        
        if (!message) return;
        
        // Show loading state
        const submitBtn = event.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        submitBtn.disabled = true;
        
        fetch('{{ route("admin.chat.send-message", $chatRoom) }}', {
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
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Clear input
                input.value = '';
                
                // Add message to chat
                addMessageToChat(data.message);
                
                // Scroll to bottom
                scrollToBottom();
            } else {
                throw new Error(data.message || 'Message not sent successfully');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to send message: ' + error.message);
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }

    function assignChat() {
        if (confirm('Assign this chat to yourself?')) {
            fetch('{{ route("admin.chat.assign", $chatRoom) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to assign chat: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to assign chat');
            });
        }
    }

    function closeChat() {
        if (confirm('Close this chat? Users will not be able to send new messages.')) {
            fetch('{{ route("admin.chat.close", $chatRoom) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to close chat: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to close chat');
            });
        }
    }

    function reopenChat() {
        if (confirm('Reopen this chat? Users will be able to send new messages again.')) {
            fetch('{{ route("admin.chat.reopen", $chatRoom) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to reopen chat: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to reopen chat');
            });
        }
    }

    function scrollToBottom() {
        const messagesContainer = document.getElementById('chatMessages');
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }

    // Clean up on page unload
    window.addEventListener('beforeunload', function() {
        stopMessagePolling();
    });
</script>
@endsection
