<?php
// app/Services/NotificationService.php
namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Events\PushNotificationEvent;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Enviar notificación a un usuario
     */
    public function send($userId, $title, $body, $type = 'info', $data = null)
    {
        try {
            // 1. Guardar en base de datos
            $notification = Notification::create([
                'user_id' => $userId,
                'title' => $title,
                'body' => $body,
                'type' => $type,
                'data' => $data,
                'sent_at' => now()
            ]);

            // 2. Obtener el usuario
            $user = User::find($userId);
            if (!$user) {
                return null;
            }

            // 3. Preparar notificación para broadcast
            $notificationData = [
                'id' => $notification->id,
                'title' => $title,
                'message' => $body,
                'type' => $type,
                'timestamp' => $notification->created_at->toISOString(),
                'from_user' => 'Sistema',
                'url' => $data['url'] ?? '/dashboard',
                'action' => $data['action'] ?? 'open',
                'read' => false
            ];

            // 4. Enviar en tiempo real (Reverb/WebSocket)
            try {
                broadcast(new PushNotificationEvent($userId, $notificationData));
            } catch (\Exception $e) {
                Log::warning('Broadcast falló: ' . $e->getMessage());
            }

            return $notification;

        } catch (\Exception $e) {
            Log::error('Error enviando notificación: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Enviar notificación a múltiples usuarios
     */
    public function sendToMany($userIds, $title, $body, $type = 'info', $data = null)
    {
        $sent = [];
        foreach ($userIds as $userId) {
            $result = $this->send($userId, $title, $body, $type, $data);
            if ($result) {
                $sent[] = $result;
            }
        }
        return $sent;
    }

    /**
     * Enviar notificación a todos los usuarios
     */
    public function sendToAll($title, $body, $type = 'info', $data = null)
    {
        $users = User::all();
        return $this->sendToMany($users->pluck('id')->toArray(), $title, $body, $type, $data);
    }

    /**
     * Marcar notificación como leída
     */
    public function markAsRead($notificationId, $userId)
    {
        $notification = Notification::where('id', $notificationId)
            ->where('user_id', $userId)
            ->first();
            
        if ($notification) {
            $notification->markAsRead();
            return true;
        }
        return false;
    }

    /**
     * Marcar todas las notificaciones como leídas
     */
    public function markAllAsRead($userId)
    {
        return Notification::where('user_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    /**
     * Obtener notificaciones no leídas
     */
    public function getUnread($userId)
    {
        return Notification::where('user_id', $userId)
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Obtener todas las notificaciones
     */
    public function getAll($userId, $limit = 50)
    {
        return Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Eliminar notificaciones antiguas
     */
    public function clearOld($userId, $days = 30)
    {
        return Notification::where('user_id', $userId)
            ->where('created_at', '<', now()->subDays($days))
            ->delete();
    }
}