<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\ClientTicket;
use App\Models\TicketComentario;
use App\Models\DesarrolladorAcceso;
use Illuminate\Http\Request;

class DevTicketController extends Controller
{
    /**
     * Dashboard del desarrollador
     */
    public function dashboard()
    {
        $devId = session('dev_user_id');
        
        $tickets = ClientTicket::where('desarrollador_id', $devId)
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => $tickets->count(),
            'pendientes' => $tickets->where('estado', 'aprobado')->count(),
            'en_desarrollo' => $tickets->where('estado', 'en_desarrollo')->count(),
            'completados' => $tickets->where('estado', 'completado')->count()
        ];

        return view('dev.dashboard', [
            'tickets' => $tickets,
            'stats' => $stats
        ]);
    }

    /**
     * Lista de tickets del desarrollador
     */
    public function index(Request $request)
    {
        $devId = session('dev_user_id');
        
        $query = ClientTicket::where('desarrollador_id', $devId);

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(15);

        if ($request->ajax()) {
            return response()->json($tickets);
        }

        return view('dev.tickets', compact('tickets'));
    }

    /**
     * Detalle de un ticket
     */
    public function show($id)
    {
        $devId = session('dev_user_id');
        
        // Verificar que el ticket esté asignado a este desarrollador
        $ticket = ClientTicket::where('id', $id)
            ->where('desarrollador_id', $devId)
            ->with(['comentarios.usuario', 'archivos'])
            ->firstOrFail();

        return view('dev.ticket-show', compact('ticket'));
    }

    /**
     * Inicia el desarrollo de un ticket
     */
    public function start($id)
    {
        $devId = session('dev_user_id');
        
        $ticket = ClientTicket::where('id', $id)
            ->where('desarrollador_id', $devId)
            ->firstOrFail();

        if ($ticket->estado !== 'aprobado') {
            return back()->with('error', 'Este ticket no está en estado para iniciar desarrollo');
        }

        $ticket->startDevelopment($devId);

        return redirect()->route('dev.tickets.show', $ticket->id)
            ->with('success', '🚀 Desarrollo iniciado correctamente');
    }

    /**
     * Marca un ticket como completado
     */
    public function complete(Request $request, $id)
    {
        $devId = session('dev_user_id');
        
        $ticket = ClientTicket::where('id', $id)
            ->where('desarrollador_id', $devId)
            ->firstOrFail();

        if ($ticket->estado !== 'en_desarrollo') {
            return back()->with('error', 'Este ticket no está en desarrollo');
        }

        $request->validate([
            'tiempo_real' => 'nullable|numeric|min:0.5'
        ]);

        $ticket->completeDevelopment($devId, $request->tiempo_real);

        return redirect()->route('dev.tickets.show', $ticket->id)
            ->with('success', '✅ Ticket completado exitosamente');
    }

    /**
     * Agrega un comentario al ticket
     */
    public function addComment(Request $request, $id)
    {
        $devId = session('dev_user_id');
        
        $ticket = ClientTicket::where('id', $id)
            ->where('desarrollador_id', $devId)
            ->firstOrFail();

        $request->validate([
            'comentario' => 'required|string|max:1000'
        ]);

        $ticket->addComment($devId, $request->comentario, true);

        return redirect()->route('dev.tickets.show', $ticket->id)
            ->with('success', 'Comentario agregado correctamente');
    }

    /**
     * Obtiene estadísticas en JSON para el dashboard
     */
    public function getStats()
    {
        $devId = session('dev_user_id');
        
        $tickets = ClientTicket::where('desarrollador_id', $devId)->get();

        return response()->json([
            'total' => $tickets->count(),
            'pendientes' => $tickets->where('estado', 'aprobado')->count(),
            'en_desarrollo' => $tickets->where('estado', 'en_desarrollo')->count(),
            'completados' => $tickets->where('estado', 'completado')->count()
        ]);
    }
}