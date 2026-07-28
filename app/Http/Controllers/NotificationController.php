<?php
// app/Http/Controllers/NotificationController.php
namespace App\Http\Controllers;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->middleware('auth');
        $this->notificationService = $notificationService;
    }

    /**
     * Obtener notificaciones no leídas del usuario (API)
     */
    public function unread()
    {
        try {
            $userId = Auth::id();
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado',
                    'notifications' => [],
                    'unread' => 0
                ], 401);
            }

            $notifications = Notification::where('user_id', $userId)
                ->whereNull('read_at')
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();

            $formatted = $notifications->map(function($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->body,
                    'type' => $notification->type,
                    'read' => !is_null($notification->read_at),
                    'timestamp' => $notification->created_at->toISOString(),
                    'data' => $notification->data,
                    'created_at' => $notification->created_at->toISOString()
                ];
            });

            return response()->json([
                'success' => true,
                'notifications' => $formatted,
                'unread' => $formatted->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Error en unread notifications: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar notificaciones',
                'notifications' => [],
                'unread' => 0
            ], 500);
        }
    }

    /**
     * Obtener todas las notificaciones del usuario
     */
    public function index(Request $request)
    {
        try {
            $userId = Auth::id();
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado',
                    'notifications' => [],
                    'unread' => 0
                ], 401);
            }

            $limit = $request->get('limit', 50);
            
            $notifications = Notification::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();

            $formatted = $notifications->map(function($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->body,
                    'type' => $notification->type,
                    'read' => !is_null($notification->read_at),
                    'timestamp' => $notification->created_at->toISOString(),
                    'data' => $notification->data,
                    'created_at' => $notification->created_at->toISOString()
                ];
            });

            $unreadCount = Notification::where('user_id', $userId)
                ->whereNull('read_at')
                ->count();

            return response()->json([
                'success' => true,
                'notifications' => $formatted,
                'unread' => $unreadCount,
                'total' => $notifications->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Error en index notifications: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar notificaciones',
                'notifications' => [],
                'unread' => 0
            ], 500);
        }
    }

    /**
     * Marcar notificación como leída
     */
    public function markAsRead($id)
    {
        try {
            $userId = Auth::id();
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }

            $notification = Notification::where('id', $id)
                ->where('user_id', $userId)
                ->first();

            if (!$notification) {
                return response()->json([
                    'success' => false,
                    'message' => 'Notificación no encontrada'
                ], 404);
            }

            $notification->read_at = now();
            $notification->save();

            return response()->json([
                'success' => true,
                'message' => 'Notificación marcada como leída'
            ]);

        } catch (\Exception $e) {
            Log::error('Error marcando como leída: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al marcar como leída'
            ], 500);
        }
    }

    /**
     * Marcar todas las notificaciones como leídas
     */
    public function markAllRead()
    {
        try {
            $userId = Auth::id();
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }

            $count = Notification::where('user_id', $userId)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => "{$count} notificaciones marcadas como leídas",
                'count' => $count
            ]);

        } catch (\Exception $e) {
            Log::error('Error marcando todas como leídas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al marcar todas como leídas'
            ], 500);
        }
    }

    /**
     * Eliminar todas las notificaciones
     */
    public function clearAll()
    {
        try {
            $userId = Auth::id();
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }

            $count = Notification::where('user_id', $userId)->delete();

            return response()->json([
                'success' => true,
                'message' => "{$count} notificaciones eliminadas",
                'count' => $count
            ]);

        } catch (\Exception $e) {
            Log::error('Error limpiando notificaciones: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al limpiar notificaciones'
            ], 500);
        }
    }

    /**
     * Eliminar una notificación específica
     */
    public function destroy($id)
    {
        try {
            $userId = Auth::id();
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }

            $notification = Notification::where('id', $id)
                ->where('user_id', $userId)
                ->first();

            if (!$notification) {
                return response()->json([
                    'success' => false,
                    'message' => 'Notificación no encontrada'
                ], 404);
            }

            $notification->delete();

            return response()->json([
                'success' => true,
                'message' => 'Notificación eliminada'
            ]);

        } catch (\Exception $e) {
            Log::error('Error eliminando notificación: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar notificación'
            ], 500);
        }
    }

    /**
 * Enviar notificación de demo
 */
public function demo(Request $request)
{
    try {
        $userId = $request->user_id ?? Auth::id();
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        $types = ['info', 'success', 'warning', 'danger', 'demo'];
        $randomType = $types[array_rand($types)];
        
        $messages = [
            'info' => [
                'title' => '📊 Actualización del sistema',
                'body' => 'El sistema se actualizará esta noche a las 2:00 AM'
            ],
            'success' => [
                'title' => '✅ Proyecto completado',
                'body' => 'El proyecto "Torre Norte" ha sido completado exitosamente'
            ],
            'warning' => [
                'title' => '⚠️ Presupuesto crítico',
                'body' => 'El proyecto "Parque Industrial" está al 85% del presupuesto'
            ],
            'danger' => [
                'title' => '🚨 Factura vencida',
                'body' => 'La factura #F-2024-001 tiene 15 días de retraso'
            ],
            'demo' => [
                'title' => '🔔 Notificación de prueba',
                'body' => '¡Esta es una notificación de demostración!'
            ]
        ];

        $message = $messages[$randomType];

        $notification = $this->notificationService->send(
            $userId,
            $message['title'],
            $message['body'],
            $randomType,
            ['url' => '/dashboard', 'action' => 'demo']
        );

        if ($notification) {
            return response()->json([
                'success' => true,
                'message' => 'Notificación enviada',
                'notification' => $notification
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Error al enviar notificación'
        ], 500);

    } catch (\Exception $e) {
        Log::error('Error en demo notification: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}
}