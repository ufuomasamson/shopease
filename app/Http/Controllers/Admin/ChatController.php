<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Show admin chat dashboard
     */
    public function index()
    {
        $admin = Auth::user();
        
        // Get assigned chat rooms
        $assignedChatRooms = $admin->assignedChatRooms()
            ->with(['user', 'latestMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        // Get pending chat rooms (unassigned)
        $pendingChatRooms = ChatRoom::where('status', 'pending')
            ->with(['user', 'latestMessage'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Get closed chat rooms
        $closedChatRooms = $admin->assignedChatRooms()
            ->where('status', 'closed')
            ->with(['user', 'latestMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        $stats = [
            'total_assigned' => $assignedChatRooms->count(),
            'total_pending' => $pendingChatRooms->count(),
            'total_closed' => $closedChatRooms->count(),
            'unread_messages' => $admin->unread_admin_message_count,
        ];

        return view('admin.chat.index', compact(
            'assignedChatRooms',
            'pendingChatRooms',
            'closedChatRooms',
            'stats'
        ));
    }

    /**
     * Show a specific chat room for admin
     */
    public function show(ChatRoom $chatRoom)
    {
        // Check if admin has access to this chat room
        if ($chatRoom->admin_id !== Auth::id() && $chatRoom->status === 'pending') {
            // Admin can view pending chat rooms
        } elseif ($chatRoom->admin_id !== Auth::id()) {
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

        return view('admin.chat.show', compact('chatRoom', 'messages'));
    }

    /**
     * Assign admin to a chat room
     */
    public function assign(Request $request, ChatRoom $chatRoom)
    {
        if ($chatRoom->status !== 'pending') {
            return back()->with('error', 'Chat room is not pending assignment.');
        }

        $chatRoom->assignAdmin(Auth::user());

        // Add system message
        $chatRoom->messages()->create([
            'sender_id' => Auth::id(),
            'message' => 'Chat room assigned to ' . Auth::user()->name,
            'message_type' => 'system',
        ]);

        return back()->with('success', 'Chat room assigned successfully.');
    }

    /**
     * Transfer chat room to another admin
     */
    public function transfer(Request $request, ChatRoom $chatRoom)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id',
        ]);

        $newAdmin = User::find($request->admin_id);
        
        if (!$newAdmin->isAdmin()) {
            return back()->with('error', 'Selected user is not an admin.');
        }

        $oldAdmin = $chatRoom->admin;
        $chatRoom->assignAdmin($newAdmin);

        // Add system message
        $chatRoom->messages()->create([
            'sender_id' => Auth::id(),
            'message' => 'Chat room transferred from ' . ($oldAdmin ? $oldAdmin->name : 'unassigned') . ' to ' . $newAdmin->name,
            'message_type' => 'system',
        ]);

        return back()->with('success', 'Chat room transferred successfully.');
    }

    /**
     * Close a chat room
     */
    public function close(ChatRoom $chatRoom)
    {
        if ($chatRoom->admin_id !== Auth::id()) {
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
        if ($chatRoom->admin_id !== Auth::id()) {
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
     * Send a message in a chat room
     */
    public function sendMessage(Request $request, ChatRoom $chatRoom)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Check if admin has access to this chat room
        if ($chatRoom->admin_id !== Auth::id() && $chatRoom->status !== 'pending') {
            abort(403, 'Unauthorized access to chat room.');
        }

        // Check if chat room is closed
        if ($chatRoom->isClosed()) {
            return back()->with('error', 'Cannot send message to closed chat room.');
        }

        // If this is the first admin message, assign admin to chat room
        if (!$chatRoom->admin_id) {
            $chatRoom->assignAdmin(Auth::user());
        }

        // Create message
        $message = $chatRoom->messages()->create([
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'message_type' => 'text',
        ]);

        // Update last message time
        $chatRoom->updateLastMessageTime();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }

        return back()->with('success', 'Message sent successfully.');
    }

    /**
     * Get chat room messages for AJAX requests
     */
    public function getMessages(ChatRoom $chatRoom)
    {
        // Check if admin has access to this chat room
        if ($chatRoom->admin_id !== Auth::id() && $chatRoom->status !== 'pending') {
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
     * Get unread message count for admin
     */
    public function getUnreadCount()
    {
        $admin = Auth::user();
        $count = $admin->unread_admin_message_count;

        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }

    /**
     * Get chat room statistics
     */
    public function getStats()
    {
        $admin = Auth::user();
        
        $stats = [
            'total_assigned' => $admin->assignedChatRooms()->where('status', 'open')->count(),
            'total_pending' => ChatRoom::where('status', 'pending')->count(),
            'total_closed' => $admin->assignedChatRooms()->where('status', 'closed')->count(),
            'unread_messages' => $admin->unread_admin_message_count,
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats,
        ]);
    }
}
