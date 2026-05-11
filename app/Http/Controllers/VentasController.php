<?php
// app/Http/Controllers/VentasController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Vista principal de ventas
     */
    public function indexView()
    {
        return view('ventas.index');
    }

    /**
     * Obtener datos para la tabla de ventas
     */
    public function getData(Request $request)
    {
        try {
            // Obtener facturas con sus conceptos
            $query = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->leftJoin('users as u', 'f.created_by', '=', 'u.id')
                ->where('f.tipo_comprobante', 'I')
                ->select(
                    'f.factura_id',
                    'f.folio',
                    'f.fecha',
                    'f.subtotal',
                    'f.iva',
                    'f.total',
                    'f.estatus',
                    'f.satcat_metodos_pago_clave as metodo_pago',
                    'cs.serie',
                    'c.razon_social as cliente_nombre',
                    'c.rfc as cliente_rfc',
                    'u.name as vendedor',
                    'f.created_at'
                );

            // Filtros
            if ($request->fecha_inicio) {
                $query->whereDate('f.fecha', '>=', $request->fecha_inicio);
            }
            if ($request->fecha_fin) {
                $query->whereDate('f.fecha', '<=', $request->fecha_fin);
            }
            if ($request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('f.folio', 'like', "%{$request->search}%")
                      ->orWhere('c.razon_social', 'like', "%{$request->search}%")
                      ->orWhere('c.rfc', 'like', "%{$request->search}%");
                });
            }

            $facturas = $query->orderBy('f.fecha', 'desc')->get();

            // Procesar datos para mostrar
            $ventas = [];
            foreach ($facturas as $factura) {
                // Obtener conceptos de la factura
                $conceptos = DB::table('facturas_conceptos')
                    ->where('factura_id', $factura->factura_id)
                    ->get();

                if ($conceptos->count() > 0) {
                    // Mostrar por concepto
                    foreach ($conceptos as $concepto) {
                        $ventas[] = (object)[
                            'factura_id' => $factura->factura_id,
                            'folio' => $factura->serie . '-' . $factura->folio,
                            'fecha' => $factura->fecha,
                            'cliente' => $factura->cliente_nombre,
                            'cliente_rfc' => $factura->cliente_rfc,
                            'producto' => $concepto->descripcion,
                            'cantidad' => $concepto->cantidad,
                            'precio_unitario' => $concepto->valor_unitario,
                            'descuento' => $concepto->descuento ?? 0,
                            'subtotal' => $concepto->subtotal ?? $concepto->importe,
                            'iva' => $concepto->iva,
                            'total' => ($concepto->subtotal ?? $concepto->importe) + ($concepto->iva ?? 0),
                            'metodo_pago' => $this->getMetodoPago($factura->metodo_pago),
                            'vendedor' => $factura->vendedor ?? 'Sistema',
                            'estatus' => $this->getEstatusVenta($factura->estatus)
                        ];
                    }
                } else {
                    // Si no hay conceptos, mostrar la factura como un solo ítem
                    $ventas[] = (object)[
                        'factura_id' => $factura->factura_id,
                        'folio' => $factura->serie . '-' . $factura->folio,
                        'fecha' => $factura->fecha,
                        'cliente' => $factura->cliente_nombre,
                        'cliente_rfc' => $factura->cliente_rfc,
                        'producto' => 'Venta General',
                        'cantidad' => 1,
                        'precio_unitario' => $factura->subtotal,
                        'descuento' => 0,
                        'subtotal' => $factura->subtotal,
                        'iva' => $factura->iva,
                        'total' => $factura->total,
                        'metodo_pago' => $this->getMetodoPago($factura->metodo_pago),
                        'vendedor' => $factura->vendedor ?? 'Sistema',
                        'estatus' => $this->getEstatusVenta($factura->estatus)
                    ];
                }
            }

            // Estadísticas
            $stats = [
                'total_ventas' => count($ventas),
                'total_facturas' => $facturas->count(),
                'total_ingresos' => array_sum(array_column($ventas, 'total')),
                'ventas_completadas' => count(array_filter($ventas, fn($v) => $v->estatus === 'Completada'))
            ];

            return response()->json([
                'success' => true,
                'data' => $ventas,
                'stats' => $stats,
                'total_rows' => count($ventas)
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getData Ventas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
                'stats' => ['total_ventas' => 0, 'total_facturas' => 0, 'total_ingresos' => 0, 'ventas_completadas' => 0]
            ], 500);
        }
    }

    private function getMetodoPago($clave)
    {
        $metodos = [
            'PUE' => 'Pago en una sola exhibición',
            'PPD' => 'Pago en parcialidades',
            '01' => 'Efectivo',
            '02' => 'Cheque',
            '03' => 'Transferencia',
            '04' => 'Tarjeta de crédito',
            '' => 'No especificado',
            null => 'No especificado'
        ];
        return $metodos[$clave] ?? $clave ?? 'No especificado';
    }

    private function getEstatusVenta($estatus)
    {
        $estatusMap = [
            1 => 'Pendiente',
            10 => 'Proceso',
            19 => 'Completada',
            21 => 'Cancelada'
        ];
        return $estatusMap[$estatus] ?? 'Pendiente';
    }

    /**
     * Obtener detalles de una venta específica
     */
    public function show($id)
    {
        try {
            $venta = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->leftJoin('users as u', 'f.created_by', '=', 'u.id')
                ->where('f.factura_id', $id)
                ->select(
                    'f.*',
                    'cs.serie',
                    'c.razon_social as cliente_nombre',
                    'c.rfc',
                    'c.email_facturacion',
                    'c.telefono',
                    'u.name as vendedor'
                )
                ->first();

            if (!$venta) {
                return response()->json(['success' => false, 'message' => 'Venta no encontrada'], 404);
            }

            $conceptos = DB::table('facturas_conceptos')
                ->where('factura_id', $id)
                ->get();

            // Agregar folio completo
            $venta->folio_completo = $venta->serie . '-' . $venta->folio;
            $venta->estatus_texto = $this->getEstatusVenta($venta->estatus);
            $venta->metodo_pago_texto = $this->getMetodoPago($venta->satcat_metodos_pago_clave);

            return response()->json([
                'success' => true,
                'data' => $venta,
                'conceptos' => $conceptos
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}