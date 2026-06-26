<?php

namespace App\Http\Controllers;

use App\Models\WorkflowTask;
use App\Models\WorkflowLog;
use App\Models\Requisicion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WorkflowController extends Controller
{
    /**
     * Constructor - Aplicar middleware de autenticación
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra el panel de tareas del usuario
     */
    /**
 * Muestra el panel de tareas del usuario
 */
public function index(Request $request)
{
    $userId = Auth::id();
    
    // Consulta base: tareas asignadas al usuario
    $query = WorkflowTask::where('assigned_to', $userId)
        ->orderBy('created_at', 'desc');

    // Aplicar filtros
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('priority')) {
        $query->where('priority', $request->priority);
    }

    if ($request->filled('module')) {
        $query->where('module', $request->module);
    }

    // Obtener tareas con paginación
    $tasks = $query->paginate(15);

    // Obtener estadísticas
    $stats = $this->getTaskStats($userId);

    // Obtener módulos disponibles para filtro
    $modules = WorkflowTask::where('assigned_to', $userId)
        ->distinct()
        ->pluck('module');

    // 👇 CORREGIDO: Cambiar 'tasks.index' por 'tareas.index'
    return view('tareas.index', compact('tasks', 'stats', 'modules'));
}

    /**
     * Muestra las tareas en formato JSON (para API/Ajax)
     */
    public function getTasksJson(Request $request)
    {
        $userId = Auth::id();
        
        $query = WorkflowTask::where('assigned_to', $userId);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $tasks = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'tasks' => $tasks
        ]);
    }

    /**
     * Muestra el detalle de una tarea específica
     */
    /**
 * Muestra el detalle de una tarea específica
 */
public function show($id)
{
    $task = WorkflowTask::findOrFail($id);
    
    // Verificar que el usuario tenga acceso
    if ($task->assigned_to !== Auth::id() && $task->created_by !== Auth::id()) {
        abort(403, 'No tienes permiso para ver esta tarea');
    }

    // Obtener el registro relacionado si existe
    $relatedRecord = $this->getRelatedRecord($task);

    // Obtener logs de la tarea
    $logs = WorkflowLog::where('workflow_task_id', $task->id)
        ->orderBy('created_at', 'desc')
        ->get();

    // 👇 CORREGIDO: Cambiar 'tasks.show' por 'tareas.show'
    return view('tareas.show', compact('task', 'relatedRecord', 'logs'));
}

    /**
     * Marca una tarea como completada
     */
    public function complete(Request $request, $id)
    {
        $task = WorkflowTask::findOrFail($id);
        
        // Verificar que el usuario sea el asignado
        if ($task->assigned_to !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para completar esta tarea'
            ], 403);
        }

        try {
            $task->markAsCompleted();

            // Registrar en logs de workflow
            $this->createWorkflowLog($task, 'completed', 'Tarea completada por el usuario');

            // Si es una tarea de requisición, actualizar estado
            if ($task->module === 'requisiciones' && $task->record_id) {
                $this->handleTaskCompletionForRequisicion($task);
            }

            Log::info("Tarea completada", [
                'task_id' => $task->id,
                'user_id' => Auth::id(),
                'module' => $task->module,
                'record_id' => $task->record_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tarea completada exitosamente',
                'task' => $task
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al completar la tarea: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Marca una tarea como "en progreso"
     */
    public function start($id)
    {
        $task = WorkflowTask::findOrFail($id);
        
        if ($task->assigned_to !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para modificar esta tarea'
            ], 403);
        }

        try {
            $task->markAsInProgress();

            // Registrar en logs de workflow
            $this->createWorkflowLog($task, 'in_progress', 'Usuario comenzó a trabajar en la tarea');

            return response()->json([
                'success' => true,
                'message' => 'Tarea en progreso',
                'task' => $task
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al iniciar la tarea: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reasigna una tarea a otro usuario
     */
    public function reassign(Request $request, $id)
    {
        $task = WorkflowTask::findOrFail($id);
        
        // Solo el creador o un admin pueden reasignar
        if ($task->created_by !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para reasignar esta tarea'
            ], 403);
        }

        $request->validate([
            'assigned_to' => 'required|exists:users,id'
        ]);

        try {
            $oldUser = $task->assigned_to;
            $task->update([
                'assigned_to' => $request->assigned_to,
                'status' => 'pending'
            ]);

            // Registrar en logs de workflow
            $this->createWorkflowLog($task, 'reassigned', 
                "Tarea reasignada de usuario ID {$oldUser} a usuario ID {$request->assigned_to}"
            );

            return response()->json([
                'success' => true,
                'message' => 'Tarea reasignada exitosamente',
                'task' => $task
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al reasignar la tarea: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene estadísticas de tareas para un usuario
     */
    private function getTaskStats($userId)
    {
        $tasks = WorkflowTask::where('assigned_to', $userId);

        return [
            'total' => $tasks->count(),
            'pending' => (clone $tasks)->where('status', 'pending')->count(),
            'in_progress' => (clone $tasks)->where('status', 'in_progress')->count(),
            'completed' => (clone $tasks)->where('status', 'completed')->count(),
            'by_module' => (clone $tasks)->selectRaw('module, count(*) as total')
                ->groupBy('module')
                ->pluck('total', 'module')
                ->toArray(),
            'by_priority' => (clone $tasks)->selectRaw('priority, count(*) as total')
                ->groupBy('priority')
                ->pluck('total', 'priority')
                ->toArray(),
            'overdue' => (clone $tasks)->where('status', '!=', 'completed')
                ->where('due_date', '<', now())
                ->count()
        ];
    }

    /**
     * Obtiene el registro relacionado con la tarea
     */
    private function getRelatedRecord($task)
    {
        try {
            switch ($task->module) {
                case 'requisiciones':
                    return Requisicion::with(['proyecto', 'creador', 'articulos'])
                        ->find($task->record_id);
                
                case 'cotizaciones':
                    // Si tienes el modelo Cotizacion
                    if (class_exists(\App\Models\Cotizacion::class)) {
                        return \App\Models\Cotizacion::with(['proveedor', 'requisicion'])
                            ->find($task->record_id);
                    }
                    return null;
                
                default:
                    return null;
            }
        } catch (\Exception $e) {
            Log::warning("Error al obtener registro relacionado: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Maneja la lógica cuando se completa una tarea de requisición
     */
    private function handleTaskCompletionForRequisicion($task)
    {
        try {
            $requisicion = Requisicion::find($task->record_id);
            
            if ($requisicion) {
                // Verificar el tipo de tarea por metadata
                $tipo = $task->getMetadataValue('tipo');
                
                if ($tipo === 'requisicion_creada') {
                    // Si la tarea era de revisión, sugerir siguiente paso
                    Log::info("Requisición revisada y completada", [
                        'requisicion_id' => $requisicion->id,
                        'folio' => $requisicion->folio
                    ]);
                } elseif ($tipo === 'orden_compra') {
                    // Si la tarea era de orden de compra
                    Log::info("Orden de Compra generada desde requisición", [
                        'requisicion_id' => $requisicion->id,
                        'folio' => $requisicion->folio
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error al procesar completado de requisición: " . $e->getMessage());
        }
    }

    /**
     * Crea un log para el workflow
     */
    private function createWorkflowLog($task, $action, $comments = null)
    {
        try {
            // Verificar si el modelo WorkflowLog existe
            if (class_exists(\App\Models\WorkflowLog::class)) {
                WorkflowLog::create([
                    'workflow_task_id' => $task->id,
                    'user_id' => Auth::id(),
                    'action' => $action,
                    'comments' => $comments,
                    'created_at' => now()
                ]);
            }
        } catch (\Exception $e) {
            Log::warning("Error al crear workflow log: " . $e->getMessage());
        }
    }

    /**
     * Obtiene usuarios disponibles para asignar tareas
     */
    public function getAvailableUsers(Request $request)
    {
        $search = $request->get('search', '');
        
        $users = User::where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get(['id', 'name', 'email']);

        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }

    /**
     * Obtiene el conteo de tareas pendientes (para el badge del menú)
     */
    public function getPendingCount()
    {
        $count = WorkflowTask::where('assigned_to', Auth::id())
            ->whereIn('status', ['pending', 'in_progress'])
            ->count();

        return response()->json([
            'count' => $count
        ]);
    }

    /**
     * Obtiene todas las tareas del usuario con filtros avanzados
     */
    public function getFilteredTasks(Request $request)
    {
        $userId = Auth::id();
        $query = WorkflowTask::where('assigned_to', $userId);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('due_date_from')) {
            $query->where('due_date', '>=', $request->due_date_from);
        }

        if ($request->filled('due_date_to')) {
            $query->where('due_date', '<=', $request->due_date_to);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $tasks = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'tasks' => $tasks
        ]);
    }

    /**
     * Actualiza la prioridad de una tarea
     */
    public function updatePriority(Request $request, $id)
    {
        $task = WorkflowTask::findOrFail($id);
        
        if ($task->assigned_to !== Auth::id() && $task->created_by !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para modificar esta tarea'
            ], 403);
        }

        $request->validate([
            'priority' => 'required|in:low,medium,high'
        ]);

        try {
            $task->update([
                'priority' => $request->priority
            ]);

            $this->createWorkflowLog($task, 'priority_changed', 
                "Prioridad cambiada a {$request->priority}"
            );

            return response()->json([
                'success' => true,
                'message' => 'Prioridad actualizada',
                'task' => $task
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar prioridad: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina una tarea (solo el creador puede eliminar)
     */
    public function destroy($id)
    {
        $task = WorkflowTask::findOrFail($id);
        
        if ($task->created_by !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para eliminar esta tarea'
            ], 403);
        }

        try {
            $task->delete();

            Log::info("Tarea eliminada", [
                'task_id' => $task->id,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tarea eliminada exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la tarea: ' . $e->getMessage()
            ], 500);
        }
    }

    public function approve($id)
    {
        $task = WorkflowTask::findOrFail($id);
        
        // Verificar permisos
        if ($task->assigned_to !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para aprobar esta tarea'
            ], 403);
        }

        try {
            // Marcar como completada o en progreso según el caso
            if ($task->status === 'pending') {
                $task->markAsInProgress();
                $message = 'Tarea marcada como en progreso';
            } else {
                $task->markAsCompleted();
                $message = 'Tarea aprobada y completada';
            }

            // Registrar en logs
            $this->createWorkflowLog($task, 'approved', 'Tarea aprobada por el usuario');

            // Si es una tarea de requisición, manejar lógica específica
            if ($task->module === 'requisiciones' && $task->record_id) {
                $this->handleTaskApprovalForRequisicion($task);
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'task' => $task
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al aprobar la tarea: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rechaza una tarea
     */
    public function reject(Request $request, $id)
    {
        $task = WorkflowTask::findOrFail($id);
        
        if ($task->assigned_to !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para rechazar esta tarea'
            ], 403);
        }

        $request->validate([
            'reason' => 'required|string|min:5'
        ]);

        try {
            $task->update([
                'status' => 'rejected'
            ]);

            // Registrar en logs
            $this->createWorkflowLog($task, 'rejected', 
                "Tarea rechazada. Motivo: {$request->reason}"
            );

            return response()->json([
                'success' => true,
                'message' => 'Tarea rechazada',
                'task' => $task
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al rechazar la tarea: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Muestra el historial de una tarea
     */
    /**
 * Muestra el historial de una tarea
 */
public function history($id)
{
    $task = WorkflowTask::findOrFail($id);
    
    // Verificar acceso
    if ($task->assigned_to !== Auth::id() && $task->created_by !== Auth::id()) {
        abort(403, 'No tienes permiso para ver el historial de esta tarea');
    }

    // Obtener logs
    $logs = WorkflowLog::where('workflow_task_id', $task->id)
        ->orderBy('created_at', 'desc')
        ->get();

    // 👇 CORREGIDO: Cambiar 'workflow.history' por 'tareas.history'
    if (view()->exists('tareas.history')) {
        return view('tareas.history', compact('task', 'logs'));
    }

    // Si no existe la vista, devolver JSON
    return response()->json([
        'success' => true,
        'task' => $task,
        'logs' => $logs
    ]);
}

    /**
     * Maneja la lógica cuando se aprueba una tarea de requisición
     */
    private function handleTaskApprovalForRequisicion($task)
    {
        try {
            $requisicion = Requisicion::find($task->record_id);
            
            if ($requisicion) {
                $tipo = $task->getMetadataValue('tipo');
                
                if ($tipo === 'requisicion_creada') {
                    // Si la tarea era de revisión, actualizar estado de requisición
                    $requisicion->update([
                        'estatus' => 'revisada'
                    ]);
                    
                    Log::info("Requisición revisada y aprobada", [
                        'requisicion_id' => $requisicion->id,
                        'folio' => $requisicion->folio,
                        'usuario' => Auth::id()
                    ]);
                } elseif ($tipo === 'orden_compra') {
                    // Si la tarea era de orden de compra
                    Log::info("Orden de Compra aprobada desde requisición", [
                        'requisicion_id' => $requisicion->id,
                        'folio' => $requisicion->folio
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error al procesar aprobación de requisición: " . $e->getMessage());
        }
    }
}
