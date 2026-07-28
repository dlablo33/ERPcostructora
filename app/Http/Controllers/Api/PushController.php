<?php
// app/Http/Controllers/Api/PushController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PushSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PushController extends Controller
{
    /**
     * Guardar suscripción push
     */
    public function subscribe(Request $request)
    {
        try {
            $userId = Auth::id();
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }

            $validated = $request->validate([
                'endpoint' => 'required|string',
                'keys' => 'required|array',
                'expiration_time' => 'nullable|string'
            ]);

            // Guardar o actualizar suscripción
            $subscription = PushSubscription::updateOrCreate(
                ['endpoint' => $validated['endpoint']],
                [
                    'user_id' => $userId,
                    'keys' => $validated['keys'],
                    'expiration_time' => $validated['expiration_time'] ?? null
                ]
            );

            Log::info('✅ Push subscription saved for user: ' . $userId);

            return response()->json([
                'success' => true,
                'message' => 'Suscripción push guardada correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error saving push subscription: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar suscripción: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar suscripción push
     */
    public function unsubscribe(Request $request)
    {
        try {
            $userId = Auth::id();
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }

            $validated = $request->validate([
                'endpoint' => 'required|string'
            ]);

            $deleted = PushSubscription::where('endpoint', $validated['endpoint'])
                ->where('user_id', $userId)
                ->delete();

            Log::info('✅ Push subscription removed for user: ' . $userId);

            return response()->json([
                'success' => true,
                'message' => 'Suscripción push eliminada'
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error removing push subscription: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar suscripción'
            ], 500);
        }
    }
}