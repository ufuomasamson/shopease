@extends('layouts.admin')

@section('page-title', 'Customer Support Chat Management')

@section('content')

@section('styles')
<style>
    /* Jumia Theme for Admin Chat */
    .admin-chat-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 2rem;
    }

    .chat-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        color: white;
    }

    .stat-icon.assigned {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .stat-icon.pending {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .stat-icon.closed {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    }

    .stat-icon.unread {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        color: #111827;
        margin: 0;
    }

    .stat-label {
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
        margin: 0.5rem 0 0 0;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .chat-tabs {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        margin-bottom: 2rem;
    }

    .tab-nav {
        display: flex;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
        border-radius: 16px 16px 0 0;
    }

    .tab-nav-item {
        flex: 1;
        padding: 1rem 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        background: transparent;
        color: #6b7280;
        font-weight: 500;
        position: relative;
    }

    .tab-nav-item.active {
        color: #f68b1e;
        background: white;
        border-bottom: 3px solid #f68b1e;
    }

    .tab-nav-item:hover {
        color: #f68b1e;
        background: #fef3c7;
    }

    .tab-content {
        padding: 2rem;
    }

    .tab-pane {
        display: none;
    }

    .tab-pane.active {
        display: block;
    }

    .chat-room-list {
        display: grid;
        gap: 1rem;
    }

    .chat-room-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        position: relative;
    }

    .chat-room-card:hover {
        border-color: #f68b1e;
        box-shadow: 0 4px 12px rgba(246, 139, 30, 0.15);
        transform: translateY(-2px);
    }

    .chat-room-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .chat-room-info h4 {
        margin: 0 0 0.5rem 0;
        color: #111827;
        font-weight: 700;
        font-size: 1.125rem;
    }

    .chat-room-meta {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .chat-room-status {
        padding: 0.5rem 1rem;
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
        margin: 0 0 1rem 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .chat-room-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .chat-action-btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid #e5e7eb;
    }

    .chat-action-btn.primary {
        background: #f68b1e;
        color: white;
        border-color: #f68b1e;
    }

    .chat-action-btn.primary:hover {
        background: #e67e22;
        border-color: #e67e22;
        color: white;
        text-decoration: none;
    }

    .chat-action-btn.secondary {
        background: #f3f4f6;
        color: #374151;
        border-color: #e5e7eb;
    }

    .chat-action-btn.secondary:hover {
        background: #e5e7eb;
        color: #111827;
        text-decoration: none;
    }

    .chat-action-btn.danger {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }

    .chat-action-btn.danger:hover {
        background: #fee2e2;
        color: #b91c1c;
        text-decoration: none;
    }

    .chat-action-btn.success {
        background: #d1fae5;
        color: #065f46;
        border-color: #a7f3d0;
    }

    .chat-action-btn.success:hover {
        background: #a7f3d0;
        color: #064e3b;
        text-decoration: none;
    }

    .unread-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: #ef4444;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
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
        margin: 0;
        color: #6b7280;
    }

    .chat-filters {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
    }

    .filter-row {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
    }

    .filter-input {
        padding: 0.5rem 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 0.875rem;
        min-width: 150px;
    }

    .filter-input:focus {
        outline: none;
        border-color: #f68b1e;
        box-shadow: 0 0 0 3px rgba(246, 139, 30, 0.1);
    }
</style>
@endsection

@section('content')
<div class="admin-chat-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Customer Support Chat Management</h1>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" onclick="refreshStats()">
                <i class="fas fa-sync-alt me-2"></i>Refresh
            </button>
        </div>
    </div>

    <!-- Chat Statistics -->
    <div class="chat-stats">
        <div class="stat-card">
            <div class="stat-icon assigned">
                <i class="fas fa-comments"></i>
            </div>
            <div class="stat-number" id="assignedCount">{{ $stats['total_assigned'] }}</div>
            <div class="stat-label">Assigned Chats</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon pending">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-number" id="pendingCount">{{ $stats['total_pending'] }}</div>
            <div class="stat-label">Pending Chats</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon closed">
                <i class="fas fa-lock"></i>
            </div>
            <div class="stat-number" id="closedCount">{{ $stats['total_closed'] }}</div>
            <div class="stat-label">Closed Chats</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon unread">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-number" id="unreadCount">{{ $stats['unread_messages'] }}</div>
            <div class="stat-label">Unread Messages</div>
        </div>
    </div>

    <!-- Chat Filters -->
    <div class="chat-filters">
        <div class="filter-row">
            <div class="filter-group">
                <label class="filter-label">Search</label>
                <input type="text" class="filter-input" id="searchInput" placeholder="Search by subject or user...">
            </div>
            <div class="filter-group">
                <label class="filter-label">Status</label>
                <select class="filter-input" id="statusFilter">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="open">Open</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Sort By</label>
                <select class="filter-input" id="sortFilter">
                    <option value="latest">Latest Message</option>
                    <option value="oldest">Oldest Message</option>
                    <option value="newest">Newest Chat</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Chat Tabs -->
    <div class="chat-tabs">
        <div class="tab-nav">
            <button class="tab-nav-item active" data-tab="assigned">
                Assigned to Me ({{ $assignedChatRooms->count() }})
            </button>
            <button class="tab-nav-item" data-tab="pending">
                Pending Assignment ({{ $pendingChatRooms->count() }})
            </button>
            <button class="tab-nav-item" data-tab="closed">
                Closed Chats ({{ $closedChatRooms->count() }})
            </button>
        </div>

        <div class="tab-content">
            <!-- Assigned Chats Tab -->
            <div class="tab-pane active" id="assigned">
                @if($assignedChatRooms->count() > 0)
                    <div class="chat-room-list">
                        @foreach($assignedChatRooms as $chatRoom)
                            <div class="chat-room-card">
                                @if($chatRoom->unread_count > 0)
                                    <div class="unread-badge">{{ $chatRoom->unread_count }}</div>
                                @endif
                                
                                <div class="chat-room-header">
                                    <div class="chat-room-info">
                                        <h4>{{ $chatRoom->subject ?: 'General Inquiry' }}</h4>
                                        <div class="chat-room-meta">
                                            <strong>{{ $chatRoom->user->name }}</strong> • 
                                            {{ $chatRoom->last_message_at ? $chatRoom->last_message_at->diffForHumans() : $chatRoom->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <span class="chat-room-status status-{{ $chatRoom->status }}">
                                        {{ ucfirst($chatRoom->status) }}
                                    </span>
                                </div>
                                
                                @if($chatRoom->latestMessage)
                                    <p class="chat-room-preview">
                                        {{ $chatRoom->latestMessage->message }}
                                    </p>
                                @endif
                                
                                <div class="chat-room-actions">
                                    <a href="{{ route('admin.chat.show', $chatRoom) }}" class="chat-action-btn primary">
                                        <i class="fas fa-comments"></i>
                                        View Chat
                                    </a>
                                    
                                    @if($chatRoom->status === 'open')
                                        <form action="{{ route('admin.chat.close', $chatRoom) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="chat-action-btn danger" onclick="return confirm('Are you sure you want to close this chat?')">
                                                <i class="fas fa-times"></i>
                                                Close Chat
                                            </button>
                                        </form>
                                    @elseif($chatRoom->status === 'closed')
                                        <form action="{{ route('admin.chat.reopen', $chatRoom) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="chat-action-btn success">
                                                <i class="fas fa-unlock"></i>
                                                Reopen Chat
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3>No Assigned Chats</h3>
                        <p>You don't have any chat rooms assigned to you at the moment.</p>
                    </div>
                @endif
            </div>

            <!-- Pending Chats Tab -->
            <div class="tab-pane" id="pending">
                @if($pendingChatRooms->count() > 0)
                    <div class="chat-room-list">
                        @foreach($pendingChatRooms as $chatRoom)
                            <div class="chat-room-card">
                                <div class="chat-room-header">
                                    <div class="chat-room-info">
                                        <h4>{{ $chatRoom->subject ?: 'General Inquiry' }}</h4>
                                        <div class="chat-room-meta">
                                            <strong>{{ $chatRoom->user->name }}</strong> • 
                                            {{ $chatRoom->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <span class="chat-room-status status-{{ $chatRoom->status }}">
                                        {{ ucfirst($chatRoom->status) }}
                                    </span>
                                </div>
                                
                                @if($chatRoom->latestMessage)
                                    <p class="chat-room-preview">
                                        {{ $chatRoom->latestMessage->message }}
                                    </p>
                                @endif
                                
                                <div class="chat-room-actions">
                                    <a href="{{ route('admin.chat.show', $chatRoom) }}" class="chat-action-btn primary">
                                        <i class="fas fa-comments"></i>
                                        View Chat
                                    </a>
                                    
                                    <form action="{{ route('admin.chat.assign', $chatRoom) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="chat-action-btn success">
                                            <i class="fas fa-user-plus"></i>
                                            Assign to Me
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3>No Pending Chats</h3>
                        <p>All chat rooms have been assigned to support agents.</p>
                    </div>
                @endif
            </div>

            <!-- Closed Chats Tab -->
            <div class="tab-pane" id="closed">
                @if($closedChatRooms->count() > 0)
                    <div class="chat-room-list">
                        @foreach($closedChatRooms as $chatRoom)
                            <div class="chat-room-card">
                                <div class="chat-room-header">
                                    <div class="chat-room-info">
                                        <h4>{{ $chatRoom->subject ?: 'General Inquiry' }}</h4>
                                        <div class="chat-room-meta">
                                            <strong>{{ $chatRoom->user->name }}</strong> • 
                                            {{ $chatRoom->last_message_at ? $chatRoom->last_message_at->diffForHumans() : $chatRoom->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <span class="chat-room-status status-{{ $chatRoom->status }}">
                                        {{ ucfirst($chatRoom->status) }}
                                    </span>
                                </div>
                                
                                @if($chatRoom->latestMessage)
                                    <p class="chat-room-preview">
                                        {{ $chatRoom->latestMessage->message }}
                                    </p>
                                @endif
                                
                                <div class="chat-room-actions">
                                    <a href="{{ route('admin.chat.show', $chatRoom) }}" class="chat-action-btn secondary">
                                        <i class="fas fa-eye"></i>
                                        View History
                                    </a>
                                    
                                    <form action="{{ route('admin.chat.reopen', $chatRoom) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="chat-action-btn success">
                                            <i class="fas fa-unlock"></i>
                                            Reopen Chat
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h3>No Closed Chats</h3>
                        <p>No chat rooms have been closed yet.</p>
                    </div>
                @endif
            </div>
        </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabNavItems = document.querySelectorAll('.tab-nav-item');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    tabNavItems.forEach(item => {
        item.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Remove active class from all tabs
            tabNavItems.forEach(tab => tab.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
        });
    });

    // Search and filter functionality
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const sortFilter = document.getElementById('sortFilter');
    
    function filterChatRooms() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const sortValue = sortFilter.value;
        
        // Implement filtering logic here
        console.log('Filtering:', { searchTerm, statusValue, sortValue });
    }
    
    searchInput.addEventListener('input', filterChatRooms);
    statusFilter.addEventListener('change', filterChatRooms);
    sortFilter.addEventListener('change', filterChatRooms);
});

// Refresh stats function
function refreshStats() {
    fetch('{{ route("admin.chat.stats") }}')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const assignedElement = document.getElementById('assignedCount');
                const pendingElement = document.getElementById('pendingCount');
                const closedElement = document.getElementById('closedCount');
                const unreadElement = document.getElementById('unreadCount');
                
                if (assignedElement) assignedElement.textContent = data.stats.total_assigned;
                if (pendingElement) pendingElement.textContent = data.stats.total_pending;
                if (closedElement) closedElement.textContent = data.stats.total_closed;
                if (unreadElement) unreadElement.textContent = data.stats.unread_messages;
            }
        })
        .catch(error => {
            console.error('Error refreshing stats:', error);
            // Don't show error to user, just log it
        });
}

// Auto-refresh stats every 30 seconds
setInterval(refreshStats, 30000);
</script>
@endsection
