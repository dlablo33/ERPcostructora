<?php

namespace App\Http\Controllers;

use App\Models\ProgramacionPago;
use App\Models\Proveedor;
use App\Models\Proyecto;
use App\Models\CuentaBancaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProgramacionPagoController extends Controller
{
    /**
     * Muestra la vista principal
     */
    public function index()
{
    try {
        Log::info('=== INICIO INDEX PROGRAMACION PAGOS ===');
        
        // Consulta sin filtros para depurar
        $totalProveedores = DB::table('proveedores')->count();
        $totalProyectos = DB::table('proyectos')->count();
        
        Log::info('Total proveedores en tabla: ' . $totalProveedores);
        Log::info('Total proyectos en tabla: ' . $totalProyectos);
        
        // Obtener proveedores - SIN FILTROS temporalmente para depurar
        $proveedores = DB::table('proveedores')
            ->select('id', 'nombre', 'rfc')
            ->get();
        
        Log::info('Proveedores encontrados (sin filtros): ' . $proveedores->count());
        
        // Obtener proyectos - SIN FILTROS temporalmente para depurar
        $proyectos = DB::table('proyectos')
            ->select('id', 'codigo', 'nombre')
            ->get();
        
        Log::info('Proyectos encontrados (sin filtros): ' . $proyectos->count());
        
        // Si no hay proveedores, crear uno de prueba
        if ($proveedores->isEmpty()) {
            Log::warning('No hay proveedores, creando uno de prueba...');
            $proveedorId = DB::table('proveedores')->insertGetId([
                'nombre' => 'Proveedor de Prueba',
                'rfc' => 'PRUEBA01',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            $proveedores = DB::table('proveedores')
                ->select('id', 'nombre', 'rfc')
                ->get();
            
            Log::info('Proveedor de prueba creado con ID: ' . $proveedorId);
        }
        
        // Si no hay proyectos, crear uno de prueba
        if ($proyectos->isEmpty()) {
            Log::warning('No hay proyectos, creando uno de prueba...');
            $proyectoId = DB::table('proyectos')->insertGetId([
                'codigo' => 'PRO-001',
                'nombre' => 'Proyecto de Prueba',
                'status' => 'activo',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            $proyectos = DB::table('proyectos')
                ->select('id', 'codigo', 'nombre')
                ->get();
            
            Log::info('Proyecto de prueba creado con ID: ' . $proyectoId);
        }
        
        $cuentasBancarias = DB::table('cuentas_bancarias')
            ->where('activa', true)
            ->get(['id', 'banco_id', 'numero_cuenta']);
        
        return view('administracion.tesoreria.programacion', compact('proveedores', 'proyectos', 'cuentasBancarias'));
        
    } catch (\Exception $e) {
        Log::error('Error en index ProgramacionPago: ' . $e->getMessage());
        Log::error('Trace: ' . $e->getTraceAsString());
        
        $proveedores = collect();
        $proyectos = collect();
        $cuentasBancarias = collect();
        return view('administracion.tesoreria.programacion', compact('proveedores', 'proyectos', 'cuentasBancarias'));
    }
}
    
    /**
     * Obtiene datos para la tabla (API)
     */
    public function getData(Request $request)
    {
        try {
            Log::info('=== getData ProgramacionPagos ===');
            
            $fechaInicio = $request->get('fecha_inicio');
            $fechaFin = $request->get('fecha_fin');
            $buscar = $request->get('buscar', '');
            
            Log::info("Parámetros - fecha_inicio: {$fechaInicio}, fecha_fin: {$fechaFin}, buscar: {$buscar}");
            
            $query = ProgramacionPago::with(['proveedor', 'proyecto'])
                ->orderBy('fecha', 'desc');
            
            if (!empty($buscar)) {
                $query->where(function($q) use ($buscar) {
                    $q->where('folio', 'LIKE', "%{$buscar}%")
                      ->orWhere('descripcion', 'LIKE', "%{$buscar}%")
                      ->orWhere('estatus', 'LIKE', "%{$buscar}%")
                      ->orWhereHas('proveedor', function($sub) use ($buscar) {
                          $sub->where('nombre', 'LIKE', "%{$buscar}%");
                      });
                });
            }
            
            if ($fechaInicio && $fechaFin) {
                $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
            }
            
            $programaciones = $query->get();
            
            Log::info('Programaciones encontradas: ' . $programaciones->count());
            
            $data = $programaciones->map(function($item) {
                return [
                    'id' => $item->id,
                    'folio' => $item->folio,
                    'estatus' => $item->estatus,
                    'fecha' => $item->fecha,
                    'proveedor_id' => $item->proveedor_id,
                    'proveedor' => $item->proveedor ? $item->proveedor->nombre : 'SIN PROVEEDOR',
                    'descripcion' => $item->descripcion,
                    'monto' => floatval($item->monto),
                    'saldo' => floatval($item->saldo),
                    'fecha_estimada' => $item->fecha_estimada_pago,
                    'proyecto_id' => $item->proyecto_id,
                    'proyecto' => $item->proyecto ? $item->proyecto->nombre : 'SIN PROYECTO'
                ];
            });
            
            $totales = [
                'monto' => $data->sum('monto'),
                'saldo' => $data->sum('saldo')
            ];
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'totales' => $totales
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getData ProgramacionPagos: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los datos: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Registra una nueva programación de pago
     */
    public function store(Request $request)
    {
        try {
            Log::info('=== GUARDANDO PROGRAMACIÓN DE PAGO ===');
            Log::info('Datos recibidos:', $request->all());
            
            $validated = $request->validate([
                'proveedor_id' => 'required|exists:proveedores,id',
                'descripcion' => 'required|string|max:255',
                'fecha' => 'required|date',
                'fecha_estimada' => 'required|date',
                'monto' => 'required|numeric|min:0',
                'estatus' => 'nullable|string|in:Programado,Pendiente,Pagado,Cancelado,Parcial',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'observaciones' => 'nullable|string'
            ]);
            
            DB::beginTransaction();
            
            // Generar folio automático
            $ultimoFolio = ProgramacionPago::withTrashed()->max('id') ?? 0;
            $folio = 'PP-' . str_pad($ultimoFolio + 1, 6, '0', STR_PAD_LEFT);
            
            $programacion = ProgramacionPago::create([
                'folio' => $folio,
                'proveedor_id' => $request->proveedor_id,
                'descripcion' => $request->descripcion,
                'fecha' => $request->fecha,
                'fecha_estimada_pago' => $request->fecha_estimada,
                'monto' => floatval($request->monto),
                'saldo' => floatval($request->monto),
                'estatus' => $request->estatus ?? 'Programado',
                'proyecto_id' => $request->proyecto_id,
                'observaciones' => $request->observaciones,
                'created_by' => auth()->id()
            ]);
            
            DB::commit();
            
            Log::info('Programación creada con ID: ' . $programacion->id . ', Folio: ' . $programacion->folio);
            
            return response()->json([
                'success' => true,
                'message' => 'Programación registrada correctamente',
                'id' => $programacion->id,
                'folio' => $programacion->folio
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            Log::error('Error de validación: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error al guardar programación: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Muestra una programación específica
     */
    public function show($id)
    {
        try {
            Log::info('Obteniendo detalle de programación ID: ' . $id);
            
            $programacion = ProgramacionPago::with(['proveedor', 'proyecto', 'cuentaBancaria', 'creador'])
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $programacion->id,
                    'folio' => $programacion->folio,
                    'estatus' => $programacion->estatus,
                    'fecha' => $programacion->fecha,
                    'fecha_estimada' => $programacion->fecha_estimada_pago,
                    'fecha_pago_real' => $programacion->fecha_pago_real,
                    'proveedor_id' => $programacion->proveedor_id,
                    'proveedor' => $programacion->proveedor ? $programacion->proveedor->nombre : null,
                    'proveedor_rfc' => $programacion->proveedor ? $programacion->proveedor->rfc : null,
                    'descripcion' => $programacion->descripcion,
                    'monto' => floatval($programacion->monto),
                    'saldo' => floatval($programacion->saldo),
                    'proyecto_id' => $programacion->proyecto_id,
                    'proyecto' => $programacion->proyecto ? $programacion->proyecto->nombre : null,
                    'observaciones' => $programacion->observaciones,
                    'referencia_pago' => $programacion->referencia_pago,
                    'created_at' => $programacion->created_at,
                    'creador' => $programacion->creador ? $programacion->creador->name : null
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en show: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Registro no encontrado'
            ], 404);
        }
    }
    
    /**
     * Actualiza una programación
     */
    public function update(Request $request, $id)
    {
        try {
            Log::info('=== ACTUALIZANDO PROGRAMACIÓN ===');
            Log::info('ID: ' . $id);
            Log::info('Datos:', $request->all());
            
            $programacion = ProgramacionPago::findOrFail($id);
            
            $validated = $request->validate([
                'proveedor_id' => 'required|exists:proveedores,id',
                'descripcion' => 'required|string|max:255',
                'fecha' => 'required|date',
                'fecha_estimada' => 'required|date',
                'monto' => 'required|numeric|min:0',
                'estatus' => 'nullable|string|in:Programado,Pendiente,Pagado,Cancelado,Parcial',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'observaciones' => 'nullable|string'
            ]);
            
            DB::beginTransaction();
            
            $programacion->update([
                'proveedor_id' => $request->proveedor_id,
                'descripcion' => $request->descripcion,
                'fecha' => $request->fecha,
                'fecha_estimada_pago' => $request->fecha_estimada,
                'monto' => floatval($request->monto),
                'estatus' => $request->estatus ?? 'Programado',
                'proyecto_id' => $request->proyecto_id,
                'observaciones' => $request->observaciones
            ]);
            
            // Si el estatus es Pagado y el saldo no está en 0, actualizar saldo
            if ($request->estatus === 'Pagado' && $programacion->saldo > 0) {
                $programacion->saldo = 0;
                $programacion->fecha_pago_real = now();
                $programacion->save();
            }
            
            // Si el estatus no es Pagado pero el saldo es 0, mantener saldo
            if ($request->estatus !== 'Pagado' && $programacion->saldo == 0 && $programacion->monto > 0) {
                $programacion->saldo = $programacion->monto;
                $programacion->save();
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Programación actualizada correctamente'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error en update: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Registra un pago parcial o total
     */
    public function registrarPago(Request $request, $id)
    {
        try {
            Log::info('=== REGISTRANDO PAGO ===');
            Log::info('ID Programación: ' . $id);
            Log::info('Datos:', $request->all());
            
            $programacion = ProgramacionPago::findOrFail($id);
            
            $validated = $request->validate([
                'monto_pago' => 'required|numeric|min:0.01',
                'referencia' => 'nullable|string|max:100'
            ]);
            
            $montoPago = floatval($request->monto_pago);
            
            if ($montoPago > $programacion->saldo) {
                return response()->json([
                    'success' => false,
                    'message' => 'El monto del pago no puede ser mayor al saldo pendiente'
                ], 422);
            }
            
            DB::beginTransaction();
            
            $programacion->saldo -= $montoPago;
            $programacion->referencia_pago = $request->referencia;
            
            if ($programacion->saldo <= 0) {
                $programacion->estatus = 'Pagado';
                $programacion->saldo = 0;
                $programacion->fecha_pago_real = now();
            } elseif ($programacion->saldo < $programacion->monto) {
                $programacion->estatus = 'Parcial';
            }
            
            $programacion->save();
            
            DB::commit();
            
            Log::info('Pago registrado. Nuevo saldo: ' . $programacion->saldo . ', Nuevo estatus: ' . $programacion->estatus);
            
            return response()->json([
                'success' => true,
                'message' => 'Pago registrado correctamente',
                'nuevo_saldo' => $programacion->saldo,
                'nuevo_estatus' => $programacion->estatus
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error en registrarPago: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar pago: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Elimina (soft delete) una programación
     */
    public function destroy($id)
    {
        try {
            Log::info('=== ELIMINANDO PROGRAMACIÓN ===');
            Log::info('ID: ' . $id);
            
            $programacion = ProgramacionPago::findOrFail($id);
            $programacion->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Programación eliminada correctamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en destroy: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtiene proveedores para selects (API)
     */
    public function getProveedores()
    {
        try {
            $proveedores = Proveedor::whereNull('deleted_at')
                ->where('activo', true)
                ->orderBy('nombre')
                ->get(['id', 'nombre', 'rfc']);
            
            return response()->json($proveedores);
            
        } catch (\Exception $e) {
            Log::error('Error en getProveedores: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }
    
    /**
     * Obtiene proyectos para selects (API)
     */
    public function getProyectos()
    {
        try {
            $proyectos = Proyecto::where('status', 'activo')
                ->whereNull('deleted_at')
                ->orderBy('codigo')
                ->get(['id', 'codigo', 'nombre']);
            
            return response()->json($proyectos);
            
        } catch (\Exception $e) {
            Log::error('Error en getProyectos: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }
}