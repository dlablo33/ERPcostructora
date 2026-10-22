<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\ActivoHerramienta;
use App\Models\ActivoMaquinaria;
use App\Models\ActivoVehiculo;
use App\Models\CuentaContable;
use App\Models\Proyecto;
use App\Models\Proveedor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ActivoController extends Controller
{
    /**
     * Catálogo de cuentas contables desde la tabla cuentas_contables.
     */
    protected function getCatalogoCuentasContables()
    {
        return CuentaContable::activas()
            ->orderBy('codigo')
            ->get()
            ->mapWithKeys(function ($cuenta) {
                $prefijo = str_repeat('— ', max(0, ($cuenta->nivel ?? 1) - 1));
                return [
                    $cuenta->codigo => $prefijo . $cuenta->codigo . ' - ' . $cuenta->nombre,
                ];
            })
            ->toArray();
    }

    /**
     * Normaliza el valor de estado_general al formato esperado por el CHECK constraint.
     */
    protected function normalizarEstadoGeneral($valor)
    {
        $map = [
            'excelente'     => 'Excelente',
            'bueno'         => 'Bueno',
            'regular'       => 'Regular',
            'malo'          => 'Malo',
            'en reparacion' => 'En reparacion',
            'en_reparacion' => 'En reparacion',
            'enreparacion'  => 'En reparacion',
        ];
        $key = strtolower(trim((string) $valor));
        return $map[$key] ?? 'Bueno';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proyectos = Proyecto::where('status', 'activo')->orderBy('nombre')->get();
        $proveedores = Proveedor::orderBy('nombre')->get();
        $cuentasContables = $this->getCatalogoCuentasContables();

        return view('almacen.catalogo.activos', compact('proyectos', 'proveedores', 'cuentasContables'));
    }

    /**
     * Get activos for DataTable.
     */
    public function getActivos(Request $request)
    {
        try {
            $query = Activo::with(['proyectoAsignado', 'responsableAsignado']);

            if ($request->filled('tipo_activo')) {
                $query->where('tipo_activo', $request->tipo_activo);
            }

            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }

            if ($request->filled('categoria')) {
                $query->where('categoria', $request->categoria);
            }

            if ($request->filled('proyecto_id')) {
                $query->where('proyecto_asignado_id', $request->proyecto_id);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('codigo', 'LIKE', "%{$search}%")
                      ->orWhere('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('marca', 'LIKE', "%{$search}%")
                      ->orWhere('modelo', 'LIKE', "%{$search}%")
                      ->orWhere('serie', 'LIKE', "%{$search}%");
                });
            }

            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);

            $activos = $query->orderBy('codigo')->paginate($perPage, ['*'], 'page', $page);

            $data = $activos->getCollection()->map(function ($activo) {
                $datosEspecificos = $activo->getDatosEspecificos();

                return [
                    'id' => $activo->id,
                    'codigo' => $activo->codigo,
                    'nombre' => $activo->nombre,
                    'tipo_activo' => $activo->tipo_activo,
                    'categoria' => $activo->categoria,
                    'marca' => $activo->marca,
                    'modelo' => $activo->modelo,
                    'serie' => $activo->serie,
                    'anio' => $activo->anio,
                    'color' => $activo->color,
                    'ubicacion_fisica' => $activo->ubicacion_fisica,
                    'proyecto_asignado_id' => $activo->proyecto_asignado_id,
                    'proyecto_asignado_nombre' => $activo->proyectoAsignado ? $activo->proyectoAsignado->nombre : null,
                    'estado_general' => $activo->estado_general,
                    'estatus' => $activo->estatus,
                    'valor_actual' => $activo->valor_actual,
                    'horometro' => $datosEspecificos ? ($datosEspecificos->horometro_actual ?? $datosEspecificos->kilometraje_actual) : null,
                    'unidad_medida' => $activo->tipo_activo === 'maquinaria' ? 'Horas' : ($activo->tipo_activo === 'vehiculo' ? 'Km' : null),
                    'created_at' => $activo->created_at ? $activo->created_at->format('d/m/Y') : '',
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data,
                'total' => $activos->total(),
                'per_page' => $activos->perPage(),
                'current_page' => $activos->currentPage(),
                'last_page' => $activos->lastPage()
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getActivos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar activos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Genera un código único para el activo, con reintento si hay colisión.
     */
    protected function generarCodigoUnico($tipo)
    {
        $prefijos = [
            'herramienta' => 'HER',
            'maquinaria' => 'MAQ',
            'vehiculo' => 'VEH',
        ];
        $prefijo = $prefijos[$tipo] ?? 'ACT';

        $ultimo = Activo::where('codigo', 'LIKE', $prefijo . '-%')
            ->lockForUpdate()
            ->orderByRaw("CAST(SUBSTRING(codigo FROM " . (strlen($prefijo) + 2) . ") AS INTEGER) DESC")
            ->first();

        $siguiente = 1;
        if ($ultimo) {
            $siguiente = ((int) substr($ultimo->codigo, strlen($prefijo) + 1)) + 1;
        }

        return $prefijo . '-' . str_pad($siguiente, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:200',
                'tipo_activo' => 'required|in:herramienta,maquinaria,vehiculo',
                'categoria' => 'nullable|string|max:100',
                'marca' => 'nullable|string|max:100',
                'modelo' => 'nullable|string|max:100',
                'serie' => 'nullable|string|max:100',
                'anio' => 'nullable|integer|min:1900|max:' . date('Y'),
                'color' => 'nullable|string|max:50',
                'ubicacion_fisica' => 'nullable|string|max:255',
                'estado_general' => 'required|string',
                'estatus' => 'required|in:Disponible,Asignado,En mantenimiento,Dado de baja',
                'fecha_adquisicion' => 'nullable|date',
                'costo_adquisicion' => 'nullable|numeric|min:0',
                'valor_actual' => 'nullable|numeric|min:0',
                'proveedor_id' => 'nullable|exists:proveedores,id',
                'factura' => 'nullable|string|max:100',
                'cuenta_contable' => 'nullable|string|max:50|exists:cuentas_contables,codigo',
                'descripcion' => 'nullable|string',
                'observaciones' => 'nullable|string'
            ]);

            DB::beginTransaction();

            $intentos = 0;
            $activo = null;
            while ($intentos < 5) {
                try {
                    $codigo = $this->generarCodigoUnico($request->tipo_activo);

                    $activo = Activo::create([
                        'codigo' => $codigo,
                        'nombre' => $request->nombre,
                        'tipo_activo' => $request->tipo_activo,
                        'categoria' => $request->categoria,
                        'marca' => $request->marca,
                        'modelo' => $request->modelo,
                        'serie' => $request->serie,
                        'anio' => $request->anio,
                        'color' => $request->color,
                        'ubicacion_fisica' => $request->ubicacion_fisica,
                        'estado_general' => $this->normalizarEstadoGeneral($request->estado_general),
                        'estatus' => $request->estatus,
                        'fecha_adquisicion' => $request->fecha_adquisicion,
                        'costo_adquisicion' => $request->costo_adquisicion,
                        'valor_actual' => $request->valor_actual,
                        'proveedor_id' => $request->proveedor_id,
                        'factura' => $request->factura,
                        'cuenta_contable' => $request->cuenta_contable,
                        'descripcion' => $request->descripcion,
                        'observaciones' => $request->observaciones,
                        'created_by' => auth()->id()
                    ]);

                    break;
                } catch (\Illuminate\Database\QueryException $qe) {
                    if ($qe->getCode() == '23505' || str_contains($qe->getMessage(), 'activos_codigo_unique')) {
                        $intentos++;
                        Log::warning("Colisión de código al crear activo, reintento #{$intentos}");
                        if ($intentos >= 5) {
                            throw $qe;
                        }
                        continue;
                    }
                    throw $qe;
                }
            }

            // Datos específicos según tipo
            if ($request->tipo_activo === 'herramienta') {
                ActivoHerramienta::create([
                    'activo_id' => $activo->id,
                    'tipo_herramienta' => $request->tipo_herramienta,
                    'voltaje' => $request->voltaje,
                    'potencia' => $request->potencia,
                    'requiere_calibracion' => $request->requiere_calibracion ?? false,
                    'numero_inventario' => $request->numero_inventario
                ]);
            } elseif ($request->tipo_activo === 'maquinaria') {
                ActivoMaquinaria::create([
                    'activo_id' => $activo->id,
                    'horometro_actual' => $request->horometro_actual ?? 0,
                    'horometro_compra' => $request->horometro_compra ?? 0,
                    'tipo_combustible' => $request->tipo_combustible,
                    'consumo_promedio' => $request->consumo_promedio,
                    'capacidad_tanque' => $request->capacidad_tanque,
                    'peso_operativo' => $request->peso_operativo,
                    'capacidad_carga' => $request->capacidad_carga,
                    'licencia_requerida' => $request->licencia_requerida
                ]);
            } elseif ($request->tipo_activo === 'vehiculo') {
                ActivoVehiculo::create([
                    'activo_id' => $activo->id,
                    'placas' => $request->placas,
                    'numero_economico' => $request->numero_economico,
                    'vin' => $request->vin,
                    'kilometraje_actual' => $request->kilometraje_actual ?? 0,
                    'kilometraje_compra' => $request->kilometraje_compra ?? 0,
                    'tipo_combustible' => $request->tipo_combustible,
                    'consumo_promedio' => $request->consumo_promedio,
                    'capacidad_tanque' => $request->capacidad_tanque,
                    'capacidad_pasajeros' => $request->capacidad_pasajeros,
                    'capacidad_carga' => $request->capacidad_carga,
                    'tipo_vehiculo' => $request->tipo_vehiculo,
                    'traccion' => $request->traccion,
                    'transmision' => $request->transmision,
                    'poliza_seguro' => $request->poliza_seguro,
                    'vencimiento_seguro' => $request->vencimiento_seguro,
                    'licencia_requerida' => $request->licencia_requerida
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Activo creado exitosamente',
                'data' => $activo->load(['herramienta', 'maquinaria', 'vehiculo'])
            ]);

        } catch (\Illuminate\Validation\ValidationException $ve) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $ve->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear activo: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al crear activo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $activo = Activo::with(['herramienta', 'maquinaria', 'vehiculo', 'proyectoAsignado', 'responsableAsignado', 'proveedor', 'creador'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $activo->id,
                    'codigo' => $activo->codigo,
                    'nombre' => $activo->nombre,
                    'tipo_activo' => $activo->tipo_activo,
                    'categoria' => $activo->categoria,
                    'marca' => $activo->marca,
                    'modelo' => $activo->modelo,
                    'serie' => $activo->serie,
                    'anio' => $activo->anio,
                    'color' => $activo->color,
                    'ubicacion_fisica' => $activo->ubicacion_fisica,
                    'proyecto_asignado_id' => $activo->proyecto_asignado_id,
                    'proyecto_asignado_nombre' => $activo->proyectoAsignado ? $activo->proyectoAsignado->nombre : null,
                    'responsable_asignado_id' => $activo->responsable_asignado_id,
                    'responsable_asignado_nombre' => $activo->responsableAsignado ? $activo->responsableAsignado->name : null,
                    'estado_general' => $activo->estado_general,
                    'estatus' => $activo->estatus,
                    'fecha_adquisicion' => $activo->fecha_adquisicion,
                    'costo_adquisicion' => $activo->costo_adquisicion,
                    'valor_actual' => $activo->valor_actual,
                    'proveedor_id' => $activo->proveedor_id,
                    'proveedor_nombre' => $activo->proveedor ? $activo->proveedor->nombre : null,
                    'factura' => $activo->factura,
                    'cuenta_contable' => $activo->cuenta_contable,
                    'descripcion' => $activo->descripcion,
                    'observaciones' => $activo->observaciones,
                    'herramienta' => $activo->herramienta,
                    'maquinaria' => $activo->maquinaria,
                    'vehiculo' => $activo->vehiculo
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Activo no encontrado'
            ], 404);
        }
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, $id)
    {
        try {
            $activo = Activo::findOrFail($id);

            $request->validate([
                'nombre' => 'required|string|max:200',
                'categoria' => 'nullable|string|max:100',
                'marca' => 'nullable|string|max:100',
                'modelo' => 'nullable|string|max:100',
                'serie' => 'nullable|string|max:100',
                'anio' => 'nullable|integer|min:1900|max:' . date('Y'),
                'color' => 'nullable|string|max:50',
                'ubicacion_fisica' => 'nullable|string|max:255',
                'estado_general' => 'required|string',
                'estatus' => 'required|in:Disponible,Asignado,En mantenimiento,Dado de baja',
                'fecha_adquisicion' => 'nullable|date',
                'costo_adquisicion' => 'nullable|numeric|min:0',
                'valor_actual' => 'nullable|numeric|min:0',
                'proveedor_id' => 'nullable|exists:proveedores,id',
                'factura' => 'nullable|string|max:100',
                'cuenta_contable' => 'nullable|string|max:50|exists:cuentas_contables,codigo',
                'descripcion' => 'nullable|string',
                'observaciones' => 'nullable|string'
            ]);

            DB::beginTransaction();

            $activo->update([
                'nombre' => $request->nombre,
                'categoria' => $request->categoria,
                'marca' => $request->marca,
                'modelo' => $request->modelo,
                'serie' => $request->serie,
                'anio' => $request->anio,
                'color' => $request->color,
                'ubicacion_fisica' => $request->ubicacion_fisica,
                'estado_general' => $this->normalizarEstadoGeneral($request->estado_general),
                'estatus' => $request->estatus,
                'fecha_adquisicion' => $request->fecha_adquisicion,
                'costo_adquisicion' => $request->costo_adquisicion,
                'valor_actual' => $request->valor_actual,
                'proveedor_id' => $request->proveedor_id,
                'factura' => $request->factura,
                'cuenta_contable' => $request->cuenta_contable,
                'descripcion' => $request->descripcion,
                'observaciones' => $request->observaciones,
            ]);

            if ($activo->tipo_activo === 'herramienta') {
                $datosHerramienta = [
                    'tipo_herramienta' => $request->tipo_herramienta,
                    'voltaje' => $request->voltaje,
                    'potencia' => $request->potencia,
                    'requiere_calibracion' => $request->requiere_calibracion ?? false,
                    'numero_inventario' => $request->numero_inventario
                ];
                if ($activo->herramienta) {
                    $activo->herramienta->update($datosHerramienta);
                } else {
                    ActivoHerramienta::create(array_merge(['activo_id' => $activo->id], $datosHerramienta));
                }
            } elseif ($activo->tipo_activo === 'maquinaria') {
                $datosMaquinaria = [
                    'horometro_actual' => $request->horometro_actual ?? 0,
                    'horometro_compra' => $request->horometro_compra ?? 0,
                    'tipo_combustible' => $request->tipo_combustible,
                    'consumo_promedio' => $request->consumo_promedio,
                    'capacidad_tanque' => $request->capacidad_tanque,
                    'peso_operativo' => $request->peso_operativo,
                    'capacidad_carga' => $request->capacidad_carga,
                    'licencia_requerida' => $request->licencia_requerida
                ];
                if ($activo->maquinaria) {
                    $activo->maquinaria->update($datosMaquinaria);
                } else {
                    ActivoMaquinaria::create(array_merge(['activo_id' => $activo->id], $datosMaquinaria));
                }
            } elseif ($activo->tipo_activo === 'vehiculo') {
                $datosVehiculo = [
                    'placas' => $request->placas,
                    'numero_economico' => $request->numero_economico,
                    'vin' => $request->vin,
                    'kilometraje_actual' => $request->kilometraje_actual ?? 0,
                    'kilometraje_compra' => $request->kilometraje_compra ?? 0,
                    'tipo_combustible' => $request->tipo_combustible,
                    'consumo_promedio' => $request->consumo_promedio,
                    'capacidad_tanque' => $request->capacidad_tanque,
                    'capacidad_pasajeros' => $request->capacidad_pasajeros,
                    'capacidad_carga' => $request->capacidad_carga,
                    'tipo_vehiculo' => $request->tipo_vehiculo,
                    'traccion' => $request->traccion,
                    'transmision' => $request->transmision,
                    'poliza_seguro' => $request->poliza_seguro,
                    'vencimiento_seguro' => $request->vencimiento_seguro,
                    'licencia_requerida' => $request->licencia_requerida
                ];
                if ($activo->vehiculo) {
                    $activo->vehiculo->update($datosVehiculo);
                } else {
                    ActivoVehiculo::create(array_merge(['activo_id' => $activo->id], $datosVehiculo));
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Activo actualizado exitosamente',
                'data' => $activo->load(['herramienta', 'maquinaria', 'vehiculo'])
            ]);

        } catch (\Illuminate\Validation\ValidationException $ve) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $ve->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar activo: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar activo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource.
     */
    public function destroy($id)
    {
        try {
            $activo = Activo::findOrFail($id);

            if ($activo->asignaciones()->where('estatus', 'Activa')->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el activo porque tiene asignaciones activas'
                ], 400);
            }

            $activo->delete();

            return response()->json([
                'success' => true,
                'message' => 'Activo eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al eliminar activo: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar activo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Assign active to project.
     */
    public function asignar(Request $request, $id)
    {
        try {
            $request->validate([
                'proyecto_id' => 'required|exists:proyectos,id',
                'responsable_id' => 'nullable|exists:users,id'
            ]);

            $activo = Activo::findOrFail($id);

            if ($activo->estatus !== 'Disponible') {
                return response()->json([
                    'success' => false,
                    'message' => 'El activo no está disponible para asignación'
                ], 400);
            }

            $activo->update([
                'proyecto_asignado_id' => $request->proyecto_id,
                'responsable_asignado_id' => $request->responsable_id,
                'fecha_asignacion' => now(),
                'estatus' => 'Asignado'
            ]);

            \App\Models\MovimientoActivo::create([
                'activo_id' => $activo->id,
                'tipo_movimiento' => 'Transferencia',
                'proyecto_destino_id' => $request->proyecto_id,
                'responsable_destino' => $request->responsable_id ? User::find($request->responsable_id)->name : null,
                'observaciones' => 'Asignación a proyecto',
                'creado_por' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Activo asignado exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al asignar activo: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al asignar activo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available actives for assignment.
     */
    public function getDisponibles(Request $request)
    {
        try {
            $query = Activo::where('estatus', 'Disponible');

            if ($request->filled('tipo_activo')) {
                $query->where('tipo_activo', $request->tipo_activo);
            }

            $activos = $query->orderBy('codigo')->get(['id', 'codigo', 'nombre', 'tipo_activo']);

            return response()->json([
                'success' => true,
                'data' => $activos
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar activos disponibles: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener catálogo de cuentas contables (endpoint AJAX).
     */
    public function getCuentasContables()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $this->getCatalogoCuentasContables()
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener cuentas contables: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener cuentas contables: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export to Excel.
     */
    public function exportar(Request $request)
    {
        try {
            $query = Activo::with(['proyectoAsignado']);

            if ($request->filled('tipo_activo')) {
                $query->where('tipo_activo', $request->tipo_activo);
            }

            $activos = $query->get();

            return response()->json([
                'success' => true,
                'message' => 'Exportación en desarrollo',
                'total' => $activos->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }
}