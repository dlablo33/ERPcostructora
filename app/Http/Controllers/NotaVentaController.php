<?php

namespace App\Http\Controllers;

use App\Models\NotaVenta;
use App\Models\NotaVentaConcepto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class NotaVentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Vista principal
     */
    public function indexView()
    {
        return view('administracion.facturacion.ventas');
    }

    /**
     * Data para la tabla principal
     */
    public function getData(Request $request)
    {
        try {
            $query = DB::table('notas_venta as nv')
                ->leftJoin('contactos as c', 'nv.contacto_id', '=', 'c.contacto_id')
                ->whereNull('nv.deleted_at')
                ->select(
                    'nv.*',
                    'c.razon_social as cliente_nombre',
                    'c.rfc as cliente_rfc'
                );

            if ($request->filled('fecha_inicio')) {
                $query->whereDate('nv.fecha', '>=', $request->fecha_inicio);
            }
            if ($request->filled('fecha_fin')) {
                $query->whereDate('nv.fecha', '<=', $request->fecha_fin);
            }
            if ($request->filled('search')) {
                $s = trim($request->search);
                $query->where(function ($q) use ($s) {
                    $q->where('nv.folio', 'like', "%{$s}%")
                      ->orWhere('c.razon_social', 'like', "%{$s}%")
                      ->orWhere('c.rfc', 'like', "%{$s}%");
                });
            }
            if ($request->filled('estatus')) {
                $query->where('nv.estatus', $request->estatus);
            }

            $notas = $query->orderBy('nv.fecha', 'desc')->get();

            // Map estatus texto
            $estatusMap = [1 => 'Abierta', 19 => 'Facturada', 21 => 'Cancelada'];
            foreach ($notas as $n) {
                $n->estatus_texto = $estatusMap[$n->estatus] ?? 'Abierta';
            }

            $stats = [
                'total_ventas'      => $notas->count(),
                'total_facturas'    => $notas->where('facturada', true)->count(),
                'ventas_completadas'=> $notas->where('estatus', 19)->count(),
                'total_ingresos'    => $notas->where('facturada', true)->sum('total'),
            ];

            return response()->json([
                'success' => true,
                'data'    => $notas,
                'stats'   => $stats,
            ]);
        } catch (\Exception $e) {
            Log::error('NotaVenta getData: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'data'    => [],
                'stats'   => ['total_ventas' => 0, 'total_facturas' => 0, 'ventas_completadas' => 0, 'total_ingresos' => 0],
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Detalle de una nota con sus conceptos
     */
    public function show($id)
    {
        try {
            $nota = DB::table('notas_venta as nv')
                ->leftJoin('contactos as c', 'nv.contacto_id', '=', 'c.contacto_id')
                ->where('nv.id', $id)
                ->whereNull('nv.deleted_at')
                ->select('nv.*', 'c.razon_social as cliente_nombre', 'c.rfc as cliente_rfc')
                ->first();

            if (!$nota) {
                return response()->json(['success' => false, 'message' => 'Nota de venta no encontrada'], 404);
            }

            $estatusMap = [1 => 'Abierta', 19 => 'Facturada', 21 => 'Cancelada'];
            $nota->estatus_texto = $estatusMap[$nota->estatus] ?? 'Abierta';

            $conceptos = DB::table('notas_venta_conceptos')
                ->where('nota_venta_id', $id)
                ->get();

            return response()->json([
                'success'   => true,
                'data'      => $nota,
                'conceptos' => $conceptos,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Guardar nueva nota de venta
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'contacto_id'                 => 'required|integer',
                'fecha'                       => 'required|date',
                'conceptos'                   => 'required|array|min:1',
                'conceptos.*.descripcion'     => 'required|string',
                'conceptos.*.cantidad'        => 'required|numeric|min:0.0001',
                'conceptos.*.valor_unitario'  => 'required|numeric|min:0',
            ]);

            DB::beginTransaction();

            // Folio automático
            $ultima = DB::table('notas_venta')->orderBy('id', 'desc')->lockForUpdate()->first();
            $siguiente = ($ultima ? intval($ultima->id) : 0) + 1;
            $folio = 'NV-' . str_pad($siguiente, 6, '0', STR_PAD_LEFT);

            // Calcular totales
            $subtotal = 0;
            $descuentoTotal = 0;
            foreach ($request->conceptos as $c) {
                $importe   = $c['cantidad'] * $c['valor_unitario'];
                $descuento = floatval($c['descuento'] ?? 0);
                $subtotal += $importe;
                $descuentoTotal += $descuento;
            }
            $baseGravable = $subtotal - $descuentoTotal;
            $iva = $baseGravable * 0.16;
            $total = $baseGravable + $iva;

            $notaId = DB::table('notas_venta')->insertGetId([
                'folio'         => $folio,
                'fecha'         => $request->fecha,
                'contacto_id'   => $request->contacto_id,
                'proyecto_id'   => $request->proyecto_id,
                'cat_serie_id'  => $request->cat_serie_id,
                'subtotal'      => $subtotal,
                'descuento'     => $descuentoTotal,
                'iva'           => $iva,
                'total'         => $total,
                'estatus'       => NotaVenta::ESTATUS_ABIERTA,
                'facturada'     => false,
                'observaciones' => $request->observaciones,
                'created_by'    => Auth::id(),
                'updated_by'    => Auth::id(),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            foreach ($request->conceptos as $c) {
                $importe   = $c['cantidad'] * $c['valor_unitario'];
                $descuento = floatval($c['descuento'] ?? 0);
                $base      = $importe - $descuento;

                DB::table('notas_venta_conceptos')->insert([
                    'nota_venta_id'                 => $notaId,
                    'codigo'                        => $c['codigo'] ?? null,
                    'descripcion'                   => $c['descripcion'],
                    'cantidad'                      => $c['cantidad'],
                    'valor_unitario'                => $c['valor_unitario'],
                    'descuento'                     => $descuento,
                    'importe'                       => $importe,
                    'iva'                           => $base * 0.16,
                    'satcat_clave_productos_clave'  => $c['producto_sat'] ?? '84111500',
                    'satcat_unidades_clave'         => $c['unidad_sat'] ?? 'ACT',
                    'observaciones'                 => $c['observaciones'] ?? null,
                    'created_at'                    => now(),
                    'updated_at'                    => now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'success'       => true,
                'id'            => $notaId,
                'folio'         => $folio,
                'message'       => 'Nota de venta creada correctamente',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('NotaVenta store: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Actualizar nota (solo si no está facturada)
     */
    public function update(Request $request, $id)
    {
        try {
            $nota = DB::table('notas_venta')->where('id', $id)->whereNull('deleted_at')->first();
            if (!$nota) {
                return response()->json(['success' => false, 'message' => 'Nota no encontrada'], 404);
            }
            if ($nota->facturada || $nota->estatus == NotaVenta::ESTATUS_FACTURADA) {
                return response()->json(['success' => false, 'message' => 'No se puede editar una nota ya facturada'], 422);
            }

            DB::beginTransaction();

            $request->validate([
                'contacto_id'                 => 'required|integer',
                'fecha'                       => 'required|date',
                'conceptos'                   => 'required|array|min:1',
                'conceptos.*.descripcion'     => 'required|string',
                'conceptos.*.cantidad'        => 'required|numeric|min:0.0001',
                'conceptos.*.valor_unitario'  => 'required|numeric|min:0',
            ]);

            $subtotal = 0;
            $descuentoTotal = 0;
            foreach ($request->conceptos as $c) {
                $importe = $c['cantidad'] * $c['valor_unitario'];
                $desc    = floatval($c['descuento'] ?? 0);
                $subtotal += $importe;
                $descuentoTotal += $desc;
            }
            $base = $subtotal - $descuentoTotal;
            $iva  = $base * 0.16;
            $total = $base + $iva;

            DB::table('notas_venta')->where('id', $id)->update([
                'fecha'         => $request->fecha,
                'contacto_id'   => $request->contacto_id,
                'proyecto_id'   => $request->proyecto_id,
                'subtotal'      => $subtotal,
                'descuento'     => $descuentoTotal,
                'iva'           => $iva,
                'total'         => $total,
                'observaciones' => $request->observaciones,
                'updated_by'    => Auth::id(),
                'updated_at'    => now(),
            ]);

            DB::table('notas_venta_conceptos')->where('nota_venta_id', $id)->delete();

            foreach ($request->conceptos as $c) {
                $importe = $c['cantidad'] * $c['valor_unitario'];
                $desc    = floatval($c['descuento'] ?? 0);
                DB::table('notas_venta_conceptos')->insert([
                    'nota_venta_id'                 => $id,
                    'codigo'                        => $c['codigo'] ?? null,
                    'descripcion'                   => $c['descripcion'],
                    'cantidad'                      => $c['cantidad'],
                    'valor_unitario'                => $c['valor_unitario'],
                    'descuento'                     => $desc,
                    'importe'                       => $importe,
                    'iva'                           => ($importe - $desc) * 0.16,
                    'satcat_clave_productos_clave'  => $c['producto_sat'] ?? '84111500',
                    'satcat_unidades_clave'         => $c['unidad_sat'] ?? 'ACT',
                    'observaciones'                 => $c['observaciones'] ?? null,
                    'created_at'                    => now(),
                    'updated_at'                    => now(),
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Nota de venta actualizada']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('NotaVenta update: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Eliminar (soft delete) — solo si no está facturada
     */
    public function destroy($id)
    {
        try {
            $nota = DB::table('notas_venta')->where('id', $id)->first();
            if (!$nota) {
                return response()->json(['success' => false, 'message' => 'Nota no encontrada'], 404);
            }
            if ($nota->facturada) {
                return response()->json(['success' => false, 'message' => 'No se puede eliminar una nota ya facturada'], 422);
            }

            DB::table('notas_venta')->where('id', $id)->update([
                'deleted_at' => now(),
                'estatus'    => NotaVenta::ESTATUS_CANCELADA,
            ]);

            return response()->json(['success' => true, 'message' => 'Nota eliminada']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Endpoint usado por el modal de facturación:
     * devuelve solo notas NO facturadas (opcionalmente filtradas por cliente)
     */
    public function getDisponibles(Request $request)
    {
        try {
            $query = DB::table('notas_venta as nv')
                ->leftJoin('contactos as c', 'nv.contacto_id', '=', 'c.contacto_id')
                ->whereNull('nv.deleted_at')
                ->where('nv.facturada', false)
                ->whereIn('nv.estatus', [NotaVenta::ESTATUS_ABIERTA])
                ->select(
                    'nv.id', 'nv.folio', 'nv.fecha',
                    'nv.subtotal', 'nv.iva', 'nv.total',
                    'nv.estatus', 'nv.contacto_id',
                    'c.razon_social as cliente_nombre',
                    'c.rfc as cliente_rfc'
                );

            if ($request->filled('contacto_id')) {
                $query->where('nv.contacto_id', $request->contacto_id);
            }

            return response()->json($query->orderBy('nv.fecha', 'desc')->limit(300)->get());
        } catch (\Exception $e) {
            Log::warning('getDisponibles NV: ' . $e->getMessage());
            return response()->json([]);
        }
    }

    /**
     * Marcar nota como facturada (se llama desde FacturaController::store)
     */
    public function marcarFacturada($id, $facturaId)
    {
        DB::table('notas_venta')->where('id', $id)->update([
            'facturada'  => true,
            'estatus'    => NotaVenta::ESTATUS_FACTURADA,
            'factura_id' => $facturaId,
            'updated_at' => now(),
        ]);
    }
}