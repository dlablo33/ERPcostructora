<?php
// app/Http/Controllers/ProveedorController.php
namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('compras.subcontratistas.gestion');
    }

    public function getData(Request $request)
    {
        try {
            $query = Proveedor::query();
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('alias', 'LIKE', "%{$search}%")
                      ->orWhere('razon_social', 'LIKE', "%{$search}%")
                      ->orWhere('rfc', 'LIKE', "%{$search}%");
                });
            }
            
            if ($request->filled('estatus')) {
                $query->where('activo', $request->estatus === 'Activo');
            }
            
            if ($request->filled('fecha_inicio')) {
                $query->whereDate('created_at', '>=', $request->fecha_inicio);
            }
            
            if ($request->filled('fecha_fin')) {
                $query->whereDate('created_at', '<=', $request->fecha_fin);
            }
            
            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);
            
            $proveedores = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
            
            $data = $proveedores->getCollection()->map(function($proveedor) {
                return [
                    'id' => $proveedor->id,
                    'folio' => 'PROV-' . str_pad($proveedor->id, 3, '0', STR_PAD_LEFT),
                    'estatus' => $proveedor->activo ? 'Activo' : 'Inactivo',
                    'fecha_alta' => $proveedor->created_at ? $proveedor->created_at->format('d/m/Y') : '',
                    'alias' => $proveedor->alias ?? $proveedor->nombre,
                    'razon_social' => $proveedor->razon_social ?? '',
                    'rfc' => $proveedor->rfc ?? '',
                    'regimen_fiscal' => $proveedor->regimen_fiscal ?? '',
                    'calle' => $proveedor->calle ?? '',
                    'num_ext' => $proveedor->num_ext ?? '',
                    'num_int' => $proveedor->num_int ?? '',
                    'codigo_postal' => $proveedor->codigo_postal ?? '',
                    'limite_credito' => number_format($proveedor->limite_credito ?? 0, 2),
                    'credito' => number_format($proveedor->credito_actual ?? 0, 2),
                    'forma_pago' => $proveedor->forma_pago ?? '',
                    'metodo_pago' => $proveedor->metodo_pago ?? '',
                    'uso_cfdi' => $proveedor->uso_cfdi ?? '',
                    'banco' => $proveedor->banco ?? '',
                    'cuenta_banco' => $proveedor->cuenta_bancaria ?? '',
                    'cuenta_contable' => $proveedor->cuenta_contable ?? '',
                    'cuenta_secundaria' => $proveedor->cuenta_secundaria ?? '',
                    'cuenta_resultado' => $proveedor->cuenta_resultado ?? ''
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'total' => $proveedores->total(),
                'per_page' => $proveedores->perPage(),
                'current_page' => $proveedores->currentPage(),
                'last_page' => $proveedores->lastPage()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getData proveedores: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar proveedores: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'alias' => 'required|string|max:100',
                'razon_social' => 'nullable|string|max:200',
                'rfc' => 'nullable|string|max:20',
                'regimen_fiscal' => 'nullable|string|max:100',
                'calle' => 'nullable|string|max:150',
                'num_ext' => 'nullable|string|max:20',
                'num_int' => 'nullable|string|max:20',
                'codigo_postal' => 'nullable|string|max:10',
                'limite_credito' => 'nullable|numeric|min:0',
                'credito' => 'nullable|numeric|min:0',
                'forma_pago' => 'nullable|string|max:100',
                'metodo_pago' => 'nullable|string|max:100',
                'uso_cfdi' => 'nullable|string|max:100',
                'banco' => 'nullable|string|max:100',
                'cuenta_banco' => 'nullable|string|max:50',
                'cuenta_contable' => 'nullable|string|max:50',
                'cuenta_secundaria' => 'nullable|string|max:50',
                'cuenta_resultado' => 'nullable|string|max:50',
                'estatus' => 'required|in:Activo,Inactivo'
            ]);
            
            DB::beginTransaction();
            
            $proveedor = Proveedor::create([
                'nombre' => $request->alias,
                'alias' => $request->alias,
                'razon_social' => $request->razon_social,
                'rfc' => $request->rfc,
                'regimen_fiscal' => $request->regimen_fiscal,
                'calle' => $request->calle,
                'num_ext' => $request->num_ext,
                'num_int' => $request->num_int,
                'codigo_postal' => $request->codigo_postal,
                'limite_credito' => $request->limite_credito ?? 0,
                'credito_actual' => $request->credito ?? 0,
                'forma_pago' => $request->forma_pago,
                'metodo_pago' => $request->metodo_pago,
                'uso_cfdi' => $request->uso_cfdi,
                'banco' => $request->banco,
                'cuenta_bancaria' => $request->cuenta_banco,
                'cuenta_contable' => $request->cuenta_contable,
                'cuenta_secundaria' => $request->cuenta_secundaria,
                'cuenta_resultado' => $request->cuenta_resultado,
                'activo' => $request->estatus === 'Activo'
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Proveedor creado exitosamente',
                'data' => $proveedor
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear proveedor: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $proveedor->id,
                    'folio' => 'PROV-' . str_pad($proveedor->id, 3, '0', STR_PAD_LEFT),
                    'estatus' => $proveedor->activo ? 'Activo' : 'Inactivo',
                    'fecha_alta' => $proveedor->created_at ? $proveedor->created_at->format('Y-m-d') : '',
                    'alias' => $proveedor->alias,
                    'razon_social' => $proveedor->razon_social,
                    'rfc' => $proveedor->rfc,
                    'regimen_fiscal' => $proveedor->regimen_fiscal,
                    'calle' => $proveedor->calle,
                    'num_ext' => $proveedor->num_ext,
                    'num_int' => $proveedor->num_int,
                    'codigo_postal' => $proveedor->codigo_postal,
                    'limite_credito' => $proveedor->limite_credito,
                    'credito' => $proveedor->credito_actual,
                    'forma_pago' => $proveedor->forma_pago,
                    'metodo_pago' => $proveedor->metodo_pago,
                    'uso_cfdi' => $proveedor->uso_cfdi,
                    'banco' => $proveedor->banco,
                    'cuenta_banco' => $proveedor->cuenta_bancaria,
                    'cuenta_contable' => $proveedor->cuenta_contable,
                    'cuenta_secundaria' => $proveedor->cuenta_secundaria,
                    'cuenta_resultado' => $proveedor->cuenta_resultado
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            
            $validated = $request->validate([
                'alias' => 'required|string|max:100',
                'razon_social' => 'nullable|string|max:200',
                'rfc' => 'nullable|string|max:20',
                'regimen_fiscal' => 'nullable|string|max:100',
                'calle' => 'nullable|string|max:150',
                'num_ext' => 'nullable|string|max:20',
                'num_int' => 'nullable|string|max:20',
                'codigo_postal' => 'nullable|string|max:10',
                'limite_credito' => 'nullable|numeric|min:0',
                'credito' => 'nullable|numeric|min:0',
                'forma_pago' => 'nullable|string|max:100',
                'metodo_pago' => 'nullable|string|max:100',
                'uso_cfdi' => 'nullable|string|max:100',
                'banco' => 'nullable|string|max:100',
                'cuenta_banco' => 'nullable|string|max:50',
                'cuenta_contable' => 'nullable|string|max:50',
                'cuenta_secundaria' => 'nullable|string|max:50',
                'cuenta_resultado' => 'nullable|string|max:50',
                'estatus' => 'required|in:Activo,Inactivo'
            ]);
            
            DB::beginTransaction();
            
            $proveedor->update([
                'nombre' => $request->alias,
                'alias' => $request->alias,
                'razon_social' => $request->razon_social,
                'rfc' => $request->rfc,
                'regimen_fiscal' => $request->regimen_fiscal,
                'calle' => $request->calle,
                'num_ext' => $request->num_ext,
                'num_int' => $request->num_int,
                'codigo_postal' => $request->codigo_postal,
                'limite_credito' => $request->limite_credito ?? 0,
                'credito_actual' => $request->credito ?? 0,
                'forma_pago' => $request->forma_pago,
                'metodo_pago' => $request->metodo_pago,
                'uso_cfdi' => $request->uso_cfdi,
                'banco' => $request->banco,
                'cuenta_bancaria' => $request->cuenta_banco,
                'cuenta_contable' => $request->cuenta_contable,
                'cuenta_secundaria' => $request->cuenta_secundaria,
                'cuenta_resultado' => $request->cuenta_resultado,
                'activo' => $request->estatus === 'Activo'
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Proveedor actualizado exitosamente',
                'data' => $proveedor
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar proveedor: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $proveedor = Proveedor::findOrFail($id);
            $proveedor->delete();
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Proveedor eliminado exitosamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar proveedor: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function exportar(Request $request)
    {
        try {
            $proveedores = Proveedor::orderBy('nombre')->get();
            return response()->json([
                'success' => true,
                'message' => 'Exportación en desarrollo',
                'total' => $proveedores->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }
}