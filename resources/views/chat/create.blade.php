@extends('layouts.user')

@section('page-title', 'Start New Chat')

@section('styles')
<style>
    /* Jumia Theme for Chat Creation */
    .chat-create-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .chat-create-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        padding: 2.5rem;
        width: 100%;
        max-width: 500px;
        border: 1px solid #e5e7eb;
    }

    .chat-create-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .chat-create-header h2 {
        color: #111827;
        font-weight: 800;
        font-size: 1.875rem;
        margin: 0 0 0.5rem 0;
    }

    .chat-create-header p {
        color: #6b7280;
        margin: 0;
        font-size: 1rem;
    }

    .chat-create-icon {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        color: white;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        color: #374151;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: #f68b1e;
        box-shadow: 0 0 0 3px rgba(246, 139, 30, 0.1);
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    .form-help {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .submit-btn {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        width: 100%;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(246, 139, 30, 0.3);
    }

    .submit-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .back-link {
        display: inline-block;
        color: #6b7280;
        text-decoration: none;
        margin-top: 1rem;
        font-size: 0.875rem;
        transition: color 0.3s ease;
    }

    .back-link:hover {
        color: #f68b1e;
    }

    .chat-topics {
        margin-bottom: 1.5rem;
    }

    .chat-topics h4 {
        color: #374151;
        font-weight: 600;
        margin: 0 0 0.75rem 0;
        font-size: 0.875rem;
    }

    .topic-suggestions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .topic-tag {
        background: #f3f4f6;
        color: #374151;
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }

    .topic-tag:hover {
        background: #f68b1e;
        color: white;
        border-color: #f68b1e;
    }

    .topic-tag.active {
        background: #f68b1e;
        color: white;
        border-color: #f68b1e;
    }

    .loading-spinner {
        display: none;
        width: 20px;
        height: 20px;
        border: 2px solid #ffffff;
        border-top: 2px solid transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-right: 0.5rem;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endsection

@section('content')
<div class="chat-create-container">
    <div class="chat-create-card">
        <div class="chat-create-header">
            <div class="chat-create-icon">
                <i class="fas fa-comments"></i>
            </div>
            <h2>Start a New Chat</h2>
            <p>Tell us how we can help you today</p>
        </div>

        <form action="{{ route('chat.store') }}" method="POST" id="chatForm">
            @csrf
            
            <div class="form-group">
                <label for="subject" class="form-label">Subject *</label>
                <input type="text" 
                       id="subject" 
                       name="subject" 
                       class="form-input" 
                       placeholder="e.g., Order Issue, Product Question, General Inquiry"
                       value="{{ old('subject') }}"
                       required>
                <div class="form-help">Brief description of your inquiry</div>
                @error('subject')
                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="chat-topics">
                <h4>Quick Topics (Click to select)</h4>
                <div class="topic-suggestions">
                    <span class="topic-tag" data-subject="Order Status">Order Status</span>
                    <span class="topic-tag" data-subject="Product Information">Product Information</span>
                    <span class="topic-tag" data-subject="Shipping & Delivery">Shipping & Delivery</span>
                    <span class="topic-tag" data-subject="Returns & Refunds">Returns & Refunds</span>
                    <span class="topic-tag" data-subject="Payment Issues">Payment Issues</span>
                    <span class="topic-tag" data-subject="Technical Support">Technical Support</span>
                    <span class="topic-tag" data-subject="General Inquiry">General Inquiry</span>
                </div>
            </div>

            <div class="form-group">
                <label for="message" class="form-label">Message *</label>
                <textarea id="message" 
                          name="message" 
                          class="form-input form-textarea" 
                          placeholder="Please describe your issue or question in detail..."
                          required>{{ old('message') }}</textarea>
                <div class="form-help">Provide as much detail as possible to help us assist you better</div>
                @error('message')
                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">
                <span class="loading-spinner" id="loadingSpinner"></span>
                Start Chat
            </button>
        </form>

        <a href="{{ route('chat.index') }}" class="back-link">
            <i class="fas fa-arrow-left mr-1"></i> Back to Chats
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Topic tag selection
    const topicTags = document.querySelectorAll('.topic-tag');
    const subjectInput = document.getElementById('subject');
    const messageInput = document.getElementById('message');

    topicTags.forEach(tag => {
        tag.addEventListener('click', function() {
            // Remove active class from all tags
            topicTags.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked tag
            this.classList.add('active');
            
            // Set subject
            subjectInput.value = this.dataset.subject;
            
            // Auto-focus message input
            messageInput.focus();
        });
    });

    // Form submission
    const form = document.getElementById('chatForm');
    const submitBtn = document.getElementById('submitBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');

    form.addEventListener('submit', function(e) {
        // Show loading state
        submitBtn.disabled = true;
        loadingSpinner.style.display = 'inline-block';
        submitBtn.textContent = 'Starting Chat...';
    });

    // Auto-resize textarea
    messageInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 200) + 'px';
    });

    // Character count for message
    messageInput.addEventListener('input', function() {
        const maxLength = 1000;
        const currentLength = this.value.length;
        const remaining = maxLength - currentLength;
        
        // Update help text with character count
        const helpText = this.parentNode.querySelector('.form-help');
        helpText.textContent = `Provide as much detail as possible to help us assist you better (${remaining} characters remaining)`;
        
        // Change color when approaching limit
        if (remaining <= 100) {
            helpText.style.color = remaining <= 50 ? '#ef4444' : '#f59e0b';
        } else {
            helpText.style.color = '#6b7280';
        }
    });
});
</script>
@endsection
