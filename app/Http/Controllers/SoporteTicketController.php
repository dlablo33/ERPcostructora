<?php

namespace App\Http\Controllers;

use App\Models\ClientTicket;
use App\Models\DesarrolladorAcceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoporteTicketController extends Controller
{
    /**
     * Constructor - Aplica middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:soporte');
    }

    /**
     * Lista de todos los tickets (para soporte)
     */
    public function index(Request $request)
    {
        $query = ClientTicket::with(['cliente', 'soporte', 'desarrollador']);

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('cliente')) {
            $query->whereHas('cliente', function($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->cliente}%");
            });
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(15);

        // Estadísticas para el dashboard
        $stats = [
            'pendientes' => ClientTicket::where('estado', 'pendiente')->count(),
            'en_revision' => ClientTicket::where('estado', 'en_revision')->count(),
            'en_desarrollo' => ClientTicket::where('estado', 'en_desarrollo')->count(),
            'completados' => ClientTicket::where('estado', 'completado')->count()
        ];

        // Desarrolladores disponibles para asignar
        $desarrolladores = DesarrolladorAcceso::where('activo', true)->get();

        return view('soporte.tickets.index', compact('tickets', 'stats', 'desarrolladores'));
    }

    /**
     * Muestra el detalle de un ticket (para soporte)
     */
    public function show($id)
    {
        $ticket = ClientTicket::with([
            'cliente', 
            'soporte', 
            'desarrollador',
            'comentarios.usuario',
            'archivos'
        ])->findOrFail($id);

        $desarrolladores = DesarrolladorAcceso::where('activo', true)->get();

        return view('soporte.tickets.show', compact('ticket', 'desarrolladores'));
    }

    /**
     * Aprueba un ticket (pasa a desarrollo)
     */
    public function approve($id)
    {
        $ticket = ClientTicket::findOrFail($id);

        if (!in_array($ticket->estado, ['pendiente', 'en_revision', 'info_requerida'])) {
            return back()->with('error', 'Este ticket no puede ser aprobado en su estado actual');
        }

        $ticket->approve(Auth::id());

        return redirect()->route('soporte.tickets.show', $ticket->id)
            ->with('success', '✅ Ticket aprobado y enviado a desarrollo');
    }

    /**
     * Rechaza un ticket con motivo
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'motivo' => 'required|string|min:10'
        ]);

        $ticket = ClientTicket::findOrFail($id);

        if (!in_array($ticket->estado, ['pendiente', 'en_revision', 'info_requerida'])) {
            return back()->with('error', 'Este ticket no puede ser rechazado en su estado actual');
        }

        $ticket->reject(Auth::id(), $request->motivo);

        return redirect()->route('soporte.tickets.show', $ticket->id)
            ->with('success', '❌ Ticket rechazado');
    }

    /**
     * Solicita información adicional al cliente
     */
    public function requestInfo(Request $request, $id)
    {
        $request->validate([
            'pregunta' => 'required|string|min:10'
        ]);

        $ticket = ClientTicket::findOrFail($id);

        if (!in_array($ticket->estado, ['pendiente', 'en_revision'])) {
            return back()->with('error', 'Este ticket no puede solicitar información en su estado actual');
        }

        $ticket->requestInfo(Auth::id(), $request->pregunta);

        return redirect()->route('soporte.tickets.show', $ticket->id)
            ->with('success', '🔍 Información solicitada al cliente');
    }

    /**
     * Asigna un ticket a un desarrollador
     */
    public function assign(Request $request, $id)
    {
        $request->validate([
            'desarrollador_id' => 'required|exists:desarrolladores_acceso,id',
            'tiempo_estimado' => 'nullable|numeric|min:0.5'
        ]);

        $ticket = ClientTicket::findOrFail($id);

        if ($ticket->estado !== 'aprobado') {
            return back()->with('error', 'Este ticket debe estar aprobado para asignarlo');
        }

        $ticket->assignToDeveloper(
            $request->desarrollador_id,
            $request->tiempo_estimado
        );

        return redirect()->route('soporte.tickets.show', $ticket->id)
            ->with('success', '👨‍💻 Ticket asignado al desarrollador');
    }

    /**
     * Agrega un comentario interno (solo visible para soporte/desarrollo)
     */
    public function addInternalComment(Request $request, $id)
    {
        $request->validate([
            'comentario' => 'required|string|max:1000'
        ]);

        $ticket = ClientTicket::findOrFail($id);

        $ticket->addComment(
            Auth::id(),
            $request->comentario,
            true // Interno
        );

        return redirect()->route('soporte.tickets.show', $ticket->id)
            ->with('success', 'Comentario interno agregado');
    }

    /**
     * Agrega un comentario público (visible para el cliente)
     */
    public function addPublicComment(Request $request, $id)
    {
        $request->validate([
            'comentario' => 'required|string|max:1000'
        ]);

        $ticket = ClientTicket::findOrFail($id);

        $ticket->addComment(
            Auth::id(),
            $request->comentario,
            false // Público
        );

        return redirect()->route('soporte.tickets.show', $ticket->id)
            ->with('success', 'Comentario público agregado');
    }

    /**
     * Obtiene estadísticas en JSON para el dashboard
     */
    public function getStats()
    {
        return response()->json([
            'pendientes' => ClientTicket::where('estado', 'pendiente')->count(),
            'en_revision' => ClientTicket::where('estado', 'en_revision')->count(),
            'info_requerida' => ClientTicket::where('estado', 'info_requerida')->count(),
            'aprobados' => ClientTicket::where('estado', 'aprobado')->count(),
            'en_desarrollo' => ClientTicket::where('estado', 'en_desarrollo')->count(),
            'completados' => ClientTicket::where('estado', 'completado')->count(),
            'rechazados' => ClientTicket::where('estado', 'rechazado')->count()
        ]);
    }

    /**
     * Obtiene todos los tickets en JSON (para AJAX)
     */
    public function getTickets(Request $request)
    {
        $query = ClientTicket::with(['cliente', 'desarrollador']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $tickets = $query->orderBy('created_at', 'desc')->get();

        return response()->json($tickets);
    }
}