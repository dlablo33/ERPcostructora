<?php

namespace App\Http\Controllers;

use App\Models\ClientTicket;
use App\Models\TicketArchivo;
use App\Models\TicketComentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClienteTicketController extends Controller
{
    /**
     * Constructor - Aplica middleware de autenticación
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Lista de tickets del usuario autenticado
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        
        $query = ClientTicket::where('cliente_id', $userId);

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(10);

        // ✅ CORREGIDO: Usar soporte.tickets.index
        return view('soporte.tickets.index', compact('tickets'));
    }

    /**
     * Muestra el formulario para crear un nuevo ticket
     */
    public function create()
    {
        // ✅ CORREGIDO: Usar soporte.tickets.create
        return view('soporte.tickets.create');
    }

    /**
     * Almacena un nuevo ticket
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'tipo' => 'required|in:error,solicitud,mejora',
            'prioridad' => 'required|in:baja,media,alta,critica',
            'archivos.*' => 'nullable|file|max:10240' // 10MB max
        ]);

        // Crear el ticket
        $ticket = ClientTicket::create([
            'cliente_id' => Auth::id(),
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'prioridad' => $request->prioridad,
            'estado' => 'pendiente'
        ]);

        // Agregar comentario inicial
        $ticket->addComment(
            Auth::id(),
            '📝 Ticket creado por ' . Auth::user()->name,
            false
        );

        // Subir archivos si existen
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $file) {
                $this->uploadFile($ticket, $file);
            }
        }

        // ✅ CORREGIDO: Usar soporte.tickets.show
        return redirect()->route('soporte.tickets.show', $ticket->id)
            ->with('success', '✅ Ticket creado exitosamente');
    }

    /**
     * Muestra el detalle de un ticket
     */
    public function show($id)
    {
        $ticket = ClientTicket::where('cliente_id', Auth::id())
            ->where('id', $id)
            ->with(['comentariosPublicos', 'archivos'])
            ->firstOrFail();

        // ✅ CORREGIDO: Usar soporte.tickets.show
        return view('soporte.tickets.show', compact('ticket'));
    }

    /**
     * Agrega un comentario al ticket (desde el cliente)
     */
    public function addComment(Request $request, $id)
    {
        $ticket = ClientTicket::where('cliente_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'comentario' => 'required|string|max:1000'
        ]);

        $ticket->addComment(
            Auth::id(),
            $request->comentario,
            false // Siempre público para que el cliente vea
        );

        // ✅ CORREGIDO: Usar soporte.tickets.show
        return redirect()->route('soporte.tickets.show', $ticket->id)
            ->with('success', 'Comentario agregado correctamente');
    }

    /**
     * Sube un archivo adjunto
     */
    private function uploadFile($ticket, $file)
    {
        $nombreOriginal = $file->getClientOriginalName();
        $nombreUnico = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $ruta = $file->storeAs('tickets/' . $ticket->id, $nombreUnico, 'public');

        TicketArchivo::create([
            'ticket_id' => $ticket->id,
            'nombre_original' => $nombreOriginal,
            'nombre_unico' => $nombreUnico,
            'ruta' => $ruta,
            'tamaño' => $file->getSize(),
            'mime_type' => $file->getMimeType()
        ]);
    }
}