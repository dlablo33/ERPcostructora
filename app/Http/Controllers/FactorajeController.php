<?php
// app/Http/Controllers/FactorajeController.php

namespace App\Http\Controllers;

use App\Models\FactorFinanciero;
use App\Models\SolicitudFactoraje;
use App\Models\FactorajeFactura;
use App\Models\Facturacion\Contacto;
use App\Models\Facturacion\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FactorajeController extends Controller
{
 
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Vista principal de factoraje
     */
    public function indexView()
    {
        return view('factoraje.index');
    }

    /**
     * Obtener datos para la tabla de factoraje
     */
    /**
 * Obtener datos para la tabla de factoraje
 */
public function getData(Request $request)
{
    try {
        $query = SolicitudFactoraje::with(['factor', 'contacto', 'creador'])
            ->select('solicitudes_factoraje.*');

        // Filtros
        if ($request->fecha_inicio) {
            $query->whereDate('fecha_solicitud', '>=', $request->fecha_inicio);
        }
        if ($request->fecha_fin) {
            $query->whereDate('fecha_solicitud', '<=', $request->fecha_fin);
        }
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('folio', 'like', "%{$request->search}%")
                  ->orWhereHas('contacto', function($sub) use ($request) {
                      $sub->where('razon_social', 'like', "%{$request->search}%");
                  })
                  ->orWhereHas('factor', function($sub) use ($request) {
                      $sub->where('nombre', 'like', "%{$request->search}%");
                  });
            });
        }

        $solicitudes = $query->orderBy('fecha_solicitud', 'desc')->get();
        
        // Formatear datos para la vista
        $data = [];
        foreach ($solicitudes as $solicitud) {
            $data[] = [
                'solicitud_id' => $solicitud->solicitud_id,
                'folio' => $solicitud->folio,
                'fecha_solicitud' => $solicitud->fecha_solicitud,
                'cliente_nombre' => $solicitud->contacto ? $solicitud->contacto->razon_social : 'N/A',
                'factor_nombre' => $solicitud->factor ? $solicitud->factor->nombre : 'N/A',
                'monto_factura' => floatval($solicitud->monto_factura),
                'monto_anticipo' => floatval($solicitud->monto_anticipo),
                'total_comision' => floatval($solicitud->total_comision),
                'monto_recibir' => floatval($solicitud->monto_recibir),
                'estatus' => $solicitud->estatus,
                'contacto' => $solicitud->contacto,
                'factor' => $solicitud->factor
            ];
        }

        $stats = [
            'total' => $solicitudes->count(),
            'solicitados' => $solicitudes->where('estatus', 1)->count(),
            'autorizados' => $solicitudes->where('estatus', 2)->count(),
            'liquidados' => $solicitudes->where('estatus', 3)->count(),
            'monto_total' => $solicitudes->sum('monto_factura')
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
            'stats' => $stats,
            'total_rows' => $solicitudes->count()
        ]);

    } catch (\Exception $e) {
        \Log::error('Error en getData Factoraje: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'data' => [],
            'stats' => ['total' => 0, 'solicitados' => 0, 'autorizados' => 0, 'liquidados' => 0, 'monto_total' => 0]
        ], 500);
    }
}

    /**
     * Obtener datos para crear una nueva solicitud
     */
    public function create()
{
    try {
        $factores = FactorFinanciero::where('activo', true)->get([
            'factor_id', 
            'nombre', 
            'porcentaje_anticipo_default', 
            'comision_default', 
            'dias_plazo_default'
        ]);
        
        // Facturas disponibles excluyendo las que ya están en factoraje
        $facturas = DB::table('facturas as f')
            ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
            ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
            ->where('f.estatus', 19)
            ->where('f.tipo_comprobante', 'I')
            ->whereNull('f.deleted_at')
            ->whereNotExists(function($query) {
                $query->select(DB::raw(1))
                    ->from('factoraje_facturas as ff')
                    ->join('solicitudes_factoraje as sf', 'ff.solicitud_id', '=', 'sf.solicitud_id')
                    ->whereRaw('ff.factura_id = f.factura_id')
                    ->whereIn('sf.estatus', [1, 2]);
            })
            ->select(
                'f.factura_id',
                'f.folio',
                'f.fecha',
                'f.total',
                'cs.serie',
                'c.razon_social as cliente_nombre',
                'c.contacto_id'
            )
            ->orderBy('f.fecha', 'desc')
            ->get();

        // Calcular saldo real para cada factura
        foreach ($facturas as $factura) {
            $factura->saldo_real = $factura->total;
            $factura->en_factoraje = false;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'factores' => $factores,
                'facturas' => $facturas
            ]
        ]);
    } catch (\Exception $e) {
        \Log::error('Error en create Factoraje: ' . $e->getMessage());
        return response()->json([
            'success' => false, 
            'message' => $e->getMessage(),
            'data' => [
                'factores' => [],
                'facturas' => []
            ]
        ], 500);
    }
}

    /**
     * Guardar nueva solicitud de factoraje
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'factor_id' => 'required|exists:factores_financieros,factor_id',
                'contacto_id' => 'required|exists:contactos,contacto_id',
                'fecha_solicitud' => 'required|date',
                'monto_factura' => 'required|numeric|min:0.01',
                'porcentaje_anticipo' => 'required|numeric|min:0|max:100',
                'observaciones' => 'nullable|string',
                'facturas' => 'required|array|min:1',
                'facturas.*.factura_id' => 'required|exists:facturas,factura_id',
                'facturas.*.monto' => 'required|numeric|min:0.01'
            ]);

            // Generar folio
            $ultimo = SolicitudFactoraje::withTrashed()->max('solicitud_id') ?? 0;
            $folio = 'FAC-' . str_pad($ultimo + 1, 6, '0', STR_PAD_LEFT);

            // Obtener el factor para calcular comisión
            $factor = FactorFinanciero::find($request->factor_id);
            
            // Calcular la comisión base (usar la del factor o la enviada)
            $comisionPorcentaje = $factor->comision_default ?? 3;
            $comision = ($request->monto_factura * $comisionPorcentaje) / 100;
            $ivaComision = $comision * 0.16;
            $totalComision = $comision + $ivaComision;
            $montoAnticipo = ($request->monto_factura * $request->porcentaje_anticipo) / 100;
            $montoRecibir = $montoAnticipo - $totalComision;

            // Calcular fecha de vencimiento
            $diasPlazo = $factor->dias_plazo_default ?? 30;
            $fechaVencimiento = date('Y-m-d', strtotime($request->fecha_solicitud . ' + ' . $diasPlazo . ' days'));

            // Crear solicitud
            $solicitud = SolicitudFactoraje::create([
                'folio' => $folio,
                'fecha_solicitud' => $request->fecha_solicitud,
                'factor_id' => $request->factor_id,
                'contacto_id' => $request->contacto_id,
                'monto_factura' => $request->monto_factura,
                'porcentaje_anticipo' => $request->porcentaje_anticipo,
                'monto_anticipo' => $montoAnticipo,
                'comision' => $comision,
                'iva_comision' => $ivaComision,
                'total_comision' => $totalComision,
                'monto_recibir' => $montoRecibir,
                'fecha_vencimiento_factoraje' => $fechaVencimiento,
                'observaciones' => $request->observaciones,
                'estatus' => SolicitudFactoraje::ESTATUS_SOLICITADO,
                'created_by' => Auth::id()
            ]);

            // Relacionar facturas
            foreach ($request->facturas as $factura) {
                FactorajeFactura::create([
                    'solicitud_id' => $solicitud->solicitud_id,
                    'factura_id' => $factura['factura_id'],
                    'monto_factura' => $factura['monto'],
                    'pagada_cliente' => false
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Solicitud de factoraje creada correctamente',
                'solicitud_id' => $solicitud->solicitud_id,
                'folio' => $folio,
                'monto_anticipo' => $montoAnticipo,
                'monto_recibir' => $montoRecibir,
                'total_comision' => $totalComision
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al guardar solicitud de factoraje: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar una solicitud de factoraje específica
     */
    /**
 * Mostrar una solicitud de factoraje específica
 */
public function show($id)
{
    try {
        $solicitud = SolicitudFactoraje::with(['factor', 'contacto', 'creador', 'facturas'])
            ->where('solicitud_id', $id)
            ->first();

        if (!$solicitud) {
            return response()->json(['success' => false, 'message' => 'Solicitud no encontrada'], 404);
        }

        // Formatear los datos para la vista
        $data = [
            'solicitud_id' => $solicitud->solicitud_id,
            'folio' => $solicitud->folio,
            'fecha_solicitud' => $solicitud->fecha_solicitud,
            'fecha_autorizacion' => $solicitud->fecha_autorizacion,
            'fecha_liquidacion' => $solicitud->fecha_liquidacion,
            'factor' => $solicitud->factor ? [
                'nombre' => $solicitud->factor->nombre,
                'factor_id' => $solicitud->factor->factor_id
            ] : null,
            'contacto' => $solicitud->contacto ? [
                'razon_social' => $solicitud->contacto->razon_social,
                'contacto_id' => $solicitud->contacto->contacto_id
            ] : null,
            'monto_factura' => $solicitud->monto_factura,
            'porcentaje_anticipo' => $solicitud->porcentaje_anticipo,
            'monto_anticipo' => $solicitud->monto_anticipo,
            'comision' => $solicitud->comision,
            'iva_comision' => $solicitud->iva_comision,
            'total_comision' => $solicitud->total_comision,
            'monto_recibir' => $solicitud->monto_recibir,
            'fecha_vencimiento_factoraje' => $solicitud->fecha_vencimiento_factoraje,
            'estatus' => $solicitud->estatus,
            'observaciones' => $solicitud->observaciones,
            'referencia_pago' => $solicitud->referencia_pago
        ];

        // Obtener facturas relacionadas
        $facturas = [];
        if ($solicitud->facturas) {
            foreach ($solicitud->facturas as $factura) {
                $facturas[] = [
                    'factura_id' => $factura->factura_id,
                    'folio' => $factura->folio,
                    'serie' => $factura->serie ? $factura->serie->serie : '',
                    'monto_factura' => $factura->pivot->monto_factura ?? $factura->total,
                    'pagada_cliente' => $factura->pivot->pagada_cliente ?? false,
                    'fecha_pago_cliente' => $factura->pivot->fecha_pago_cliente ?? null
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => $data,
            'facturas' => $facturas
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error en show Factoraje: ' . $e->getMessage());
        return response()->json([
            'success' => false, 
            'message' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Autorizar una solicitud de factoraje
     */
    public function autorizar($id)
    {
        try {
            DB::beginTransaction();

            $solicitud = SolicitudFactoraje::find($id);
            if (!$solicitud) {
                return response()->json(['success' => false, 'message' => 'Solicitud no encontrada'], 404);
            }

            if ($solicitud->estatus != SolicitudFactoraje::ESTATUS_SOLICITADO) {
                return response()->json(['success' => false, 'message' => 'La solicitud ya fue procesada'], 422);
            }

            $solicitud->update([
                'estatus' => SolicitudFactoraje::ESTATUS_AUTORIZADO,
                'fecha_autorizacion' => now(),
                'autorizado_por' => Auth::id()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Solicitud autorizada correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al autorizar factoraje: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Registrar liquidación de factoraje (cuando el factor paga)
     */
    public function liquidar(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $solicitud = SolicitudFactoraje::find($id);
            if (!$solicitud) {
                return response()->json(['success' => false, 'message' => 'Solicitud no encontrada'], 404);
            }

            if ($solicitud->estatus != SolicitudFactoraje::ESTATUS_AUTORIZADO) {
                return response()->json(['success' => false, 'message' => 'La solicitud debe estar autorizada para liquidar'], 422);
            }

            $validated = $request->validate([
                'referencia_pago' => 'nullable|string',
                'fecha_liquidacion' => 'required|date'
            ]);

            $solicitud->update([
                'estatus' => SolicitudFactoraje::ESTATUS_LIQUIDADO,
                'fecha_liquidacion' => $validated['fecha_liquidacion'],
                'referencia_pago' => $validated['referencia_pago'] ?? null
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Factoraje liquidado correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al liquidar factoraje: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Rechazar una solicitud de factoraje
     */
    public function rechazar($id)
    {
        try {
            DB::beginTransaction();

            $solicitud = SolicitudFactoraje::find($id);
            if (!$solicitud) {
                return response()->json(['success' => false, 'message' => 'Solicitud no encontrada'], 404);
            }

            if ($solicitud->estatus != SolicitudFactoraje::ESTATUS_SOLICITADO) {
                return response()->json(['success' => false, 'message' => 'Solo se pueden rechazar solicitudes en estado "Solicitado"'], 422);
            }

            $solicitud->update([
                'estatus' => SolicitudFactoraje::ESTATUS_RECHAZADO,
                'autorizado_por' => Auth::id()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Solicitud rechazada'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al rechazar factoraje: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Eliminar solicitud (solo si está en estado Solicitado)
     */
    public function destroy($id)
    {
        try {
            $solicitud = SolicitudFactoraje::find($id);
            if (!$solicitud) {
                return response()->json(['success' => false, 'message' => 'Solicitud no encontrada'], 404);
            }

            if ($solicitud->estatus != SolicitudFactoraje::ESTATUS_SOLICITADO) {
                return response()->json(['success' => false, 'message' => 'Solo se pueden eliminar solicitudes en estado "Solicitado"'], 422);
            }

            $solicitud->delete();

            return response()->json(['success' => true, 'message' => 'Solicitud eliminada']);
        } catch (\Exception $e) {
            \Log::error('Error al eliminar factoraje: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Obtener catálogo de factores financieros (para selects)
     */
    public function getFactores()
    {
        try {
            $factores = FactorFinanciero::activos()->get(['factor_id', 'nombre', 'porcentaje_anticipo_default', 'comision_default', 'dias_plazo_default']);
            return response()->json($factores);
        } catch (\Exception $e) {
            return response()->json([]);
        }
    }

    /**
     * Obtener clientes con facturas disponibles para factoraje
     */
    public function getClientesConFacturas()
    {
        try {
            $clientes = DB::table('facturas as f')
                ->leftJoin('contactos as c', 'f.contacto_id', '=', 'c.contacto_id')
                ->where('f.estatus', 19)
                ->where('f.tipo_comprobante', 'I')
                ->whereNull('f.deleted_at')
                ->select('c.contacto_id', 'c.razon_social', 'c.rfc')
                ->distinct()
                ->get();

            return response()->json($clientes);
        } catch (\Exception $e) {
            return response()->json([]);
        }
    }

    /**
 * Obtener facturas disponibles para un cliente específico
 */
/**
 * Obtener facturas disponibles para un cliente específico
 */
public function getFacturasDisponibles(Request $request)
{
    try {
        $clienteId = $request->cliente_id;
        
        if (!$clienteId) {
            return response()->json([]);
        }
        
        $facturas = DB::table('facturas as f')
            ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
            ->where('f.contacto_id', $clienteId)
            ->where('f.estatus', 19) // Pagada
            ->where('f.tipo_comprobante', 'I') // Ingreso
            ->whereNull('f.deleted_at')
            ->whereNotExists(function($query) {
                $query->select(DB::raw(1))
                    ->from('factoraje_facturas as ff')
                    ->join('solicitudes_factoraje as sf', 'ff.solicitud_id', '=', 'sf.solicitud_id')
                    ->whereRaw('ff.factura_id = f.factura_id')
                    ->whereIn('sf.estatus', [1, 2]); // 1=Solicitado, 2=Autorizado
            })
            ->select(
                'f.factura_id',
                'f.folio',
                'f.fecha',
                'f.total',
                'cs.serie'
            )
            ->orderBy('f.fecha', 'desc')
            ->get();
        
        // Calcular saldo real
        foreach ($facturas as $factura) {
            $factura->saldo_real = $factura->total;
        }
        
        return response()->json($facturas);
        
    } catch (\Exception $e) {
        \Log::error('Error en getFacturasDisponibles: ' . $e->getMessage());
        return response()->json([]);
    }
}
    
}