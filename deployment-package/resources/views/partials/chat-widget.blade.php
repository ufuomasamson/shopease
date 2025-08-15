@auth
    @if(!auth()->user()->isAdmin())
        <!-- Floating Chat Widget -->
        <div class="chat-widget" id="chatWidget">
            <!-- Chat Widget Toggle Button -->
            <div class="chat-widget-toggle" id="chatWidgetToggle" onclick="toggleChatWidget()">
                <i class="fas fa-comments"></i>
                @if(auth()->user()->unread_message_count > 0)
                    <span class="chat-widget-badge">{{ auth()->user()->unread_message_count }}</span>
                @endif
            </div>

            <!-- Chat Widget Panel -->
            <div class="chat-widget-panel" id="chatWidgetPanel">
                <div class="chat-widget-header">
                    <h4>Customer Support</h4>
                    <button class="chat-widget-close" onclick="toggleChatWidget()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="chat-widget-content">
                    @if(auth()->user()->chatRooms()->where('status', 'open')->count() > 0)
                        <!-- Existing Chat -->
                        @php
                            $activeChat = auth()->user()->chatRooms()->where('status', 'open')->first();
                        @endphp
                        <div class="chat-widget-messages" id="chatWidgetMessages" data-chat-id="{{ $activeChat->id }}">
                            @foreach($activeChat->messages()->with('sender')->orderBy('created_at', 'asc')->get() as $message)
                                <div class="chat-widget-message {{ $message->sender_id === auth()->id() ? 'user' : 'admin' }}" data-message-id="{{ $message->id }}">
                                    <div class="message-content">
                                        {{ $message->message }}
                                    </div>
                                    <div class="message-time">{{ $message->created_at->format('H:i') }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="chat-widget-input">
                            <form id="chatWidgetForm" onsubmit="sendWidgetMessage(event)">
                                <div class="input-group">
                                    <input type="text" 
                                           id="chatWidgetInput" 
                                           placeholder="Type your message..." 
                                           class="form-control"
                                           maxlength="500">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="chat-widget-footer">
                            <a href="{{ route('chat.show', $activeChat) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-external-link-alt"></i> Open Full Chat
                            </a>
                        </div>
                    @else
                        <!-- New Chat -->
                        <div class="chat-widget-new" id="chatWidgetNew">
                            <div class="chat-widget-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <h5>Need Help?</h5>
                            <p>Start a conversation with our customer support team</p>
                            <button class="btn btn-primary" onclick="showNewChatForm()">
                                <i class="fas fa-plus"></i> Start Chat
                            </button>
                        </div>

                        <!-- New Chat Form (Hidden by default) -->
                        <div class="chat-widget-new-form" id="chatWidgetNewForm" style="display: none;">
                            <h5>Start New Chat</h5>
                            <form id="newChatForm" onsubmit="createNewChat(event)">
                                <div class="form-group mb-3">
                                    <label for="chatSubject" class="form-label">Subject</label>
                                    <input type="text" 
                                           id="chatSubject" 
                                           class="form-control" 
                                           placeholder="What can we help you with?"
                                           required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="chatMessage" class="form-label">Message</label>
                                    <textarea id="chatMessage" 
                                              class="form-control" 
                                              rows="3"
                                              placeholder="Describe your issue or question..."
                                              required></textarea>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary flex-fill">
                                        <i class="fas fa-paper-plane"></i> Send
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="hideNewChatForm()">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <style>
            .chat-widget {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 1000;
                font-family: 'Inter', sans-serif;
            }

            .chat-widget-toggle {
                width: 60px;
                height: 60px;
                background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.5rem;
                cursor: pointer;
                box-shadow: 0 4px 20px rgba(23, 162, 184, 0.4);
                transition: all 0.3s ease;
                position: relative;
            }

            .chat-widget-toggle:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 25px rgba(23, 162, 184, 0.5);
            }

            .chat-widget-badge {
                position: absolute;
                top: -5px;
                right: -5px;
                background: #dc3545;
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

            .chat-widget-panel {
                position: absolute;
                bottom: 80px;
                right: 0;
                width: 350px;
                background: white;
                border-radius: 16px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
                opacity: 0;
                visibility: hidden;
                transform: translateY(20px) scale(0.95);
                transition: all 0.3s ease;
                border: 1px solid #e5e7eb;
            }

            .chat-widget-panel.show {
                opacity: 1;
                visibility: visible;
                transform: translateY(0) scale(1);
            }

            .chat-widget-header {
                background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 16px 16px 0 0;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .chat-widget-header h4 {
                margin: 0;
                font-weight: 600;
                font-size: 1.1rem;
            }

            .chat-widget-close {
                background: none;
                border: none;
                color: white;
                font-size: 1.2rem;
                cursor: pointer;
                padding: 0.25rem;
                border-radius: 4px;
                transition: background 0.2s ease;
            }

            .chat-widget-close:hover {
                background: rgba(255, 255, 255, 0.2);
            }

            .chat-widget-content {
                padding: 1rem;
                max-height: 400px;
                overflow-y: auto;
            }

            .chat-widget-messages {
                margin-bottom: 1rem;
                max-height: 300px;
                overflow-y: auto;
            }

            .chat-widget-message {
                margin-bottom: 0.75rem;
                display: flex;
                flex-direction: column;
            }

            .chat-widget-message.user {
                align-items: flex-end;
            }

            .chat-widget-message.admin {
                align-items: flex-start;
            }

            .message-content {
                background: #f3f4f6;
                padding: 0.75rem 1rem;
                border-radius: 18px;
                max-width: 80%;
                word-wrap: break-word;
                font-size: 0.9rem;
                line-height: 1.4;
            }

            .chat-widget-message.user .message-content {
                background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
                color: white;
            }

            .chat-widget-message.admin .message-content {
                background: #f3f4f6;
                color: #374151;
            }

            .message-time {
                font-size: 0.75rem;
                color: #9ca3af;
                margin-top: 0.25rem;
                font-weight: 500;
            }

            .chat-widget-input {
                margin-bottom: 1rem;
            }

            .chat-widget-input .input-group {
                display: flex;
                gap: 0.5rem;
            }

            .chat-widget-input input {
                flex: 1;
                border: 1px solid #e5e7eb;
                border-radius: 20px;
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
                transition: border-color 0.2s ease;
            }

            .chat-widget-input input:focus {
                outline: none;
                border-color: #17a2b8;
                box-shadow: 0 0 0 3px rgba(23, 162, 184, 0.1);
            }

            .chat-widget-input button {
                background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
                border: none;
                color: white;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .chat-widget-input button:hover {
                transform: scale(1.05);
                box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
            }

            .chat-widget-footer {
                text-align: center;
                padding-top: 0.5rem;
                border-top: 1px solid #f3f4f6;
            }

            .chat-widget-footer .btn {
                font-size: 0.85rem;
                padding: 0.5rem 1rem;
            }

            .chat-widget-new {
                text-align: center;
                padding: 2rem 1rem;
            }

            .chat-widget-icon {
                font-size: 3rem;
                color: #17a2b8;
                margin-bottom: 1rem;
            }

            .chat-widget-new h5 {
                color: #374151;
                margin-bottom: 0.5rem;
                font-weight: 600;
            }

            .chat-widget-new p {
                color: #6b7280;
                margin-bottom: 1.5rem;
                font-size: 0.9rem;
            }

            .chat-widget-new-form {
                padding: 1rem 0;
            }

            .chat-widget-new-form h5 {
                color: #374151;
                margin-bottom: 1rem;
                font-weight: 600;
                text-align: center;
            }

            .form-group {
                margin-bottom: 1rem;
            }

            .form-label {
                display: block;
                margin-bottom: 0.5rem;
                color: #374151;
                font-weight: 500;
                font-size: 0.9rem;
            }

            .form-control {
                width: 100%;
                padding: 0.75rem;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                font-size: 0.9rem;
                transition: border-color 0.2s ease;
            }

            .form-control:focus {
                outline: none;
                border-color: #17a2b8;
                box-shadow: 0 0 0 3px rgba(23, 162, 184, 0.1);
            }

            .btn {
                padding: 0.75rem 1.5rem;
                border: none;
                border-radius: 8px;
                font-size: 0.9rem;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s ease;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
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

            .btn-outline-primary {
                background: transparent;
                color: #17a2b8;
                border: 1px solid #17a2b8;
            }

            .btn-outline-primary:hover {
                background: #17a2b8;
                color: white;
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

            .btn-sm {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }

            .flex-fill {
                flex: 1;
            }

            .gap-2 {
                gap: 0.5rem;
            }

            .mb-3 {
                margin-bottom: 1rem;
            }

            .me-2 {
                margin-right: 0.5rem;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .chat-widget-panel {
                    width: calc(100vw - 40px);
                    right: -10px;
                }
            }

            /* Message Notification Styles */
            .chat-notification {
                position: fixed;
                top: 20px;
                right: 20px;
                background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                box-shadow: 0 8px 25px rgba(23, 162, 184, 0.3);
                z-index: 10000;
                transform: translateX(100%);
                transition: transform 0.3s ease;
                max-width: 350px;
                border: none;
            }

            .chat-notification.show {
                transform: translateX(0);
            }

            .notification-content {
                display: flex;
                align-items: center;
                font-weight: 500;
                font-size: 0.9rem;
            }

            .notification-content i {
                font-size: 1.1rem;
                margin-right: 0.5rem;
            }
        </style>

        <script>
            let chatWidgetOpen = false;
            let messageCheckInterval = null;
            let currentChatId = null;

            // Initialize chat widget
            document.addEventListener('DOMContentLoaded', function() {
                initializeChatWidget();
            });

            function initializeChatWidget() {
                const messagesContainer = document.getElementById('chatWidgetMessages');
                if (messagesContainer) {
                    currentChatId = messagesContainer.dataset.chatId;
                    startMessagePolling();
                }
            }

            function toggleChatWidget() {
                const panel = document.getElementById('chatWidgetPanel');
                chatWidgetOpen = !chatWidgetOpen;
                
                if (chatWidgetOpen) {
                    panel.classList.add('show');
                    // Scroll to bottom of messages
                    const messages = document.getElementById('chatWidgetMessages');
                    if (messages) {
                        messages.scrollTop = messages.scrollHeight;
                    }
                    // Start polling when widget is open
                    startMessagePolling();
                } else {
                    panel.classList.remove('show');
                    // Stop polling when widget is closed
                    stopMessagePolling();
                }
            }

            function startMessagePolling() {
                if (messageCheckInterval) {
                    clearInterval(messageCheckInterval);
                }
                
                // Only start polling if there's an active chat
                if (currentChatId) {
                    messageCheckInterval = setInterval(function() {
                        if (chatWidgetOpen && currentChatId) {
                            checkForNewMessages();
                            updateUnreadBadge();
                        }
                    }, 10000); // Check every 10 seconds, only when widget is open
                }
            }

            function stopMessagePolling() {
                if (messageCheckInterval) {
                    clearInterval(messageCheckInterval);
                    messageCheckInterval = null;
                }
            }

            function sendWidgetMessage(event) {
                event.preventDefault();
                
                const input = document.getElementById('chatWidgetInput');
                const message = input.value.trim();
                
                if (!message) return;
                
                // Show loading state
                const submitBtn = event.target.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                submitBtn.disabled = true;
                
                // Send message to current chat
                if (currentChatId) {
                    sendMessageToChat(currentChatId, message, input, submitBtn, originalText);
                } else {
                    alert('No active chat found. Please start a new chat first.');
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }

            function sendMessageToChat(chatId, msg, input, submitBtn, originalText) {
                fetch('{{ route("chat.send-message", ":chatRoom") }}'.replace(':chatRoom', chatId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        message: msg
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
                        
                        // Add new message to the chat widget dynamically
                        addMessageToWidget(msg, 'user', Date.now());
                        
                        // Scroll to bottom
                        const messages = document.getElementById('chatWidgetMessages');
                        if (messages) {
                            messages.scrollTop = messages.scrollHeight;
                        }
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

            // New Chat Functions
            function showNewChatForm() {
                document.getElementById('chatWidgetNew').style.display = 'none';
                document.getElementById('chatWidgetNewForm').style.display = 'block';
            }

            function hideNewChatForm() {
                document.getElementById('chatWidgetNewForm').style.display = 'none';
                document.getElementById('chatWidgetNew').style.display = 'block';
            }

            function createNewChat(event) {
                event.preventDefault();
                
                const subject = document.getElementById('chatSubject').value.trim();
                const message = document.getElementById('chatMessage').value.trim();
                
                if (!subject || !message) return;
                
                // Show loading state
                const submitBtn = event.target.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                submitBtn.disabled = true;
                
                // Create new chat via AJAX
                fetch('{{ route("chat.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        subject: subject,
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
                        // Reload widget to show the new chat
                        location.reload();
                    } else {
                        throw new Error(data.message || 'Failed to create chat');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to create chat: ' + error.message);
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            }

            // Helper function to add message to widget
            function addMessageToWidget(message, senderType, messageId = null) {
                const messagesContainer = document.getElementById('chatWidgetMessages');
                if (!messagesContainer) return;

                const messageDiv = document.createElement('div');
                messageDiv.className = `chat-widget-message ${senderType}`;
                
                // Use provided message ID or generate temporary one
                const id = messageId || Date.now();
                messageDiv.dataset.messageId = id;
                
                const now = new Date();
                const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                
                messageDiv.innerHTML = `
                    <div class="message-content">${message}</div>
                    <div class="message-time">${timeString}</div>
                `;
                
                messagesContainer.appendChild(messageDiv);
                
                // Scroll to bottom
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            // Function to check for new messages
            function checkForNewMessages() {
                if (!currentChatId) return;
                
                fetch('{{ route("chat.get-messages", ":chatRoom") }}'.replace(':chatRoom', currentChatId))
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateWidgetMessages(data.messages);
                        }
                    })
                    .catch(error => {
                        console.error('Error checking for new messages:', error);
                    });
            }

            // Function to update widget messages
            function updateWidgetMessages(messages) {
                const messagesContainer = document.getElementById('chatWidgetMessages');
                if (!messagesContainer) return;

                // Store current scroll position
                const wasAtBottom = messagesContainer.scrollTop + messagesContainer.clientHeight >= messagesContainer.scrollHeight - 10;
                
                // Get current message IDs
                const currentMessageIds = Array.from(messagesContainer.children).map(el => parseInt(el.dataset.messageId));
                
                // Add only new messages
                messages.forEach(msg => {
                    if (!currentMessageIds.includes(msg.id)) {
                        const messageDiv = document.createElement('div');
                        messageDiv.className = `chat-widget-message ${msg.sender_id === {{ auth()->id() }} ? 'user' : 'admin'}`;
                        messageDiv.dataset.messageId = msg.id;
                        
                        const messageTime = new Date(msg.created_at);
                        const timeString = messageTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        
                        messageDiv.innerHTML = `
                            <div class="message-content">${msg.message}</div>
                            <div class="message-time">${timeString}</div>
                        `;
                        
                        messagesContainer.appendChild(messageDiv);
                        
                        // Show notification for admin messages
                        if (msg.sender_id !== {{ auth()->id() }}) {
                            showMessageNotification(msg.message);
                        }
                    }
                });

                // Scroll to bottom only if user was already at bottom
                if (wasAtBottom) {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            }

            // Function to update unread count badge
            function updateUnreadBadge() {
                if (!currentChatId) return;
                
                fetch('{{ route("chat.unread-count") }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const badge = document.querySelector('.chat-widget-badge');
                            if (data.count > 0) {
                                if (badge) {
                                    badge.textContent = data.count;
                                } else {
                                    // Create badge if it doesn't exist
                                    const toggle = document.getElementById('chatWidgetToggle');
                                    if (toggle) {
                                        const newBadge = document.createElement('span');
                                        newBadge.className = 'chat-widget-badge';
                                        newBadge.textContent = data.count;
                                        toggle.appendChild(newBadge);
                                    }
                                }
                            } else if (badge) {
                                badge.remove();
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error updating unread count:', error);
                    });
            }

            // Function to show message notification
            function showMessageNotification(message) {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = 'chat-notification';
                notification.innerHTML = `
                    <div class="notification-content">
                        <i class="fas fa-comment me-2"></i>
                        <span>New message: ${message.substring(0, 50)}${message.length > 50 ? '...' : ''}</span>
                    </div>
                `;
                
                // Add to page
                document.body.appendChild(notification);
                
                // Show notification
                setTimeout(() => notification.classList.add('show'), 100);
                
                // Remove notification after 5 seconds
                setTimeout(() => {
                    notification.classList.remove('show');
                    setTimeout(() => {
                        if (document.body.contains(notification)) {
                            document.body.removeChild(notification);
                        }
                    }, 300);
                }, 5000);
            }

            // Clean up on page unload
            window.addEventListener('beforeunload', function() {
                stopMessagePolling();
            });
        </script>
    @endif
@endauth
