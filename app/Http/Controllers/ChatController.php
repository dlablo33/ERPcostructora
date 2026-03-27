<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Obtener lista de conversaciones del usuario autenticado
     */
    public function getConversations()
    {
        $userId = auth()->id();

        $conversations = Conversation::where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId)
            ->with(['userOne', 'userTwo', 'messages' => function($q) {
                $q->latest()->limit(1);
            }])
            ->orderBy('last_message_at', 'desc')
            ->get()
            ->map(function($conversation) use ($userId) {
                $otherUser = $conversation->getOtherUser($userId);
                $lastMessage = $conversation->messages->first();
                $unreadCount = Message::where('conversation_id', $conversation->id)
                    ->where('recipient_id', $userId)
                    ->where('is_read', false)
                    ->count();

                return [
                    'id' => $conversation->id,
                    'user' => [
                        'id' => $otherUser->id,
                        'name' => $otherUser->name,
                        'email' => $otherUser->email,
                    ],
                    'last_message' => $lastMessage ? $lastMessage->message : null,
                    'last_message_time' => $lastMessage ? $lastMessage->created_at : null,
                    'unread_count' => $unreadCount,
                ];
            });

        return response()->json($conversations);
    }

    /**
     * Obtener todos los usuarios (para iniciar nuevas conversaciones)
     */
    public function getUsers()
    {
        $users = User::where('id', '!=', auth()->id())
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return response()->json($users);
    }

    /**
     * Obtener mensajes de una conversación específica
     */
    public function getMessages($userId)
    {
        $currentUserId = auth()->id();
        
        // Buscar o crear conversación
        $conversation = Conversation::where(function($q) use ($currentUserId, $userId) {
                $q->where('user_one_id', $currentUserId)
                  ->where('user_two_id', $userId);
            })->orWhere(function($q) use ($currentUserId, $userId) {
                $q->where('user_one_id', $userId)
                  ->where('user_two_id', $currentUserId);
            })->first();

        if (!$conversation) {
            return response()->json([]);
        }

        // Marcar mensajes como leídos
        Message::where('conversation_id', $conversation->id)
            ->where('recipient_id', $currentUserId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        // Actualizar último leído en la conversación
        $conversation->updateLastReadAt($currentUserId);

        // Obtener mensajes
        $messages = Message::where('conversation_id', $conversation->id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function($message) use ($currentUserId) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'user_id' => $message->user_id,
                    'recipient_id' => $message->recipient_id,
                    'is_own' => $message->user_id == $currentUserId,
                    'is_read' => $message->is_read,
                    'created_at' => $message->created_at,
                ];
            });

        return response()->json([
            'conversation_id' => $conversation->id,
            'messages' => $messages
        ]);
    }

    /**
     * Enviar un mensaje
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string|max:5000'
        ]);

        $currentUserId = auth()->id();
        $recipientId = $request->recipient_id;

        // Buscar o crear conversación
        $conversation = Conversation::where(function($q) use ($currentUserId, $recipientId) {
                $q->where('user_one_id', $currentUserId)
                  ->where('user_two_id', $recipientId);
            })->orWhere(function($q) use ($currentUserId, $recipientId) {
                $q->where('user_one_id', $recipientId)
                  ->where('user_two_id', $currentUserId);
            })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one_id' => $currentUserId,
                'user_two_id' => $recipientId,
                'last_message_at' => now(),
            ]);
        }

        // Crear el mensaje
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => $currentUserId,
            'recipient_id' => $recipientId,
            'message' => $request->message,
            'is_read' => false,
        ]);

        // Actualizar último mensaje en la conversación
        $conversation->update(['last_message_at' => now()]);

        // Disparar evento para WebSocket
        broadcast(new MessageSent($message, $conversation, auth()->user()))->toOthers();

        return response()->json([
            'id' => $message->id,
            'message' => $message->message,
            'user_id' => $message->user_id,
            'recipient_id' => $message->recipient_id,
            'is_own' => true,
            'is_read' => false,
            'created_at' => $message->created_at,
        ]);
    }

    /**
     * Marcar mensajes como leídos
     */
    public function markAsRead($userId)
    {
        $currentUserId = auth()->id();

        $conversation = Conversation::where(function($q) use ($currentUserId, $userId) {
                $q->where('user_one_id', $currentUserId)
                  ->where('user_two_id', $userId);
            })->orWhere(function($q) use ($currentUserId, $userId) {
                $q->where('user_one_id', $userId)
                  ->where('user_two_id', $currentUserId);
            })->first();

        if ($conversation) {
            Message::where('conversation_id', $conversation->id)
                ->where('recipient_id', $currentUserId)
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);

            $conversation->updateLastReadAt($currentUserId);
        }

        return response()->json(['success' => true]);
    }
}