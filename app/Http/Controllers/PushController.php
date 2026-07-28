<?php
// app/Http/Controllers/PushController.php
namespace App\Http\Controllers;

use App\Models\PushSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PushController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function subscribe(Request $request)
    {
        try {
            $user = Auth::user();
            
            $validated = $request->validate([
                'endpoint' => 'required|string',
                'keys' => 'required|array',
                'expiration_time' => 'nullable|string'
            ]);
            
            $subscription = PushSubscription::updateOrCreate(
                ['endpoint' => $validated['endpoint']],
                [
                    'user_id' => $user->id,
                    'keys' => $validated['keys'],
                    'expiration_time' => $validated['expiration_time'] ?? null
                ]
            );
            
            Log::info('✅ Push subscription saved for user: ' . $user->id);
            
            return response()->json([
                'success' => true,
                'message' => 'Suscripción push guardada'
            ]);
            
        } catch (\Exception $e) {
            Log::error('❌ Error saving push subscription: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar suscripción'
            ], 500);
        }
    }

    public function unsubscribe(Request $request)
    {
        try {
            $user = Auth::user();
            
            $validated = $request->validate([
                'endpoint' => 'required|string'
            ]);
            
            $deleted = PushSubscription::where('endpoint', $validated['endpoint'])
                ->where('user_id', $user->id)
                ->delete();
            
            Log::info('✅ Push subscription removed for user: ' . $user->id);
            
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