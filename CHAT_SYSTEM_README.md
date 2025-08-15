# Live Chat System - Shopease E-commerce Platform

## Overview

The Live Chat System is a comprehensive customer support solution integrated into the Shopease e-commerce platform. It provides real-time communication between customers and support agents, enhancing customer experience and support efficiency.

## Features

### 🎯 Core Functionality
- **Real-time Messaging**: Instant communication between customers and support agents
- **Chat Room Management**: Organized conversations with subjects and status tracking
- **File Sharing**: Support for image and document uploads (up to 10MB)
- **Admin Assignment**: Automatic and manual assignment of chat rooms to support agents
- **Status Tracking**: Pending, Open, and Closed chat states
- **Unread Message Counts**: Real-time notifications for both users and admins

### 👥 User Features
- **Customer Support Access**: Easy access through sidebar navigation
- **Chat Creation**: Start new conversations with topic suggestions
- **Message History**: View complete conversation history
- **File Attachments**: Share images and documents with support team
- **Floating Widget**: Quick access chat widget on all pages
- **Real-time Updates**: Auto-refresh messages every 10 seconds

### 🛠️ Admin Features
- **Chat Dashboard**: Overview of all chat rooms with statistics
- **Room Assignment**: Assign pending chats to support agents
- **Chat Management**: Close, reopen, and transfer chat rooms
- **Performance Metrics**: Track assigned, pending, and closed chats
- **Quick Actions**: Streamlined chat room management

## Database Structure

### Tables

#### `chat_rooms`
- `id` - Primary key
- `user_id` - Customer who created the chat
- `admin_id` - Support agent assigned to the chat
- `status` - Chat status (pending, open, closed)
- `subject` - Chat topic/subject
- `last_message_at` - Timestamp of last message
- `created_at`, `updated_at` - Timestamps

#### `chat_messages`
- `id` - Primary key
- `chat_room_id` - Reference to chat room
- `sender_id` - User who sent the message
- `message` - Message content
- `message_type` - Type (text, image, file, system)
- `file_path` - File storage path (if applicable)
- `file_name` - Original filename (if applicable)
- `is_read` - Read status
- `read_at` - Timestamp when read
- `created_at`, `updated_at` - Timestamps

## Routes

### User Routes
```php
GET    /chat                    - Chat index (list all chats)
GET    /chat/create            - Create new chat form
POST   /chat                   - Store new chat
GET    /chat/{chatRoom}        - Show specific chat
POST   /chat/{chatRoom}/message - Send message
POST   /chat/{chatRoom}/file   - Upload file
POST   /chat/{chatRoom}/close  - Close chat
GET    /chat/{chatRoom}/messages - Get messages (AJAX)
GET    /chat/unread-count      - Get unread count (AJAX)
```

### Admin Routes
```php
GET    /admin/chat                    - Admin chat dashboard
GET    /admin/chat/{chatRoom}         - Show chat for admin
POST   /admin/chat/{chatRoom}/assign  - Assign chat to admin
POST   /admin/chat/{chatRoom}/transfer - Transfer chat to another admin
POST   /admin/chat/{chatRoom}/close   - Close chat
POST   /admin/chat/{chatRoom}/reopen  - Reopen chat
POST   /admin/chat/{chatRoom}/message - Send admin message
GET    /admin/chat/{chatRoom}/messages - Get messages (AJAX)
GET    /admin/chat/unread-count       - Get unread count (AJAX)
GET    /admin/chat/stats              - Get chat statistics (AJAX)
```

## Models

### ChatRoom Model
- **Relationships**: `user()`, `admin()`, `messages()`, `latestMessage()`
- **Methods**: `isActive()`, `isClosed()`, `isPending()`, `assignAdmin()`, `close()`, `reopen()`
- **Accessors**: `unread_count`, `status_badge_class`, `status_text`

### ChatMessage Model
- **Relationships**: `chatRoom()`, `sender()`
- **Methods**: `isFromAdmin()`, `isFromUser()`, `isSystemMessage()`, `markAsRead()`
- **Accessors**: `file_url`, `file_size`, `time_ago`, `display_date`, `display_time`

## Controllers

### ChatController (User)
- Handles user-side chat operations
- Manages chat creation, messaging, and file uploads
- Implements chat room logic and access control

### Admin\ChatController
- Manages admin-side chat operations
- Handles chat assignment, transfer, and management
- Provides chat statistics and overview

## Views

### User Views
- `chat/index.blade.php` - Chat room list with sidebar navigation
- `chat/create.blade.php` - New chat creation form with topic suggestions
- `chat/show.blade.php` - Full chat interface with message history

### Admin Views
- `admin/chat/index.blade.php` - Admin chat dashboard with tabs and statistics
- `admin/chat/show.blade.php` - Admin chat interface with management tools

### Widget
- `partials/chat-widget.blade.php` - Floating chat widget for quick access

## Installation & Setup

### 1. Run Migrations
```bash
php artisan migrate
```

### 2. Include Chat Widget
Add the chat widget to your layouts:
```php
@include('partials.chat-widget')
```

### 3. Update Navigation
Add chat links to your navigation menus:
```php
<a href="{{ route('chat.index') }}">Customer Support</a>
```

## Usage

### For Customers
1. **Access Support**: Click "Customer Support" in the sidebar
2. **Start Chat**: Click "Start New Chat" and fill in subject and message
3. **Send Messages**: Type and send messages in real-time
4. **Attach Files**: Use the paperclip icon to share images/documents
5. **Quick Access**: Use the floating chat widget on any page

### For Support Agents
1. **View Dashboard**: Access admin chat dashboard
2. **Assign Chats**: Click "Assign to Me" for pending chats
3. **Respond**: Send messages and manage conversations
4. **Manage Status**: Close or reopen chats as needed
5. **Track Performance**: Monitor assigned and pending chat counts

## Customization

### Styling
The chat system uses Jumia-inspired design with:
- Orange gradient theme (`#f68b1e` to `#e67e22`)
- Modern card-based layouts
- Responsive design for mobile devices
- Smooth animations and transitions

### Configuration
- File upload limits: 10MB maximum
- Auto-refresh intervals: 10 seconds for messages, 30 seconds for stats
- Message length limits: 1000 characters
- Supported file types: Images, PDFs, documents, text files

## Security Features

- **Authentication Required**: All chat routes require user authentication
- **Access Control**: Users can only access their own chat rooms
- **Admin Middleware**: Admin routes protected by admin middleware
- **CSRF Protection**: All forms include CSRF tokens
- **File Validation**: Secure file upload handling

## Performance Considerations

- **Eager Loading**: Relationships loaded efficiently to prevent N+1 queries
- **Indexed Queries**: Database indexes on frequently queried columns
- **AJAX Updates**: Real-time updates without full page reloads
- **Lazy Loading**: Chat rooms loaded on demand

## Future Enhancements

- **Real-time Notifications**: Push notifications for new messages
- **Chat Transcripts**: Export chat history as PDF/email
- **Canned Responses**: Pre-written response templates for common issues
- **Chat Analytics**: Detailed reporting and performance metrics
- **Multi-language Support**: Internationalization for global customers
- **Voice/Video Chat**: Advanced communication options

## Troubleshooting

### Common Issues

1. **Chat Widget Not Showing**
   - Ensure user is authenticated and not an admin
   - Check if `partials.chat-widget.blade.php` is included in layout

2. **Messages Not Sending**
   - Verify CSRF token is present
   - Check user permissions and chat room access

3. **File Uploads Failing**
   - Ensure storage is properly configured
   - Check file size limits and supported types

4. **Admin Access Issues**
   - Verify user has admin role
   - Check admin middleware configuration

### Debug Mode
Enable Laravel debug mode to see detailed error messages:
```php
// .env
APP_DEBUG=true
```

## Support

For technical support or questions about the chat system implementation, please refer to the main project documentation or contact the development team.

---

**Version**: 1.0.0  
**Last Updated**: August 2025  
**Compatibility**: Laravel 12.x, PHP 8.2+
