<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\ProyectoEquipo;
use App\Models\ProyectoDocumento;
use App\Models\ProyectoCosto;
use App\Models\ProyectoFlujoEfectivo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProyectoController extends Controller
{
    /**
     * Muestra la cartera de proyectos (listado)
     */
    public function index(Request $request)
{
    $query = Proyecto::with(['responsable', 'costos']);
    
    // Filtros
    if ($request->has('status') && $request->status) {
        $query->where('status', $request->status);
    }
    
    if ($request->has('prioridad') && $request->prioridad) {
        $query->where('prioridad', $request->prioridad);
    }
    
    if ($request->has('search') && $request->search) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nombre', 'LIKE', "%{$search}%")
              ->orWhere('codigo', 'LIKE', "%{$search}%")
              ->orWhere('cliente_nombre', 'LIKE', "%{$search}%");
        });
    }
    
    $proyectos = $query->orderBy('created_at', 'desc')->get();
    
    return view('proyectos.gestion.cartera', compact('proyectos'));
}

    /**
     * Muestra el formulario para crear un nuevo proyecto
     */
    public function create()
    {
        // Generar código automático para el proyecto
        $codigo = $this->generarCodigoProyecto();
        
        // Obtener usuarios para el responsable del proyecto
        $usuarios = User::where('estatus', 'activo')
            ->orWhereNull('estatus')
            ->orderBy('name')
            ->get();
        
        // Vista corregida: alta de proyecto
        return view('proyectos.gestion.alta', compact('codigo', 'usuarios'));
    }

    /**
     * Almacena un nuevo proyecto en la base de datos
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            // Validar los datos
            $validated = $this->validarProyecto($request);
            
            // Crear el proyecto
            $proyecto = $this->crearProyecto($request);
            
            // Guardar equipo del proyecto
            if ($request->has('equipo') && $request->equipo) {
                $this->guardarEquipo($proyecto->id, $request->equipo);
            }
            
            // Guardar costos del proyecto
            if ($request->has('costos') && $request->costos) {
                $this->guardarCostos($proyecto->id, $request->costos);
            }
            
            // Guardar documentos del proyecto
            if ($request->hasFile('documentos')) {
                $this->guardarDocumentos($proyecto->id, $request->file('documentos'));
            }
            
            DB::commit();
            
            $mensaje = $request->status === 'borrador' 
                ? 'Borrador guardado correctamente' 
                : 'Proyecto creado exitosamente';
            
            return response()->json([
                'success' => true,
                'message' => $mensaje,
                'proyecto_id' => $proyecto->id,
                'proyecto_codigo' => $proyecto->codigo
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al guardar proyecto: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el proyecto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Muestra los detalles de un proyecto
     */
    public function show($id)
    {
        $proyecto = Proyecto::with(['responsable', 'equipo', 'documentos', 'costos', 'flujoEfectivo'])
            ->findOrFail($id);
        
        return view('proyectos.show', compact('proyecto'));
    }

    /**
     * Muestra el formulario para editar un proyecto
     */
    public function edit($id)
    {
        $proyecto = Proyecto::with(['equipo', 'costos'])->findOrFail($id);
        $usuarios = User::orderBy('name')->get();
        $codigo = $proyecto->codigo;
        
        // Reutilizar la misma vista de alta con los datos del proyecto
        return view('proyectos.gestion.alta', compact('proyecto', 'usuarios', 'codigo'));
    }

    /**
     * Actualiza un proyecto existente
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $proyecto = Proyecto::findOrFail($id);
            
            // Validar datos
            $validated = $this->validarProyecto($request, $id);
            
            // Actualizar proyecto
            $proyecto->update($this->prepararDatosProyecto($request));
            
            // Actualizar equipo (eliminar y recrear)
            ProyectoEquipo::where('proyecto_id', $id)->delete();
            if ($request->has('equipo') && $request->equipo) {
                $this->guardarEquipo($id, $request->equipo);
            }
            
            // Actualizar costos
            if ($request->has('costos') && $request->costos) {
                ProyectoCosto::updateOrCreate(
                    ['proyecto_id' => $id],
                    $this->prepararDatosCostos($request)
                );
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Proyecto actualizado exitosamente',
                'proyecto_id' => $proyecto->id
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar proyecto: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el proyecto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina un proyecto
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $proyecto = Proyecto::findOrFail($id);
            
            // Eliminar documentos físicos
            $documentos = ProyectoDocumento::where('proyecto_id', $id)->get();
            foreach ($documentos as $doc) {
                if (Storage::disk('public')->exists($doc->ruta)) {
                    Storage::disk('public')->delete($doc->ruta);
                }
            }
            
            // Eliminar registros relacionados
            ProyectoEquipo::where('proyecto_id', $id)->delete();
            ProyectoDocumento::where('proyecto_id', $id)->delete();
            ProyectoCosto::where('proyecto_id', $id)->delete();
            ProyectoFlujoEfectivo::where('proyecto_id', $id)->delete();
            
            // Eliminar proyecto
            $proyecto->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Proyecto eliminado correctamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar proyecto: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el proyecto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Busca clientes existentes
     */
    public function buscarCliente(Request $request)
    {
        $termino = $request->get('q');
        
        if (strlen($termino) < 3) {
            return response()->json([]);
        }
        
        $clientes = Proyecto::select('cliente_nombre', 'cliente_rfc', 'cliente_email', 'cliente_telefono', 'cliente_contacto', 'cliente_cargo')
            ->where('cliente_nombre', 'LIKE', "%{$termino}%")
            ->orWhere('cliente_rfc', 'LIKE', "%{$termino}%")
            ->groupBy('cliente_nombre', 'cliente_rfc', 'cliente_email', 'cliente_telefono', 'cliente_contacto', 'cliente_cargo')
            ->limit(10)
            ->get();
        
        return response()->json($clientes);
    }

    /**
     * Sube un documento al proyecto
     */
    public function subirDocumento(Request $request, $proyecto_id)
    {
        try {
            $request->validate([
                'archivo' => 'required|file|max:51200', // 50MB max
                'tipo' => 'required|string|in:contrato,anexos,planos,presupuesto,programa'
            ]);
            
            $archivo = $request->file('archivo');
            $nombreOriginal = $archivo->getClientOriginalName();
            $extension = $archivo->getClientOriginalExtension();
            $nombreGuardado = time() . '_' . uniqid() . '.' . $extension;
            
            // Guardar el archivo
            $ruta = $archivo->storeAs(
                "proyectos/{$proyecto_id}/documentos",
                $nombreGuardado,
                'public'
            );
            
            // Guardar registro en la base de datos
            $documento = ProyectoDocumento::create([
                'proyecto_id' => $proyecto_id,
                'tipo' => $request->tipo,
                'nombre_original' => $nombreOriginal,
                'ruta' => $ruta,
                'mime_type' => $archivo->getMimeType(),
                'tamaño' => $archivo->getSize()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Documento subido correctamente',
                'documento' => $documento
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al subir documento: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al subir el documento: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Descarga un documento del proyecto
     */
    public function descargarDocumento($id)
    {
        try {
            $documento = ProyectoDocumento::findOrFail($id);
            
            if (!Storage::disk('public')->exists($documento->ruta)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo no existe'
                ], 404);
            }
            
            return Storage::disk('public')->download($documento->ruta, $documento->nombre_original);
            
        } catch (\Exception $e) {
            Log::error('Error al descargar documento: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al descargar el documento'
            ], 500);
        }
    }

    /**
     * Elimina un documento del proyecto
     */
    public function eliminarDocumento($id)
    {
        try {
            $documento = ProyectoDocumento::findOrFail($id);
            
            // Eliminar archivo físico
            if (Storage::disk('public')->exists($documento->ruta)) {
                Storage::disk('public')->delete($documento->ruta);
            }
            
            // Eliminar registro
            $documento->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Documento eliminado correctamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar documento: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el documento'
            ], 500);
        }
    }

    /**
     * Muestra el dashboard de proyectos
     */
    public function dashboard()
    {
        $totalProyectos = Proyecto::count();
        $proyectosActivos = Proyecto::where('status', 'activo')->count();
        $proyectosBorrador = Proyecto::where('status', 'borrador')->count();
        $proyectosCancelados = Proyecto::where('status', 'cancelado')->count();
        
        $presupuestoTotal = Proyecto::sum('presupuesto_total');
        $presupuestoActivo = Proyecto::where('status', 'activo')->sum('presupuesto_total');
        
        $proyectosPorPrioridad = Proyecto::select('prioridad', DB::raw('count(*) as total'))
            ->groupBy('prioridad')
            ->get();
        
        return view('proyectos.dashboard', compact(
            'totalProyectos', 'proyectosActivos', 'proyectosBorrador', 
            'proyectosCancelados', 'presupuestoTotal', 'presupuestoActivo',
            'proyectosPorPrioridad'
        ));
    }

    /**
     * Genera un código único para el proyecto
     */
    private function generarCodigoProyecto()
    {
        $year = date('Y');
        $lastProyecto = Proyecto::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastProyecto && $lastProyecto->codigo) {
            $parts = explode('-', $lastProyecto->codigo);
            $lastNumber = isset($parts[2]) ? intval($parts[2]) : 0;
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }
        
        return "PRO-{$year}-{$newNumber}";
    }

    /**
     * Valida los datos del proyecto
     */
    private function validarProyecto(Request $request, $id = null)
    {
        $rules = [
            'codigo' => 'nullable|string|max:50|unique:proyectos,codigo' . ($id ? ',' . $id : ''),
            'nombre_proyecto' => 'required|string|max:255',
            'tipo_proyecto' => 'required|string|max:100',
            'categoria' => 'nullable|string|max:100',
            'prioridad' => 'required|in:alta,media,baja',
            'ubicacion' => 'required|string|max:255',
            'direccion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'descripcion' => 'nullable|string',
            'estado_inicial' => 'nullable|in:activo,en_curso,pendiente,en_espera',
            'moneda' => 'nullable|string|size:3',
            'tipo_cambio' => 'nullable|numeric|min:0',
            'cliente_nombre' => 'required|string|max:255',
            'cliente_rfc' => 'required|string|max:20',
            'cliente_email' => 'nullable|email|max:255',
            'cliente_telefono' => 'nullable|string|max:50',
            'cliente_contacto' => 'nullable|string|max:255',
            'cliente_cargo' => 'nullable|string|max:255',
            'numero_contrato' => 'required|string|max:100',
            'fecha_firma' => 'nullable|date',
            'tipo_contrato' => 'nullable|string|max:100',
            'forma_pago' => 'nullable|string|max:100',
            'plazo_pago' => 'nullable|integer|min:0',
            'responsable' => 'required|exists:users,id',
            'presupuesto_total' => 'required|numeric|min:0',
            'anticipo' => 'nullable|numeric|min:0|max:100',
            'margen' => 'nullable|numeric|min:0|max:100',
            'fondo_reserva' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:borrador,activo,cancelado'
        ];
        
        return $request->validate($rules);
    }

    /**
     * Prepara los datos del proyecto para guardar
     */
    private function prepararDatosProyecto(Request $request)
    {
        return [
            'codigo' => $request->codigo,
            'nombre' => $request->nombre_proyecto,
            'tipo_proyecto' => $request->tipo_proyecto,
            'categoria' => $request->categoria,
            'prioridad' => $request->prioridad,
            'ubicacion' => $request->ubicacion,
            'direccion' => $request->direccion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado_inicial ?? 'pendiente',
            'moneda' => $request->moneda ?? 'MXN',
            'tipo_cambio' => $request->tipo_cambio ?? 1,
            'cliente_nombre' => $request->cliente_nombre,
            'cliente_rfc' => $request->cliente_rfc,
            'cliente_email' => $request->cliente_email,
            'cliente_telefono' => $request->cliente_telefono,
            'cliente_contacto' => $request->cliente_contacto,
            'cliente_cargo' => $request->cliente_cargo,
            'numero_contrato' => $request->numero_contrato,
            'fecha_firma' => $request->fecha_firma,
            'tipo_contrato' => $request->tipo_contrato,
            'forma_pago' => $request->forma_pago,
            'plazo_pago' => $request->plazo_pago,
            'responsable_id' => $request->responsable,
            'cargo_responsable' => $request->cargo_responsable,
            'email_responsable' => $request->email_responsable,
            'presupuesto_total' => $request->presupuesto_total,
            'anticipo' => $request->anticipo ?? 0,
            'margen' => $request->margen ?? 0,
            'fondo_reserva' => $request->fondo_reserva ?? 0,
            'status' => $request->status ?? 'activo',
            'created_by' => auth()->id()
        ];
    }

    /**
     * Crea un nuevo proyecto
     */
    private function crearProyecto(Request $request)
    {
        $datos = $this->prepararDatosProyecto($request);
        
        // Si es borrador y no hay código, generar uno temporal
        if ($request->status === 'borrador' && empty($datos['codigo'])) {
            $datos['codigo'] = 'BORRADOR-' . time();
        }
        
        return Proyecto::create($datos);
    }

    /**
     * Guarda el equipo del proyecto
     */
    private function guardarEquipo($proyectoId, $equipoJson)
    {
        $equipo = is_string($equipoJson) ? json_decode($equipoJson, true) : $equipoJson;
        
        if (is_array($equipo)) {
            foreach ($equipo as $miembro) {
                if (isset($miembro['nombre']) && isset($miembro['rol'])) {
                    ProyectoEquipo::create([
                        'proyecto_id' => $proyectoId,
                        'nombre' => $miembro['nombre'],
                        'rol' => $miembro['rol'],
                        'departamento' => $miembro['departamento'] ?? 'General',
                        'dedicacion' => $miembro['dedicacion'] ?? 100
                    ]);
                }
            }
        }
    }

    /**
     * Guarda los costos del proyecto
     */
    private function guardarCostos($proyectoId, $costosJson)
    {
        $costos = is_string($costosJson) ? json_decode($costosJson, true) : $costosJson;
        
        if (is_array($costos)) {
            ProyectoCosto::create([
                'proyecto_id' => $proyectoId,
                'materiales' => $costos['materiales'] ?? 0,
                'mano_obra' => $costos['mano_obra'] ?? 0,
                'maquinaria' => $costos['maquinaria'] ?? 0,
                'gastos_indirectos' => $costos['gastos_indirectos'] ?? 0
            ]);
        }
    }

    /**
     * Prepara los datos de costos
     */
    private function prepararDatosCostos(Request $request)
    {
        $costos = [];
        
        if ($request->has('costos')) {
            $costosData = is_string($request->costos) ? json_decode($request->costos, true) : $request->costos;
            $costos = [
                'materiales' => $costosData['materiales'] ?? 0,
                'mano_obra' => $costosData['mano_obra'] ?? 0,
                'maquinaria' => $costosData['maquinaria'] ?? 0,
                'gastos_indirectos' => $costosData['gastos_indirectos'] ?? 0
            ];
        }
        
        return $costos;
    }

    /**
     * Guarda los documentos del proyecto
     */
    private function guardarDocumentos($proyectoId, $documentos)
    {
        foreach ($documentos as $tipo => $archivos) {
            // Asegurar que $archivos es un array
            $archivosArray = is_array($archivos) ? $archivos : [$archivos];
            
            foreach ($archivosArray as $archivo) {
                $nombreOriginal = $archivo->getClientOriginalName();
                $extension = $archivo->getClientOriginalExtension();
                $nombreGuardado = time() . '_' . uniqid() . '.' . $extension;
                
                $ruta = $archivo->storeAs(
                    "proyectos/{$proyectoId}/documentos",
                    $nombreGuardado,
                    'public'
                );
                
                ProyectoDocumento::create([
                    'proyecto_id' => $proyectoId,
                    'tipo' => $tipo,
                    'nombre_original' => $nombreOriginal,
                    'ruta' => $ruta,
                    'mime_type' => $archivo->getMimeType(),
                    'tamaño' => $archivo->getSize()
                ]);
            }
        }
    }

    /**
 * Obtiene datos para edición (AJAX)
 */
public function editData($id)
{
    $proyecto = Proyecto::findOrFail($id);
    return response()->json([
        'success' => true,
        'proyecto' => $proyecto
    ]);
}

/**
 * Obtiene detalle del proyecto (AJAX)
 */
public function getDetalle($id)
{
    $proyecto = Proyecto::with(['responsable', 'equipo', 'costos'])->findOrFail($id);
    return response()->json([
        'success' => true,
        'proyecto' => $proyecto
    ]);
}
}