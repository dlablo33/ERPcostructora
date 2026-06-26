<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TareaController extends Controller
{
    // Mostrar todas las tareas del usuario autenticado
    public function index(Request $request)
    {
        $query = Tarea::with(['creador', 'referencia'])
            ->where('usuario_asignado_id', Auth::id());

        // Filtrar por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtrar por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $tareas = $query->orderBy('created_at', 'desc')->paginate(15);

        // Estadísticas para el dashboard
        $stats = [
            'pendientes' => Tarea::where('usuario_asignado_id', Auth::id())
                ->where('estado', 'pendiente')->count(),
            'total' => Tarea::where('usuario_asignado_id', Auth::id())->count(),
            'hoy' => Tarea::where('usuario_asignado_id', Auth::id())
                ->whereDate('created_at', today())->count(),
        ];

        if ($request->ajax()) {
            return response()->json([
                'tareas' => $tareas,
                'stats' => $stats,
            ]);
        }

        return view('tareas.index', compact('tareas', 'stats'));
    }

    // Mostrar detalle de una tarea específica
    public function show($id)
    {
        $tarea = Tarea::with(['creador', 'asignado', 'referencia'])
            ->where('usuario_asignado_id', Auth::id())
            ->findOrFail($id);

        // Marcar como leída si no lo está
        if (!$tarea->leida_at) {
            $tarea->update(['leida_at' => now()]);
        }

        return view('tareas.show', compact('tarea'));
    }

    // Aceptar tarea
    public function aceptar($id)
    {
        $tarea = Tarea::where('usuario_asignado_id', Auth::id())
            ->where('estado', 'pendiente')
            ->findOrFail($id);

        $tarea->update(['estado' => 'aceptada']);

        // Procesar la acción según el tipo de tarea
        $this->procesarAccionTarea($tarea, 'aceptar');

        // Notificar al creador
        $this->notificarCreador($tarea, 'aceptada');

        return response()->json([
            'success' => true,
            'message' => 'Tarea aceptada exitosamente',
            'tarea' => $tarea
        ]);
    }

    // Rechazar tarea
    public function rechazar($id, Request $request)
    {
        $tarea = Tarea::where('usuario_asignado_id', Auth::id())
            ->where('estado', 'pendiente')
            ->findOrFail($id);

        $tarea->update([
            'estado' => 'rechazada',
            'data' => array_merge($tarea->data ?? [], [
                'motivo_rechazo' => $request->input('motivo'),
                'rechazado_por' => Auth::id(),
                'rechazado_at' => now()
            ])
        ]);

        // Procesar la acción según el tipo de tarea
        $this->procesarAccionTarea($tarea, 'rechazar');

        // Notificar al creador
        $this->notificarCreador($tarea, 'rechazada');

        return response()->json([
            'success' => true,
            'message' => 'Tarea rechazada exitosamente',
            'tarea' => $tarea
        ]);
    }

    // Procesar acciones específicas según tipo de tarea
    private function procesarAccionTarea(Tarea $tarea, $accion)
    {
        switch ($tarea->tipo) {
            case 'compra':
                $this->procesarCompra($tarea, $accion);
                break;
            case 'factura':
                $this->procesarFactura($tarea, $accion);
                break;
            case 'licitacion':
                $this->procesarLicitacion($tarea, $accion);
                break;
            // Agregar más casos según necesidades
        }
    }

    private function procesarCompra(Tarea $tarea, $accion)
    {
        // Obtener la compra relacionada
        $compra = $tarea->referencia;
        
        if ($compra) {
            if ($accion === 'aceptar') {
                $compra->update(['estado' => 'aprobada']);
                // Aquí podrías disparar otros eventos
                // Ejemplo: enviar a almacén para surtido
            } else {
                $compra->update(['estado' => 'rechazada']);
            }
        }
    }

    private function procesarFactura(Tarea $tarea, $accion)
    {
        // Lógica para procesar factura
    }

    private function procesarLicitacion(Tarea $tarea, $accion)
    {
        // Lógica para procesar licitación
    }

    private function notificarCreador(Tarea $tarea, $estado)
    {
        // Crear una notificación para el creador
        $mensaje = $estado === 'aceptada' 
            ? "Tu solicitud de {$tarea->tipo} ha sido aceptada"
            : "Tu solicitud de {$tarea->tipo} ha sido rechazada";

        // Aquí implementar sistema de notificaciones
        // Puedes usar Notification facade o crear una nueva tarea
        Tarea::create([
            'usuario_creador_id' => Auth::id(), // El administrador como creador
            'usuario_asignado_id' => $tarea->usuario_creador_id, // El empleado
            'titulo' => $mensaje,
            'descripcion' => $tarea->titulo,
            'tipo' => 'notificacion',
            'referencia_id' => $tarea->id,
            'referencia_type' => Tarea::class,
            'estado' => 'completada'
        ]);
    }
}