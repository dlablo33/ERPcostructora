<?php
// app/Http/Controllers/ContrareciboController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\CodigoSat;

class ContrareciboController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Vista principal de contrarecibos
     */
    public function indexView()
    {
        // Obtener códigos SAT para ingresos
        $codigosSatIngresos = CodigoSat::whereIn('tipo', ['I'])
            ->orderBy('codigo_agrupador')
            ->get();
        
        return view('contrarecibos.index', compact('codigosSatIngresos'));
    }

    /**
     * Obtener datos para la tabla de contrarecibos
     */
    public function getData(Request $request)
    {
        try {
            $query = DB::table('contrarecibos as c')
                ->leftJoin('contactos as cont', 'c.contacto_id', '=', 'cont.contacto_id')
                ->leftJoin('users as u', 'c.created_by', '=', 'u.id')
                ->leftJoin('codigos_sat as cs', 'c.codigo_sat_id', '=', 'cs.id')
                ->select(
                    'c.contrarecibo_id',
                    'c.folio',
                    'c.fecha_pago as fecha',
                    'c.monto',
                    'c.forma_pago',
                    'c.referencia_bancaria',
                    'c.estatus',
                    'c.observaciones',
                    'c.codigo_sat_id',
                    'cont.razon_social as cliente',
                    'cont.rfc',
                    'u.name as usuario',
                    'cs.codigo_agrupador as codigo_sat_codigo',
                    'cs.nombre_cuenta as codigo_sat_nombre'
                );

            // Filtros
            if ($request->fecha_inicio) {
                $query->whereDate('c.fecha_pago', '>=', $request->fecha_inicio);
            }
            if ($request->fecha_fin) {
                $query->whereDate('c.fecha_pago', '<=', $request->fecha_fin);
            }
            if ($request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('c.folio', 'like', "%{$request->search}%")
                      ->orWhere('cont.razon_social', 'like', "%{$request->search}%")
                      ->orWhere('cont.rfc', 'like', "%{$request->search}%")
                      ->orWhere('c.referencia_bancaria', 'like', "%{$request->search}%");
                });
            }

            $contrarecibos = $query->orderBy('c.fecha_pago', 'desc')->get();

            // Mapear estatus
            foreach ($contrarecibos as $cr) {
                $estatusMap = [1 => 'Pendiente', 19 => 'Aplicado', 21 => 'Cancelado'];
                $cr->estatus_texto = $estatusMap[$cr->estatus] ?? 'Pendiente';
            }

            $stats = [
                'total' => $contrarecibos->count(),
                'pendientes' => $contrarecibos->where('estatus', 1)->count(),
                'aplicados' => $contrarecibos->where('estatus', 19)->count(),
                'cancelados' => $contrarecibos->where('estatus', 21)->count(),
                'monto_total' => $contrarecibos->sum('monto')
            ];

            return response()->json([
                'success' => true,
                'data' => $contrarecibos,
                'stats' => $stats,
                'total_rows' => $contrarecibos->count()
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en getData Contrarecibos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
                'stats' => ['total' => 0, 'pendientes' => 0, 'aplicados' => 0, 'cancelados' => 0, 'monto_total' => 0]
            ], 500);
        }
    }

    /**
     * Guardar nuevo contrarecibo
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'contacto_id' => 'required|exists:contactos,contacto_id',
                'fecha_pago' => 'required|date',
                'monto' => 'required|numeric|min:0.01',
                'forma_pago' => 'nullable|string',
                'referencia_bancaria' => 'nullable|string',
                'observaciones' => 'nullable|string',
                'codigo_sat_id' => 'required|exists:codigos_sat,id', // 🔴 NUEVO
                'facturas' => 'required|array|min:1',
                'facturas.*.factura_id' => 'required|exists:facturas,factura_id',
                'facturas.*.monto' => 'required|numeric|min:0.01'
            ]);

            // Generar folio
            $ultimo = DB::table('contrarecibos')->max('contrarecibo_id') ?? 0;
            $folio = 'CR-' . str_pad($ultimo + 1, 6, '0', STR_PAD_LEFT);

            // Insertar contrarecibo con código SAT
            $contrareciboId = DB::table('contrarecibos')->insertGetId([
                'folio' => $folio,
                'serie' => 'CR',
                'fecha_pago' => $request->fecha_pago,
                'contacto_id' => $request->contacto_id,
                'monto' => $request->monto,
                'saldo_aplicado' => $request->monto,
                'forma_pago' => $request->forma_pago,
                'referencia_bancaria' => $request->referencia_bancaria,
                'observaciones' => $request->observaciones,
                'codigo_sat_id' => $request->codigo_sat_id, // 🔴 NUEVO
                'estatus' => 19, // Aplicado directamente
                'created_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now()
            ], 'contrarecibo_id');

            // Insertar relación con facturas y actualizar saldos
            foreach ($request->facturas as $factura) {
                DB::table('contrarecibo_facturas')->insert([
                    'contrarecibo_id' => $contrareciboId,
                    'factura_id' => $factura['factura_id'],
                    'monto_aplicado' => $factura['monto'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                // Actualizar el saldo disponible de la factura
                $facturaData = DB::table('facturas')->where('factura_id', $factura['factura_id'])->first();
                
                // Calcular total aplicado (notas de crédito + contrarecibos)
                $notasAplicadas = DB::table('facturas')
                    ->where('factura_relacionada_id', $factura['factura_id'])
                    ->where('tipo_comprobante', 'E')
                    ->where('estatus', 19)
                    ->sum('total');
                
                $pagosAplicados = DB::table('contrarecibo_facturas as cf')
                    ->join('contrarecibos as cr', 'cf.contrarecibo_id', '=', 'cr.contrarecibo_id')
                    ->where('cf.factura_id', $factura['factura_id'])
                    ->where('cr.estatus', 19)
                    ->sum('cf.monto_aplicado');
                
                $totalAplicado = abs($notasAplicadas) + $pagosAplicados;
                $nuevoSaldo = max(0, $facturaData->total - $totalAplicado);
                
                DB::table('facturas')
                    ->where('factura_id', $factura['factura_id'])
                    ->update(['saldo_disponible' => $nuevoSaldo]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Contrarecibo creado correctamente',
                'contrarecibo_id' => $contrareciboId,
                'folio' => $folio
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al guardar contrarecibo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un contrarecibo específico
     */
    public function show($id)
    {
        try {
            $contrarecibo = DB::table('contrarecibos as c')
                ->leftJoin('contactos as cont', 'c.contacto_id', '=', 'cont.contacto_id')
                ->leftJoin('codigos_sat as cs', 'c.codigo_sat_id', '=', 'cs.id')
                ->where('c.contrarecibo_id', $id)
                ->select('c.*', 'cont.razon_social as cliente', 'cs.codigo_agrupador as codigo_sat_codigo', 'cs.nombre_cuenta as codigo_sat_nombre')
                ->first();

            if (!$contrarecibo) {
                return response()->json(['success' => false, 'message' => 'Contrarecibo no encontrado'], 404);
            }

            $facturas = DB::table('contrarecibo_facturas as cf')
                ->leftJoin('facturas as f', 'cf.factura_id', '=', 'f.factura_id')
                ->leftJoin('cat_series as cs', 'f.cat_serie_id', '=', 'cs.cat_serie_id')
                ->where('cf.contrarecibo_id', $id)
                ->select('cf.*', 'f.folio', 'cs.serie')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $contrarecibo,
                'facturas' => $facturas
            ]);
        } catch (\Exception $e) {
            \Log::error('Error en show Contrarecibo: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Actualizar contrarecibo
     */
    public function update(Request $request, $id)
    {
        try {
            $contrarecibo = DB::table('contrarecibos')->where('contrarecibo_id', $id)->first();

            if (!$contrarecibo) {
                return response()->json(['success' => false, 'message' => 'Contrarecibo no encontrado'], 404);
            }

            if ($contrarecibo->estatus == 19) {
                return response()->json(['success' => false, 'message' => 'No se puede editar un contrarecibo aplicado'], 422);
            }

            $validated = $request->validate([
                'fecha_pago' => 'required|date',
                'monto' => 'required|numeric|min:0.01',
                'forma_pago' => 'nullable|string',
                'referencia_bancaria' => 'nullable|string',
                'observaciones' => 'nullable|string',
                'codigo_sat_id' => 'required|exists:codigos_sat,id' // 🔴 NUEVO
            ]);

            DB::table('contrarecibos')
                ->where('contrarecibo_id', $id)
                ->update([
                    'fecha_pago' => $request->fecha_pago,
                    'monto' => $request->monto,
                    'saldo_aplicado' => $request->monto,
                    'forma_pago' => $request->forma_pago,
                    'referencia_bancaria' => $request->referencia_bancaria,
                    'observaciones' => $request->observaciones,
                    'codigo_sat_id' => $request->codigo_sat_id, // 🔴 NUEVO
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Contrarecibo actualizado correctamente'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error al actualizar contrarecibo: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Eliminar contrarecibo (soft delete)
     */
    public function destroy($id)
    {
        try {
            $contrarecibo = DB::table('contrarecibos')->where('contrarecibo_id', $id)->first();

            if (!$contrarecibo) {
                return response()->json(['success' => false, 'message' => 'Contrarecibo no encontrado'], 404);
            }

            if ($contrarecibo->estatus == 19) {
                return response()->json(['success' => false, 'message' => 'No se puede eliminar un contrarecibo aplicado'], 422);
            }

            DB::table('contrarecibos')->where('contrarecibo_id', $id)->update(['deleted_at' => now()]);

            return response()->json(['success' => true, 'message' => 'Contrarecibo eliminado']);
        } catch (\Exception $e) {
            \Log::error('Error al eliminar contrarecibo: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Obtener códigos SAT disponibles para el select
     */
    public function getCodigosSat()
    {
        try {
            $codigosSat = CodigoSat::whereIn('tipo', ['I'])
                ->orderBy('codigo_agrupador')
                ->get(['id', 'codigo_agrupador', 'nombre_cuenta']);
            
            return response()->json([
                'success' => true,
                'data' => $codigosSat
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}