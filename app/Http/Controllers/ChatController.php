<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the chat interface for users
     */
    public function index()
    {
        $user = Auth::user();
        $chatRooms = $user->chatRooms()
            ->with(['latestMessage', 'admin'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        return view('chat.index', compact('chatRooms'));
    }

    /**
     * Show the form for creating a new chat
     */
    public function create()
    {
        return view('chat.create');
    }

    /**
     * Show a specific chat room
     */
    public function show(ChatRoom $chatRoom)
    {
        // Check if user has access to this chat room
        if ($chatRoom->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access to chat room.');
        }

        // Mark messages as read
        $chatRoom->messages()
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        $messages = $chatRoom->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat.show', compact('chatRoom', 'messages'));
    }

    /**
     * Create a new chat room
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        // Check if user already has an open chat room
        $existingChatRoom = $user->chatRooms()
            ->where('status', 'open')
            ->first();

        if ($existingChatRoom) {
            // Add message to existing chat room
            $existingChatRoom->messages()->create([
                'sender_id' => $user->id,
                'message' => $request->message,
                'message_type' => 'text',
            ]);

            $existingChatRoom->updateLastMessageTime();

            // Check if this is an AJAX request
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Message added to existing chat.',
                    'chat_room_id' => $existingChatRoom->id
                ]);
            }

            return redirect()->route('chat.show', $existingChatRoom)
                ->with('success', 'Message added to existing chat.');
        }

        // Create new chat room
        $chatRoom = $user->chatRooms()->create([
            'subject' => $request->subject,
            'status' => 'pending',
        ]);

        // Add initial message
        $chatRoom->messages()->create([
            'sender_id' => $user->id,
            'message' => $request->message,
            'message_type' => 'text',
        ]);

        $chatRoom->updateLastMessageTime();

        // Check if this is an AJAX request
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Chat room created successfully.',
                'chat_room_id' => $chatRoom->id
            ]);
        }

        return redirect()->route('chat.show', $chatRoom)
            ->with('success', 'Chat room created successfully.');
    }

    /**
     * Send a message in a chat room
     */
    public function sendMessage(Request $request, ChatRoom $chatRoom)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Check if user has access to this chat room
        if ($chatRoom->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access to chat room.');
        }

        // Check if chat room is closed
        if ($chatRoom->isClosed()) {
            return back()->with('error', 'Cannot send message to closed chat room.');
        }

        // Create message
        $message = $chatRoom->messages()->create([
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'message_type' => 'text',
        ]);

        // Update last message time
        $chatRoom->updateLastMessageTime();

        // If this is the first admin message, assign admin to chat room
        if (Auth::user()->isAdmin() && !$chatRoom->admin_id) {
            $chatRoom->assignAdmin(Auth::user());
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }

        return back()->with('success', 'Message sent successfully.');
    }

    /**
     * Upload file in chat
     */
    public function uploadFile(Request $request, ChatRoom $chatRoom)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        // Check if user has access to this chat room
        if ($chatRoom->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access to chat room.');
        }

        // Check if chat room is closed
        if ($chatRoom->isClosed()) {
            return back()->with('error', 'Cannot send file to closed chat room.');
        }

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('chat-files', 'public');

        // Determine message type
        $messageType = 'file';
        if (in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
            $messageType = 'image';
        }

        // Create message
        $message = $chatRoom->messages()->create([
            'sender_id' => Auth::id(),
            'message' => 'File: ' . $fileName,
            'message_type' => $messageType,
            'file_path' => $filePath,
            'file_name' => $fileName,
        ]);

        // Update last message time
        $chatRoom->updateLastMessageTime();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }

        return back()->with('success', 'File uploaded successfully.');
    }

    /**
     * Close a chat room
     */
    public function close(ChatRoom $chatRoom)
    {
        // Only admins or the chat room owner can close it
        if ($chatRoom->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $chatRoom->close();

        // Add system message
        $chatRoom->messages()->create([
            'sender_id' => Auth::id(),
            'message' => 'Chat room closed by ' . Auth::user()->name,
            'message_type' => 'system',
        ]);

        return back()->with('success', 'Chat room closed successfully.');
    }

    /**
     * Reopen a chat room
     */
    public function reopen(ChatRoom $chatRoom)
    {
        // Only admins can reopen chat rooms
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $chatRoom->reopen();

        // Add system message
        $chatRoom->messages()->create([
            'sender_id' => Auth::id(),
            'message' => 'Chat room reopened by ' . Auth::user()->name,
            'message_type' => 'system',
        ]);

        return back()->with('success', 'Chat room reopened successfully.');
    }

    /**
     * Get chat room messages for AJAX requests
     */
    public function getMessages(ChatRoom $chatRoom)
    {
        // Check if user has access to this chat room
        if ($chatRoom->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access to chat room.');
        }

        $messages = $chatRoom->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }

    /**
     * Get unread message count for current user
     */
    public function getUnreadCount()
    {
        $user = Auth::user();
        $count = $user->unread_message_count;

        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }

    /**
     * Get latest messages for all user's chat rooms (for widget)
     */
    public function getLatestMessages()
    {
        $user = Auth::user();
        
        // Get the most recent message from each chat room
        $latestMessages = $user->chatRooms()
            ->with(['latestMessage.sender', 'admin'])
            ->whereHas('messages')
            ->orderBy('last_message_at', 'desc')
            ->get()
            ->map(function ($chatRoom) {
                return [
                    'chat_room_id' => $chatRoom->id,
                    'subject' => $chatRoom->subject,
                    'status' => $chatRoom->status,
                    'latest_message' => $chatRoom->latestMessage ? [
                        'id' => $chatRoom->latestMessage->id,
                        'message' => $chatRoom->latestMessage->message,
                        'sender_id' => $chatRoom->latestMessage->sender_id,
                        'sender_name' => $chatRoom->latestMessage->sender->name,
                        'created_at' => $chatRoom->latestMessage->created_at,
                        'is_read' => $chatRoom->latestMessage->is_read,
                    ] : null,
                    'unread_count' => $chatRoom->messages()
                        ->where('sender_id', '!=', $user->id)
                        ->where('is_read', false)
                        ->count(),
                    'admin_name' => $chatRoom->admin ? $chatRoom->admin->name : null,
                ];
            });

        return response()->json([
            'success' => true,
            'chat_rooms' => $latestMessages,
        ]);
    }
}
