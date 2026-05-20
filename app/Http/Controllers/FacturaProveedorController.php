<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FacturaProveedorController extends Controller
{
    /**
     * Muestra la vista principal de facturas de proveedores
     */
    public function index(Request $request)
    {
        try {
            $proveedores = DB::table('proveedores')
                ->whereNull('deleted_at')
                ->where('activo', true)
                ->orderBy('nombre')
                ->select('id', 'nombre', 'rfc')
                ->get();
            
            return view('administracion.presupuestos.facturacion', compact('proveedores'));
            
        } catch (\Exception $e) {
            Log::error('Error en index: ' . $e->getMessage());
            $proveedores = collect();
            return view('administracion.presupuestos.facturacion', compact('proveedores'));
        }
    }
    
    /**
     * Obtiene los datos para la tabla (API)
     */
    public function getData(Request $request)
    {
        try {
            $fechaInicio = $request->get('fecha_inicio', date('Y-m-01'));
            $fechaFin = $request->get('fecha_fin', date('Y-m-d'));
            $buscar = $request->get('buscar', '');
            
            $query = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->leftJoin('proveedores as p', function($join) {
                    $join->on('c.rfc', '=', 'p.rfc')
                         ->orOn('c.razon_social', '=', 'p.nombre');
                })
                ->select(
                    'f.factura_id',
                    'f.estatus',
                    'f.folio',
                    DB::raw("COALESCE(p.nombre, c.razon_social, 'SIN PROVEEDOR') as proveedor"),
                    'f.fecha',
                    'f.fecha_vencimiento',
                    'f.subtotal',
                    'f.iva',
                    'f.total',
                    'f.saldo_disponible as saldo'
                )
                ->whereNull('f.deleted_at')
                ->orderBy('f.fecha', 'desc');
            
            if (!empty($buscar)) {
                $query->where(function($q) use ($buscar) {
                    $q->where('f.folio', 'LIKE', "%{$buscar}%")
                      ->orWhere('c.razon_social', 'LIKE', "%{$buscar}%")
                      ->orWhere('p.nombre', 'LIKE', "%{$buscar}%");
                });
            }
            
            if ($fechaInicio && $fechaFin) {
                $query->whereBetween('f.fecha', [$fechaInicio, $fechaFin]);
            }
            
            $facturas = $query->get();
            
            $totales = [
                'subtotal' => $facturas->sum('subtotal'),
                'iva' => $facturas->sum('iva'),
                'total' => $facturas->sum('total'),
                'saldo' => $facturas->sum('saldo')
            ];
            
            return response()->json([
                'success' => true,
                'data' => $facturas,
                'totales' => $totales
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getData: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los datos: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Registra una nueva factura de proveedor
     */
    public function store(Request $request)
    {
        try {
            Log::info('=== INICIO GUARDAR FACTURA ===');
            Log::info('Datos recibidos:', $request->all());
            
            DB::beginTransaction();
            
            // 1. Obtener el proveedor
            $proveedor = DB::table('proveedores')->where('id', $request->proveedor_id)->first();
            
            if (!$proveedor) {
                DB::rollback();
                return response()->json([
                    'success' => false, 
                    'message' => 'Proveedor no encontrado'
                ], 404);
            }
            
            Log::info('Proveedor encontrado:', (array)$proveedor);
            
            // 2. Buscar o crear contacto
            $contacto = DB::table('contactos')
                ->where('rfc', $proveedor->rfc)
                ->first();
            
            if (!$contacto) {
                $regimenFiscal = '601';
                if (isset($proveedor->regimen_fiscal) && !empty($proveedor->regimen_fiscal)) {
                    if (preg_match('/(\d{3})/', $proveedor->regimen_fiscal, $matches)) {
                        $regimenFiscal = $matches[1];
                    } else {
                        $regimenFiscal = substr(preg_replace('/[^0-9]/', '', $proveedor->regimen_fiscal), 0, 3);
                        if (empty($regimenFiscal)) $regimenFiscal = '601';
                    }
                }
                
                $usoCFDI = 'G01';
                if (isset($proveedor->uso_cfdi) && !empty($proveedor->uso_cfdi)) {
                    if (preg_match('/^([A-Z0-9]{3})/', $proveedor->uso_cfdi, $matches)) {
                        $usoCFDI = $matches[1];
                    } else {
                        $usoCFDI = substr(preg_replace('/[^A-Z0-9]/', '', $proveedor->uso_cfdi), 0, 3);
                        if (empty($usoCFDI)) $usoCFDI = 'G01';
                    }
                }
                
                Log::info('Regimen fiscal extraído: ' . $regimenFiscal);
                Log::info('Uso CFDI extraído: ' . $usoCFDI);
                
                $contactoId = DB::table('contactos')->insertGetId([
                    'razon_social' => $proveedor->nombre,
                    'rfc' => $proveedor->rfc,
                    'tipo' => 'proveedor',
                    'estatus' => 1,
                    'satcat_regimen_fiscal_clave' => $regimenFiscal,
                    'satcat_uso_cfdi_clave' => $usoCFDI,
                    'created_at' => now(),
                    'updated_at' => now()
                ], 'contacto_id');
                
                Log::info('Contacto creado con ID: ' . $contactoId);
            } else {
                $contactoId = $contacto->contacto_id;
                Log::info('Contacto existente ID: ' . $contactoId);
            }
            
            // 3. Crear la factura
            $facturaData = [
                'contacto_id' => $contactoId,
                'folio' => $request->folio,
                'fecha' => $request->fecha,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'subtotal' => floatval($request->subtotal),
                'iva' => floatval($request->iva),
                'total' => floatval($request->total),
                'saldo_disponible' => floatval($request->total),
                'estatus' => 1,
                'tipo_comprobante' => 'I',
                'satcat_metodos_pago_clave' => $request->metodo_pago ?? 'PUE',
                'satcat_formas_pago_clave' => $request->forma_pago ?? '01',
                'satcat_uso_cfdi_clave' => 'G01',
                'satcat_regimen_fiscal_clave' => '601',
                'cat_monedas_clave' => $request->moneda ?? 'MXN',
                'tipo_cambio' => floatval($request->tipo_cambio ?? 1),
                'observaciones' => $request->observaciones,
                'created_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
                'cat_serie_id' => 1,
                'cat_sucursal_id' => 1,
                'descuento' => 0,
                'riva' => 0,
                'referencia' => null,
                'xml' => null,
                'version' => 4,
                'poliza_contable_id' => null,
                'refacturacion' => false,
                'factura_relacionada_id' => null,
                'motivo_nota_credito' => null
            ];
            
            $facturaId = DB::table('facturas')->insertGetId($facturaData, 'factura_id');
            
            Log::info('Factura creada con ID: ' . $facturaId);
            
            // 4. Crear conceptos - CON TODOS LOS CAMPOS REQUERIDOS
            if (!empty($request->conceptos) && is_array($request->conceptos)) {
                foreach ($request->conceptos as $concepto) {
                    if (!empty($concepto['descripcion'])) {
                        $cantidad = floatval($concepto['cantidad'] ?? 1);
                        $precio = floatval($concepto['precio_unitario'] ?? 0);
                        $importe = $cantidad * $precio;
                        
                        DB::table('facturas_conceptos')->insert([
                            'factura_id' => $facturaId,
                            'descripcion' => $concepto['descripcion'],
                            'cantidad' => $cantidad,
                            'valor_unitario' => $precio,
                            'importe' => $importe,
                            'subtotal' => $importe,
                            'satcat_unidades_clave' => 'H87',
                            'satcat_clave_productos_clave' => '01010101', // Clave de producto genérica
                            'iva' => 16,
                            'tasa_iva' => 0.16,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                        Log::info('Concepto agregado: ' . $concepto['descripcion']);
                    }
                }
            }
            
            DB::commit();
            
            Log::info('Factura guardada exitosamente');
            
            return response()->json([
                'success' => true,
                'message' => 'Factura registrada correctamente',
                'factura_id' => $facturaId
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error al guardar factura: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la factura: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtiene el detalle de una factura
     */
    public function show($id)
    {
        try {
            $factura = DB::table('facturas')
                ->where('factura_id', $id)
                ->whereNull('deleted_at')
                ->first();
            
            if (!$factura) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Factura no encontrada'
                ], 404);
            }
            
            $contacto = DB::table('contactos')
                ->where('contacto_id', $factura->contacto_id)
                ->first();
            
            $conceptos = DB::table('facturas_conceptos')
                ->where('factura_id', $id)
                ->get();
            
            $proveedor = null;
            if ($contacto) {
                $proveedor = DB::table('proveedores')
                    ->where('rfc', $contacto->rfc)
                    ->orWhere('nombre', $contacto->razon_social)
                    ->first();
            }
            
            return response()->json([
                'success' => true,
                'factura' => $factura,
                'proveedor_nombre' => $proveedor ? $proveedor->nombre : ($contacto ? $contacto->razon_social : 'N/A'),
                'proveedor_rfc' => $proveedor ? $proveedor->rfc : ($contacto ? $contacto->rfc : 'N/A'),
                'conceptos' => $conceptos
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en show: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Error al obtener detalle: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Cancela/Elimina una factura
     */
    public function destroy($id)
    {
        try {
            $factura = DB::table('facturas')
                ->where('factura_id', $id)
                ->whereNull('deleted_at')
                ->first();
            
            if (!$factura) {
                return response()->json([
                    'success' => false,
                    'message' => 'Factura no encontrada'
                ], 404);
            }
            
            DB::table('facturas')
                ->where('factura_id', $id)
                ->update([
                    'deleted_at' => now(),
                    'estatus' => 3,
                    'updated_at' => now()
                ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Factura cancelada correctamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en destroy: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cancelar la factura: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtiene la lista de proveedores
     */
    public function getProveedores()
    {
        try {
            $proveedores = DB::table('proveedores')
                ->whereNull('deleted_at')
                ->where('activo', true)
                ->orderBy('nombre')
                ->select('id', 'nombre', 'rfc')
                ->get();
            
            return response()->json($proveedores);
            
        } catch (\Exception $e) {
            Log::error('Error en getProveedores: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }
    
    /**
     * Registra un nuevo proveedor
     */
    public function storeProveedor(Request $request)
    {
        try {
            Log::info('=== GUARDANDO NUEVO PROVEEDOR ===');
            Log::info('Datos recibidos:', $request->all());
            
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'rfc' => 'required|string|max:13|unique:proveedores,rfc',
                'telefono' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255'
            ]);
            
            $existente = DB::table('proveedores')
                ->where('rfc', $request->rfc)
                ->first();
            
            if ($existente) {
                Log::info('Proveedor ya existe con ID: ' . $existente->id);
                return response()->json([
                    'success' => true,
                    'message' => 'Proveedor ya existe',
                    'proveedor_id' => $existente->id
                ]);
            }
            
            $proveedorId = DB::table('proveedores')->insertGetId([
                'nombre' => $request->nombre,
                'rfc' => $request->rfc,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            Log::info('Proveedor creado con ID: ' . $proveedorId);
            
            return response()->json([
                'success' => true,
                'message' => 'Proveedor registrado correctamente',
                'proveedor_id' => $proveedorId,
                'proveedor' => [
                    'id' => $proveedorId,
                    'nombre' => $request->nombre,
                    'rfc' => $request->rfc
                ]
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error en storeProveedor: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el proveedor: ' . $e->getMessage()
            ], 500);
        }
    }
}