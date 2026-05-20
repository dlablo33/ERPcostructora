<?php

namespace App\Http\Controllers;

use App\Models\GastoFijo;
use App\Models\Proveedor;
use App\Models\Proyecto;
use App\Models\CuentaContable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GastoFijoController extends Controller
{
    /**
     * Muestra la vista principal
     */
    public function index()
    {
        $proveedores = Proveedor::whereNull('deleted_at')
            ->where('activo', true)
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'rfc']);
        
        $proyectos = Proyecto::where('status', 'activo')
            ->whereNull('deleted_at')
            ->orderBy('codigo')
            ->get(['id', 'codigo', 'nombre']);
        
        $cuentasContables = CuentaContable::where('activa', true)
            ->whereNull('deleted_at')
            ->orderBy('codigo')
            ->get(['id', 'codigo', 'nombre']);
        
        return view('administracion.presupuestos.gastos', compact('proveedores', 'proyectos', 'cuentasContables'));
    }
    
    /**
     * Obtiene datos para la tabla (API)
     */
    public function getData(Request $request)
    {
        try {
            $fechaInicio = $request->get('fecha_inicio', date('Y-m-01'));
            $fechaFin = $request->get('fecha_fin', date('Y-m-d'));
            $buscar = $request->get('buscar', '');
            
            $query = GastoFijo::with(['proveedor', 'proyecto', 'cuentaContable'])
                ->orderBy('fecha_inicio', 'desc');
            
            if (!empty($buscar)) {
                $query->where(function($q) use ($buscar) {
                    $q->where('descripcion', 'LIKE', "%{$buscar}%")
                      ->orWhereHas('proveedor', function($sub) use ($buscar) {
                          $sub->where('nombre', 'LIKE', "%{$buscar}%");
                      })
                      ->orWhereHas('proyecto', function($sub) use ($buscar) {
                          $sub->where('nombre', 'LIKE', "%{$buscar}%");
                      });
                });
            }
            
            if ($fechaInicio && $fechaFin) {
                $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin]);
            }
            
            $gastos = $query->get();
            
            // Formatear los datos para la tabla
            $data = $gastos->map(function($gasto) {
                return [
                    'gasto_fijo_id' => $gasto->gasto_fijo_id,
                    'proveedor_id' => $gasto->proveedor_id,
                    'proveedor' => $gasto->proveedor ? $gasto->proveedor->nombre : 'SIN PROVEEDOR',
                    'proyecto_id' => $gasto->proyecto_id,
                    'proyecto' => $gasto->proyecto ? $gasto->proyecto->nombre : 'SIN PROYECTO',
                    'cuenta_contable_id' => $gasto->cuenta_contable_id,
                    'cuenta_contable' => $gasto->cuentaContable ? $gasto->cuentaContable->nombre : 'SIN CUENTA',
                    'fecha_inicio' => $gasto->fecha_inicio,
                    'fecha_fin' => $gasto->fecha_fin,
                    'descripcion' => $gasto->descripcion,
                    'importe' => $gasto->importe,
                    'periodicidad' => $gasto->periodicidad,
                    'dia_cobro' => $gasto->dia_cobro,
                    'estatus' => $gasto->estatus,
                    'cuenta_flujo_dinero' => $gasto->cuenta_flujo_dinero,
                    'satcat_uso_cfdi_clave' => $gasto->satcat_uso_cfdi_clave,
                    'satcat_metodos_pago_clave' => $gasto->satcat_metodos_pago_clave,
                    'satcat_formas_pago_clave' => $gasto->satcat_formas_pago_clave
                ];
            });
            
            $totales = [
                'importe' => $data->sum('importe')
            ];
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'totales' => $totales
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getData GastosFijos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los datos: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Registra un nuevo gasto fijo
     */
    public function store(Request $request)
    {
        try {
            Log::info('=== GUARDANDO GASTO FIJO ===');
            Log::info('Datos:', $request->all());
            
            $validated = $request->validate([
                'proveedor_id' => 'required|exists:proveedores,id',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'cuenta_contable_id' => 'nullable|exists:cuentas_contables,id',
                'descripcion' => 'required|string|max:255',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
                'importe' => 'required|numeric|min:0',
                'periodicidad' => 'nullable|string|in:Mensual,Trimestral,Semestral,Anual',
                'dia_cobro' => 'nullable|integer|min:1|max:31',
                'dia_mes_cobro' => 'nullable|integer|min:1|max:31',
                'mes_inicio_cobro' => 'nullable|integer|min:1|max:12',
                'estatus' => 'nullable|string|in:Activo,Inactivo,Pendiente',
                'cuenta_flujo_dinero' => 'nullable|string|max:50',
                'uso_cfdi' => 'nullable|string|max:10',
                'metodo_pago' => 'nullable|string|max:10',
                'forma_pago' => 'nullable|string|max:10'
            ]);
            
            $gasto = GastoFijo::create([
                'proveedor_id' => $request->proveedor_id,
                'proyecto_id' => $request->proyecto_id,
                'cuenta_contable_id' => $request->cuenta_contable_id,
                'descripcion' => $request->descripcion,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'importe' => floatval($request->importe),
                'periodicidad' => $request->periodicidad ?? 'Mensual',
                'dia_cobro' => $request->dia_cobro,
                'dia_mes_cobro' => $request->dia_mes_cobro,
                'mes_inicio_cobro' => $request->mes_inicio_cobro,
                'estatus' => $request->estatus ?? 'Activo',
                'cuenta_flujo_dinero' => $request->cuenta_flujo_dinero,
                'satcat_uso_cfdi_clave' => $request->uso_cfdi,
                'satcat_metodos_pago_clave' => $request->metodo_pago,
                'satcat_formas_pago_clave' => $request->forma_pago
            ]);
            
            Log::info('Gasto fijo creado con ID: ' . $gasto->gasto_fijo_id);
            
            return response()->json([
                'success' => true,
                'message' => 'Gasto fijo registrado correctamente',
                'gasto_fijo_id' => $gasto->gasto_fijo_id
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al guardar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Muestra un gasto fijo específico
     */
    public function show($id)
    {
        try {
            $gasto = GastoFijo::with(['proveedor', 'proyecto', 'cuentaContable'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'gasto_fijo_id' => $gasto->gasto_fijo_id,
                    'proveedor_id' => $gasto->proveedor_id,
                    'proveedor' => $gasto->proveedor ? $gasto->proveedor->nombre : null,
                    'proyecto_id' => $gasto->proyecto_id,
                    'proyecto' => $gasto->proyecto ? $gasto->proyecto->nombre : null,
                    'cuenta_contable_id' => $gasto->cuenta_contable_id,
                    'cuenta_contable' => $gasto->cuentaContable ? $gasto->cuentaContable->nombre : null,
                    'descripcion' => $gasto->descripcion,
                    'fecha_inicio' => $gasto->fecha_inicio,
                    'fecha_fin' => $gasto->fecha_fin,
                    'importe' => $gasto->importe,
                    'periodicidad' => $gasto->periodicidad,
                    'dia_cobro' => $gasto->dia_cobro,
                    'dia_mes_cobro' => $gasto->dia_mes_cobro,
                    'mes_inicio_cobro' => $gasto->mes_inicio_cobro,
                    'estatus' => $gasto->estatus,
                    'cuenta_flujo_dinero' => $gasto->cuenta_flujo_dinero,
                    'satcat_uso_cfdi_clave' => $gasto->satcat_uso_cfdi_clave,
                    'satcat_metodos_pago_clave' => $gasto->satcat_metodos_pago_clave,
                    'satcat_formas_pago_clave' => $gasto->satcat_formas_pago_clave
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en show: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gasto no encontrado'
            ], 404);
        }
    }
    
    /**
     * Actualiza un gasto fijo
     */
    public function update(Request $request, $id)
    {
        try {
            $gasto = GastoFijo::findOrFail($id);
            
            $validated = $request->validate([
                'proveedor_id' => 'required|exists:proveedores,id',
                'proyecto_id' => 'nullable|exists:proyectos,id',
                'cuenta_contable_id' => 'nullable|exists:cuentas_contables,id',
                'descripcion' => 'required|string|max:255',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
                'importe' => 'required|numeric|min:0',
                'periodicidad' => 'nullable|string|in:Mensual,Trimestral,Semestral,Anual',
                'dia_cobro' => 'nullable|integer|min:1|max:31',
                'dia_mes_cobro' => 'nullable|integer|min:1|max:31',
                'mes_inicio_cobro' => 'nullable|integer|min:1|max:12',
                'estatus' => 'nullable|string|in:Activo,Inactivo,Pendiente',
                'cuenta_flujo_dinero' => 'nullable|string|max:50',
                'uso_cfdi' => 'nullable|string|max:10',
                'metodo_pago' => 'nullable|string|max:10',
                'forma_pago' => 'nullable|string|max:10'
            ]);
            
            $gasto->update([
                'proveedor_id' => $request->proveedor_id,
                'proyecto_id' => $request->proyecto_id,
                'cuenta_contable_id' => $request->cuenta_contable_id,
                'descripcion' => $request->descripcion,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'importe' => floatval($request->importe),
                'periodicidad' => $request->periodicidad ?? 'Mensual',
                'dia_cobro' => $request->dia_cobro,
                'dia_mes_cobro' => $request->dia_mes_cobro,
                'mes_inicio_cobro' => $request->mes_inicio_cobro,
                'estatus' => $request->estatus ?? 'Activo',
                'cuenta_flujo_dinero' => $request->cuenta_flujo_dinero,
                'satcat_uso_cfdi_clave' => $request->uso_cfdi,
                'satcat_metodos_pago_clave' => $request->metodo_pago,
                'satcat_formas_pago_clave' => $request->forma_pago
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Gasto fijo actualizado correctamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en update: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Elimina (soft delete) un gasto fijo
     */
    public function destroy($id)
    {
        try {
            $gasto = GastoFijo::findOrFail($id);
            $gasto->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Gasto fijo eliminado correctamente'
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
     * Obtiene proyectos activos para selects
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
            return response()->json([], 500);
        }
    }
    
    /**
     * Obtiene cuentas contables activas para selects
     */
    public function getCuentasContables()
    {
        try {
            $cuentas = CuentaContable::where('activa', true)
                ->whereNull('deleted_at')
                ->orderBy('codigo')
                ->get(['id', 'codigo', 'nombre']);
            
            return response()->json($cuentas);
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }
}