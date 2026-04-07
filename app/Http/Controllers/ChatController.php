<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Obtener usuarios con contador de mensajes no leídos
     */
    public function getUsers()
    {
        try {
            $currentUserId = Auth::id();
            
            $users = User::where('id', '!=', $currentUserId)
                ->select('id', 'name', 'email')
                ->get();
            
            foreach ($users as $user) {
                $conversation = Conversation::where(function($q) use ($currentUserId, $user) {
                    $q->where('user_one_id', $currentUserId)->where('user_two_id', $user->id);
                })->orWhere(function($q) use ($currentUserId, $user) {
                    $q->where('user_one_id', $user->id)->where('user_two_id', $currentUserId);
                })->first();
                
                if ($conversation) {
                    $user->unread_count = Message::where('conversation_id', $conversation->id)
                        ->where('recipient_id', $currentUserId)
                        ->where('is_read', false)
                        ->count();
                } else {
                    $user->unread_count = 0;
                }
            }
            
            $users = $users->sortByDesc(function($user) {
                return $user->unread_count;
            })->values();
            
            return response()->json($users);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Obtener mensajes de una conversación específica
     */
    public function getMessages($userId)
    {
        try {
            $currentUserId = Auth::id();
            
            $conversation = Conversation::where(function($q) use ($currentUserId, $userId) {
                $q->where('user_one_id', $currentUserId)->where('user_two_id', $userId);
            })->orWhere(function($q) use ($currentUserId, $userId) {
                $q->where('user_one_id', $userId)->where('user_two_id', $currentUserId);
            })->first();
            
            if (!$conversation) {
                return response()->json([]);
            }
            
            $messages = Message::where('conversation_id', $conversation->id)
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function($msg) use ($currentUserId) {
                    return [
                        'id' => $msg->id,
                        'message' => $msg->message,
                        'user_id' => $msg->user_id,
                        'recipient_id' => $msg->recipient_id,
                        'is_read' => $msg->is_read,
                        'read_at' => $msg->read_at,
                        'created_at' => $msg->created_at,
                    ];
                });
            
            return response()->json($messages);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Enviar mensaje y actualizar contadores
     */
    public function sendMessage(Request $request)
    {
        try {
            $request->validate([
                'recipient_id' => 'required|exists:users,id',
                'message' => 'required|string|max:5000'
            ]);
            
            $currentUserId = Auth::id();
            $recipientId = $request->recipient_id;
            
            $conversation = Conversation::where(function($q) use ($currentUserId, $recipientId) {
                $q->where('user_one_id', $currentUserId)->where('user_two_id', $recipientId);
            })->orWhere(function($q) use ($currentUserId, $recipientId) {
                $q->where('user_one_id', $recipientId)->where('user_two_id', $currentUserId);
            })->first();
            
            if (!$conversation) {
                $conversation = Conversation::create([
                    'user_one_id' => $currentUserId,
                    'user_two_id' => $recipientId,
                    'last_message_at' => now(),
                ]);
            }
            
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'user_id' => $currentUserId,
                'recipient_id' => $recipientId,
                'message' => $request->message,
                'is_read' => false,
            ]);
            
            $conversation->update(['last_message_at' => now()]);
            
            $user = Auth::user();
            
            broadcast(new MessageSent($message, $conversation, $user))->toOthers();
            
            return response()->json([
                'success' => true,
                'id' => $message->id,
                'message' => $message->message,
                'user_id' => $message->user_id,
                'recipient_id' => $message->recipient_id,
                'created_at' => $message->created_at,
                'sender_name' => $user->name
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Marcar mensajes como leídos y obtener contadores actualizados
     */
    public function markAsRead($userId)
    {
        try {
            $currentUserId = Auth::id();
            
            $conversation = Conversation::where(function($q) use ($currentUserId, $userId) {
                $q->where('user_one_id', $currentUserId)
                  ->where('user_two_id', $userId);
            })->orWhere(function($q) use ($currentUserId, $userId) {
                $q->where('user_one_id', $userId)
                  ->where('user_two_id', $currentUserId);
            })->first();
            
            if ($conversation) {
                $updated = Message::where('conversation_id', $conversation->id)
                    ->where('recipient_id', $currentUserId)
                    ->where('is_read', false)
                    ->update([
                        'is_read' => true,
                        'read_at' => now()
                    ]);
                
                // Usar el método del modelo
                $conversation->updateLastReadAt($currentUserId);
                
                $totalUnread = $this->getTotalUnreadCount($currentUserId);
                
                return response()->json([
                    'success' => true,
                    'updated' => $updated,
                    'total_unread' => $totalUnread
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Conversación no encontrada'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener contador total de mensajes no leídos del usuario
     */
    public function getTotalUnreadCount($userId = null)
    {
        try {
            $currentUserId = $userId ?? Auth::id();
            
            $conversations = Conversation::where('user_one_id', $currentUserId)
                ->orWhere('user_two_id', $currentUserId)
                ->pluck('id');
            
            $totalUnread = Message::whereIn('conversation_id', $conversations)
                ->where('recipient_id', $currentUserId)
                ->where('is_read', false)
                ->count();
            
            // Si se llamó desde una ruta HTTP, devolver JSON
            if ($userId === null) {
                return response()->json(['total_unread' => $totalUnread]);
            }
            
            // Si se llamó internamente, devolver el número
            return $totalUnread;
            
        } catch (\Exception $e) {
            if ($userId === null) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return 0;
        }
    }

    /**
     * Obtener últimas conversaciones con resumen
     */
    public function getConversations()
    {
        try {
            $currentUserId = Auth::id();
            
            $conversations = Conversation::where('user_one_id', $currentUserId)
                ->orWhere('user_two_id', $currentUserId)
                ->with(['messages' => function($q) {
                    $q->latest()->limit(1);
                }])
                ->orderBy('last_message_at', 'desc')
                ->get();
            
            $result = [];
            foreach ($conversations as $conv) {
                $otherUserId = $conv->user_one_id == $currentUserId ? $conv->user_two_id : $conv->user_one_id;
                $otherUser = User::find($otherUserId);
                
                $unreadCount = Message::where('conversation_id', $conv->id)
                    ->where('recipient_id', $currentUserId)
                    ->where('is_read', false)
                    ->count();
                
                $lastMessage = $conv->messages->first();
                
                $result[] = [
                    'user_id' => $otherUserId,
                    'user_name' => $otherUser->name,
                    'user_email' => $otherUser->email,
                    'last_message' => $lastMessage ? $lastMessage->message : null,
                    'last_message_at' => $lastMessage ? $lastMessage->created_at : null,
                    'unread_count' => $unreadCount
                ];
            }
            
            return response()->json($result);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}