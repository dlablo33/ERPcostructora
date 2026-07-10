<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile\UserPreference;
use App\Models\Profile\UserSession;
use App\Models\Profile\UserNotification;
use App\Models\Profile\UserApiToken;
use App\Models\Profile\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Constructor - Aplicar middleware de autenticación.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user's profile dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $preferences = $this->getUserPreferences($user->id);
        $notifications = $this->getUserNotifications($user->id, 5);
        $unreadCount = UserNotification::where('user_id', $user->id)
            ->where('is_read', false)
            ->where('is_dismissed', false)
            ->count();

        $pendingTasks = \DB::table('tareas')
            ->where('usuario_asignado_id', $user->id)
            ->where('estado', 'pendiente')
            ->count();

        $projectsCount = \DB::table('asignaciones_personal')
            ->where('empleado_id', $user->id)
            ->where('status', 'activo')
            ->count();

        $sessions = $this->getUserSessions($user->id);

        return view('profile.index', compact(
            'user',
            'preferences',
            'notifications',
            'unreadCount',
            'pendingTasks',
            'projectsCount',
            'sessions'
        ));
    }

    /**
     * Display the user's profile form (edit).
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $preferences = $this->getUserPreferences($user->id);

        return view('profile.edit', [
            'user' => $user,
            'preferences' => $preferences,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Si la request viene con validación de ProfileUpdateRequest (Breeze)
        if ($request->has('name') && $request->has('email') && !$request->hasFile('avatar')) {
            return $this->updateProfileBreeze($request);
        }

        // Si la request viene con datos extendidos (nueva funcionalidad)
        return $this->updateProfileFull($request);
    }

    /**
     * Update profile using Breeze-style validation.
     */
    protected function updateProfileBreeze($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $user->fill($request->only('name', 'email'));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update profile with full features (phone, avatar, etc.).
     */
    protected function updateProfileFull($request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Actualizar campos básicos
            $user->name = $request->name;
            $user->email = $request->email;
            
            // Actualizar campos adicionales SOLO si existen en la tabla
            if ($request->has('phone')) {
                $user->phone = $request->phone;
            }
            if ($request->has('position')) {
                $user->position = $request->position;
            }
            if ($request->has('department')) {
                $user->department = $request->department;
            }

            // Manejar avatar
            if ($request->hasFile('avatar')) {
                $avatarPath = $this->uploadAvatar($request->file('avatar'), $user->id);
                $user->avatar_path = $avatarPath;
            }

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Perfil actualizado correctamente',
                    'data' => $user
                ]);
            }

            return Redirect::route('profile.edit')->with('status', 'profile-updated');

        } catch (\Exception $e) {
            \Log::error('Error en updateProfileFull: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el perfil: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Error al actualizar el perfil: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        if (!Hash::check($request->current_password, $user->password)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'La contraseña actual es incorrecta'
                ], 422);
            }
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta']);
        }

        try {
            $user->password = Hash::make($request->new_password);
            $user->password_changed_at = now();
            $user->save();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Contraseña actualizada correctamente'
                ]);
            }

            return back()->with('status', 'password-updated');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cambiar la contraseña: ' . $e->getMessage()
                ], 500);
            }
            return back()->withErrors(['error' => 'Error al cambiar la contraseña']);
        }
    }

    /**
     * Update the user's preferences.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePreferences(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'theme' => 'required|in:light,dark,auto',
            'language' => 'required|string|in:es,en',
            'timezone' => 'required|string|timezone',
            'date_format' => 'required|string|max:20',
            'time_format' => 'required|string|max:10',
            'currency' => 'required|string|in:MXN,USD,EUR',
            'notifications_email' => 'boolean',
            'notifications_system' => 'boolean',
            'notifications_whatsapp' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $preferences = UserPreference::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'theme' => $request->theme,
                    'language' => $request->language,
                    'timezone' => $request->timezone,
                    'date_format' => $request->date_format,
                    'time_format' => $request->time_format,
                    'currency' => $request->currency,
                    'notifications_email' => $request->notifications_email ?? true,
                    'notifications_system' => $request->notifications_system ?? true,
                    'notifications_whatsapp' => $request->notifications_whatsapp ?? false,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Preferencias actualizadas correctamente',
                'data' => $preferences
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar preferencias: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user notifications.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotifications(Request $request)
    {
        $user = Auth::user();
        $limit = $request->get('limit', 20);
        $type = $request->get('type', 'all');

        $query = UserNotification::where('user_id', $user->id)
            ->where('is_dismissed', false);

        if ($type === 'unread') {
            $query->where('is_read', false);
        } elseif ($type !== 'all') {
            $query->where('type', $type);
        }

        $notifications = $query->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        $unreadCount = UserNotification::where('user_id', $user->id)
            ->where('is_read', false)
            ->where('is_dismissed', false)
            ->count();

        return response()->json([
            'success' => true,
            'data' => $notifications,
            'unread_count' => $unreadCount,
            'total' => $notifications->count()
        ]);
    }

    /**
     * Mark notification as read.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function markNotificationRead($id)
    {
        try {
            $notification = UserNotification::where('user_id', Auth::id())
                ->findOrFail($id);

            $notification->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'Notificación marcada como leída'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al marcar la notificación: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAllNotificationsRead()
    {
        try {
            UserNotification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->where('is_dismissed', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Todas las notificaciones marcadas como leídas'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al marcar notificaciones: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Dismiss notification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function dismissNotification($id)
    {
        try {
            $notification = UserNotification::where('user_id', Auth::id())
                ->findOrFail($id);

            $notification->dismiss();

            return response()->json([
                'success' => true,
                'message' => 'Notificación descartada'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al descartar la notificación: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user sessions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSessions()
    {
        try {
            $currentSessionId = session()->getId();
            
            $sessions = UserSession::where('user_id', Auth::id())
                ->orderBy('last_activity', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $sessions,
                'current_session_id' => $currentSessionId
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener sesiones: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Terminate a user session.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function terminateSession($id)
    {
        try {
            $session = UserSession::where('user_id', Auth::id())
                ->findOrFail($id);

            if ($session->is_current) {
                return response()->json([
                    'success' => false,
                    'message' => 'No puedes cerrar tu sesión actual desde aquí'
                ], 422);
            }

            $session->terminate();

            return response()->json([
                'success' => true,
                'message' => 'Sesión terminada correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al terminar la sesión: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Terminate all user sessions except current.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function terminateAllSessions()
    {
        try {
            $currentSessionId = session()->getId();

            UserSession::where('user_id', Auth::id())
                ->where('session_id', '!=', $currentSessionId)
                ->update(['is_active' => false]);

            return response()->json([
                'success' => true,
                'message' => 'Todas las sesiones terminadas correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al terminar las sesiones: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user API tokens.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getApiTokens()
    {
        try {
            $tokens = UserApiToken::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $tokens
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener tokens: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createApiToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'expires_in_days' => 'nullable|integer|min:1|max:365',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $token = UserApiToken::createToken(
                Auth::id(),
                $request->name,
                null,
                $request->expires_in_days ?? 30
            );

            return response()->json([
                'success' => true,
                'message' => 'Token creado correctamente',
                'data' => $token
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el token: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Revoke an API token.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function revokeApiToken($id)
    {
        try {
            $token = UserApiToken::where('user_id', Auth::id())
                ->findOrFail($id);

            $tokenName = $token->name;
            $token->revoke();

            return response()->json([
                'success' => true,
                'message' => 'Token revocado correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al revocar el token: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user activity log.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getActivity(Request $request)
    {
        try {
            $limit = $request->get('limit', 50);
            $activity = $this->getUserActivity(Auth::id(), $limit);

            return response()->json([
                'success' => true,
                'data' => $activity
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener actividad: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's projects.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProjects()
    {
        try {
            $userId = Auth::id();
            
            $projects = \DB::table('asignaciones_personal as ap')
                ->join('proyectos as p', 'ap.proyecto_id', '=', 'p.id')
                ->where('ap.empleado_id', $userId)
                ->where('ap.status', 'activo')
                ->select(
                    'p.id',
                    'p.codigo',
                    'p.nombre',
                    'p.estado',
                    'p.presupuesto_total',
                    'ap.rol',
                    'ap.fecha_asignacion'
                )
                ->get();

            return response()->json([
                'success' => true,
                'data' => $projects
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener proyectos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's tasks.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTasks(Request $request)
    {
        try {
            $status = $request->get('status', 'all');
            $limit = $request->get('limit', 10);

            $query = \DB::table('tareas')
                ->where('usuario_asignado_id', Auth::id());

            if ($status === 'pending') {
                $query->where('estado', 'pendiente');
            } elseif ($status === 'completed') {
                $query->where('estado', 'completada');
            }

            $tasks = $query->orderBy('fecha_limite', 'asc')
                ->limit($limit)
                ->get();

            $pendingCount = \DB::table('tareas')
                ->where('usuario_asignado_id', Auth::id())
                ->where('estado', 'pendiente')
                ->count();

            return response()->json([
                'success' => true,
                'data' => $tasks,
                'pending_count' => $pendingCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener tareas: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // MÉTODOS PRIVADOS (Helpers)
    // ============================================

    /**
     * Upload user avatar.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  int  $userId
     * @return string|null
     */
    protected function uploadAvatar($file, $userId)
    {
        try {
            if (!$file->isValid()) {
                throw new \Exception('El archivo no es válido');
            }

            $extension = $file->getClientOriginalExtension();
            $filename = 'avatar_' . $userId . '_' . time() . '.' . $extension;
            $path = $file->storeAs('avatars', $filename, 'public');
            
            return $path;
        } catch (\Exception $e) {
            \Log::error('Error al subir avatar: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get user preferences.
     *
     * @param  int  $userId
     * @return \App\Models\Profile\UserPreference|null
     */
    protected function getUserPreferences($userId)
    {
        return UserPreference::where('user_id', $userId)->first();
    }

    /**
     * Get user sessions.
     *
     * @param  int  $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getUserSessions($userId)
    {
        return UserSession::where('user_id', $userId)
            ->orderBy('last_activity', 'desc')
            ->get();
    }

    /**
     * Get user notifications.
     *
     * @param  int  $userId
     * @param  int  $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getUserNotifications($userId, $limit = 10)
    {
        return UserNotification::where('user_id', $userId)
            ->where('is_dismissed', false)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get user activity log.
     *
     * @param  int  $userId
     * @param  int  $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getUserActivity($userId, $limit = 20)
    {
        return UserActivityLog::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}