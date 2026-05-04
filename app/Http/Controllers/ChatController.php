<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Events\MessageSent;
use App\Services\MistralAIService;

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
            Log::error('getUsers error: ' . $e->getMessage());
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
            Log::error('getMessages error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Enviar mensaje y actualizar contadores
     */
    public function sendMessage(Request $request)
    {
        Log::info('=== sendMessage INICIADO ===');
        Log::info('recipient_id: ' . $request->recipient_id);
        Log::info('message: ' . substr($request->message, 0, 100));
        
        try {
            $request->validate([
                'recipient_id' => 'required|exists:users,id',
                'message' => 'required|string|max:5000'
            ]);
            
            $currentUserId = Auth::id();
            $recipientId = $request->recipient_id;
            
            Log::info('Current User ID: ' . $currentUserId);
            
            // Verificar si el destinatario es la IA
            $recipient = User::find($recipientId);
            $isAI = $recipient && $recipient->email === 'ia@mejorasoft.com';
            
            Log::info('Is AI: ' . ($isAI ? 'YES' : 'NO'));
            Log::info('Recipient email: ' . ($recipient ? $recipient->email : 'NOT FOUND'));
            
            // Crear o obtener conversación
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
                Log::info('Nueva conversación creada ID: ' . $conversation->id);
            } else {
                Log::info('Usando conversación existente ID: ' . $conversation->id);
            }
            
            // Guardar mensaje del usuario
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'user_id' => $currentUserId,
                'recipient_id' => $recipientId,
                'message' => $request->message,
                'is_read' => false,
            ]);
            
            Log::info('Mensaje guardado ID: ' . $message->id);
            
            $conversation->update(['last_message_at' => now()]);
            
            $user = Auth::user();
            
            broadcast(new MessageSent($message, $conversation, $user))->toOthers();
            
            // SI ES IA: Generar respuesta automática
            if ($isAI) {
                Log::info('=== GENERANDO RESPUESTA IA ===');
                
                try {
                    // Instanciar Mistral manualmente
                    $mistral = new MistralAIService();
                    $aiResponseText = $mistral->ask($request->message);
                    
                    Log::info('Respuesta IA generada: ' . substr($aiResponseText, 0, 100));
                    
                    // Guardar respuesta de la IA
                    $aiMessage = Message::create([
                        'conversation_id' => $conversation->id,
                        'user_id' => $recipientId,
                        'recipient_id' => $currentUserId,
                        'message' => $aiResponseText,
                        'is_read' => false,
                    ]);
                    
                    Log::info('Mensaje IA guardado ID: ' . $aiMessage->id);
                    
                    $conversation->update(['last_message_at' => now()]);
                    
                    broadcast(new MessageSent($aiMessage, $conversation, $recipient))->toOthers();
                    
                    return response()->json([
                        'success' => true,
                        'is_ai_response' => true,
                        'user_message' => [
                            'id' => $message->id,
                            'message' => $message->message,
                            'user_id' => $message->user_id,
                            'recipient_id' => $message->recipient_id,
                            'created_at' => $message->created_at,
                            'sender_name' => $user->name
                        ],
                        'ai_response' => [
                            'id' => $aiMessage->id,
                            'message' => $aiMessage->message,
                            'user_id' => $aiMessage->user_id,
                            'recipient_id' => $aiMessage->recipient_id,
                            'created_at' => $aiMessage->created_at,
                            'sender_name' => $recipient->name
                        ]
                    ]);
                    
                } catch (\Exception $e) {
                    Log::error('ERROR al generar respuesta IA: ' . $e->getMessage());
                    Log::error($e->getTraceAsString());
                    
                    // Devolver éxito del mensaje del usuario aunque falle la IA
                    return response()->json([
                        'success' => true,
                        'is_ai_response' => false,
                        'ai_error' => $e->getMessage(),
                        'id' => $message->id,
                        'message' => $message->message,
                        'user_id' => $message->user_id,
                        'recipient_id' => $message->recipient_id,
                        'created_at' => $message->created_at,
                        'sender_name' => $user->name
                    ]);
                }
            }
            
            // Respuesta normal (no IA)
            return response()->json([
                'success' => true,
                'is_ai_response' => false,
                'id' => $message->id,
                'message' => $message->message,
                'user_id' => $message->user_id,
                'recipient_id' => $message->recipient_id,
                'created_at' => $message->created_at,
                'sender_name' => $user->name
            ]);
            
        } catch (\Exception $e) {
            Log::error('ERROR CRÍTICO en sendMessage: ' . $e->getMessage());
            Log::error('Archivo: ' . $e->getFile() . ' Línea: ' . $e->getLine());
            Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'file' => basename($e->getFile()),
                'line' => $e->getLine()
            ], 500);
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
            Log::error('markAsRead error: ' . $e->getMessage());
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
            
            if ($userId === null) {
                return response()->json(['total_unread' => $totalUnread]);
            }
            
            return $totalUnread;
            
        } catch (\Exception $e) {
            Log::error('getTotalUnreadCount error: ' . $e->getMessage());
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
            Log::error('getConversations error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}