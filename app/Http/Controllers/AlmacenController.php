<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\CuentaContable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $almacenes = Almacen::orderBy('codigo')->get();
        return view('almacen.catalogo.almacen', compact('almacenes'));
    }

    /**
     * Get almacenes for DataTable with pagination
     */
    public function getAlmacenes(Request $request)
    {
        try {
            $query = Almacen::query();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('codigo', 'LIKE', "%{$search}%")
                      ->orWhere('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('tipo', 'LIKE', "%{$search}%")
                      ->orWhere('descripcion', 'LIKE', "%{$search}%")
                      ->orWhere('ubicacion', 'LIKE', "%{$search}%")
                      ->orWhere('responsable', 'LIKE', "%{$search}%")
                      ->orWhere('cuenta_contable', 'LIKE', "%{$search}%");
                });
            }

            if ($request->filled('tipo')) {
                $query->where('tipo', $request->tipo);
            }

            if ($request->filled('estatus')) {
                $query->where('estatus', $request->estatus);
            }

            $perPage = $request->get('per_page', 10);
            $page    = $request->get('page', 1);

            $almacenes = $query->orderBy('codigo')->paginate($perPage, ['*'], 'page', $page);

            $data = $almacenes->getCollection()->map(function ($almacen) {
                return [
                    'id'              => $almacen->id,
                    'codigo'          => $almacen->codigo,
                    'nombre'          => $almacen->nombre,
                    'tipo'            => $almacen->tipo,
                    'descripcion'     => $almacen->descripcion,
                    'ubicacion'       => $almacen->ubicacion,
                    'responsable'     => $almacen->responsable,
                    'telefono'        => $almacen->telefono,
                    'email'           => $almacen->email,
                    'cuenta_contable' => $almacen->cuenta_contable,
                    'estatus'         => $almacen->estatus,
                    'created_at'      => $almacen->created_at ? $almacen->created_at->format('d/m/Y') : '',
                ];
            });

            return response()->json([
                'success'      => true,
                'data'         => $data,
                'total'        => $almacenes->total(),
                'per_page'     => $almacenes->perPage(),
                'current_page' => $almacenes->currentPage(),
                'last_page'    => $almacenes->lastPage()
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getAlmacenes: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar almacenes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre'          => 'required|string|max:100',
                'tipo'            => 'required|string|max:50',
                'descripcion'     => 'nullable|string',
                'ubicacion'       => 'nullable|string|max:255',
                'responsable'     => 'nullable|string|max:150',
                'telefono'        => 'nullable|string|max:20',
                'email'           => 'nullable|email|max:100',
                'cuenta_contable' => 'nullable|string|max:50',
                'estatus'         => 'required|in:Activo,Inactivo'
            ]);

            // Validar que la cuenta contable exista en la BD
            if ($request->filled('cuenta_contable')) {
                $existe = CuentaContable::where('codigo', $request->cuenta_contable)->exists();
                if (!$existe) {
                    return response()->json([
                        'success' => false,
                        'message' => 'La cuenta contable seleccionada no existe.'
                    ], 422);
                }
            }

            DB::beginTransaction();

            $almacen = Almacen::create([
                'codigo'          => Almacen::generarCodigo(),
                'nombre'          => $request->nombre,
                'tipo'            => $request->tipo,
                'descripcion'     => $request->descripcion,
                'ubicacion'       => $request->ubicacion,
                'responsable'     => $request->responsable,
                'telefono'        => $request->telefono,
                'email'           => $request->email,
                'cuenta_contable' => $request->cuenta_contable,
                'estatus'         => $request->estatus
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Almacén creado exitosamente',
                'data'    => $almacen
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear almacén: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al crear almacén: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $almacen = Almacen::findOrFail($id);

            return response()->json([
                'success' => true,
                'data'    => [
                    'id'              => $almacen->id,
                    'codigo'          => $almacen->codigo,
                    'nombre'          => $almacen->nombre,
                    'tipo'            => $almacen->tipo,
                    'descripcion'     => $almacen->descripcion,
                    'ubicacion'       => $almacen->ubicacion,
                    'responsable'     => $almacen->responsable,
                    'telefono'        => $almacen->telefono,
                    'email'           => $almacen->email,
                    'cuenta_contable' => $almacen->cuenta_contable,
                    'estatus'         => $almacen->estatus
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Almacén no encontrado'
            ], 404);
        }
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, $id)
    {
        try {
            $almacen = Almacen::findOrFail($id);

            $request->validate([
                'nombre'          => 'required|string|max:100',
                'tipo'            => 'required|string|max:50',
                'descripcion'     => 'nullable|string',
                'ubicacion'       => 'nullable|string|max:255',
                'responsable'     => 'nullable|string|max:150',
                'telefono'        => 'nullable|string|max:20',
                'email'           => 'nullable|email|max:100',
                'cuenta_contable' => 'nullable|string|max:50',
                'estatus'         => 'required|in:Activo,Inactivo'
            ]);

            // Validar que la cuenta contable exista en la BD
            if ($request->filled('cuenta_contable')) {
                $existe = CuentaContable::where('codigo', $request->cuenta_contable)->exists();
                if (!$existe) {
                    return response()->json([
                        'success' => false,
                        'message' => 'La cuenta contable seleccionada no existe.'
                    ], 422);
                }
            }

            DB::beginTransaction();

            $almacen->update([
                'nombre'          => $request->nombre,
                'tipo'            => $request->tipo,
                'descripcion'     => $request->descripcion,
                'ubicacion'       => $request->ubicacion,
                'responsable'     => $request->responsable,
                'telefono'        => $request->telefono,
                'email'           => $request->email,
                'cuenta_contable' => $request->cuenta_contable,
                'estatus'         => $request->estatus
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Almacén actualizado exitosamente',
                'data'    => $almacen
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar almacén: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar almacén: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource.
     */
    public function destroy($id)
    {
        try {
            $almacen = Almacen::findOrFail($id);
            $almacen->delete();

            return response()->json([
                'success' => true,
                'message' => 'Almacén eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al eliminar almacén: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar almacén: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reactivate an inactive warehouse
     */
    public function reactivar($id)
    {
        try {
            $almacen = Almacen::findOrFail($id);

            if ($almacen->estatus === 'Activo') {
                return response()->json([
                    'success' => false,
                    'message' => 'El almacén ya está activo'
                ], 400);
            }

            $almacen->update(['estatus' => 'Activo']);

            return response()->json([
                'success' => true,
                'message' => 'Almacén reactivado exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al reactivar almacén: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al reactivar almacén: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get tipos de almacenes for filter
     */
    public function getTipos()
    {
        try {
            $tipos = Almacen::select('tipo')
                ->distinct()
                ->orderBy('tipo')
                ->pluck('tipo');

            return response()->json([
                'success' => true,
                'data'    => $tipos
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar tipos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Devuelve el catálogo de cuentas contables para el selector.
     * Endpoint: GET /almacen/api/cuentas-contables
     */
    public function getCuentasContables()
    {
        try {
            $cuentas = CuentaContable::activas()
                ->orderBy('codigo')
                ->get(['id', 'codigo', 'nombre', 'tipo', 'nivel'])
                ->map(function ($c) {
                    return [
                        'id'     => $c->id,
                        'codigo' => $c->codigo,
                        'nombre' => $c->nombre,
                        'label'  => trim($c->codigo . ' - ' . $c->nombre),
                        'tipo'   => $c->tipo,
                        'nivel'  => $c->nivel,
                    ];
                })
                ->values();

            return response()->json([
                'success' => true,
                'data'    => $cuentas,
                'total'   => $cuentas->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getCuentasContables: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar cuentas contables: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Devuelve los usuarios del sistema para el selector de Responsable.
     * Endpoint: GET /almacen/api/usuarios
     */
    public function getUsuarios()
    {
        try {
            // ⚠️ Ajusta las columnas según tu tabla `users`
            $usuarios = User::query()
                ->orderBy('name')
                ->get(['id', 'name', 'email'])
                ->map(function ($u) {
                    return [
                        'id'    => $u->id,
                        'name'  => $u->name,
                        'email' => $u->email,
                        'label' => trim($u->name . ($u->email ? ' (' . $u->email . ')' : '')),
                    ];
                })
                ->values();

            return response()->json([
                'success' => true,
                'data'    => $usuarios,
                'total'   => $usuarios->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getUsuarios: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar usuarios: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export to Excel
     */
    public function exportar()
    {
        try {
            $almacenes = Almacen::orderBy('codigo')->get();

            return response()->json([
                'success' => true,
                'message' => 'Exportación en desarrollo',
                'total'   => $almacenes->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics
     */
    public function getEstadisticas()
    {
        try {
            $total     = Almacen::count();
            $activos   = Almacen::where('estatus', 'Activo')->count();
            $inactivos = Almacen::where('estatus', 'Inactivo')->count();

            $tipos = Almacen::select('tipo', DB::raw('count(*) as total'))
                ->groupBy('tipo')
                ->orderBy('total', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data'    => [
                    'total'     => $total,
                    'activos'   => $activos,
                    'inactivos' => $inactivos,
                    'por_tipo'  => $tipos
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar estadísticas: ' . $e->getMessage()
            ], 500);
        }
    }
}